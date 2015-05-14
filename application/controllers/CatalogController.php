<?php
class CatalogController extends Zend_Controller_Action
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
        $model = new Default_Model_Catalog();
        $result = $model->fetchAll();
        $page=$this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
                $auth2 = Zend_Auth::getInstance();
                    $authAccount = $auth2->getStorage()->read();
                    if($authAccount){
                            if($authAccount->getIduser()){
                                    $loggedIn = $authAccount->getIduser();
                                    $this->view->user_session = $loggedIn;
                            }
                    }

        $this->view->paginator=$paginator;
    }
    
    public function helpAction()
    {
        $model = new Default_Model_Catalog();
        $result = $model->fetchAll();
        $page=$this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
                $auth2 = Zend_Auth::getInstance();
                    $authAccount = $auth2->getStorage()->read();
                    if($authAccount){
                            if($authAccount->getIduser()){
                                    $loggedIn = $authAccount->getIduser();
                                    $this->view->user_session = $loggedIn;
                            }
                    }

        $this->view->paginator=$paginator;
    }

    public function addcosAction()
    {
            if($this->getRequest()->isPost())
            {
                $pret = $this->getRequest()->getPost('pret');
                $cant = $this->getRequest()->getPost('cantitate');
                $model = new Default_Model_Cos();
                $model->setIdprodus($this->getRequest()->getPost('idprodus'));
                $model->setIduser($this->getRequest()->getPost('iduser'));
                $model->setCantitate($this->getRequest()->getPost('cantitate'));
                $model->setTotal($pret*$cant);
                if($model->save()){
                    $this->_redirect('/catalog/index/');
                }
            }
    }

    public function filterAction() {
        if($this->getRequest()->isPost())
            {
            $cod = $this->getRequest()->getPost('cod');
            $model = new Default_Model_Catalog();
            $result = $model->getMapper()->getDbTable()
                                         ->select()
                                         ->where('cod' . ' =?', $cod);

            $row=$model->fetchAll($result);
            $page=$this->_getParam('page',1);
            $paginator = Zend_Paginator::factory($result);
            $paginator->setItemCountPerPage(20);
            $paginator->setCurrentPageNumber($page);
                $auth2 = Zend_Auth::getInstance();
                    $authAccount = $auth2->getStorage()->read();
                    if($authAccount){
                            if($authAccount->getIduser()){
                                    $loggedIn = $authAccount->getIduser();
                                    $this->view->user_session = $loggedIn;
                            }
                    }

            $this->view->paginator=$paginator;
            }

    }

    public function deleteAction()
    {

    }

    public function produsecos() {
        $model=new Default_Model_Cos();
        if(!Zend_Auth::getInstance()->hasIdentity()){
             $this->_redirect('/index/index/');
        }else{
        $auth = Zend_Auth::getInstance()->getStorage()->read();
        $authAcc = $auth->getIduser();
        }
//            $result = $model->getMapper()->getDbTable()
//                                            ->select()
//                                            ->where('iduser' . ' =?', $authAcc);
        $db = new PDO('mysql:host=localhost;dbname=zend_test', 'root', 'farcasfpa2');
        $sql="SELECT COUNT(*) FROM cos WHERE iduser='$authAcc'";
        $result = $db->query($sql)->fetchColumn();
        $this->view->obiectecos = $result;
    }
}