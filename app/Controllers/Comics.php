<?php

namespace App\Controllers;

use App\Models\ComicModel;
use CodeIgniter\CodeIgniter;

class Comics extends BaseController
{
    protected $komikModel;

    public function __construct()
    {
        $this->komikModel = new ComicModel();
    }

    public function index()
    {

        $data = [
            "title" => "daftar komik",
            "komik" => $this->komikModel->getComic()
        ];


        return view('comic/index', $data);
    }

    public function detail($slug)
    {
        $komik = $this->komikModel->getComic($slug);
        $data = [
            "title" => "Daftar Komik",
            "komik" => $komik
        ];
        // jika komik tidak ada di tabel
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('judul komik ' . $slug . ' tidak ada');
        }

        return view('comic/detail', $data);
    }

    public function create()
    {
        $data = [
            "title" => "form tambah data komik"
        ];

        return view('comic/create', $data);
    }

    public function save()
    {
        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            "judul" => $this->request->getVar('judul'),
            "slug" => $slug,
            "penulis" => $this->request->getVar('penulis'),
            "penerbit" => $this->request->getVar('penerbit'),
            "sampul" => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'data telah ditambahkan');

        return redirect()->to('/comics');
    }
}
