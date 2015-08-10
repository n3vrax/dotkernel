<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/DotUser for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace DotUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use ZfcUser\Service\User;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;
use Zend\Form\Form;
use DotUser\Service\UserMailHelperInterface;
use DotUser\Helper\UserUtilsInterface;
use DotUser\Mapper\UserDetailsInterface;

class UserController extends AbstractActionController
{   
    protected $loginRoute = 'zfcuser/login';
    
    protected $indexRoute = 'zfcuser';
    
    protected $recoveryRoute = 'zfcuser/recovery';
    
    protected $changeEmailRoute = 'zfcuser/change-email';
    
    protected $userService;
    
    protected $userUtils;
    
    protected $mailHelper;
    
    protected $resetPasswordForm;
    
    protected $userDetailsForm;
    
    protected $changePasswordForm;
    
    protected $changeEmailForm;
    
    protected $userDetailsMapper;
    
    public function __construct(User $userService)
    {
        $this->userService = $userService;
    }
    
    public function setUserDetailsMapper(UserDetailsInterface $userDetailsMapper)
    {
        $this->userDetailsMapper = $userDetailsMapper;
    }
    
    public function setUserUtils(UserUtilsInterface $userUtils)
    {
        $this->userUtils = $userUtils;
    }
    
    public function setResetPasswordForm(Form $form)
    {
        $this->resetPasswordForm = $form;
    }
    
    public function setUserDetailsForm(Form $form)
    {
        $this->userDetailsForm = $form;
    }
    
    public function setChangeEmailForm(Form $form)
    {
        $this->changeEmailForm = $form;
    }
    
    public function setChangePasswordForm(Form $form)
    {
        $this->changePasswordForm = $form;
    }
    
    public function setMailHelper(UserMailHelperInterface $mailHelper)
    {
        $this->mailHelper = $mailHelper;
    }
    
    public function indexAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        
        $identity = $this->zfcUserAuthentication()->getIdentity();
        $this->userDetailsForm->getInputFilter()->getUsernameValidator()->setCurrentUser($identity);
        $this->userDetailsForm->setHydrator($this->userService->getFormHydrator());
        $this->userDetailsForm->bind($identity);
        
        if($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $this->userDetailsForm->setData($data);
            
            if($this->userDetailsForm->isValid())
            {
                $user = $this->userDetailsForm->getData();
                
                $this->userService->getUserMapper()->update($user);
                $this->userDetailsMapper->update($user);
                $this->flashmessenger()->addSuccessMessage('Account successfully updated');
                return $this->redirect()->toRoute($this->indexRoute);
            }
        }
        
