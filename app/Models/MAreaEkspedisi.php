<?php

namespace App\Models;

use CodeIgniter\Model;

class MAreaEkspedisi extends Model
{
    protected $table            = 'tbl_areasorting';
    protected $primaryKey       = 'id_area';
    protected $allowedFields    = ['id_ekspedisi','area'];
    protected $useTimestamps    = true;

    public function listArea($id_ekspedisi)
    {
        $getData = $this->db->table('tbl_areasorting')->where('id_ekspedisi', $id_ekspedisi)->get()
        ->getResultArray();

        return $getData;
    }
}
