<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MNoInbound extends Model
{
    protected $table            = 'tbl_noinbound';
    protected $primaryKey       = 'id_inbound';
    protected $allowedFields    = ['code_inbound', 'qty'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null,'code_inbound', 'qty','status','created_at', null);
    protected $column_search    = array('code_inbound', 'created_at', 'qty');
    protected $order            = array('created_at' => 'desc_cust');
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
        $query = $this->dt->get();
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
    public function idInbound()
    {
        $kode = $this->db->table('tbl_noinbound')->select('RIGHT(code_inbound,3) as id', false)->orderBy('code_inbound', 'DESC')->limit(1)->get()->getRowArray();
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
        $idInbound = $awal . $l . $userId . $tgl . $batas;
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
}
