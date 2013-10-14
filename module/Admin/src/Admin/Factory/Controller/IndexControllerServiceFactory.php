<?php
namespace Admin\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Admin\Controller\IndexController;

class IndexControllerServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authService = $serviceLocator->getServiceLocator()->get('AuthService');
        $controller = new IndexController($authService);

        return $controller;
    }
}