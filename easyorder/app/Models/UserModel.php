<?php

namespace App\Models; 

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'Users';
    protected $primaryKey = 'user_id';
    protected $allowedFields  = ['email', 'password_hash', 'restaurant_name', 'location', 'city', 'role'];
    protected $returnType = 'array';

}