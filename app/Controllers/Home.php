<?php

namespace App\Controllers;

use App\Models\MTransaksi;
use Config\Services;

class Home extends BaseController
{
    public function index()
    {
        $request = Services::request();
        $modelTransaksi = new MTransaksi($request);
        $data = [
            'menu'                  => 'dashboard',
            'link'                  => 'Home/index',
            'submenu'               => 'dashboard',
            'alltransaksi'          => count($modelTransaksi->findAll()),
            'transaksiIn'           => count($modelTransaksi->getWhere(['status_hub'=> 1])->getResult()),
            'transaksiSort'         => count($modelTransaksi->getWhere(['status_hub'=> 2])->getResult()),
            'transaksiOut'          => count($modelTransaksi->getWhere(['status_hub'=> 3])->getResult()),
            'transaksiRtn'          => count($modelTransaksi->getWhere(['status_hub'=> 4])->getResult()),
            'transaksiReturned'     => count($modelTransaksi->getWhere(['status_hub'=> 5])->getResult()),
        ];

        return view('layout/dashboard',$data);
    }
}
