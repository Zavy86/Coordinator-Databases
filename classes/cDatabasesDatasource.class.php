<?php
/**
 * Databases - Datasource
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

/**
 * Databases, Datasource class
 */
class cDatabasesDatasource extends cObject{

	/** Parameters */
	static protected $table="databases__datasources";
	static protected $logs=true;

	/** Properties */
	protected $id;
	protected $deleted;
	protected $name;
	protected $description;
	protected $typology;
	protected $connector;
	protected $hostname;
	protected $database;
	protected $username;
	protected $password;
	protected $tns;
	protected $queries;

	/**
	 * Check
	 *
	 * @return boolean
	 * @throws Exception
	 */
	protected function check(){
		// check properties
		if(!strlen(trim($this->name))){throw new Exception("Datasource name is mandatory..");}
		if(!strlen(trim($this->typology))){throw new Exception("Datasource typology is mandatory..");}
		if(!array_key_exists($this->typology,cDatabasesDatasourceTypology::availables())){throw new Exception("Datasource typology \"".$this->typology."\" is not defined..");}
		if(!strlen(trim($this->connector))){throw new Exception("Datasource connector is mandatory..");}
		if(!array_key_exists($this->connector,static::availableConnectors())){throw new Exception("Datasource connector \"".$this->connector."\" is not defined..");}
		// return
		return true;
	}

	/**
	 * Get Typology
	 *
	 * @return cDatabasesDatasourceTypology
	 */
	public function getTypology(){return new cDatabasesDatasourceTypology($this->typology);}

	/**
	 * Get Connector
	 *
	 * @return cDatabasesDatasourceConnector
	 */
	public function getConnector(){return new cDatabasesDatasourceConnector($this->connector);}

	/**
	 * Get Label
	 *
	 * @return string
	 */
	public function getLabel(){
		return $this->name.($this->description?" (".$this->description.")":null);
	}

	// debug
	//protected function event_triggered($event){api_dump($event);}

}
