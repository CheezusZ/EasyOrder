<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_id' => [
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
            'table_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'order_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'completed', 'cancelled'],
                'default' => 'active', 
            ],
            'customer_email' => [
                'type' => 'VARCHAR',
                'constraint' => 55,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'total_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ]
        ]);
        
        $this->forge->addKey('order_id', TRUE); 
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('table_id', 'Tables', 'table_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Orders'); 
    }

    public function down()
    {
        $this->forge->dropTable('Orders');
    }
}
