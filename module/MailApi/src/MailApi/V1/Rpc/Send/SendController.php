<?php
namespace MailApi\V1\Rpc\Send;

use Zend\Mvc\Controller\AbstractActionController;
use AcMailer\Service\MailServiceAwareInterface;

class SendController extends AbstractActionController implements MailServiceAwareInterface
{
    protected $mailService;
    
    public function getMailService()
    {
        return $this->mailService;
    }

    public function setMailService(\AcMailer\Service\MailServiceInterface $mailService)
    {
        $this->mailService = $mailService;
    }

    public function sendAction()
    {
        $params = array();
        $event = $this->getEvent();
        $inputFilter = $event->getParam('ZF\ContentValidation\InputFilter');
        if ($inputFilter)
        {
            $data = $inputFilter->getValues();
        }
        
        $this->mailService->setBody($data['body']);
        $this->mailService->setSubject($data['subject']);
        $this->mailService->getMessage()->setTo($data['to']);
        $this->mailService->getMessage()->setFrom($data['from'], isset($data['from_name']) && !empty($data['from_name']) ? $data['from_name'] : null);
        
        if(isset($data['cc']) && !empty($data['cc']))
            $this->mailService->getMessage()->setCc($data['cc']);
        
        if(isset($data['bcc']) && !empty($data['bcc']))
            $this->mailService->getMessage()->setBcc($data['bcc']);
        
        $result = $this->mailService->send();
        if($result->isValid())
        {
            return array('message' => 'success');
        }
        
        error_log($result->getMessage());
        return array('message' => 'The email could not be sent server side. Try again later');
        
    }
}
