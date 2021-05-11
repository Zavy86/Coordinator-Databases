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


	public function query($statement,$debug){
		// check if is connected
		if(!$this->isConnected()){return false;} /** @todo force connect? */
		if(!strlen($statement)){return false;}
		// try to execute query
		try{return $this->pdo->query($statement);}
		catch(PDOException $e){throw new Exception($e->getMessage()."<br>Statement: ".$statement);}
	}


	public function select($sql){
		// try to query
		$pdo_statement=$this->query($sql);
		// fetch object records
		$pdo_results=$pdo_statement->fetchAll(PDO::FETCH_OBJ);
		// check results
		if(!is_array($pdo_results)||!count($pdo_results)){$pdo_results=array();}
		// return
		return $pdo_results;
	}

}
