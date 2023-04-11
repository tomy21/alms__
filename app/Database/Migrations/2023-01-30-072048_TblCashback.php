<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblCashback extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_cashback'    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'agen' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'ekspedisi' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'cashback' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
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
        $this->forge->addKey('id_cashback', TRUE);
        $this->forge->createTable('tbl_cashback');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_cashback');
    }
}
