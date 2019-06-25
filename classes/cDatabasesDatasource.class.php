<?php
/**
 * Databases - Datasource
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Databases Datasource class
  */
 class cDatabasesDatasource extends cObject{

  /** Parameters */
  static protected $module="databases";
  static protected $object="datasource";
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
   * Available Typologies
   *
   * @return object[] Array of available typologies
   */
  public static function availableTypologies(){
   // return available typologyes
   return array(
    "coordinator"=>(object)array("code"=>"coordinator","text"=>api_text("databases_datasource_typology-coordinator"),"icon"=>api_icon("fa-database",api_text("databases_datasource_typology-coordinator"))),
    "reporting"=>(object)array("code"=>"reporting","text"=>api_text("databases_datasource_typology-reporting"),"icon"=>api_icon("fa-bar-chart",api_text("databases_datasource_typology-reporting")))
   );
  }

  /**
   * Available Connectors
   *
   * @return object[] Array of available connectors
   */
  public static function availableConnectors(){
   // return available typologyes
   return array(
    "mysql"=>(object)array("code"=>"mysql","text"=>api_text("databases_datasource_connector-mysql"),"icon"=>api_icon("fa-maxcdn",api_text("databases_datasource_connector-mysql"))),
    "oci"=>(object)array("code"=>"oci","text"=>api_text("databases_datasource_connector-oci"),"icon"=>api_icon("fa-opera",api_text("databases_datasource_connector-oci")))
   );
  }

  /**
   * Get Typology
   *
   * @param boolean $icon Return icon
   * @param boolean $text Return text
   * @param string $align Icon alignment [left|right]
   * @return string
   */
  public function getTypology($icon=true,$text=true,$align="left"){
   return parent::convertAvailable($this->typology,static::availableTypologies(),$icon,$text,$align);
  }

  /**
   * Get Connector
   *
   * @param boolean $icon Return icon
   * @param boolean $text Return text
   * @param string $align Icon alignment [left|right]
   * @return string
   */
  public function getConnector($icon=true,$text=true,$align="left"){
   return parent::convertAvailable($this->connector,static::availableConnectors(),$icon,$text,$align);
  }

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
   if(!array_key_exists($this->typology,static::availableTypologies())){throw new Exception("Datasource typology \"".$this->typology."\" is not defined..");}
   if(!strlen(trim($this->connector))){throw new Exception("Datasource connector is mandatory..");}
   if(!array_key_exists($this->connector,static::availableConnectors())){throw new Exception("Datasource connector \"".$this->connector."\" is not defined..");}
   // return
   return true;
  }

  // debug
  //protected function event_triggered($event){api_dump($event);}

 }

?>