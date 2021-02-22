<?php


namespace App\Repository;


use Btinet\Ringhorn\Model\EntityRepository;


class CategoryRepository extends EntityRepository
{

    /**
     * @return array
     */
    public function findAllAndParentAsArray(): array
    {
        $array = array();
        $result = $this->db->select('SELECT * FROM '.$this->table.' ');
        foreach ($result as $item){
            if($item['parent']){
                $item['parent'] = $this->findOneBy(['id' => $item['parent']]);
            }
            $array[] = $item;
        }
        return $array;
    }

    /**
     * @param array $criteria
     * @param array $falseCriteria
     * @return array
     */
    public function findDuplicate(array $criteria, array $falseCriteria): array
    {

        $conditions = $this->createSqlConditions($criteria, $falseCriteria);

        foreach($falseCriteria as $property => $value){
            $criteria[$property] = $value;
        }

        return $this->db->select('SELECT * FROM '.$this->table.' '.$conditions, $criteria);

    }

}
