<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderitemTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'menu_item_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'quantity' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
        ]);
        
        $this->forge->addKey('order_item_id', TRUE); 
        $this->forge->addForeignKey('order_id', 'Orders', 'order_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('menu_item_id', 'Menuitem', 'menu_item_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Orderitem'); 
    }

    public function down()
    {
        $this->forge->dropTable('Orderitem');
    }
}
