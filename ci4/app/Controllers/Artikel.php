<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    // Di dalam Controller artikel lu, cari fungsi index() atau sejenisnya:
    public function index()
    {
        // Ambil parameter pencarian & filter dari URL
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';

        // Bikin query dasar ke model artikel
        // Kita tambahkan urutan 'orderBy' berdasarkan ID biar urut 1 sampai 20
        $this->artikelModel->orderBy('id', 'ASC'); 

        // Jika ada filter pencarian kata kunci
        if ($q) {
            $this->artikelModel->like('judul', $q);
        }

        // Jika ada filter kategori
        if ($kategori_id) {
            $this->artikelModel->where('id_kategori', $kategori_id);
        }

        $data = [
            'title'       => 'Daftar Artikel',
            // Set paginate(5) artinya membagi data per 5 item per halaman
            'artikel'     => $this->artikelModel->paginate(5, 'default'),
            'pager'       => $this->artikelModel->pager,
            'kategori'    => $this->kategoriModel->findAll(),
            'q'           => $q,
            'kategori_id' => $kategori_id
        ];

        return view('artikel/admin_index', $data);
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $model = new \App\Models\ArtikelModel();
        
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page = $this->request->getVar('page') ?? 1;

        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        if ($q != '') $builder->like('artikel.judul', $q);
        if ($kategori_id != '') $builder->where('artikel.id_kategori', $kategori_id);

        $artikel = $builder->paginate(10, 'default', $page);
        $pager = $model->pager;

        $data = [
            'artikel'     => $artikel,
            'current_page'=> $page,
            'per_page'    => 10
        ];

        if ($this->request->isAJAX()) {
            $data['pagination_html'] = $pager->links('default', 'default_full');
            return $this->response->setJSON($data);
        }
        
        $data['title'] = $title;
        $data['q'] = $q;
        $data['kategori_id'] = $kategori_id;
        $kategoriModel = new \App\Models\KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'judul' => 'required'
        ]);

        $isDataValid = $validation
            ->withRequest($this->request)
            ->run();

        if ($isDataValid) {
            $file = $this->request->getFile('gambar');

            // Memindahkan file gambar yang di-upload ke folder public/gambar
            $file->move(ROOTPATH . 'public/gambar');

            $artikel = new ArtikelModel();

            // Proses insert data ke database (Sesuaikan field database lu)
            $artikel->insert([
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'), // <-- Tambahan biar id_kategori lu kesimpan ke database!
                'slug'        => url_title(
                    $this->request->getPost('judul'),
                    '-',
                    true
                ),
                'gambar'      => $file->getName(),
            ]);

            return redirect()->to('/admin/artikel');
        }

        $title = 'Tambah Artikel';
        
        // SOLUSI: Tarik data kategori dari model sebelum merender View
        $kategoriModel = new \App\Models\KategoriModel();
        $kategori = $kategoriModel->findAll();

        // Masukkan variabel 'kategori' ke dalam compact() biar bisa dibaca di form_add.php
        return view('artikel/form_add', compact('title', 'kategori'));
    }

    public function edit($id)
    {
        $model = new ArtikelModel();

        if (
            $this->request->getMethod() == 'post' &&
            $this->validate([
                'judul'       => 'required',
                'id_kategori' => 'required|integer',
            ])
        ) {
            $model->update($id, [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
            ]);

            return redirect()->to('/admin/artikel');
        }

        $data['artikel'] = $model->find($id);

        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        $data['title'] = 'Edit Artikel';

        return view('artikel/form_edit', $data);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        return redirect()->to('/admin/artikel');
    }

    public function view($slug)
    {
        $model = new ArtikelModel();

        $data['artikel'] = $model
            ->where('slug', $slug)
            ->first();

        if (empty($data['artikel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Cannot find the article.'
            );
        }

        $data['title'] = $data['artikel']['judul'];

        return view('artikel/detail', $data);
    }
}