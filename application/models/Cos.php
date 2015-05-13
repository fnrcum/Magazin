<?php
class Default_Model_DbTable_Cos extends Zend_Db_Table_Abstract
{
	protected $_name    = 'cos';
	protected $_primary = 'idcos';
}

class Default_Model_Cos
{
	protected $_idcos;
        protected $_iduser;
        protected $_idprodus;
	protected $_cantitate;
        protected $_total;
       
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
	
	public function setIdcos($id)
	{
		$this->_idcos = (int) $id;
		return $this;
	}

	public function getIdcos()
	{
		return $this->_idcos;
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
	
        public function setIdprodus($string)
	{
		$this->_idprodus = (int) $string;
		return $this;
	}

	public function getIdprodus()
	{
		return $this->_idprodus;
	}
        
        public function setCantitate($string)
	{
		$this->_cantitate = (string) $string;
		return $this;
	}

	public function getCantitate()
	{
		return $this->_cantitate;
	}
        
        public function setTotal($string)
	{
		$this->_total = (string) $string;
		return $this;
	}

	public function getTotal()
	{
		return $this->_total;
	}
        
       
        
	public function setMapper($mapper)
	{
		$this->_mapper = $mapper;
		return $this;
	}
	
	public function getMapper()
	{
		if(null === $this->_mapper) {
			$this->setMapper(new Default_Model_CosMapper());
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

class Default_Model_CosMapper
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
			$this->setDbTable('Default_Model_DbTable_Cos');
		}
		return $this->_dbTable;
	}

	public function find($id, Default_Model_Cos $model)
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
			$model = new Default_Model_Cos();
			$model->setOptions($row->toArray())
					->setMapper($this);
			$entries[] = $model;
		}
		return $entries;
	}
        
        public function fetchRow($select, Default_Model_Cos $model)
        {  
            $result=$this->getDbTable()->fetchRow($select);
                  if(0 == count($result)) 
                  {
                      return;
                  }       
                  $model->setOptions($result->toArray());
            return $model;
        }
        
     
	
	public function save(Default_Model_Cos $value)
    {
        $data = array(
			'iduser'                => $value->getIduser(),
                        'idprodus'              => $value->getIdprodus(),
                        'cantitate'             => $value->getCantitate(),
                        'total'                 => $value->getTotal(),
                      
        );
        
        if (null === ($id = $value->getIdcos()))
		{       
            $id = $this->getDbTable()->insert($data);            
        } 
		else 
		{        	
            $this->getDbTable()->update($data, array('idcos = ?' => $id));            
        }
        return $id;
    }	

    public function delete($id)
    {
    	$where = $this->getDbTable()->getAdapter()->quoteInto('idcos = ?', $id);
        return $this->getDbTable()->delete($where);
    }
}