<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblSorting extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sorting'    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'code_sorting' => [
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
            'warehouse' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'area' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'status_sort' => [
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
        $this->forge->addKey('id_sorting', TRUE);
        $this->forge->createTable('tbl_sorting');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_sorting');
    }
}
