<?php
/**
 * Created by PhpStorm.
 * User: t0wqa
 * Date: 13.11.2018
 * Time: 14:12
 */

namespace Application\Model;


class Test
{

    public $id;

    public $scriptName;

    public $startTime;

    public $endTime;

    public $result;

    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->scriptName = !empty($data['scriptName']) ? $data['scriptName'] : null;
        $this->startTime = !empty($data['startTime']) ? $data['startTime'] : null;
        $this->endTime = !empty($data['endTime']) ? $data['endTime'] : null;
        $this->result = !empty($data['result']) ? $data['result'] : null;
    }

}