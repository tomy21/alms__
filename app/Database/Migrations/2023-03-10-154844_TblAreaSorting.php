<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblAreaSorting extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_area'        => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'id_ekspedisi'        => [
                'type'              => 'INT',
                'constraint'        => 5,
            ],
            'area'   => [
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
        $this->forge->addKey('id_area', TRUE);
        $this->forge->createTable('tbl_areasorting');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_areasorting');
    }
}
