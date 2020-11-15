<?php


namespace App\Repository;


use Btinet\Ringhorn\Model\EntityRepository;

class CategoryRepository extends EntityRepository
{

    public function findCustom(){
       return $this->db->select('SELECT * FROM category');
    }

}
