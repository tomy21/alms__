<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MTransaksi;
use Config\Services;
use DateTime;

class CStatus extends BaseController
{
    function __construct()
    {
        $request = Services::request();
        $this->modelTransaksi = new MTransaksi($request);
    }
    public function index()
    {
        $data = [
            'menu' => 'status',
            'submenu' => 'index',
            'link'      => 'CStatus/index'
        ];

        return view('Transaksi/status', $data);
    }

    public function dataAjax()
    {
        $request = Services::request();
        $datatable = new MTransaksi($request);

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables();
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $tglManifest = strtotime($list->update_resi);
                $tglPOD = strtotime($list->created_at);
                $sla    = $tglPOD - $tglManifest;

                $print =  "H+" . floor($sla / 60 / 60 / 24);

                if ($list->status_hub == 1) {
                    $status = "<span class=\"badge badge-info\">In Hub</span>";
                } else if ($list->status_hub == 2) {
                    $status = "<span class=\"badge badge-warning\">Sort</span>";
                } else if($list->status_hub == 3) {
                    $status = "<span class=\"badge badge-primary\">Out</span>";
                } else if ($list->status_hub == 4) {
                    $status = "<span class=\"badge badge-danger\">Return</span>";
                }else {
                    $status = "<span class=\"badge badge-success\">Returned</span>";
                }

                $button = "
                        <button class=\"btn btn-sm btn-info\" id=\"updateData\" onclick=\"detail($list->id_transaksi)\" ><i class=\"fa fa-eye\"></i></button>
                    ";

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->inv;
                $row[] = $list->no_resi;
                $row[] = $list->nama_customer;
                $row[] = $list->nama_ekspedisi;
                $row[] = $list->status_pod;
                $row[] = $list->desc;
                $row[] = $status;
                $row[] = $list->ongkir;
                $row[] = $list->update_resi == "" ? '-' : $print;
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

    function update_resi()
    {
        $getDataTransaksi = $this->modelTransaksi->findAll();

        foreach ($getDataTransaksi as $z) {
            $id         = $z["id_transaksi"];
            $inv        = $z["inv"];
            $resi       = $z["no_resi"];
            $date       = date('Y-m-d h:i:s', strtotime($z['updated_at']));
            $ekspedisi  = $z["ekspedisi"];

            $timeNow    = date("Y-m-d h:i:s");

            if($timeNow < $date){
                if ($z['status_hub'] == 3) {
                    if ($timeNow > $date) {
                        if ($ekspedisi == 1) {
                            if ($z['status_pod'] != "DELIVERED") {
                                $getUpdate = $this->modelTransaksi->jnt($resi);
                                $jumlahArray = count($getUpdate->history) - 1;
                                $awb        = isset($getUpdate->awb) ? $getUpdate->awb : "-";
                                $getID       = $this->modelTransaksi->getWhere(['no_resi' => $resi])->getRow();
                                if (end($getUpdate->history)->status_code == 101) {
                                    $updateStatus = "Order has been created";
                                } elseif (end($getUpdate->history)->status_code == 100) {
                                    $updateStatus = "Package has been picked up by J&T";
                                } elseif (end($getUpdate->history)->status_code == 162) {
                                    $updateStatus = "Cancelled by Seller";
                                } elseif (end($getUpdate->history)->status_code == 162) {
                                    $updateStatus = "Cancelled AWB";
                                } elseif (end($getUpdate->history)->status_code == 150) {
                                    $updateStatus = "Problem with shipment / Onhold";
                                } elseif (end($getUpdate->history)->status_code == 151) {
                                    $updateStatus = "Problem on pickup process";
                                } elseif (end($getUpdate->history)->status_code == 152) {
                                    $updateStatus = "Problem on delivery process";
                                } elseif (end($getUpdate->history)->status_code == 200) {
                                    $updateStatus = "Delivered";
                                } elseif (end($getUpdate->history)->status_code == 402) {
                                    $updateStatus = "Package returned to sender";
                                } elseif (end($getUpdate->history)->status_code == 401) {
                                    $updateStatus = "Package will be returned to sender";
                                } else {
                                    $updateStatus = "no data";
                                }
                                $data = [
                                    // 'awb'               => isset($getUpdate->result->waybill_number) ? $getUpdate->result->waybill_number : "-",
                                    'status_pod'        => isset($updateStatus) ? $updateStatus : "-",
                                    'desc'              => isset(end($getUpdate->history)->status) ? end($getUpdate->history)->status : '-',
                                    'update_resi'       => isset($getUpdate->history[0]->date_time) ? $getUpdate->history[0]->date_time : "-",
                                    'ongkir'            => isset($getUpdate->detail->actual_amount) ? $getUpdate->detail->actual_amount : "-",
                                ];
                                $this->modelTransaksi->update($getID->id_transaksi, $data);
                            } else {
                                continue;
                            }
                        } else if ($ekspedisi == 4) {
                            if ($z['status_pod'] != "DELIVERED") {
                                $getUpdate  = $this->modelTransaksi->sicepat($resi);
                                $awb        = isset($getUpdate->result->waybill_number) ? $getUpdate->result->waybill_number : "-";
                                $getID       = $this->modelTransaksi->getWhere(['no_resi' => $resi])->getRow();
                                // var_dump($getID);die;
                                $data = [
                                    // 'awb'               => isset($getUpdate->result->waybill_number) ? $getUpdate->result->waybill_number : "-",
                                    'status_pod'        => isset($getUpdate->sicepat->result->last_status->status) ? $getUpdate->sicepat->result->last_status->status : "-",
                                    'desc'              => isset($getUpdate->sicepat->result->last_status->city) ? $getUpdate->sicepat->result->last_status->city : $getUpdate->sicepat->result->last_status->receiver_name,
                                    'update_resi'       => isset($getUpdate->sicepat->result->track_history[0]->date_time) ? $getUpdate->sicepat->result->track_history[0]->date_time : "-",
                                    'ongkir'            => isset($getUpdate->sicepat->result->totalprice) ? $getUpdate->sicepat->result->totalprice : "-",
                                ];
                                $this->modelTransaksi->update($getID->id_transaksi, $data);
                            } else {
                                continue;
                            }
                        } else {
                            if ($z['status_pod'] != "DELIVERED") {
                                if ($ekspedisi == 2) {
                                    $eks = "spx";
                                } else if ($ekspedisi == 3) {
                                    $eks = "jne";
                                } else if ($ekspedisi == 5) {
                                    $eks = "lzd";
                                } else if ($ekspedisi == 6) {
                                    $eks = "anteraja";
                                } else if ($ekspedisi == 7) {
                                    $eks = "ninja";
                                } else {
                                    $eks = "sap";
                                }
                                $getUpdate = $this->modelTransaksi->other($resi, $eks);
                                $jumlahArray = count($getUpdate->data->history) - 2;
                                $getID       = $this->modelTransaksi->getWhere(['no_resi' => $resi])->getRow();
                                $data = [
                                    // 'awb'               => isset($getUpdate->data->summary->awb) ? $getUpdate->data->summary->awb : "-",
                                    'status_pod'        => isset($getUpdate->data->summary->status) ? $getUpdate->data->summary->status : "-",
                                    'desc'              => isset($getUpdate->data->history[0]->desc) ? $getUpdate->data->history[0]->desc : "-",
                                    'update_resi'       => isset($getUpdate->data->history[$jumlahArray]->date) ? $getUpdate->data->history[$jumlahArray]->date : "-",
                                ];
                                $this->modelTransaksi->update($getID->id_transaksi, $data);
                            } else {
                                continue;
                            }
                        }
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }  
            }else{
                break;
            }
        }
    }
    public function modalTrack()
    {
        if ($this->request->isAJAX()) {
            $code = $this->request->getVar('id');
            $getCode = $this->modelTransaksi->getWhere(['id_transaksi' => $code])->getRow();
            $resi  = $getCode->no_resi;
            $ekspedisi = $getCode->ekspedisi;


            if($getCode->ekspedisi == 1){
                $getUpdate = $this->modelTransaksi->jnt($resi);
                $dataList  = $getUpdate->history;
            }else if($getCode->ekspedisi == 4){
                $getUpdate  = $this->modelTransaksi->sicepat($resi);
                $dataList   = $getUpdate->sicepat->result->track_history;
            }else{
                if ($ekspedisi == 2) {
                    $eks = "spx";
                } else if ($ekspedisi == 3) {
                    $eks = "jne";
                } else if ($ekspedisi == 5) {
                    $eks = "lzd";
                } else if ($ekspedisi == 6) {
                    $eks = "anteraja";
                } else if ($ekspedisi == 7) {
                    $eks = "ninja";
                } else {
                    $eks = "sap";
                }
                $getUpdate  = $this->modelTransaksi->other($resi, $eks);
                $dataList       = $getUpdate->data->history;
            }
            $data = [
                'listData'  => $dataList,
            ];
            // var_dump($data);die;
            $json = [
                'data' => view('Transaksi/modalTrack', $data),
            ];

            // var_dump($data["listData"]->data->history);
            // die;
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
