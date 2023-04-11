<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class MTransaksi extends Model
{
    protected $table            = 'tbl_transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $allowedFields    = ['inv', 'no_resi', 'service', 'warehouse', 'ekspedisi', 'agen', 'cp_name', 'status_pod','desc','status_hub','ongkir','update_resi'];
    protected $useTimestamps    = true;
    protected $column_order     = array(null,'inv','service','warehouse', 'ekspedisi', 'no_resi', 'agen','status_pod',  'status_hub', 'ongkir', 'update_resi','created_at', null);
    protected $column_search    = array('inv','service','warehouse', 'ekspedisi', 'no_resi', 'agen','status_pod','status_hub','ongkir', 'created_at','update_resi');
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
        $builder = $this->dt;
        $builder->select('tbl_transaksi.*,tbl_customer.id_customer AS id_cust , tbl_customer.nama_customer, tbl_ekspedisi.ekspedisi as nama_ekspedisi');
        $builder->join('tbl_customer', 'tbl_customer.id_customer = tbl_transaksi.warehouse');
        $builder->join('tbl_ekspedisi', 'tbl_ekspedisi.id_ekspedisi = tbl_transaksi.ekspedisi');
        $query = $builder->get();
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

    public function jnt($resi)
    {
        $username = 'CREWDIBLE';
        $password = 'YdVMlGvK2yE110ko';
        $billcode =  $resi;
        $companyId = "CREWDIBLE"; // Your eccompanyid value

        $data = array(
            'awb' => $billcode,
            'eccompanyid' => $companyId,
        );

        $dataField = json_encode($data);
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://interchange.jet.co.id:22268/jandt-order-web/track/trackAction!tracking.action',
            CURLOPT_USERPWD => $username . ":" . $password,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_POSTFIELDS => $dataField,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER => [
                'Content-Type:application/json',
                'Authorization :basic Q1JFV0RJQkxFOllkVk1sR3ZLMnlFMTEwa28=',
                'Accept'        =>  "application/json",
            ],

        ));

        $response = curl_exec($ch);

        curl_close($ch);
        $data2 = json_decode($response);

        return $data2;
    }

    public function sicepat($resi)
    {
        $apiKey = 'ae69c72e3d86a21c19288a6e2c4ce504';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.sicepat.com/customer/waybill?api-key=" . $apiKey . "&waybill=" . $resi . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data1 = json_decode($response);

        return $data1;

    }

    public function other($resi, $exp)
    {
        $url = 'https://api.binderbyte.com/v1/track?';
        $key = 'fc2d0f3fa9318f0ae9a01bc43a26b485d120b3873a4efae10976ce0a79e0cc6c';

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.binderbyte.com/v1/track?api_key=fc2d0f3fa9318f0ae9a01bc43a26b485d120b3873a4efae10976ce0a79e0cc6c&courier=" . $exp . "&awb=" . $resi . "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data2 = json_decode($response);

        return $data2;
    }
}
