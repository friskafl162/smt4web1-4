<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {
        return view('ajax/index');
    }

    // Ambil semua data artikel untuk tabel
    public function getData()
    {
        $model = new ArtikelModel();
        $data = $model->findAll();

        return $this->response->setJSON($data);
    }

    // FUNGSI BARU: Ambil 1 data detail buat modal Edit
    public function getOne($id)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);

        return $this->response->setJSON($data);
    }

    // FUNGSI BARU: Simpan data artikel baru (Tambah)
    public function save()
    {
        $model = new ArtikelModel();
        
        $model->insert([
            'judul'  => $this->request->getPost('judul'),
            'isi'    => $this->request->getPost('isi'),
            'status' => $this->request->getPost('status'),
            'slug'   => url_title($this->request->getPost('judul'), '-', true),
        ]);

        return $this->response->setJSON(['status' => 'OK']);
    }

    // FUNGSI BARU: Update data artikel lama (Ubah)
    public function update()
    {
        $model = new ArtikelModel();
        $id = $this->request->getPost('id');

        $model->update($id, [
            'judul'  => $this->request->getPost('judul'),
            'isi'    => $this->request->getPost('isi'),
            'status' => $this->request->getPost('status'),
            'slug'   => url_title($this->request->getPost('judul'), '-', true),
        ]);

        return $this->response->setJSON(['status' => 'OK']);
    }

    // Proses hapus data artikel
    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        return $this->response->setJSON(['status' => 'OK']);
    }
}