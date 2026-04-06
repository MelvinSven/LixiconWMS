<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $table = '';
    protected $perPage = 5; // Banyak data tiap halaman

    public function __construct()
    {
        parent::__construct();

        if (!$this->table) {    // Jika nilai table kosong 
            $this->table = strtolower(
                str_replace('_model', '', get_class($this))
            );
        }
    }

    /**
     * Get perPage value (for pagination)
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    // ===================================================
    // FORM VALIDATION
    // ===================================================
    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters(
            '<small class="form-text text-danger">',
            '</small>'
        );

        $validationRules = $this->getValidationRules();
        $this->form_validation->set_rules($validationRules);

        return $this->form_validation->run();
    }

    // ===================================================
    // QUERY BUILDER HELPERS
    // ===================================================
    public function select($columns)
    {
        $this->db->select($columns);
        return $this;
    }

    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function like($column, $condition)
    {
        $this->db->like($column, $condition);
        return $this;
    }

    public function orLike($column, $condition)
    {
        $this->db->or_like($column, $condition);
        return $this;
    }

    public function limit($value)
    {
        $this->db->limit($value);
        return $this;
    }

    public function join($table, $conditionOrType = 'left', $type = 'left')
    {
        // Check if second parameter is a custom condition or join type
        if (in_array($conditionOrType, ['left', 'right', 'inner', 'outer', 'LEFT', 'RIGHT', 'INNER', 'OUTER'])) {
            // Default behavior: auto-generate join condition
            $this->db->join($table, "$this->table.id_$table = $table.id", $conditionOrType);
        } else {
            // Custom join condition provided
            $this->db->join($table, $conditionOrType, $type);
        }
        return $this;
    }

    public function orderBy($column, $order = 'asc')
    {
        $this->db->order_by($column, $order);
        return $this;
    }

    public function groupBy($type)
    {
        $this->db->group_by($type);
        return $this;
    }

    // ===================================================
    // OUTPUT METHODS
    // ===================================================
    public function first()
    {
        return $this->db->get($this->table)->row();
    }

    public function get()
    {
        return $this->db->get($this->table)->result();
    }

    public function count()
    {
        return $this->db->count_all_results($this->table);
    }

    // ===================================================
    // CRUD METHODS
    // ===================================================
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id = null)
    {
        if ($id !== null) {
            $this->db->where('id', $id);
        }
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    public function resetIndex()
    {
        $this->db->query("ALTER TABLE $this->table AUTO_INCREMENT = 1");
    }

    // ===================================================
    // PAGINATION
    // ===================================================
    public function paginate($page)
    {
        $this->db->limit(
            $this->perPage,
            $this->calculateRealOffset($page)
        );
        return $this;
    }

    public function calculateRealOffset($page)
    {
        return (is_null($page) || empty($page))
            ? 0
            : ($page * $this->perPage) - $this->perPage;
    }

    public function makePagination($baseUrl, $uriSegment, $totalRows = null)
    {
        $this->load->library('pagination');

        $config = [
            'base_url'          => $baseUrl,
            'uri_segment'       => $uriSegment,
            'per_page'          => $this->perPage,
            'total_rows'        => $totalRows,
            'use_page_numbers'  => true,

            // Desain pagination Bootstrap v4
            'full_tag_open'     => '<ul class="pagination">',
            'full_tag_close'    => '</ul>',
            'attributes'        => ['class' => 'page-link'],
            'first_link'        => false,
            'last_link'         => false,
            'first_tag_open'    => '<li class="page-item">',
            'first_tag_close'   => '</li>',
            'prev_link'         => '&laquo',
            'prev_tag_open'     => '<li class="page-item">',
            'prev_tag_close'    => '</li>',
            'next_link'         => '&raquo',
            'next_tag_open'     => '<li class="page-item">',
            'next_tag_close'    => '</li>',
            'cur_tag_open'      => '<li class="page-item active"><a href="#" class="page-link">',
            'cur_tag_close'     => '<span class="sr-only">(current)</span></a></li>',
            'num_tag_open'      => '<li class="page-item">',
            'num_tag_close'     => '</li>'
        ];

        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
}

/* End of file MY_Model.php */
