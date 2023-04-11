<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblNoinbound extends Migration
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
            'qty' => [
                'type'              => 'INT',
                'constraint'        => 255,
            ],
            'status' => [
                'type'              => 'INT',
                'constraint'        => 3,
                'default'           => 0,
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
        $this->forge->createTable('tbl_noinbound');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_noinbound');
    }
}
