<?php

namespace App\Controllers;

class Comics extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "daftar komik"
        ];
        return view('comic/index', $data);
    }
}
