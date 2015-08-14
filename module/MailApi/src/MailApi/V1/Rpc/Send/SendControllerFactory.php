<?php
namespace MailApi\V1\Rpc\Send;

class SendControllerFactory
{
    public function __invoke($controllers)
    {
        $sm = $controllers->getServiceLocator();
        
        $controller = new SendController();
        $controller->setMailService($sm->get('acmailer.mailservice.mailapi'));
        
        return $controller;
    }
}
