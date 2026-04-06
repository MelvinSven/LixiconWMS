<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends MY_Model
{
    protected $table = 'category';

    public function getDefaultValues()
    {
        return [
            'CategoryName' => ''
        ];
    }

    public function getValidationRules()
    {
        return [
            [
                'field' => 'CategoryName',
                'label' => 'Nama Kategori',
                'rules' => 'trim|required|callback_unique_category',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ]
        ];
    }

    public function getById($id)
    {
        return $this->where('id_category', $id)->first();
    }

    public function updateById($id, $data)
    {
        return $this->db->where('id_category', $id)->update($this->table, $data);
    }

    public function deleteById($id)
    {
        return $this->db->where('id_category', $id)->delete($this->table);
    }
}

/* End of file Categories_model.php */
