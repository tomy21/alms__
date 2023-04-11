<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MAreaEkspedisi;
use App\Models\MEkspedisi;
use App\Models\MInbound;
use App\Models\MNoSorting;
use App\Models\MSorting;
use App\Models\MTransaksi;
use Config\Services;

class CSorting extends BaseController
{
    public function __construct()
    {
        $request = Services::request();
        $this->modelTransaksi = new MTransaksi($request);
        $this->modelListEkspedisi  = new MEkspedisi();
        $this->modelNoSorting  = new MNoSorting($request);
        $this->modelAreaSorting = new MAreaEkspedisi();
        $this->modelSorting = new MSorting();
    }
    public function index()
    {
        $data = [
            'menu'      => 'sorting',
            'submenu'   => 'Sorting',
            'link'      => 'CSorting/index',
            // 'code'      => $this->modelNoSorting->idSorting(),
            // 'ekspedisi' => $this->modelListEkspedisi->listEkspedisi(),
        ];
        return view('Sorting/listSorting', $data);
    }
    public function buatSorting()
    {
        $data = [
            'menu'      => 'sorting',
            'submenu'   => 'Sorting / Buat Sorting',
            'link'      => 'CSorting/index',
            'code'      => $this->modelNoSorting->idSorting(),
            'ekspedisi' => $this->modelListEkspedisi->listEkspedisi(),
        ];
        return view('Sorting/index', $data);
    }
    public function tableSorting()
    {
        if ($this->request->isAJAX()) {
            $data =[
                'data'  => $this->modelSorting->tampilData(),
            ];

            $json = [
                'data' => view('Sorting/tableSorting',$data),
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function areaEkspedisi()
    {
        $id_ekspedisi = $this->request->getPost('id_eks');
        $data = $this->modelAreaSorting->listArea($id_ekspedisi);

        echo '<option value=""> -- Pilih Area -- </option>';
        foreach($data as $x){
            echo '<option value="'.$x['id_area']. '"> ' . $x['area'] . ' </option>';
        }

    }
    public function addSorting()
    {
        if ($this->request->isAJAX()) {
            $awb = $this->request->getVar('awb');
            $idIn = $this->request->getVar('idIn');
            $area = $this->request->getVar('area');
            $ekspedisi = $this->request->getVar('ekspedisi');

            $modelSorting = new MSorting();
            $modelInbound = new MInbound();
            $getData = $modelSorting->getWhere(['resi' => $awb]);
            $get = $modelInbound->getWhere(['resi' => $awb])->getRow();
            $count = $modelInbound->getWhere(['resi' => $awb]);
            // var_dump($get->warehouse);die;

            if ($count->getNumRows() < 1) {
                $json = [
                    'error' => "Resi tidak ada"
                ];
            }else if($get->ekspedisi != $ekspedisi){
                $json = [
                    'error' => "Salah ekspedisi"
                ];
            }else if ($getData->getNumRows() > 0) {
                $json = [
                    'error' => "Resi sudah ada"
                ];
            }else {
                $data = [
                    'code_sorting'  => $idIn,
                    'resi'          => $awb,
                    'ekspedisi'     => $ekspedisi,
                    'warehouse'     => $get->warehouse,
                    'area'          => $area,
                    'status_sort'   => 1,
                ];
                $modelSorting->insert($data);

                $json = [
                    'success' => 'Berhasil diinput'
                ];
            }

            echo json_encode($json);
        } else {
            exit("data not found");
        }
    }
    public function hapusData()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $request = Services::request();
            $modelAgen = new MSorting();
            $modelAgen->delete($id);

            $json = [
                'success'       => 'Data Inbound berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function simpanSorting()
    {
        if ($this->request->isAJAX()) {
            $codeSorting    = $this->request->getVar('codeSorting');
            $ekspedisi      = $this->request->getVar('ekspedisi');
            $cekSorting     = $this->modelSorting->getWhere(['code_sorting' => $codeSorting])->getResult();
            $jumlah         = count($cekSorting);
            // var_dump($jumlah);die;

            foreach($cekSorting as $x){
                $resi   = $x->resi;
                $getIdTransaksi = $this->modelTransaksi->getWhere(['no_resi'=> $resi])->getResult();

                foreach($getIdTransaksi as $y){
                    $data = [
                        'status_hub'   => 2, 
                    ];
                    $this->modelTransaksi->update($y->id_transaksi,$data);

                    $json = [
                        'success'       => 'Data berhasil disorting'
                    ];
                }

                $this->modelSorting->update($x->id_sorting,['status_sort' => 2]);
            }
            $listSorting = [
                'code_sorting'  => $codeSorting,
                'qty'           => $jumlah,
                'sort_ekspedisi'=> $ekspedisi,
            ];

            if ($jumlah == 0) {
                $json = [
                    'error'       => 'Tidak ada resi yang di input'
                ];
            } else {
                $this->modelNoSorting->insert($listSorting);
            }

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function dataAjax()
    {
        $request = Services::request();
        $datatable = new MNoSorting($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $button = "
                        <button class=\"btn btn-sm btn-info\" id=\"updateData\" onclick=\"detail($list->id_sorting)\" ><i class=\"fa fa-edit\"></i></button>
                    ";

                if ($list->status == 0) {
                    $status = "<span class=\"badge badge-danger\">Process</span>";
                } else {
                    $status = "<span class=\"badge badge-success\">Done</span>";
                }

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->code_sorting;
                $row[] = $list->qty;
                $row[] = $list->created_at;
                $row[] = $status;
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
    public function modalList()
    {
        if ($this->request->isAJAX()) {
            $code = $this->request->getVar('id');
            $getCode = $this->modelNoSorting->getWhere(['id_sorting' => $code])->getRow();
            $codeIn  = $getCode->code_sorting;
            $data = [
                'listData'  => $this->modelSorting->tampilDataListModal($codeIn),
            ];
            $json = [
                'data' => view('Sorting/modalSorting', $data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
