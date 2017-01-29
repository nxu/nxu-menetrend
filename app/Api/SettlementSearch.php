<?php
/**
 * Copyright (c) 2016 nXu
 */

namespace App\Api;

class SettlementSearch
{
    /**
     * Gets a settlement name by its ID.
     *
     * @param int  $settlementId  ID of the settlement.
     * @return string
     */
    public function getSettlementById($settlementId)
    {
        return app('db')->table('settlements')->where('id', $settlementId)->value('name');
    }

    /**
     * Gets an array of settlement IDs and names whose names match the given string.
     *
     * @param string  $name  Part of the name of the settlement.
     * @return array
     */
    public function getSettlementsByName($name)
    {
        return $this->getSettlementQuery($name)
            ->limit(5)
            ->pluck('id', 'name');
    }

    public function getSettlementIdByName($name)
    {
        return $this->getSettlementQuery($name)->pluck('id');
    }
    
    protected function getSettlementQuery($name)
    {
        return app('db')
            ->table('settlements')
            ->where('name', 'LIKE', '%'.$name.'%')
            ->orderBy(app('db')->raw("
                CASE
                    WHEN name = '".$name."' THEN 1
                    WHEN name LIKE '".$name."%' THEN 2
                    WHEN name LIKE '%".$name."%' THEN 3
                END"))
            ->orderBy('name', 'asc');
    }
}
