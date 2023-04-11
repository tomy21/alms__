<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblOutbound extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_outbound'    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'code_outbound' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'code_sorting' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'ekspedisi' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'resi_out' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'warehouse' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'agen' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'status' => [
                'type'              => 'int',
                'constraint'        => 5,
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
        $this->forge->addKey('id_outbound', TRUE);
        $this->forge->createTable('tbl_outbound');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_outbound');
    }
}
