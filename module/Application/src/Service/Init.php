<?php
/**
 * Created by PhpStorm.
 * User: t0wqa
 * Date: 13.11.2018
 * Time: 13:15
 */

namespace Application\Service;


use Application\Ddl\CreateTable;
use Application\Type\Enum;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\Insert;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

/**
 * Class Init
 * @package Application\Service
 */
final class Init
{

    const RESULT_SUCCESS = 'success';

    const RESULT_NORMAL = 'normal';

    const RESULT_ILLEGAL = 'illegal';

    const RESULT_FAILED = 'failed';

    protected $adapter;

    /**
     * Init constructor.
     */
    public function __construct()
    {
        $this->adapter = new Adapter([
            'driver'   => 'Pdo',
            'username' => 'foo',
            'password' => 'bar',
            'dsn' => 'mysql:dbname=zf_test;host=localhost'
        ]);

        $this->create();
        $this->fill();
    }

    /**
     * @return void
     */
    private function create()
    {
        $table = new CreateTable('test');

        $table->addColumn((new Ddl\Column\Integer('id'))
            ->addConstraint(new Ddl\Constraint\PrimaryKey())
            ->setOption('AUTO_INCREMENT', true));

        $table->addColumn(new Ddl\Column\Varchar('script_name', 25));
        $table->addColumn(new Ddl\Column\Integer('start_time'));
        $table->addColumn(new Ddl\Column\Integer('end_time'));
        $table->addColumn(new Enum('result', [
            static::RESULT_SUCCESS,
            static::RESULT_NORMAL,
            static::RESULT_ILLEGAL,
            static::RESULT_FAILED,
        ]));

        $this->adapter->query(
            (new Sql($this->adapter))->buildSqlString($table),
            Adapter::QUERY_MODE_EXECUTE
        );

    }

    /**
     * @return void
     */
    private function fill()
    {
        $names = ['Foo', 'Bar', 'Test1', 'Test2'];
        $results = [static::RESULT_SUCCESS, static::RESULT_NORMAL, static::RESULT_ILLEGAL, static::RESULT_FAILED];

        $data = array_map(function($el) use ($names, $results) {
            return [
                'script_name' => $names[array_rand($names)],
                'start_time' => mt_rand(time() - 24 * 3600 * 30, time()),
                'end_time' => mt_rand(time(), time() + 24 * 3600 * 30),
                'result' => $results[array_rand($results)]
            ];
        }, range(0, 20));

        foreach ($data as $dataItem) {
            $insert = new Insert('test');
            $insert->columns([
                'script_name',
                'start_time',
                'end_time',
                'result'
            ]);

            $insert->values($dataItem);

            $this->adapter->query(
                (new Sql($this->adapter))->buildSqlString($insert),
                Adapter::QUERY_MODE_EXECUTE
            );
        }
    }

    /**
     * @return array
     */
    public function get()
    {
        $select = new Select('test');
        $select->where([
            'result' => [static::RESULT_NORMAL, static::RESULT_SUCCESS]
        ]);

        return $this->adapter->query(
            (new Sql($this->adapter))->buildSqlString($select),
            Adapter::QUERY_MODE_EXECUTE
        )->toArray();
    }

}