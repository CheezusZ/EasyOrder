<?php

namespace App\Models;

use CodeIgniter\Model;

class TablesModel extends Model
{
    protected $table = 'Tables';
    protected $primaryKey = 'table_id';
    protected $allowedFields = ['user_id', 'table_number', 'qrcode_image'];
    protected $returnType = 'array'; 
}