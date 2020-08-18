<?php

namespace App\Controllers;

use App\Models\OrangModel;
use CodeIgniter\CodeIgniter;
use CodeIgniter\Config\Config;

class Orang extends BaseController
{
    protected $orangModel;

    public function __construct()
    {
        $this->orangModel = new OrangModel();
    }

    public function index()
    {
        $curentPage = $this->request->getVar('page_orang') ? $this->request->getVar('page_orang') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $orang = $this->orangModel->search($keyword);
        } else {
            $orang = $this->orangModel;
        }
        $data = [
            "title" => "daftar orang",
            "orang" => $orang->paginate(5, 'orang'),
            "pager" => $this->orangModel->pager,
            "curent_page" => $curentPage
        ];

        return view('orang/index', $data);
    }
}
