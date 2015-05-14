<?php
class CosController extends Zend_Controller_Action
{
        public function init(){
            $this->produsecos();
                $contextSwitch = $this->_helper->getHelper('contextSwitch');
                $contextSwitch->addActionContext('addcos', array ('xml', 'json'))
                                ->initContext();
                if(!Zend_Auth::getInstance()->hasIdentity()){
                $this->_redirect('/index/index/');
            }
        }

        public function indexAction()
        {


           $auth = Zend_Auth::getInstance()->getStorage()->read();
           $userid = $auth->getIduser();
           $db = Zend_Db_Table::getDefaultAdapter();
           
           $sql= $db->select()
                ->from(array('c'=>'cos'))
                ->joinLeft(array('u'=>'users'), "u.iduser = $userid")
                ->joinLeft(array('ca'=>'catalog'), 'ca.idprodus = c.idprodus')
                ->where('c.iduser' . ' =?', $userid);
                
                
                
           $result = $db->fetchAll($sql);
           $this->view->coscumparaturi=$result;
           
//           $form = new Default_Form_Comanda();
//	   $form->setDecorators(array('ViewScript', array('ViewScript', array('viewScript' => 'forms/account/comanda.phtml'))));
//	   $this->view->form_comanda = $form;
        }

       
        
	public function deleteAction()
	{
            
            $model = new Default_Model_Cos();
            if($this->getRequest()->isPost()){
                $userid=$this->getRequest()->getPost('iduser');
                $productid=$this->getRequest()->getPost('idprodus');
                $db = Zend_Db_Table::getDefaultAdapter();
           
                $sql= $db->delete('cos', array(
                                    'iduser = ?' => $userid,
                                    'idprodus = ?' => $productid
                                ));
            }
		$this->_redirect('/cos/index');
	}
        
        public function comandaAction() {
    
            $form = new Default_Form_Comanda();
            $form->setDecorators(array('ViewScript', array('ViewScript', array('viewScript' => 'forms/account/comanda.phtml'))));
            $this->view->form_comanda = $form;
            if($this->getRequest()->isPost())
		{
                if($form->isValid($this->getRequest()->getPost()))
			{
                            $model = new Default_Model_Comanda();
                           
                                        $model->setOptions($form->getValues());
                                        $model->setIduser($userid=$this->getRequest()->getPost('iduser'));
                                        $model->setIdcos($userid=$this->getRequest()->getPost('idcos'));
                                        if($model->save()){
                                            
                                            $this->_redirect('/catalog/');
                                        }
                                        
                        }
                }
        }
        
        public function produsecos() {
            $model=new Default_Model_Cos();
            if(!Zend_Auth::getInstance()->hasIdentity()){
                 $this->_redirect('/index/index/');
            }else{
            $auth = Zend_Auth::getInstance()->getStorage()->read();
            $authAcc = $auth->getIduser();
            }

            $db = new PDO('mysql:host=localhost;dbname=zend_test', 'root', 'farcasfpa2');
            $sql="SELECT COUNT(*) FROM cos WHERE iduser='$authAcc'";
            $result = $db->query($sql)->fetchColumn();
            $this->view->obiectecos = $result;
        }
}
