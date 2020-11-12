<?php


namespace App\Repository;


use Btinet\Baldur\Model\Model;

class CategoryRepository extends Model
{

    public function findAll(){
       return $this->db->select('SELECT * FROM category');
    }

}