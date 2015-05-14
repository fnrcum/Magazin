<?php
class IndexController extends Zend_Controller_Action
{
        public function init(){
                $bootstrap = $this->getInvokeArg('bootstrap');
		if($bootstrap->hasResource('db')) {
			$this->db = $bootstrap->getResource('db');
		}
            $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
            $this->view->message = $this->_flashMessenger->getMessages();
            if(Zend_Auth::getInstance()->hasIdentity()){
                $this->_redirect('/catalog/index/');
            }
        }

        public function indexAction()
        {
            $form = new Default_Form_Login();
            $form->setDecorators(array('ViewScript', array('ViewScript', array('viewScript' => 'forms/account/login.phtml'))));
            $this->view->login_form = $form;
		
                if($this->getRequest()->isPost()) {
                    if($form->isValid($this->getRequest()->getPost())) {
                        $dbAdapter = new Zend_Auth_Adapter_DbTable($this->db, 'users', 'email', 'password', 'MD5(?)');
                        $dbAdapter -> setIdentity($this->getRequest()->getPost('email'))
                                           -> setCredential($this->getRequest()->getPost('password'));

                        $auth = Zend_Auth::getInstance();
                        $result = $auth->authenticate($dbAdapter);
                        if(!$result->isValid()) {
					switch($result->getCode()) {
					
					    case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
					    case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
								$this->_flashMessenger->addMessage("<div class='mess-false'>Invalid Username or Password</div>");
//                                                                $this->_redirect('/index/1');
					        break;
					
					    default:
					        /** do stuff for other failure **/
                                                case Zend_Auth_Result::FAILURE_UNCATEGORIZED:
								$this->_flashMessenger->addMessage("<div class='mess-false'>Username/Password must not be empty.</div>");
//                                                $this->_redirect('/index/2');
					        break;
					}                                        
					$this->_redirect('/index/');
                    } else {
		        	$accountId = $dbAdapter->getResultRowObject();
		        	$model = new Default_Model_Users();
		        	$model->find($accountId->iduser);
                                
		        	$storage = $auth->getStorage();
		        	$storage->write($model);
                                //echo $accountId->iduser; die();
		       	}
				//check if user is logged in successfully
				$loggedIn = 'false';
				$auth2 = Zend_Auth::getInstance();
				$authAccount = $auth2->getStorage()->read();
				if($authAccount){
					if($authAccount->getIduser()){
						$loggedIn = $authAccount->getIduser();
                                                //$this->view->user_session = $loggedIn;
                                                //echo $loggedIn;die();
                                                //$this->view->user_email =$loggedIn;
                                                $this->_redirect('/catalog/index/');
					}
				}else{
                                    echo 'Nu functioneaza';
                                }	
//				echo $loggedIn;
//				die();
				
            }
        }        
        }
	
	public function loginAction(){
        
		
      }
	
	public function editAction()
	{
		
	}
	
	public function deleteAction()
	{
		
	}
}