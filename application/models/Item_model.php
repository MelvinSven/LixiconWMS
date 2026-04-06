<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Item_model extends MY_Model
{
    protected $table = 'barang';

    public function getDefaultValues()
    {
        return [
            'id'    => '',
            'nama'  => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Barang',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ]
        ];

        return $validationRules;
    }

    /**
     * Melakukan insert barang baru ke db
     */
    public function run($input)
    {
        $data = [
            'nama'        => $input->nama,
            // 'id_supplier' => $input->id_supplier,
            'id_satuan'   => $input->id_satuan
        ];

        $this->create($data);

        return true;
    }
}

/* End of file Item_model.php */
