<?php


namespace App\Repository;


use Btinet\Ringhorn\Model\EntityRepository;


class CategoryRepository extends EntityRepository
{

    public function findDuplicate(array $criteria, array $falseCriteria): array
    {

        $conditions = $this->createSqlConditions($criteria, $falseCriteria);

        foreach($falseCriteria as $property => $value){
            $criteria[$property] = $value;
        }

        return $this->db->select('SELECT * FROM '.$this->table.' '.$conditions, $criteria);

    }

}
