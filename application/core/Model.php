<?php

namespace application\core;

use application\libs\Db;

abstract class Model
{

    public $db;

    public function __construct()
    {

        $this->db = new Db;
    }

    protected function updateParamsArr($innerArray, $arrToUpdate = null)
    {
        if ($arrToUpdate === null) {
            $arrToUpdate = [];
        }
        foreach ($innerArray as $key => $val) {
            $arrToUpdate[$key] = $val;
        }

        return $arrToUpdate;
    }
}
