<?php
class Default_Model_DbTable_Catalog extends Zend_Db_Table_Abstract
{
	protected $_name    = 'catalog';
	protected $_primary = 'idprodus';
}

class Default_Model_Catalog
{
	protected $_idprodus;
        protected $_codfurnizor;
        protected $_cod;
	protected $_numepiesa;
        protected $_pret;
        protected $_tipcod;
	protected $_marca;
        protected $_stoc;
        protected $_codatp;
	
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
	
	public function setIdprodus($id)
	{
		$this->_idprodus = (int) $id;
		return $this;
	}

	public function getIdprodus()
	{
		return $this->_idprodus;
	}
	
	public function setCodfurnizor($string)
	{
		$this->_codfurnizor = (string) $string;
		return $this;
	}

	public function getCodfurnizor()
	{
		return $this->_codfurnizor;
	}
	
        public function setCod($string)
	{
		$this->_cod = (string) $string;
		return $this;
	}

	public function getCod()
	{
		return $this->_cod;
	}
        
        public function setNumepiesa($string)
	{
		$this->_numepiesa = (string) $string;
		return $this;
	}

	public function getNumepiesa()
	{
		return $this->_numepiesa;
	}
        
        public function setPret($string)
	{
		$this->_pret = (string) $string;
		return $this;
	}

	public function getPret()
	{
		return $this->_pret;
	}
        
        public function setTipcod($string)
	{
		$this->_tipcod = (string) $string;
		return $this;
	}

	public function getTipcod()
	{
		return $this->_tipcod;
	}
        
	public function setMarca($string)
	{
		$this->_marca = (string) $string;
		return $this;
	}

	public function getMarca()
	{
		return $this->_marca;
	}
	
        public function setStoc($string)
	{
		$this->_stoc = (string) $string;
		return $this;
	}

	public function getStoc()
	{
		return $this->_stoc;
	}
        
        public function setCodatp($string)
	{
		$this->_codatp = (string) $string;
		return $this;
	}

	public function getCodatp()
	{
		return $this->_codatp;
	}
        
	public function setMapper($mapper)
	{
		$this->_mapper = $mapper;
		return $this;
	}
	
	public function getMapper()
	{
		if(null === $this->_mapper) {
			$this->setMapper(new Default_Model_CatalogMapper());
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

class Default_Model_CatalogMapper
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
			$this->setDbTable('Default_Model_DbTable_Catalog');
		}
		return $this->_dbTable;
	}

	public function find($id, Default_Model_Catalog $model)
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
			$model = new Default_Model_Catalog();
			$model->setOptions($row->toArray())
					->setMapper($this);
			$entries[] = $model;
		}
		return $entries;
	}
        
        public function fetchRow($select, Default_Model_Catalog $model)
        {  
            $result=$this->getDbTable()->fetchRow($select);
                  if(0 == count($result)) 
                  {
                      return;
                  }       
                  $model->setOptions($result->toArray());
            return $model;
        }
        
     
	
	public function save(Default_Model_Catalog $value)
    {
        $data = array(
			'codfurnizor'           => $value->getCodfurnizor(),
                        'cod'                   => $value->getCod(),
                        'numepiesa'             => $value->getNumepiesa(),
                        'pret'                  => $value->getPret(),
                        'tipcod'		=> $value->getTipcod(),
			'marca'         	=> $value->getMarca(),
                        'stoc'                  => $value->getStoc(),
                        'codatp'         	=> $value->getCodatp(),
        );
        
        if (null === ($id = $value->getIdprodus()))
		{       
            $id = $this->getDbTable()->insert($data);            
        } 
		else 
		{        	
            $this->getDbTable()->update($data, array('idprodus = ?' => $id));            
        }
        return $id;
    }	

    public function delete($id)
    {
    	$where = $this->getDbTable()->getAdapter()->quoteInto('idprodus = ?', $id);
        return $this->getDbTable()->delete($where);
    }
}