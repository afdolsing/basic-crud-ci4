<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Home | WPU"
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            "title" => "About Me"
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            "title" => "contact us",
            "alamat" => [
                [
                    "tipe" => "Rumah",
                    "alamat" => "jl ikan laut, no 2020",
                    "kota" => "ponorogo"
                ],
                [
                    "tipe" => "Kantor",
                    "alamat" => "jl sarden abc, no 123",
                    "kota" => "malang"
                ]
            ]
        ];
        return view('pages/contact', $data);
    }
    //--------------------------------------------------------------------

}
