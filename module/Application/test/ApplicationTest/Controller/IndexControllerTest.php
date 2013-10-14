<?php


namespace ApplicationTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class IndexControllerTest extends AbstractHttpControllerTestCase

{
   // protected $traceError = true;

    public function setUp()
    {

        $this->setApplicationConfig(
            //include __DIR__ . '/../../../config/application.config.php'
            //include __DIR__ . '/../../../config/module.config.php'
            include __DIR__ . '/../../../../../config/application.config.php'
        );

        parent::setUp();

    }

    public function testIndexActionCanBeAccessed()

    {

        $this->dispatch('/');

        $this->assertResponseStatusCode(200);

        $this->assertModuleName('application');

        $this->assertControllerName('application\controller\index');

        $this->assertControllerClass('IndexController');

        //$this->assertMatchedRouteName('home');


    }

}