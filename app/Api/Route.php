<?php
/**
 * (c) 2017. 01. 29..
 * Authors: nxu
 */

namespace app\Api;

use Carbon\Carbon;

class Route
{
    /**
     * @var Carbon
     */
    public $date;

    public $from;

    public $to;

    /**
     * @var Carbon
     */
    public $departure;

    /**
     * @var Carbon
     */
    public $arrival;

    public function __construct(Carbon $date, $from, $to, $departure, $arrival)
    {
        $this->date = $date;
        $this->from = $from;
        $this->to = $to;
        $this->departure = (new Carbon($departure))->setDate($date->year, $date->month, $date->day);
        $this->arrival = (new Carbon($arrival))->setDate($date->year, $date->month, $date->day);
    }

    public function alreadyGone()
    {
        return Carbon::now() > $this->departure;
    }

    public function isLater()
    {
        return Carbon::now() < $this->departure;
    }
}
