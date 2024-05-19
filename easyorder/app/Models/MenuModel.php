<?php

namespace App\Models; 

use CodeIgniter\Model; 

class MenuModel extends Model
{
    protected $table = 'Menuitem';
    protected $primaryKey = 'menu_item_id';
    protected $allowedFields = [
        'user_id', 'category_id', 'item_name', 'description', 'price', 'is_active'
    ];
    protected $returnType = 'array'; 
}