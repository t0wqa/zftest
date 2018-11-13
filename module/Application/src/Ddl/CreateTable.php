<?php
/**
 * Created by PhpStorm.
 * User: t0wqa
 * Date: 13.11.2018
 * Time: 14:36
 */

namespace Application\Ddl;


class CreateTable extends \Zend\Db\Sql\Ddl\CreateTable
{

    /**
     * {@inheritDoc}
     */
    protected $specifications = [
        self::TABLE => 'CREATE %1$sTABLE IF NOT EXISTS %2$s (',
        self::COLUMNS  => [
            "\n    %1\$s" => [
                [1 => '%1$s', 'combinedby' => ",\n    "]
            ]
        ],
        'combinedBy' => ",",
        self::CONSTRAINTS => [
            "\n    %1\$s" => [
                [1 => '%1$s', 'combinedby' => ",\n    "]
            ]
        ],
        'statementEnd' => '%1$s',
    ];

}