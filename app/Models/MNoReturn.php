<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MNoReturn extends Model
{
    protected $table            = 'tbl_noreturn';
    protected $primaryKey       = 'id_return';
    protected $allowedFields    = ['code_return', 'qty', 'status'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null, 'code_return', 'qty', 'status', null);
    protected $column_search    = array('code_return', 'qty', 'status');
    protected $order            = array('created_at' => 'desc');
    protected $request;
    protected $dt;
    protected $db;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
    }
    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $_POST['search']['value']);
                } else {
                    $this->dt->orLike($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }
        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $builder = $this->db->table('tbl_return');
        $builder->select('*, tbl_ekspedisi.ekspedisi as ekspedisiName,tbl_agen.nama_agen as namaAgen');
        $builder->join('tbl_customer', 'tbl_customer.id_customer=tbl_return.warehouse');
        $builder->join('tbl_ekspedisi', 'tbl_ekspedisi.id_ekspedisi = tbl_return.ekspedisi');
        $builder->join('tbl_agen', 'tbl_agen.id_agen = tbl_return.agen');
        $data = $builder->get();
        return $data->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

    public function idReturn()
    {
        $kode = $this->db->table('tbl_noreturn')->select('RIGHT(code_return,3) as id', false)->orderBy('code_return', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $tgl = date('Ymd');
        $awal = "RTN";
        $l = "-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $idInbound = $awal . $l . $tgl . $batas;
        return $idInbound;
    }
}
