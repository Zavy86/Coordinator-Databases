<?php
/**
 * Databases - Synchronizations (Select)
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

// check objects
 if(!$datasource_obj->exists() || $datasource_obj->deleted){api_redirect("?mod=".MODULE."&scr=synchronizations&tab=datasources");}

 // build table
 $table=new strTable(api_text("datasources_list-tr-unvalued"));
 $table->addHeader("&nbsp;",null,16);
 $table->addHeader(api_text("datasources_list-th-name"),"nowrap");
 $table->addHeader(api_text("datasources_list-th-description"),null,"100%");
 // cycle all datasources
 foreach(cDatabasesDatasource::availables("`deleted`='0' AND `typology`='coordinator'","`name`") as $datasource_obj){
  // make datasource row
  $table->addRow();
  $table->addRowFieldAction("?mod=".MODULE."&scr=synchronizations&tab=tables&idDatasource=".$datasource_obj->id,"fa-plus",api_text("synchronizations-td-select"));
  $table->addRowField($datasource_obj->name,"nowrap");
  $table->addRowField($datasource_obj->description,"truncate-ellipsis");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($table->render(),"col-xs-12");
 // add content to application
 $app->addContent($grid->render());

?>