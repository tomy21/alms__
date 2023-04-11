<?php

namespace App\Models;

use CodeIgniter\Model;

class MEkspedisi extends Model
{
    protected $table            = 'tbl_ekspedisi';
    protected $primaryKey       = 'id_ekspedisi';
    protected $allowedFields    = ['ekspedisi'];
    protected $useTimestamps    = true;

    public function listEkspedisi()
    {
        $getData = $this->db->table('tbl_ekspedisi')->get()->getResult();

        return $getData;
    }
}
