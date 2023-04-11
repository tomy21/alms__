<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MCustomer;
use App\Models\MEkspedisi;
use App\Models\MNoReturn;
use App\Models\MOutbound;
use App\Models\MReturn;
use App\Models\MTransaksi;
use Config\Services;

class CReturn extends BaseController
{
    public function index()
    {
        $request = Services::request();
        $desc = "Warehouse";
        $modelWarehouse = new MCustomer($request);
        $modelEkspedisi = new MEkspedisi();

        $data = [
            'menu'      => 'return',
            'submenu'   => 'Return',
            'link'      => 'CReturn/index',
            'data'      => $modelWarehouse->listWarehouse($desc),
            'ekspedisi' => $modelEkspedisi->listEkspedisi(),
        ];
        return view('Return/index', $data);
    }
    public function createOutbound()
    {
        $request = Services::request();
        $modelNoReturn = new MNoReturn($request);


        $data = [
            'menu'      => 'return',
            'submenu'   => 'OutboundReturn',
            'link'      => 'CReturn/index',
            'idReturn'  => $modelNoReturn->idReturn(),
        ];
        return view("Return/outboundReturn", $data);
    }
    public function historyReturn()
    {
        $data = [
            'menu'      => 'return',
            'submenu'   => 'History',
            'link'      => 'CReturn/index'
        ];
        return view("Return/historyReturn", $data);
    }
    public function tableReturn()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $modelReturn = new MReturn($request);

            $data = [
                'list'      => $modelReturn->tampilDataOut(),
            ];

            $json = [
                'data' => view('Return/tableReturn', $data),
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function dataAjax()
    {
        $request = Services::request();
        $datatable = new MReturn($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $tglManifest = strtotime($list->created_at);
                $tglPOD = strtotime($list->updated_at);
                $sla    = $tglPOD - $tglManifest;

                $print =  "H+" . floor($sla / 60 / 60 / 24);
                $button = "
                        <button class=\"btn btn-sm btn-danger\" id=\"hapusData\" onclick=\"hapus($list->id_return)\" ><i class=\"fa fa-trash-alt\"></i></button>
                    ";

                if ($list->desc == 'in') {
                    $status = "<span class=\"badge badge-danger\">In Process</span>";
                } else {
                    $status = "<span class=\"badge badge-success\">Out Process</span>";
                }

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->resi;
                $row[] = $list->code_return;
                $row[] = $list->nama_customer;
                $row[] = $list->ekspedisiName;
                $row[] = $list->namaAgen;
                $row[] = $status;
                $row[] = $list->created_at;
                $row[] = $list->updated_at ? $print : "-";
                $row[] = $button;
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
    public function addReturn()
    {
        if ($this->request->isAJAX()) {
            $noAwb = $this->request->getPost('awb');
            $request = Services::request();
            $modelOutbound = new MOutbound();
            $modelReturn    = new MReturn($request);
            $modelTransaksi = new MTransaksi($request);

            $getQuery       = $modelOutbound->getWhere(['resi_out' => $noAwb])->getResult();
            $getIdTransaksi = $modelTransaksi->getWhere(['no_resi' => $noAwb])->getResult();

            // var_dump(count($getQuery));die;

            if (count($getQuery) == 0) {
                $json = [
                    'error' => 'Resi belum pernah di input',
                ];
            } else {
                foreach ($getQuery as $k) {
                    $data = [
                        'code_return'   => '-',
                        'resi'          => $noAwb,
                        'ekspedisi'     => $k->ekspedisi,
                        'warehouse'     => $k->warehouse,
                        'agen'          => $k->agen,
                        'desc'          => 'In',
                    ];
                    $modelReturn->insert($data);
                }
                foreach ($getIdTransaksi as $z) {
                    $modelTransaksi->update($z->id_transaksi, ['status_hub' => 4]);
                }

                $json = [
                    'success' => 'data berhasil di input'
                ];
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function hapusData()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $request = Services::request();
            $modelReturn    = new MReturn($request);

            $modelReturn->delete($id);

            $json = [
                'success'       => 'Data Inbound berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function addOutReturn()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('awb');
            $code = $this->request->getPost('idReturn');
            $request = Services::request();
            $modelReturn    = new MReturn($request);
            $queryId = $modelReturn->getWhere(['resi' => $id])->getResult();

            // var_dump(count($queryId));die;
            if (count($queryId) == 0) {
                $json = [
                    'error'       => 'Resi ini belum diterima'
                ];
            } else {
                foreach ($queryId as $x) {
                    $modelReturn->update($x->id_return, ['desc' => 'out', 'code_return' => $code]);
                }

                $json = [
                    'success'       => 'Data Inbound berhasil dihapus'
                ];
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function simpanReturn()
    {
        if ($this->request->isAJAX()) {
            $code = $this->request->getPost('codeReturn');
            $request = Services::request();
            $modelReturn        = new MReturn($request);
            $modelNoReturn      = new MNoReturn($request);
            $modelTransaksi     = new MTransaksi($request);
            $queryId = $modelReturn->getWhere(['code_return' => $code])->getResult();

            // var_dump(count($queryId));die;

            foreach ($queryId as $x) {
                $modelReturn->update($x->id_return, ['desc' => 'done']);

                $queryTransaksi = $modelTransaksi->getWhere(['no_resi' => $x->resi])->getResult();
                
                foreach($queryTransaksi as $z){
                    $idTransaksi = $z->id_transaksi;
                    $modelTransaksi->update($idTransaksi,['status_hub'=> 5]);
                }
            }

            $data= [
                'code_return'       => $code,
                'qty'               => count($queryId),
                'status'            => 1,
            ];
            $modelNoReturn->insert($data);

            $json = [
                'success'       => 'Data Inbound berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
