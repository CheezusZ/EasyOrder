<?php

namespace App\Models; 

use CodeIgniter\Model; 

class OrderModel extends Model 
{
    protected $table = 'Orders'; 
    protected $primaryKey = 'order_id'; 
    protected $allowedFields = ['user_id', 'table_id', 'order_status', 'created_at', 'total_price'];
    protected $returnType = 'array';
    protected $useTimestamps = true;  
}