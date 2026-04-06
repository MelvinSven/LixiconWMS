<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_Model
{
    protected $table = 'category';

    public function getDefaultValues()
    {
        return ['CategoryName' => ''];
    }

    public function getValidationRules()
    {
        return [
            [
                'field' => 'CategoryName',
                'label' => 'Nama Kategori',
                'rules' => 'trim|required|is_unique[category.CategoryName]',
                'errors' => [
                    'required'  => '<h6>%s harus diisi.</h6>',
                    'is_unique' => '<h6>%s sudah terdaftar.</h6>'
                ]
            ]
        ];
    }

    public function run($input)
    {
        $data = ['CategoryName' => $input->CategoryName];
        $this->create($data);
        return true;
    }
}

/* End of file Category_model.php */