        return array('userDetailsForm' => $this->userDetailsForm, 'changePasswordForm' => $this->changePasswordForm);
    }
    
    public function changePasswordAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        
        $identity = $this->zfcUserAuthentication()->getIdentity();
        
        $errors = array();
        
        if($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost()->toArray();
            $this->changePasswordForm->setData($data);
            
            if($this->changePasswordForm->isValid())
            {
                $data = $this->changePasswordForm->getData();
                $cryptoService = $this->userService->getFormHydrator()->getCryptoService();
                //check old password is valid
                if($cryptoService->verify($data['old_password'], $identity->getPassword()))
                {
                    //update user password
                    $password = $cryptoService->create($data['new_password']);
                    $identity = $this->userService->getFormHydrator()->hydrate(compact('password'), $identity);
                    
                    $res = $this->userService->getUserMapper()->update($identity);
                    if($res)
                    {
                        //update succesfull
                        $this->flashmessenger()->addSuccessMessage('Password changed succesfully');
                    }
                    else{
                        $errors[] = 'Update was not applied. An error occurred';
                    }
                }
                else{
                    $errors[] = 'Old password entered is not valid';
                }
            }
            else{
                $errors = $this->changePasswordForm->getMessages();
            }
            
            if(!empty($errors))
            {
                foreach ($errors as $error)
                {
                    $this->flashmessenger()->addErrorMessage($error);
                }
            }
        }
        return $this->redirect()->toRoute($this->indexRoute);
    }
    
    public function changeEmailAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        
        $identity = $this->zfcUserAuthentication()->getIdentity();
        
        if(empty($this->changeEmailForm->get('email')->getValue()))
        {
            $this->changeEmailForm->get('email')->setValue($identity->getEmail());
        }
        if($this->getRequest()->isPost())
        {
            $post = $this->getRequest()->getPost();
            $this->changeEmailForm->setData($post);
            if($this->changeEmailForm->isValid())
            {
                $data = $this->changeEmailForm->getData();
                $cryptoService = $this->userService->getFormHydrator()->getCryptoService();
                //check old password is valid
                if($cryptoService->verify($data['password'], $identity->getPassword()))
                {
                    $email = $data['email'];
                    
                    //check is email exists
                    $check = $this->userService->getUserMapper()->findByEmail($email);
                    if($check && $check->getId() !== $identity->getId())
                    {
                        $this->changeEmailForm->get('email')->setMessages(array('Email already registered'));
                    }
                    else{
                        $identity = $this->userService->getFormHydrator()->hydrate(compact('email'), $identity);
                        $res = $this->userService->getUserMapper()->update($identity);
                        if($res)
                        {
                            $this->flashmessenger()->addSuccessMessage('Email changed succesfully');
                            return $this->redirect()->toRoute($this->indexRoute);
                        }
                    }
                }
                else{
                    $this->changeEmailForm->get('password')->setMessages(array('Password is not valid'));
                }
            }
        }
        return array('form' => $this->changeEmailForm);
    }
    
    public function confirmAction()
    {
        //take required params from POST or GET whatever is set
        $email = $this->request->getPost()->get('email', '');
        $token = $this->request->getPost()->get('token', '');
        
        $email = $this->request->getQuery()->get('email', $email);
        $token = $this->request->getQuery()->get('token', $token);
        
        $user = $this->userService->getUserMapper()->findByEmail($email);
        if($user)
        {
            //check token validity
            $tokenCheck = $this->userUtils->checkUserToken($user, $token);
            
            if(!$tokenCheck)
            {
                $this->flashmessenger()->addErrorMessage('Could not confirm account. Token invalid or is expired');
                return $this->redirect()->toRoute($this->loginRoute);
            }
            
            $user->setState(\DotUser\Entity\User::ACTIVE);
            
            $updateRes = $this->userService->getUserMapper()->update($user);
            if($updateRes)
            {
                //delete the confirmation tokens
                $this->userUtils->deleteUserToken($user, $token);
                $this->flashmessenger()->addSuccessMessage('Account successfully confirmed. You may now sign in');
                return $this->redirect()->toRoute($this->loginRoute);
            }
        }
        
        $this->flashmessenger()->addErrorMessage('Could not confirm account. Make sure you used the link provided in the email');
        return $this->redirect()->toRoute($this->loginRoute);
        
    }
    
    public function resetPasswordAction()
    {
        //take required params from POST or GET whatever is set
        $email = $this->request->getPost()->get('email', '');
        $token = $this->request->getPost()->get('token', '');
        
        $email = $this->request->getQuery()->get('email', $email);
        $token = $this->request->getQuery()->get('token', $token);
        
        $errors = null;
        
        $user = $this->userService->getUserMapper()->findByEmail($email);
        if($user)
        {
            //check token validity
            $tokenCheck = $this->userUtils->checkUserToken($user, $token);
        
            if(!$tokenCheck)
            {
                $errors[] = 'Can\'t reset password - Token invalid or is expired';
            }
        }
        else{
            $errors[] = 'Can\'t reset password - User is not registered';
        }
        
        if($errors)
        {
            foreach ($errors as $error)
            {
                $this->flashmessenger()->addErrorMessage($error);
                return $this->redirect()->toRoute($this->loginRoute);
            }
        }
        
        if($this->getRequest()->isPost())
        {
            $data = $this->getRequest()->getPost();
            $this->resetPasswordForm->setData($data);
            if($this->resetPasswordForm->isValid())
            {
                $data = $this->resetPasswordForm->getData();
                //update user's password
                $password = $this->userService->getFormHydrator()->getCryptoService()->create($data['password']);
                $user = $this->userService->getFormHydrator()->hydrate(compact('password'), $user);
                $this->userService->getUserMapper()->update($user);
                
                //delete token
                $this->userUtils->deleteUserToken($user, $data['token']);
                
                $this->flashmessenger()->addSuccessMessage('Password reset successfully');
                return $this->redirect()->toRoute($this->loginRoute);
            }
        }
        
        return array('form' => $this->resetPasswordForm, 'email' => $email, 'token' => $token);
    }
    
    public function recoveryAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();
        
        if($request->isPost())
        {
            $email = isset($post['recovery_email']) ? $post['recovery_email'] : '';
            $validator = new EmailAddress();
            $validator->setOptions(array('allow' => Hostname::ALLOW_DNS, 'domain' => true));
            if($validator->isValid($email))
            {
                $user = $this->userService->getUserMapper()->findByEmail($email);
                if($user)
                {
                    //send reset email
                    $result = $this->mailHelper->sendResetPasswordEmail($user);
                    if(!$result->isValid())
                    {
                        $this->flashmessenger()->addErrorMessage('Could not sent email. Please try again later.');
                        return $this->redirect()->toRoute($this->recoveryRoute);
                    }
                    else{
                        $this->flashmessenger()->addSuccessMessage('Reset password email was sent');
                        return $this->redirect()->toRoute($this->loginRoute);
                    }
                    
                }
                else{
                    $this->flashmessenger()->addErrorMessage('Email address is not registered');
                    return $this->redirect()->toRoute($this->recoveryRoute);
                }
                
            }
            else{
                $this->flashmessenger()->addErrorMessage('Email address is not valid');
                return $this->redirect()->toRoute($this->recoveryRoute);
            }
        }
    }
}
