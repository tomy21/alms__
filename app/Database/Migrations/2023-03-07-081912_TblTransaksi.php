<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_transaksi'        => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'inv'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'no_resi'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'service'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'warehouse'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'ekspedisi'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'agen'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'cp_name'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'status_pod'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'desc'   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'status_hub'   => [
                'type'              => 'INT',
                'constraint'        => 255,
            ],
            'ongkir'   => [
                'type'              => 'INT',
                'constraint'        => 255,
                'null'              => TRUE,
            ],
            'update_resi'   => [
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
        $this->forge->addKey('id_transaksi', TRUE);
        $this->forge->createTable('tbl_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_transaksi');
    }
}
