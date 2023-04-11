<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CReport extends BaseController
{
    public function index()
    {
        $data = [
            'menu'      => 'report',
            'submenu'   => 'Report',
            'link'      => 'CReport/index'
        ];
        return view('Report/index', $data);
    }
}
