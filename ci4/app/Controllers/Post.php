<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // Menampilkan semua data
    public function index()
    {
        $model = new ArtikelModel();

        $data['artikel'] = $model
            ->orderBy('id', 'DESC')
            ->findAll();

        return $this->respond($data);
    }

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    }

    // Menambahkan data
    public function create()
    {
        $model = new ArtikelModel();

        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];

        $model->insert($data);

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data artikel berhasil ditambahkan.'
            ]
        ];

        return $this->respondCreated($response);
    }

    // Menampilkan data berdasarkan ID
    public function show($id = null)
    {
        $model = new ArtikelModel();

        $data = $model->where('id', $id)->first();

        if ($data) {
            return $this->respond($data);
        }

        return $this->failNotFound('Data tidak ditemukan.');
    }

    // Mengubah data
    public function update($id = null)
    {
        $model = new ArtikelModel();

        $id = $this->request->getVar('id');

        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];

        $model->update($id, $data);

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data artikel berhasil diubah.'
            ]
        ];

        return $this->respond($response);
    }

    // Menghapus data
    public function delete($id = null)
    {
        $model = new ArtikelModel();

        $data = $model->where('id', $id)->first();

        if ($data) {
            $model->delete($id);

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data artikel berhasil dihapus.'
                ]
            ];

            return $this->respondDeleted($response);
        }

        return $this->failNotFound('Data tidak ditemukan.');
    }
}