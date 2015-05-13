<?php
class UserController extends Zend_Controller_Action
{
        public function init(){
                $bootstrap = $this->getInvokeArg('bootstrap');
		if($bootstrap->hasResource('db')) {
			$this->db = $bootstrap->getResource('db');
		}
            $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $this->view->message = $this->_flashMessenger->getMessages();
            
        }

        public function indexAction()
        {
            if(Zend_Auth::getInstance()->hasIdentity()){
                $this->_redirect('/catalog/index/');
            }
            $form = new Default_Form_AddUser();
            $form->setDecorators(array('ViewScript', array('ViewScript', array('viewScript' => 'forms/account/register.phtml'))));
            $this->view->form = $form;
            if($this->getRequest()->isPost())
		{
                    if($form->isValid($this->getRequest()->getPost()))
			{
                            $password= $this->getRequest()->getPost('password');
                            $email= $this->getRequest()->getPost('email');
                            $encoded_pass = md5($password);
                            $email = $this->getRequest()->getPost('email');
                            $model = new Default_Model_Users();
                            $result = $model->getMapper()->getDbTable()
                                                        ->select()
                                                        ->where('email' . ' =?', $email);
                                    $row=$model->fetchRow($result);
                                    if($row)
                                    {
                                       $this->_flashMessenger->addMessage("<style type='text/css'>.error{display:block;}</style>");
                                       $this->_redirect('/user/index/');
                                    }
                                    else
                                   {
                                        $model->setOptions($form->getValues());
                                        $model->setPassword($encoded_pass);
                                        if($model->save()){
                                            
                                            $this->_redirect('/catalog/');
                                        }
                                    }
                                   
                                   
                                       
                                  
                            
                        }else{
                            
                        }
                }
        
        }
	
	public function logoutAction()
	{
            $auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()) {
    		$auth->clearIdentity();
            }
            $this->_redirect('/index/');
		
	}
    
        
	
	public function editAction()
	{
		
	}
	
	public function deleteAction()
	{
		
	}
        
        
}