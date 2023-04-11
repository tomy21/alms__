<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblEkspedisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ekspedisi'        => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'ekspedisi'   => [
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
        $this->forge->addKey('id_ekspedisi', TRUE);
        $this->forge->createTable('tbl_ekspedisi');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_ekspedisi');
    }
}
