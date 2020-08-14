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
        $komik = $this->komikModel->findAll();

        $data = [
            "title" => "daftar komik",
            "komik" => $komik
        ];


        return view('comic/index', $data);
    }
}
