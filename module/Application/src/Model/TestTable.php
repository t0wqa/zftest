<?php
/**
 * Created by PhpStorm.
 * User: t0wqa
 * Date: 13.11.2018
 * Time: 14:19
 */

namespace Application\Model;


use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class TestTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function get($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function save(Test $test)
    {
        $data = [
            'id' => $test->id,
            'script_name'  => $test->scriptName,
            'start_time'  => $test->startTime,
            'end_time'  => $test->endTime,
            'result'  => $test->result,
        ];

        $id = (int) $test->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->get($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function delete($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}