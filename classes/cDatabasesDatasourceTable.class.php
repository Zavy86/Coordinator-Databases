<?php
/**
 * Databases - Datasource Table
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Databases Datasource Table class
  */
 class cDatabasesDatasourceTable extends cObject{

  /** Parameters */
  static protected $module="databases";
  static protected $object="datasource_table";
  static protected $table="databases__datasources__tables";
  static protected $logs=false;

  /** Properties */
  protected $id;
  protected $deleted;
  protected $fkDatasource;
  protected $name;
  protected $description;

  /**
   * Check before save
   *
   * @return boolean
   * @throws Exception
   */
  protected function check(){
   // check properties
   if(!strlen(trim($this->fkDatasource))){throw new Exception("Datasource key is mandatory..");}
   if(!strlen(trim($this->name))){throw new Exception("Datasource table name is mandatory..");}
   // return
   return true;
  }

  /**
   * Event triggered
   *
   * @param object $event Object event
   */
  protected function event_triggered($event){
   // check parameters
   if(!in_array($event->action,array("created","updated","delete","undeleted","removed"))){return;}
   // get datasource
   $datasource=new cDatabasesDatasource($this->fkDatasource);
   // save table event to parent datasource
   $datasource->event($event->typology,"table-".$event->action,array("note"=>$this->name));
  }

 }

?>