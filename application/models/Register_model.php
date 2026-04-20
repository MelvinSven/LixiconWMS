<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register_model extends MY_Model
{
    protected $table = 'user';

    public function getDefaultValues()
    {
        return [
            'nama' => '',
            'email' => '',
            'password' => '',
            'telefon' => '',
            'ktp' => '',
            'id_gudang' => '',
            'role' => 'staff'
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Lengkap',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ],
            [
                'field' => 'email',
                'label' => 'E-Mail',
                'rules' => 'trim|required|valid_email|is_unique[user.email]',
                'errors' => [
                    'is_unique' => '<h6>%s sudah digunakan.</h6>'
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[4]',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>',
                    'min_length' => '<h6>%s minimal 4 karakter.</h6>'
                ]
            ],
            [
                'field' => 'telefon',
                'label' => 'Nomor Telefon',
                'rules' => 'trim|required',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>'
                ]
            ],
            [
                'field' => 'ktp',
                'label' => 'Nomor KTP',
                'rules' => 'trim|required|is_unique[user.ktp]',
                'errors' => [
                    'required' => '<h6>%s harus diisi.</h6>',
                    'is_unique' => '<h6>%s sudah digunakan.</h6>'
                ]
            ],
            [
                'field' => 'role',
                'label' => 'Role',
                'rules' => 'trim|required|in_list[admin,staff,purchasing_admin]',
                'errors' => [
                    'required' => '<h6>%s harus dipilih.</h6>',
                    'in_list'  => '<h6>%s tidak valid.</h6>'
                ]
            ],
        ];

        return $validationRules;
    }

    /**
     * Melakukan insert user baru ke db
     */
    public function run($input)
    {
        $allowedRoles = ['admin', 'staff', 'purchasing_admin'];
        $role = isset($input->role) && in_array($input->role, $allowedRoles, true)
            ? $input->role
            : 'staff';

        $data = [
            'nama' => $input->nama,
            'email' => strtolower($input->email),
            'password' => hashEncrypt($input->password),
            'telefon' => $input->telefon,
            'ktp' => $input->ktp,
            'role' => $role,
            'id_gudang' => !empty($input->id_gudang) ? $input->id_gudang : null
        ];

        $this->create($data);

        return true;
    }
}

/* End of file Register_model.php */
