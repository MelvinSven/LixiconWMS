<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends MY_Model
{
    protected $table = 'barang';
    protected $perPage = 10;

    protected $fillable = [
        'nama',
        'deskripsi',
        'qty',
        'id_satuan',
        'id_lokasi',
        'harga',
        'image'
    ];

    public function getValidationRules()
    {
        return [
            ['field' => 'nama', 'label' => 'Nama Barang', 'rules' => 'required'],
            ['field' => 'qty', 'label' => 'Kuantitas', 'rules' => 'required|numeric'],
            ['field' => 'id_satuan', 'label' => 'Satuan', 'rules' => 'required|numeric'],
            ['field' => 'harga', 'label' => 'Harga', 'rules' => 'required|numeric']
        ];
    }

    public function getById($id)
    {
        return $this->where('barang.id', $id)->first();
    }

    // ✅ Tambahkan method insert()
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // ✅ Tambahkan method update() biar aman
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }
}
