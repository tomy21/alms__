<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MUsers;
use Config\Services;

class CUsers extends BaseController
{
    public function index()
    {
        $data = [
            'menu' => 'users',
            'link' => 'Users/index',
            'submenu' => 'Users'
        ];

        return view('Login/listAkun', $data);
    }
    public function dataAjax()
    {
        $request = Services::request();
        $datatable = new MUsers($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                
                if ($list->active == 1) {
                    $status = "<span class=\"badge badge-info\">Active</span>";
                } else {
                    $status = "<span class=\"badge badge-success\">Not Active</span>";
                }

                // $button = "
                //         <button class=\"btn btn-sm btn-info\" id=\"updateData\" onclick=\"detail($list->id_transaksi)\" ><i class=\"fa fa-eye\"></i></button>
                //     ";

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->username;
                $row[] = $list->email;
                $row[] = $status;
                // $row[] = $button;
                $data[] = $row;
            }

            $output = [
                'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
                'recordsTotal' => $datatable->countAll(),
                'recordsFiltered' => $datatable->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    public function modalTambah()
    {
        if ($this->request->isAJAX()) {
            $json = [
                'data' => view('Login/modalTambahUsers'),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
