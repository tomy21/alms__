<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblInbound extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_inbound'    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'code_inbound' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'resi' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'ekspedisi' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'desc' => [
                'type'              => 'INT',
                'constraint'        => 255,
            ],
            'warehouse' => [
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
        $this->forge->addKey('id_inbound', TRUE);
        $this->forge->createTable('tbl_inbound');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_inbound');
    }
}
