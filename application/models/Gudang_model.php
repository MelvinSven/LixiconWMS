<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gudang_model extends MY_Model 
{
    public $table = 'gudang';

    /**
     * Validation rules untuk form gudang
     */
    public function getValidationRules()
    {
        return [
            [
                'field' => 'nama',
                'label' => 'Nama Gudang',
                'rules' => 'required|max_length[100]'
            ],
            [
                'field' => 'alamat',
                'label' => 'Alamat',
                'rules' => 'max_length[255]'
            ]
        ];
    }

    /**
     * Ambil semua gudang
     */
    public function getAllWarehouses()
    {
        return $this->db->order_by('nama', 'asc')
                        ->get('gudang')
                        ->result();
    }
}

/* End of file Gudang_model.php */
