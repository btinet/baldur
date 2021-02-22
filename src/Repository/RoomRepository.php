<?php


namespace App\Repository;


use Btinet\Ringhorn\Model\EntityRepository;


class RoomRepository extends EntityRepository
{

    /**
     * @param $join
     * @return array
     */
    public function findAllJoined($join){

        $array = array();
        $result = $this->db->select('SELECT * FROM '.$this->table.' ');
        foreach ($result as $item){
                $item['blacklist'] = $this->db->select('SELECT * FROM '.$join.' WHERE roomId = :roomId ',['roomId' => $item['id']]);
            $array[] = $item;
        }
        return $array;
    }

}
