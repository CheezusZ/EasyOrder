<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        // Define the User table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'restaurant_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['owner', 'admin'],
                'default' => 'owner', 
            ]
        ]);
        
        $this->forge->addKey('user_id', TRUE); // Set user_id as primary key
        $this->forge->createTable('Users'); // Create the User table
    }

    public function down()
    {
        // Drop the User table if needed
        $this->forge->dropTable('Users');
    }
}
