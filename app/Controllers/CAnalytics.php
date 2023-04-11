<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CAnalytics extends BaseController
{
    public function index()
    {
        $data = [
            'menu'      => 'analytics',
            'submenu'   => 'Analytics',
            'link'      => 'CAnalytics/index'
        ];
        return view('Analytics/index', $data);
    }
}
