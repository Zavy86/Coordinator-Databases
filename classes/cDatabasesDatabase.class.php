<?php
/**
 * Databases - Database
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

/**
 * Databases, Database class
 */
class cDatabasesDatabase{

	/** @var PDO $pdo */
	private $pdo;

	/** @var cDatabasesDatasource $datasource */
	private $datasource;

	/**
	 * Constructor
	 *
	 * @param cDatabasesDatasource $datasource
	 * @throws Exception
	 */
	public function __construct(cDatabasesDatasource $datasource){
		if(!is_a($datasource,"cDatabasesDatasource")){throw new Exception("Datasource is mandatory..");}
		$this->datasource=$datasource;
	}

	/**
	 * Get Datasource
	 *
	 * @return cDatabasesDatasource
	 */
	public function getDatasource(){return new cDatabasesDatasource($this->datasource);}

	/**
	 * Check if is Connected
	 *
	 * @return boolean
	 */
	public function isConnected(){if(is_a($this->pdo,"PDO")){return true;}else{return false;}}

	/**
	 * Connect to Database
	 *
	 * @return boolean
	 * @throws Exception
	 */
	public function connect(){
		// check if already connected
		if($this->isConnected()){return true;}
		// try to connect
		try{
			// make pdo dns
			switch($this->datasource->connector){
				case "oci":
					$dsn="oci:dbname=".$this->datasource->tns;
					break;
				default:
					$dsn=$this->datasource->connector.":host=".$this->datasource->hostname.";dbname=".$this->datasource->database;
			}
			// build pdo
			$this->pdo=new PDO($dsn,$this->datasource->username,$this->datasource->password);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			// database queries
			if($this->datasource->queries){
				// cycle all queries
				$queries_array=array_filter(explode(";",$this->datasource->queries));
				foreach($queries_array as $query){$this->query($query);}
			}
			// return
			return true;
		}catch(PDOException $e){
			// reset pdo
			$this->pdo=null;
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Query to Database
	 *
	 * @param $statement SQL Statement
	 * @return PDOStatement|false
	 * @throws Exception
	 */
	public function query($statement){
		// check if is not connected
		if(!$this->isConnected()){
			// try to connect
			$this->connect();
			if(!$this->isConnected()){return false;}
		}
		// check if is connected
		if(!strlen($statement)){return false;}
		// try to execute query
		try{return $this->pdo->query($statement);}
		catch(PDOException $e){throw new Exception($e->getMessage()."<br><br><pre>".$statement."</pre>");}
	}

	/**
	 * Select Query
	 *
	 * @param $statement SQL Statement
	 * @return array|false
	 * @throws Exception
	 */
	public function select($statement){
		// check parameters
		if(!strlen($statement)){return false;}
		// try to query
		$pdo_statement=$this->query($statement);
		// fetch object records
		$pdo_records=$pdo_statement->fetchAll(PDO::FETCH_OBJ);
		// check for records or build an empty array
		if(!is_array($pdo_records)||!count($pdo_records)){$pdo_records=array();}
		// return
		return $pdo_records;
	}

	/**
	 * Execute Query
	 *
	 * @param $statement SQL Statement
	 * @return integer Number of affected rows
	 * @throws Exception
	 */
	public function execute($statement){
		// try to query
		$pdo_statement=$this->query($statement);
		// fetch object records
		$pdo_affected=$pdo_statement->rowCount();
		// return
		return (integer)$pdo_affected;
	}

	/** @todo migliorare, aggiungendo magare selectUniqueObject, selectUniqueValue, Count, ecc.. */

}
