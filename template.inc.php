<?php
/**
 * Databases - Template
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // build application
 $app=new strApplication();
 // build nav object
 $nav=new strNav("nav-tabs");
 // dashboard
 $nav->addItem(api_icon("fa-th-large",null,"hidden-link"),"?mod=".MODULE."&scr=dashboard");
 // datasources
 if(explode("_",SCRIPT)[0]=="datasources"){
  $nav->addItem(api_text("datasources_list"),"?mod=".MODULE."&scr=datasources_list");
  // operations
  if($datasource_obj->id && in_array(SCRIPT,array("datasources_view","datasources_edit"))){
   $nav->addItem(api_text("nav-operations"),null,null,"active");
   $nav->addSubItem(api_text("datasources_edit"),"?mod=".MODULE."&scr=datasources_edit&idDatasource=".$datasource_obj->id,(api_checkAuthorization("databases-manage")));
   $nav->addSubSeparator();
   $nav->addSubItem(api_text("datasources-operations-specification_add"),"?mod=".MODULE."&scr=datasources_view&tab=specifications&act=specification_add&idDatasource=".$datasource_obj->id,(api_checkAuthorization("databases-manage")));
  }else{
   $nav->addItem(api_text("datasources_edit-add"),"?mod=".MODULE."&scr=datasources_edit",(api_checkAuthorization("databases-manage")));
  }
 }
 // add nav to html
 $app->addContent($nav->render(false));
?>