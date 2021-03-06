<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Service\Init;
use Zend\Db\Adapter\Adapter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $service = new Init(new Adapter([
            'driver'   => 'Pdo',
            'username' => 'foo',
            'password' => 'bar',
            'dsn' => 'mysql:dbname=zf_test;host=localhost'
        ]));

        print_r($service->get());

        die();

        return new ViewModel();
    }
}
