<?php

namespace App\Models;

use CodeIgniter\Model;

class MSorting extends Model
{
    protected $table            = 'tbl_sorting';
    protected $primaryKey       = 'id_sorting';
    protected $allowedFields    = ['code_sorting', 'resi', 'ekspedisi', 'warehouse', 'area','status_sort'];
    protected $useTimestamps    = true;

    public function tampilData()
    {
        $builder = $this->db->table('tbl_sorting');
        $builder->select('*, tbl_ekspedisi.ekspedisi as ekspedisiName');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_sorting.warehouse');
        $builder->join('tbl_ekspedisi', 'tbl_ekspedisi.id_ekspedisi = tbl_sorting.ekspedisi');
        $builder->where('status_sort', 1);
        $data = $builder->get();

        return $data->getResult();
    }
    public function tampilDataListModal($codeIn)
    {
        $builder = $this->db->table('tbl_sorting');
        $builder->select('tbl_sorting.*,tbl_ekspedisi.ekspedisi as namaEkspedisi, tbl_customer.nama_customer as namaCustomer');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_sorting.warehouse');
        $builder->join('tbl_ekspedisi', 'tbl_ekspedisi.id_ekspedisi=tbl_sorting.ekspedisi');
        $builder->where('code_sorting', $codeIn);
        $data = $builder->get();
        // $data = $this->db->table('tbl_inbound')->get();

        return $data->getresult();
    }
}
