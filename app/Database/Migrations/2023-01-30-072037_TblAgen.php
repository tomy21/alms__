<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblAgen extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_agen'    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'code_agen' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'nama_agen' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'alamat_agen' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'email' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'phone' => [
                'type'              => 'varchar',
                'constraint'        => 100,
            ],
            'longitude' => [
                'type'              => 'varchar',
                'constraint'        => 255,
            ],
            'latitude' => [
                'type'              => 'varchar',
                'constraint'        => 255,
            ],
            'owner_name' => [
                'type'              => 'varchar',
                'constraint'        => 255,
            ],
            'status' => [
                'type'              => 'enum',
                'constraint'        => ['1','2'],
            ],
            'join_date' => [
                'type'              => 'date',
                'null'              => TRUE
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
        $this->forge->addKey('id_agen', TRUE);
        $this->forge->createTable('tbl_agen');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_agen');
    }
}
