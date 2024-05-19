<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'table_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'table_number' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'qrcode_image' => [
                'type' => 'TEXT',
            ],
        ]);
        
        $this->forge->addKey('table_id', TRUE); 
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Tables'); 
    }

    public function down()
    {
        $this->forge->dropTable('Tables');
    }
}

