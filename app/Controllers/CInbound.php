<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MCustomer;
use App\Models\MEkspedisi;
use App\Models\MInbound;
use App\Models\MNoInbound;
use App\Models\MTransaksi;
use Config\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class CInbound extends BaseController
{
    public function __construct()
    {
        $request = Services::request();
        $this->modelTransaksi = new MTransaksi($request);
        $this->modelInbound  = new MInbound();
        $this->modelNoInbound  = new MNoInbound($request);
    }
    public function index()
    {
        // $request = Services::request();
        // $modelWarehouse = new MCustomer($request);
        $modelInboun = new MInbound();
        // $desc = "Warehouse";
        $data = [
            'menu'      => 'inbound',
            'submenu'   => 'Inbound',
            'link'      => 'CInbound/index',
            // 'idInbound' => $modelInboun->idInbound(),
        ];
        return view('Inbound/listInbound',$data);
    }
    public function modalList(){
        if ($this->request->isAJAX()) {
            $code = $this->request->getVar('id');
            $getCode = $this->modelNoInbound->getWhere(['id_inbound'=>$code])->getRow();
            $codeIn  = $getCode->code_inbound;
            $data = [
                'listData'  => $this->modelInbound->tampilDataListModal($codeIn),
            ];
            $json = [
                'data' => view('Inbound/modalListResi',$data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function dataAjax(){
        $request = Services::request();
        $datatable = new MNoInbound($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $button = "
                        <button class=\"btn btn-sm btn-info\" id=\"updateData\" onclick=\"detail($list->id_inbound)\" ><i class=\"fa fa-edit\"></i></button>
                    ";
                
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->code_inbound;
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
    public function createNewInbound()
    {
        $request = Services::request();
        $modelWarehouse = new MCustomer($request);
        $modelInboun = new MNoInbound($request);
        $modelEkspedisi = new MEkspedisi();
        $desc = "Warehouse";
        $data = [
            'menu'      => 'inbound',
            'submenu'   => 'Create Inbound',
            'link'      => 'CInbound/createNewInbound',
            'data'      => $modelWarehouse->listWarehouse($desc),
            'wh'        => $modelWarehouse->listWarehouse($desc),
            'idInbound' => $modelInboun->idInbound(),
            'ekspedisi' => $modelEkspedisi->listEkspedisi(),
            'count'     => $this->modelInbound->where('desc', 1)->countAllResults(),
            'total'     => $this->modelInbound->like('created_at', date('Y-m-d'))->countAllResults(),
        ];
        return view('Inbound/index', $data);
    }
    public function tableInbound(){
        if ($this->request->isAJAX()) {
            $modelInbound = new MInbound();
            $data = [
                'query' => $modelInbound->tampilDataList(),
                'count'     => $modelInbound->where('desc', 1)->countAllResults(),
            ];
            
            $json = [
                'data' => view('Inbound/tableList', $data)
            ];
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function addInbound()
    {
        if($this->request->isAJAX())
        {
            $awb = $this->request->getVar('awb');
            $idIn= $this->request->getVar('idIn');
            $warehouse = $this->request->getVar('warehouse') ;
            $ekspedisi = $this->request->getVar('ekspedisi');

            $modelInbound = new MInbound();
            $getData = $modelInbound->getWhere(['resi' => $awb]);
            // dd($getData->resi);die;

            if($getData->getNumRows() > 0 ){
                $json = [
                    'error'=> "Resi sudah ada"
                ];
            }else{
                $data = [
                    'code_inbound'  => $idIn,
                    'resi'          => $awb,
                    'ekspedisi'     => $ekspedisi,
                    'warehouse'     => $warehouse,
                    'desc'          => 1,
                ];
                $modelInbound->insert($data);

                $json = [
                    'success' => 'Berhasil diinput'
                ];
            }

            echo json_encode($json);


        }else{
            exit("data not found");
        }
    }
    public function hapusData()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $request = Services::request();
            $modelAgen = new MInbound();
            $modelAgen->delete($id);

            $json = [
                'success'       => 'Data Inbound berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function submitInbound()
    {
        if ($this->request->isAJAX()) {
            $code = $this->request->getVar('codeInbound');
            $request = Services::request();
            $modelInbound = new MInbound();

            $cekNoInbound = $this->modelNoInbound->getWhere(['code_inbound'=>$code])->getRow();
            // var_dump($cekNoInbound['qty']);die;

            $getData = $modelInbound->getWhere(['code_inbound' =>$code])->getResult();
            $jumlahResi = count($getData);
            // var_dump($jumlahResi);die;
            foreach ($getData as $x) {
                $data = [
                    'inv'           => '-',
                    'no_resi'       => $x->resi,
                    'service'       => '-',
                    'warehouse'     => $x->warehouse,
                    'ekspedisi'     => $x->ekspedisi,
                    'agen'          => '-',
                    'cp_name'       => '-',
                    'status_pod'    => '-',
                    'desc'          => '-',
                    'status_hub'    => $x->desc,
                    'ongkir'        => '0',
                    'update_resi'   => '-'
                ];
                

                    $this->modelTransaksi->insert($data);
                    
                    $updateInbound = [
                        'desc'          => 2
                    ];
                    $this->modelInbound->update($x->id_inbound,$updateInbound);
                    
                    $json = [
                        'success'       => 'Data Inbound berhasil diinput'
                    ];
                // }
            }
            $listInbound = [
                'code_inbound'  => $code,
                'qty'           => $jumlahResi,
            ];
            if($jumlahResi == 0){
                $json = [
                    'error'       => 'Tidak ada resi yang di input'
                ];
            }else{
                $this->modelNoInbound->insert($listInbound);
            }
            
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function download()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', "No Resi");
        $sheet->setCellValue('B1', "Ekspedisi");

        $column = 2;

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, '')
            ->setCellValue('B' . $column, '');
        $column++;

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Tamplate Input Manifest';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    public function upload()
    {
        $file_upload    = $this->request->getFile('fileimport');
        $codeIn         = $this->request->getVar('barcode');
        $warehouse      = $this->request->getVar('warehouse');
        $ext            = $file_upload->getClientExtension();

        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_upload);
        $sheet = $spreadsheet->getActiveSheet()->toArray();
        // var_dump($sheet);die;
        foreach($sheet as $x => $row){
            if($x == 0){
                continue;
            }
            $awb        = $row[0];
            $exp        = $row[1];

            $modelInbound = new MInbound();
            $cekResi = $modelInbound->getWhere(['resi'=>$awb])->getResult();

            if(count($cekResi) > 0){
                $pesan_gagal = [
                    'error' => '<div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                            <h5><i class="icon fas fa-ban"></i> Gagal </h5>
                            Data Gagal Di Import  
                            </div>'
                ];
                session()->setFlashdata($pesan_gagal);
            } else {
                if($exp == "spx"){
                    $ekspedisi = 2;
                }else if($exp == "jnt"){
                    $ekspedisi = 1;
                }else if ($exp == "jne") {
                    $ekspedisi = 3;
                }else if ($exp == "sicepat") {
                    $ekspedisi = 4;
                }else if ($exp == "lazada") {
                    $ekspedisi = 5;
                }else if ($exp == "anteraja") {
                    $ekspedisi = 6;
                }else if ($exp == "ninja") {
                    $ekspedisi = 7;
                }else{
                    $ekspedisi = 8;
                }

                $data = [
                    'code_inbound'  => $codeIn,
                    'resi'          => $awb,
                    'ekspedisi'     => $ekspedisi,
                    'warehouse'     => $warehouse,
                    'desc'          => 1,
                ];
                $modelInbound->insert($data);


                $pesan_success = [
                    'success' => '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dissmis="alert" aria-hidden="true">X</button>
                        <h5><i class="icon fas fa-check"></i> Berhasil </h5>
                        Data Berhasil Di Import
                        </div>'
                ];
                session()->setFlashdata($pesan_success);
            }
        }
        return redirect()->to('/CInbound/createNewInbound');
    }
}
