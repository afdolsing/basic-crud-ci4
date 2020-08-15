<?php

namespace App\Controllers;

use App\Models\ComicModel;

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

        return view('comic/detail', $data);
    }
}
