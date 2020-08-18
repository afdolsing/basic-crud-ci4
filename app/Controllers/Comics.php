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
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            // ambil pesan kesalahan
            // $validation = \Config\Services::validation();
            // return redirect()->to('/comics/create')->withInput()->with('validation', $validation);
            return redirect()->to('/comics/create')->withInput();
        }
        // ambil gambar
        $file_sampul = $this->request->getFile('sampul');
        // apakah tidak ada gambar yang diupload
        if ($file_sampul->getError() == 4) {
            $nama_sampul = 'default.jpg';
        } else {
            // generate nama sampul
            $nama_sampul = $file_sampul->getRandomName();
            // pindafkan file ke folder img
            $file_sampul->move('img', $nama_sampul);
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            "judul" => $this->request->getVar('judul'),
            "slug" => $slug,
            "penulis" => $this->request->getVar('penulis'),
            "penerbit" => $this->request->getVar('penerbit'),
            "sampul" => $nama_sampul
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
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'ukuran gambar terlalu besar',
                    'is_image' => 'yang anda pilih bukan gambar',
                    'mime_in' => 'yang anda pilih bukan gambar'
                ]
            ]
        ])) {
            return redirect()->to('/comics/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        // cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            // generate nama file random
            $namaSampul = $fileSampul->getRandomName();
            // pindahkan gambar atau upload gambar
            $fileSampul->move('img/', $namaSampul);
            // hapus file lama
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            "id" => $id,
            "judul" => $this->request->getVar('judul'),
            "slug" => $slug,
            "penulis" => $this->request->getVar('penulis'),
            "penerbit" => $this->request->getVar('penerbit'),
            "sampul" => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'data telah diedit');

        return redirect()->to('/comics');
    }

    public function delete($id)
    {
        // cari gambar berdasarkan id
        $komik = $this->komikModel->find($id);
        // cek file jika gambarnya default.jpg
        if ($komik['sampul'] != 'default.jpg') {
            // hapus gambar
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);

        session()->setFlashdata('pesan', 'data telah dihapus');
        return redirect()->to('/comics');
    }
}
