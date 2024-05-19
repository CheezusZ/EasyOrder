<?php

namespace App\Models; 

use CodeIgniter\Model; 

class CategoryModel extends Model
{
    protected $table = 'Category'; 
    protected $primaryKey = 'category_id'; 
    protected $allowedFields = ['user_id', 'category_name', 'category_sort'];
    protected $returnType = 'array'; 
}