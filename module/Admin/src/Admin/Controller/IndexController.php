<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function onDispatch( \Zend\Mvc\MvcEvent $e )
    {
        $actionName = $this->params('action');

        if (!$this->authService->getStorage()->getSessionManager()
            ->getSaveHandler()
            ->read($this->authService->getStorage()->getSessionId()) AND
            $actionName != "login") {
            return $this->redirect()->toRoute('admin', array('action' => 'login'));
        }

        return parent::onDispatch($e);
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {

        $form = $this->getServiceLocator()
            ->get('FormElementManager')
            ->get('AuthWithDbSaveHandler\Form\LoginForm');
        $viewModel = new ViewModel();

        //initialize error...
        $viewModel->setVariable('error', '');
        //authentication block...
        $this->authenticate($form, $viewModel);

        $viewModel->setVariable('form', $form);
        return $viewModel;

    }

    protected function authenticate($form, $viewModel)
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $dataform = $form->getData();

                $this->authService->getAdapter()
                    ->setIdentity($dataform['username'])
                    ->setCredential($dataform['password']);
                $result = $this->authService->authenticate();
                if ($result->isValid()) {
                    //authentication success
                    $resultRow = $this->authService->getAdapter()->getResultRowObject();

                    $this->authService->getStorage()->write(
                        array('id'          => $resultRow->id,
                            'username'   => $dataform['username'],
                            'ip_address' => $this->getRequest()->getServer('REMOTE_ADDR'),
                            'user_agent'    => $request->getServer('HTTP_USER_AGENT'))
                    );

                    return $this->redirect()->toRoute('admin', array('action' => 'index'));
                } else {
                    $viewModel->setVariable('error', 'Login Error');
                }
            }
        }
    }

    public function logoutAction()
    {
        $this->authService->getStorage()->clear();
        return $this->redirect()->toRoute('admin');
    }

}
