<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MAgen;
use App\Models\MNoOutbound;
use App\Models\MNoSorting;
use App\Models\MOutbound;
use App\Models\MSorting;
use App\Models\MTransaksi;
use Config\Services;

use function PHPUnit\Framework\isNull;

class COutbound extends BaseController
{
    public function __construct()
    {
        $request = Services::request();
        $this->modelTransaksi       = new MTransaksi($request);
        $this->modelNoOutbound      = new MNoOutbound($request);
        $this->modelOutbound        = new MOutbound();
        $this->modelNoSorting       = new MNoSorting($request);
        $this->modelAgen            = new MAgen($request);
        $this->modelSorting         = new MSorting();
    }
    public function index()
    {
        $data = [
            'menu'      => 'outbound',
            'submenu'   => 'Outbound',
            'link'      => 'COutbound/index',
            // 'idInbound' => $modelInboun->idInbound(),
        ];
        return view('Outbound/listOutbound', $data);
    }
    public function dataAjax()
    {
        $request = Services::request();
        $datatable = new MNoOutbound($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $this->modelNoOutbound->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $button = "
                        <button class=\"btn btn-sm btn-info\" id=\"updateData\" onclick=\"detail($list->id_outbound)\" ><i class=\"fa fa-edit\"></i></button>
                    ";

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->code_outbound;
                $row[] = $list->qty;
                $row[] = $list->created_at;
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
    public function buatOutbound()
    {
        $data = [
            'menu'          => 'outbound',
            'submenu'       => 'Outbound / Create Outbound',
            'link'          => 'COutbound/buatOutbound',
            'idOutbound'    => $this->modelNoOutbound->idOutbound(),
            'listSorting'   => $this->modelNoSorting->listSorting(),
            'agen'          => $this->modelAgen->listAgen(),
        ];
        return view('Outbound/index', $data);
    }
    public function modalList()
    {
        if ($this->request->isAJAX()) {
            $code = $this->request->getVar('id');
            $getCode = $this->modelNoOutbound->getWhere(['id_outbound' => $code])->getRow();
            $codeIn  = $getCode->code_inbound;
            $data = [
                'listData'  => $this->modelInbound->tampilDataListModal($codeIn),
            ];
            $json = [
                'data' => view('Inbound/modalListResi', $data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function tableOutbound()
    {
        if ($this->request->isAJAX()) {
            $codeIn = 1;
            $data = [
                'data' => $this->modelOutbound->tampilDataListModal($codeIn)
            ];
            $json = [
                'data' => view('Outbound/tableOutbound', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function addOutbound()
    {
        if ($this->request->isAJAX()) {
        $idSorting = $this->request->getPost('idSorting');
        $agen      = $this->request->getPost('agen');
        $idOutbound = $this->request->getPost('idOutbound');

        $codeSorting = $this->modelNoSorting->getWhere(['id_sorting'=> $idSorting])->getRow();

        // var_dump($idSorting);die;
        $getNoSorting   = $this->modelNoSorting->getWhere(['id_sorting' => $idSorting]);
        $listSorting    = $this->modelSorting->getWhere(['code_sorting' => $codeSorting->code_sorting])->getResult();
        $listOutbound   = $this->modelNoOutbound->getWhere(['id_outbound' => $idOutbound]);
        $modelOutbound  = new MOutbound();
        // var_dump($listSorting);die;
        if ($listOutbound->getNumRows() > 0) {
            $json = [
                'error'     => 'Id Outbound ini sudah di proses',
            ];
        } else {
            if ($getNoSorting->getNumRows() > 0) {
                foreach ($listSorting as $z) {
                    $list = [
                        'code_outbound'     => $idOutbound,
                        'code_sorting'      => $codeSorting->code_sorting,
                        'ekspedisi'         => $z->ekspedisi,
                        'resi_out'          => $z->resi,
                        'warehouse'         => $z->warehouse,
                        'agen'              => $agen,
                        'status'            => 1,
                    ];
                    $modelOutbound->insert($list);
                    $this->modelNoSorting->update($idSorting, ['status'=>1]);
                }
            }else{
                $json = [
                    'error' => 'No Sorting ini tidak ada',
                ];
            }
            $json = [
                'success'       => 'Outbound berhasil di input'
            ];
        }

        echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function simpanOutbound()
    {
        if ($this->request->isAJAX()) {
            $codeOutbound = $this->request->getVar('codeOutbound');

            // get data Outbound
            $queryOutbound  = $this->modelNoOutbound->getWhere(['code_outbound'=> $codeOutbound])->getRow();
            $queryOut       = $this->modelOutbound->getWhere(['code_outbound'=> $codeOutbound])->getResult();
            $countdata      = count($this->modelOutbound->getWhere(['code_outbound'=> $codeOutbound])->getResult());
            

            if($queryOutbound == null){

                foreach ($queryOut as $z) {
                    $id = $z->id_outbound;
                    $resi = $z->resi_out;
                    $noSorting = $z->code_sorting;

                    // var_dump($noSorting);
                    // die;
                    
                    // update status outbound
                    $this->modelOutbound->update($id, ['status' => 2]);

                    $queryTransaksi = $this->modelTransaksi->getWhere(['no_resi' => $resi])->getResult();

                    // update no sorting
                    $querySoorting = $this->modelNoSorting->getWhere(['code_sorting'=>$noSorting])->getresult();
                    foreach($querySoorting as $n){
                        $idSorting = $n->id_sorting;
                        $this->modelNoSorting->update($idSorting, ['status'=>1]);
                    }
                    
                    // update status di transaksi
                    foreach ($queryTransaksi as $i) {
                        $idTransaksi = $i->id_transaksi;
                        $this->modelTransaksi->update($idTransaksi, ['status_hub' => 3]);
                    }
                }

                // input no outbound
                $this->modelNoOutbound->insert([
                    'code_outbound'     => $codeOutbound,
                    'qty'               => $countdata,
                ]);

                $json = [
                    'success'             => 'Outbound berhasil di input'
                ];
            }else{
                $json = [
                    'error'             => 'Code ini sudah pernah di input'
                ];

            }
            echo json_encode($json);

        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
