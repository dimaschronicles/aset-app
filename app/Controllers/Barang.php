<?php

namespace App\Controllers;

class Barang extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Data Barang',
        ];

        return view('barang/index', $data);
    }
}
