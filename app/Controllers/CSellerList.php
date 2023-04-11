<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MCustomer;
use Config\Services;

class CSellerList extends BaseController
{
    public function index()
    {
        $data = [
            'menu'      => 'seller',
            'submenu'   => 'list_seller',
            'link'      => 'CSellerList/index'
        ];
        return view('Seller/index',$data);
    }
    public function modalTambah()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $modalAgen = new MCustomer($request);
            $data = [
                'idSeller' => $modalAgen->idSeller(),
                'validation' => \Config\Services::validation(),
            ];
            $json = [
                'data' => view('Seller/tambahSellerModal',$data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function modalUpdate()
    {
        if ($this->request->isAJAX()) {
            $request = Services::request();
            $modalAgen = new MCustomer($request);
            $id         = $this->request->getVar('id');
            $getData    = $modalAgen->getWhere(['id_customer' => $id])->getRow();

            // dd($getData->code_agen);die();
            $data = [
                'idSeller' => $getData->code_customer,
                'name' => $getData->nama_customer,
                'email' => $getData->email,
                'address' => $getData->alamat_customer,
                'phone' => $getData->phone,
                'long' => $getData->longitude,
                'lat' => $getData->latitude,
                'pic' => $getData->pic_name,
                // 'validation' => \Config\Services::validation(),
            ];
            $json = [
                'data' => view('Seller/modalUpdate', $data),
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function dataAjax()
    {
        $request = Services::request();
        $datatable = new MCustomer($request);
        $desc = "Seller";

        if ($request->getMethod(true) === 'POST') {
            $lists = $datatable->getDatatables($desc);
            $data = [];
            $no = $request->getPost('start');

            foreach ($lists as $list) {
                $button = "
                        <button class=\"btn btn-sm btn-info\" id=\"updateData\" onclick=\"detail($list->id_customer)\" ><i class=\"fa fa-edit\"></i></button>
                        <button class=\"btn btn-sm btn-danger\" onclick=\"hapus($list->id_customer)\" ><i class=\"fa fa-trash-alt\"></i></button>
                    ";
                $status = $list->status == 1 ? "<span class=\"badge text-bg-success\">Active</span>" : "<span class=\"badge text-bg-danger\">Not Active</span>";
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->nama_customer;
                $row[] = $list->alamat_customer;
                $row[] = $list->phone;
                $row[] = '10000000';
                $row[] = '100000';
                $row[] = $status;
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
    public function addSeller()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'name'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Nama Seller tidak boleh kosong'
                    ]
                ],
                'email'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Email Seller tidak boleh kosong'
                    ]
                ],
                'address'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Address Seller tidak boleh kosong'
                    ]
                ],
                'phone'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Phone Seller tidak boleh kosong'
                    ]
                ],
                'long'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Longitude Seller tidak boleh kosong'
                    ]
                ],
                'lat'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Latitude Seller tidak boleh kosong'
                    ]
                ],
                'pic'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'PIC Seller tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $json = [
                    'error' => [
                        'name' => $validation->getError('name'),
                        'email' => $validation->getError('email'),
                        'address' => $validation->getError('address'),
                        'phone' => $validation->getError('phone'),
                        'long' => $validation->getError('long'),
                        'lat' => $validation->getError('lat'),
                        'pic' => $validation->getError('pic'),
                    ]
                ];
            } else {

                $id = $this->request->getPost('idSeller');
                $name = $this->request->getPost('name');
                $address = $this->request->getPost('address');
                $email = $this->request->getPost('email');
                $phone = $this->request->getPost('phone');
                $long = $this->request->getPost('long');
                $lat = $this->request->getPost('lat');
                $owner = $this->request->getPost('pic');

                $request = Services::request();
                $modelAgen = new MCustomer($request);
                $cekId = $modelAgen->getWhere(['code_customer' => $id])->getResult();
                $findId = $modelAgen->find($id);



                if ($findId > 0) {
                    $json = [
                        'error' => 'Seller sudah pernah terdaftar'
                    ];
                } else {
                    $modelAgen->insert([
                        'code_customer'     => $id,
                        'nama_customer'     => $name,
                        'alamat_customer'   => $address,
                        'desc_cust'          => "Seller",
                        'email'         => $email,
                        'phone'         => $phone,
                        'longitude'     => $long,
                        'latitude'      => $lat,
                        'pic_name'      => $owner,
                        'status'        => 1,
                    ]);

                    $json = [
                        'success'       => 'Seller berhasil ditambah'
                    ];
                }
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function updateSeller()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'name'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Nama Seller tidak boleh kosong'
                    ]
                ],
                'email'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Email Seller tidak boleh kosong'
                    ]
                ],
                'address'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Address Seller tidak boleh kosong'
                    ]
                ],
                'phone'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Phone Seller tidak boleh kosong'
                    ]
                ],
                'long'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Longitude Seller tidak boleh kosong'
                    ]
                ],
                'lat'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'Latitude Seller tidak boleh kosong'
                    ]
                ],
                'pic'  => [
                    'rules' => 'required',
                    'errors' => [
                        'required'  => 'PIC Seller tidak boleh kosong'
                    ]
                ],
            ]);
            if (!$valid) {
                $json = [
                    'error' => [
                        'name' => $validation->getError('name'),
                        'email' => $validation->getError('email'),
                        'address' => $validation->getError('address'),
                        'phone' => $validation->getError('phone'),
                        'long' => $validation->getError('long'),
                        'lat' => $validation->getError('lat'),
                        'pic' => $validation->getError('pic'),
                    ]
                ];
            } else {

                $id = $this->request->getPost('idSeller');
                $name = $this->request->getPost('name');
                $address = $this->request->getPost('address');
                $email = $this->request->getPost('email');
                $phone = $this->request->getPost('phone');
                $long = $this->request->getPost('long');
                $lat = $this->request->getPost('lat');
                $owner = $this->request->getPost('pic');

                $request = Services::request();
                $modelAgen = new MCustomer($request);
                $cekId = $modelAgen->getWhere(['code_customer' => $id])->getResult();
                $findId = $modelAgen->find($id);



                if ($findId > 0) {
                    $json = [
                        'error' => 'Seller sudah pernah terdaftar'
                    ];
                } else {
                    $data = [
                        'code_customer'     => $id,
                        'nama_customer'     => $name,
                        'alamat_customer'   => $address,
                        'desc_cust'          => "Seller",
                        'email'         => $email,
                        'phone'         => $phone,
                        'longitude'     => $long,
                        'latitude'      => $lat,
                        'pic_name'      => $owner,
                        'status'        => 1,
                    ];

                    $modelAgen->update($id, $data);

                    $json = [
                        'success'       => 'Seller berhasil ditambah'
                    ];
                }
            }
            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
    public function hapusData()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $request = Services::request();
            $modelAgen = new MCustomer($request);
            $modelAgen->delete($id);

            $json = [
                'success'       => 'Data Seller berhasil dihapus'
            ];

            echo json_encode($json);
        } else {
            exit('Maaf tidak bisa dipanggil');
        }
    }
}
