<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblNooutbound extends Migration
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
        $this->forge->addKey('id_outbound', TRUE);
        $this->forge->createTable('tbl_nooutbound');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_nooutbound');
    }
}
