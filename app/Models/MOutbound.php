<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MOutbound extends Model
{
    protected $table            = 'tbl_outbound';
    protected $primaryKey       = 'id_outbound';
    protected $allowedFields    = ['code_outbound', 'code_sorting', 'ekspedisi', 'resi_out', 'warehouse', 'agen', 'status'];
    protected $useTimestamps    = true;

    public function tampilData()
    {
        $builder = $this->db->table('tbl_outbound');
        $builder->select('tbl_outbound.*, tbl_customer.nama_customer as namaCustomer, tbl_ekspedisi.ekspedisi as namaEkspedisi');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_outbound.warehouse');
        $builder->join('tbl_ekspedisi', 'tbl_ekspedisi.id_ekspedisi=tbl_outbound.ekspedisi');
        $data = $builder->get();
        // $data = $this->db->table('tbl_inbound')->get();

        return $data->getresult();
    }
    public function tampilDataListModal($codeIn)
    {
        $builder = $this->db->table('tbl_outbound');
        $builder->select('tbl_outbound.*, tbl_customer.nama_customer AS namaCustomer, tbl_customer.status AS statusCust, tbl_ekspedisi.ekspedisi AS namaEkspedisi');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_outbound.warehouse');
        $builder->join('tbl_ekspedisi', 'tbl_ekspedisi.id_ekspedisi=tbl_outbound.ekspedisi');
        $builder->where('tbl_outbound.status', $codeIn);
        $data = $builder->get();
        // $data = $this->db->table('tbl_inbound')->get();

        return $data->getresult();
    }
}
