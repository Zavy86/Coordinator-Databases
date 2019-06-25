<?php
/**
 * Databases - Submit
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 // debug
 api_dump($_REQUEST,"_REQUEST");
 // check for actions
 if(!defined('ACTION')){die("ERROR EXECUTING SCRIPT: The action was not defined");}
 // switch action
 switch(ACTION){
  // datasources
  case "datasource_save":datasource_save();break;
  case "datasource_delete":datasource_deleted(true);break;
  case "datasource_undelete":datasource_deleted(false);break;
  case "datasource_remove":datasource_remove();break;
  // default
  default:
   api_alerts_add(api_text("alert_submitFunctionNotFound",array(MODULE,SCRIPT,ACTION)),"danger");
   api_redirect("?mod=".MODULE);
 }

 /**
  * Datasource Save
  */
 function datasource_save(){
  // check authorizations
  api_checkAuthorization("databases-manage","dashboard");
  // get object
  $datasource_obj=new cDatabasesDatasource($_REQUEST['idDatasource']);
  api_dump($datasource_obj,"datasource object");
  try{
   // set properties
   $datasource_obj->setProperties($_REQUEST);
   // save object
   $datasource_obj->save();
   // alert and redirect
   api_alerts_add(api_text("databases_alert-datasource-saved"),"success");
   api_redirect("?mod=".MODULE."&scr=".api_return_script("datasources_view")."&idDatasource=".$datasource_obj->id);
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,"?mod=".MODULE."&scr=datasources_list&idDatasource=".$datasource_obj->id,"databases_alert-datasourceError");
  }
 }

 /**
  * Datasource Deleted
  *
  * @param boolean $deleted Deleted if true or undeleted
  */
 function datasource_deleted($deleted){
  // check authorizations
  api_checkAuthorization("databases-manage","dashboard");
  // get object
  $datasource_obj=new cDatabasesDatasource($_REQUEST['idDatasource']);
  api_dump($datasource_obj,"datasource object");
  // check object
  if(!$datasource_obj->id){api_alerts_add(api_text("databases_alert-datasource-exists"),"danger");api_redirect("?mod=".MODULE."&scr=datasources_list");}
  try{
   if($deleted){
    $datasource_obj->delete();
    $action="datasource-deleted";
   }else{
    $datasource_obj->undelete();
    $action="datasource-undeleted";
   }
   // alert and redirect
   api_alerts_add(api_text("databases_alert-".$action),"warning");
   api_redirect("?mod=".MODULE."&scr=datasources_list&idDatasource=".$datasource_obj->id);
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,"?mod=".MODULE."&scr=datasources_list&idDatasource=".$datasource_obj->id,"databases_alert-datasourceError");
  }
 }

 /**
  * Datasource Remove
  */
 function datasource_remove(){
  // check authorizations
  api_checkAuthorization("databases-manage","dashboard");
  // get object
  $datasource_obj=new cDatabasesDatasource($_REQUEST['idDatasource']);
  api_dump($datasource_obj,"datasource object");
  // check object
  if(!$datasource_obj->id){api_alerts_add(api_text("databases_alert-datasource-exists"),"danger");api_redirect("?mod=".MODULE."&scr=datasources_list");}
  try{
   // remove object
   $datasource_obj->remove();
   // alert and redirect
   api_alerts_add(api_text("databases_alert-datasource-removed"),"warning");
   api_redirect("?mod=".MODULE."&scr=datasources_list");
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,"?mod=".MODULE."&scr=datasources_list&idDatasource=".$datasource_obj->id,"databases_alert-datasourceError");
  }
 }

?>