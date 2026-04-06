<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Suppliers_model extends MY_Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'id_supplier';
    
    public function getDefaultValues()
    {
        return [
            'nama' => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Supplier',
                'rules' => 'trim|required|callback_unique_supplier',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>',
                    'unique_supplier' => '<h6>%s sudah digunakan.</h6>'
                ]
            ]
        ];

        return $validationRules;
    }
}

/* End of file Suppliers_model.php */
