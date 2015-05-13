<?php
class Default_Model_DbTable_Comanda extends Zend_Db_Table_Abstract
{
	protected $_name    = 'comanda';
	protected $_primary = 'id';
}

class Default_Model_Comanda
{
	protected $_id;
        protected $_iduser;
        protected $_idcos;
	protected $_contact;
        protected $_email;
        protected $_tel;
        protected $_adresa;
       
	protected $_mapper;

	public function __construct(array $options = null)
	{
		if(is_array($options)) {
			$this->setOptions($options);
		}
	}

	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if(('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid '.$name.' property '.$method);
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
		if(('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid '.$name.' property '.$method);
		}
		return $this->$method();
	}

	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if(in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}	
	
	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}

	public function getId()
	{
		return $this->_id;
	}
	
	public function setIduser($string)
	{
		$this->_iduser = (int) $string;
		return $this;
	}

	public function getIduser()
	{
		return $this->_iduser;
	}
	
        public function setIdcos($string)
	{
		$this->_idcos = (int) $string;
		return $this;
	}

	public function getIdcos()
	{
		return $this->_idcos;
	}
        
        public function setContact($string)
	{
		$this->_contact = (string) $string;
		return $this;
	}

	public function getContact()
	{
		return $this->_contact;
	}
        
        public function setEmail($string)
	{
		$this->_email = (string) $string;
		return $this;
	}

	public function getEmail()
	{
		return $this->_email;
	}
        
        public function setTel($string)
	{
		$this->_tel = (int) $string;
		return $this;
	}

	public function getTel()
	{
		return $this->_tel;
	}
        
        public function setAdresa($string)
	{
		$this->_adresa = (string) $string;
		return $this;
	}

	public function getAdresa()
	{
		return $this->_adresa;
	}
        
        
	public function setMapper($mapper)
	{
		$this->_mapper = $mapper;
		return $this;
	}
	
	public function getMapper()
	{
		if(null === $this->_mapper) {
			$this->setMapper(new Default_Model_ComandaMapper());
		}
		return $this->_mapper;
	}

	public function find($id)
	{
		return $this->getMapper()->find($id, $this);
	}

	public function fetchAll($select=null)
	{
		return $this->getMapper()->fetchAll($select);
	}
        
        public function fetchRow($select =null)
        {
                return $this->getMapper()->fetchRow($select,$this);
        }
	
	public function save()
	{
		return $this->getMapper()->save($this);
	}
	
	public function saveLastlogin()
    {
        $this->getMapper()->saveLastlogin($this);
    }

    public function delete()
    {
    	if(null === ($id = $this->getId())) {
    		throw new Exception("Invalid record selected!");
    	}
        return $this->getMapper()->delete($id);
    }
}

class Default_Model_ComandaMapper
{
	protected $_dbTable;

	public function setDbTable($dbTable)
	{
		if(is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if(!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable()
	{
		if(null === $this->_dbTable) {
			$this->setDbTable('Default_Model_DbTable_Comanda');
		}
		return $this->_dbTable;
	}

	public function find($id, Default_Model_Comanda $model)
	{
		$result = $this->getDbTable()->find($id);
		if(0 == count($result)) {
			return;
		}
		$row = $result->current();
		$model->setOptions($row->toArray());
		return $model;
	}

	public function fetchAll($select)
	{
		$resultSet = $this->getDbTable()->fetchAll($select);
		$entries = array();
		foreach($resultSet as $row) {
			$model = new Default_Model_Comanda();
			$model->setOptions($row->toArray())
					->setMapper($this);
			$entries[] = $model;
		}
		return $entries;
	}
        
        public function fetchRow($select, Default_Model_Comanda $model)
        {  
            $result=$this->getDbTable()->fetchRow($select);
                  if(0 == count($result)) 
                  {
                      return;
                  }       
                  $model->setOptions($result->toArray());
            return $model;
        }
        
     
	
	public function save(Default_Model_Comanda $value)
    {
        $data = array(
			'iduser'                => $value->getIduser(),
                        'idcos'              => $value->getIdcos(),
                        'contact'             => $value->getContact(),
                        'email'                 => $value->getEmail(),
                        'tel'                 => $value->getTel(),
                        'adresa'                 => $value->getAdresa(),
                        
                      
        );
        
        if (null === ($id = $value->getId()))
		{       
            $id = $this->getDbTable()->insert($data);            
        } 
		else 
		{        	
            $this->getDbTable()->update($data, array('id = ?' => $id));            
        }
        return $id;
    }	

    public function delete($id)
    {
    	$where = $this->getDbTable()->getAdapter()->quoteInto('id = ?', $id);
        return $this->getDbTable()->delete($where);
    }
}