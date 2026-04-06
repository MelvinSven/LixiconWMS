<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Locations_model extends MY_Model
{
    protected $table = 'lokasi_barang';

    public function getDefaultValues()
    {
        return [
            'nama_lokasi' => ''
        ];
    }

    public function getValidationRules()
    {
        return [
            [
                'field' => 'nama_lokasi',
                'label' => 'Nama Lokasi',
                'rules' => 'trim|required|callback_unique_location',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ]
        ];
    }

    public function getById($id)
    {
        return $this->where('id_lokasi', $id)->first();
    }

    public function updateById($id, $data)
    {
        return $this->db->where('id_lokasi', $id)->update($this->table, $data);
    }

    public function deleteById($id)
    {
        return $this->db->where('id_lokasi', $id)->delete($this->table);
    }
}

/* End of file Locations_model.php */
