<?php

namespace App\Models;

use CodeIgniter\Model;

class MInbound extends Model
{
    protected $table            = 'tbl_inbound';
    protected $primaryKey       = 'id_inbound';
    protected $allowedFields    = ['code_inbound', 'resi', 'ekspedisi', 'desc', 'agen', 'warehouse'];
    protected $useTimestamps    = true;

    public function idInbound()
    {
        $kode = $this->db->table('tbl_inbound')->select('RIGHT(code_inbound,3) as id', false)->orderBy('code_inbound', 'DESC')->limit(1)->get()->getRowArray();
        $userId = user()->id;
        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $tgl = date('Ymd');
        $awal = "IN";
        $l = "-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $idInbound = $awal . $l .$userId. $tgl . $batas;
        return $idInbound;
    }

    public function tampilData()
    {
        $builder = $this->db->table('tbl_inbound');
        $builder->select('*');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_inbound.warehouse');
        $data = $builder->get();
        // $data = $this->db->table('tbl_inbound')->get();

        return $data->getresult();
    }
    public function tampilDataList()
    {
        $builder = $this->db->table('tbl_inbound');
        $builder->select('tbl_inbound.*, tbl_customer.nama_customer as namaCustomer, tbl_ekspedisi.ekspedisi as namaEkspedisi');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_inbound.warehouse');
        $builder->join('tbl_ekspedisi', 'tbl_ekspedisi.id_ekspedisi=tbl_inbound.ekspedisi');
        $builder->where('desc',1);
        $data = $builder->get();
        // $data = $this->db->table('tbl_inbound')->get();

        return $data->getresult();
    }
    public function tampilDataListModal($codeIn)
    {
        $builder = $this->db->table('tbl_inbound');
        $builder->select('*');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_inbound.warehouse');
        $builder->where('code_inbound', $codeIn);
        $data = $builder->get();
        // $data = $this->db->table('tbl_inbound')->get();

        return $data->getresult();
    }
}
