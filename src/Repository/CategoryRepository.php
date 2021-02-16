<?php


namespace App\Repository;


use Btinet\Ringhorn\Model\EntityRepository;


class CategoryRepository extends EntityRepository
{

    public function findCustom(): array
    {
       return $this->db->select('SELECT * FROM category');
    }

    public function findDuplicate(array $criteria, array $falseCriteria): array
    {

        $criteria_data = $this->createSqlConditions($criteria, $falseCriteria);

        foreach($falseCriteria as $property => $value){
            $criteria[$property] = $value;
        }
        print($criteria_data);
        print_r($criteria);

        return $this->db->select('SELECT * FROM '.$this->table.' '.$criteria_data, $criteria);

    }

}
