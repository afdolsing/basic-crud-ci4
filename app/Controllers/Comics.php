<?php

namespace App\Controllers;

use App\Models\ComicModel;
use CodeIgniter\CodeIgniter;
use CodeIgniter\Config\Config;

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
            "title" => "Daftar Komik ",
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
            "title" => "form tambah data komik",
            "validation" => \Config\Services::validation()
        ];

        return view('comic/create', $data);
    }

    public function save()
    {
        //validasi input
        if (!$this->validate([
            "judul" => [
                "rules" => 'required|is_unique[komik.judul]',
                "errors" => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ]
        ])) {
            // ambil pesan kesalahan
            $validation = \Config\Services::validation();
            return redirect()->to('/comics/create')->withInput()->with('validation', $validation);
        }

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

    public function edit($slug)
    {
        $data = [
            "title" => "form ubah data komik",
            "validation" => \Config\Services::validation(),
            "komik" => $this->komikModel->getComic($slug)
        ];

        return view('comic/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $komik_lama = $this->komikModel->getComic($this->request->getVar('slug'));
        if ($komik_lama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }
        //validasi input
        if (!$this->validate([
            "judul" => [
                "rules" => $rule_judul,
                "errors" => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ]
        ])) {
            // ambil pesan kesalahan
            $validation = \Config\Services::validation();
            return redirect()->to('/comics/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            "id" => $id,
            "judul" => $this->request->getVar('judul'),
            "slug" => $slug,
            "penulis" => $this->request->getVar('penulis'),
            "penerbit" => $this->request->getVar('penerbit'),
            "sampul" => $this->request->getVar('sampul')
        ]);

        session()->setFlashdata('pesan', 'data telah diedit');

        return redirect()->to('/comics');
    }

    public function delete($id)
    {
        $this->komikModel->delete($id);

        session()->setFlashdata('pesan', 'data telah dihapus');
        return redirect()->to('/comics');
    }
}
