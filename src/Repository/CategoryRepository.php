<?php


namespace App\Repository;


use Core\Model\Model;

class CategoryRepository extends Model
{

    public function findAll(){
       return $this->db->select('SELECT * FROM category');
    }

}