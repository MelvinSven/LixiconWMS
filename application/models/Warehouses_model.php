<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouses_model extends MY_Model 
{
    public $table = 'gudang';
    protected $perPage = 10;

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
}

/* End of file Warehouses_model.php */
