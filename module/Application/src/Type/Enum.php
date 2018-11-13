<?php
/**
 * Created by PhpStorm.
 * User: t0wqa
 * Date: 13.11.2018
 * Time: 13:38
 */

namespace Application\Type;


use Zend\Db\Sql\Ddl\Column\Column;

class Enum extends Column
{

    protected $type = 'ENUM';

    public function __construct($name = null, $enumListData = [])
    {
        $options['enumListData'] = array_map(function($el) {
            return "'$el'";
        }, $enumListData);

        parent::__construct($name, false, null, $options);
    }

    /**
     * @return array
     */
    public function getExpressionData()
    {
        $data = parent::getExpressionData();
        $options = $this->getOptions();

        if (isset($options['enumListData'])) {
            $data[0][1][1] .= '(' . implode(',', $options['enumListData']) . ')';
        }

        return $data;
    }

}