<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMenuitemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'menu_item_id' => [
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
            'category_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'item_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'unsigned' => TRUE,
                'default' => 1,
            ],
        ]);
        
        $this->forge->addKey('menu_item_id', TRUE); 
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'Category', 'category_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Menuitem'); 
    }

    public function down()
    {
        $this->forge->dropTable('Menuitem');
    }
}
