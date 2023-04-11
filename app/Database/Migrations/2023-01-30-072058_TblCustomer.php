<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblCustomer extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_customer'    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'code_customer' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'desc_cust' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'nama_customer' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'alamat_customer' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'email' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'phone' => [
                'type'              => 'VARCHAR',
                'constraint'        => 18,
                'null'              => TRUE,
            ],
            'longitude' => [
                'type'              => 'varchar',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'latitude' => [
                'type'              => 'varchar',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'pic_name' => [
                'type'              => 'varchar',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'status' => [
                'type'              => 'enum',
                'constraint'        => ['1','2'],
            ],
            'join_date' => [
                'type'              => 'datetime',
                'null'              => TRUE,
            ],
            'created_at'   => [
                'type'              => 'datetime',
                'null'              => TRUE,
            ],
            'updated_at'   => [
                'type'              => 'datetime',
                'null'              => TRUE,
            ],
        ]);
        $this->forge->addKey('id_customer', TRUE);
        $this->forge->createTable('tbl_customer');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_customer');
    }
}
