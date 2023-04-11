<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MCustomer extends Model
{
    protected $table            = 'tbl_customer';
    protected $primaryKey       = 'id_customer';
    protected $allowedFields    = ['code_customer', 'desc_cust', 'nama_customer', 'alamat_customer','email', 'phone', 'longitude', 'latitude','pic_name', 'join_date', 'status'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null, 'nama_customer', 'desc_cust', 'phone', 'email', 'pic_name', null, null, 'status', null, null);
    protected $column_search    = array('nama_customer', 'alamat_agen', 'phone', 'pic_name');
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

    public function getDatatables($desc)
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->where('desc_cust',$desc)->get();
        return $query->getResult();
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
    public function idSeller()
    {
        $kode = $this->db->table('tbl_customer')->select('RIGHT(code_customer,3) as id', false)->orderBy('code_customer', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $tgl = date('Ymd');
        $awal = "Sel";
        $l = "-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $idAgen = $awal . $l . $tgl . $batas;
        return $idAgen;
    }
    public function idWarehouse()
    {
        $kode = $this->db->table('tbl_customer')->select('RIGHT(code_customer,3) as id', false)->orderBy('code_customer', 'DESC')->limit(1)->get()->getRowArray();

        // $no = 1;
        if (isset($kode['id']) == null) {
            $no = 1;
        } else {
            $no = intval($kode['id']) + 1;
        }

        $tgl = date('Ymd');
        $awal = "WH";
        $l = "-";
        $batas = str_pad($no, 3, "0", STR_PAD_LEFT);
        $idAgen = $awal . $l . $tgl . $batas;
        return $idAgen;
    }

    public function listWarehouse($desc)
    {
        $list = $this->dt->where('desc_cust',$desc)->get();

        return $list->getResult();
    }
}
