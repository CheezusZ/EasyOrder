<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'category_id' => [
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
            'category_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'category_sort' => [
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => TRUE,
            ],
        ]);
        
        $this->forge->addKey('category_id', TRUE); 
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Category'); 
    }

    public function down()
    {
        $this->forge->dropTable('Category');
    }
}

