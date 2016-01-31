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
     * @param string  $settlementName  Part of the name of the settlement.
     * @return array
     */
    public function getSettlementsByName($settlementName)
    {
        $settlements = app('db')
            ->table('settlements')
            ->where('name', 'LIKE', '%'.$settlementName.'%')
            ->orderBy(app('db')->raw("
                CASE
                    WHEN name LIKE '".$settlementName."%' THEN 1
                    WHEN name LIKE '%".$settlementName."%' THEN 2
                END"))
            ->limit(5)
            ->lists('id', 'name');
        return $settlements;
    }

    public function getSettlementIdByName($settlementName)
    {
        return app('db')->table('settlements')->where('name', 'LIKE', '%' . $settlementName . '%')->value('id');
    }
}