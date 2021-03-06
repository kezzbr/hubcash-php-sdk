<?php

namespace Hubcash;

/**
 * Class History
 * @package Hubcash
 */
class History
{

    /**
     * @var $HistoryId string
     */
    public $HistoryId;

    /**
     * @var $Action string
     */
    public $Action;

    /**
     * @var $DateAdded string
     */
    public $DateAdded;

    /**
     * @var array
     */
    public $_hiddenSet = [];

    /**
     * @param array $data
     * @return History
     */
    public function ArrayToObject(Array $data)
    {
        $this->HistoryId = !empty($data['HistoryId']) ? $data['HistoryId'] : null;
        $this->Action = !empty($data['Action']) ? $data['Action'] : null;
        $this->DateAdded = !empty($data['DateAdded']) ? $data['DateAdded'] : null;
        return $this;
    }
}