<?php
/**
 * Databases - Datasources List
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // check authorizations
 api_checkAuthorization("databases-manage","dashboard");
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // definitions
 $users_array=array();
 // set application title
 $app->setTitle(api_text("datasources_list"));
 // definitions
 $datasources_array=array();
 // build filter
 $filter=new strFilter();
 $filter->addSearch(array("name","description"));
 // build query object
 $query=new cQuery("databases__datasources",$filter->getQueryWhere());
 $query->addQueryOrderField("name");
 // build pagination object
 $pagination=new strPagination($query->getRecordsCount());
 // cycle all results
 foreach($query->getRecords($pagination->getQueryLimits()) as $result_f){$datasources_array[$result_f->id]=new cDatabasesDatasource($result_f);}
 // build table
 $table=new strTable(api_text("datasources_list-tr-unvalued"));
 $table->addHeader($filter->link(api_icon("fa-filter",api_text("filters-modal-link"),"hidden-link")),"text-center",16);
 $table->addHeader(api_text("datasources_list-th-name"),"nowrap");
 $table->addHeader(api_text("datasources_list-th-description"),null,"100%");
 $table->addHeader("&nbsp;",null,16);
 // cycle all datasources
 foreach($datasources_array as $datasource_obj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement("?mod=".MODULE."&scr=datasources_edit&idDatasource=".$datasource_obj->id."&return_scr=datasources_list","fa-pencil",api_text("datasources_list-td-edit"),(api_checkAuthorization("databases-manage")));
  if($datasource_obj->deleted){$ob->addElement("?mod=".MODULE."&scr=submit&act=datasource_undelete&idDatasource=".$datasource_obj->id,"fa-trash-o",api_text("datasources_list-td-undelete"),true,api_text("datasources_list-td-undelete-confirm"));}
  else{$ob->addElement("?mod=".MODULE."&scr=submit&act=datasource_delete&idDatasource=".$datasource_obj->id,"fa-trash",api_text("datasources_list-td-delete"),true,api_text("datasources_list-td-delete-confirm"));}
  // make table row class
  $tr_class_array=array();
  if($datasource_obj->id==$_REQUEST['idDatasource']){$tr_class_array[]="info";}
  if($datasource_obj->deleted){$tr_class_array[]="deleted";}
  // make datasource row
  $table->addRow(implode(" ",$tr_class_array));
  $table->addRowFieldAction("?mod=".MODULE."&scr=datasources_view&idDatasource=".$datasource_obj->id,"fa-search",api_text("datasources_list-td-view"));
  $table->addRowField($datasource_obj->name,"nowrap");
  $table->addRowField($datasource_obj->description,"truncate-ellipsis");
  $table->addRowField($ob->render(),"text-right");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($filter->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($table->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($pagination->render(),"col-xs-12");
 // add content to application
 $app->addContent($grid->render());
 // renderize application
 $app->render();
 // debug
 api_dump($query->getQuerySQL(),"query");
?>