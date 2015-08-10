<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * PageController
 *
 * @author tibi
 *
 */
class PageController extends AbstractActionController
{
    /**
     * The default action - show the home page
     */
    public function indexAction()
    {
        // TODO redirect to home page
        $this->redirect()->toRoute('home');
    }
    
    public function aboutAction()
    {
        return array();
    }
    
    public function whoweareAction()
    {
        return array();
    }
}