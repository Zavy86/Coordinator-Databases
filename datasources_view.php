<?php
/**
 * Databases - Datasources View
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // check authorizations
 api_checkAuthorization("databases-manage","dashboard");
 // get objects
 $datasource_obj=new cDatabasesDatasource($_REQUEST['idDatasource'],$_REQUEST['datasource']);
 // check objects  /** @todo decidere se usare exists o id */
 if(!$datasource_obj->exists()){api_alerts_add(api_text("databases_alert-datasource-exists"),"danger");api_redirect("?mod=".MODULE."&scr=datasources_list");}
 // deleted alert
 if($datasource_obj->deleted){api_alerts_add(api_text("datasources_view-alert-deleted"),"warning");}
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(api_text("datasources_view",$datasource_obj->name));
 // check for tab
 if(!defined(TAB)){define("TAB","informations");}
 // build datasource description list
 $datasource_dl=new strDescriptionList("br","dl-horizontal");
 $datasource_dl->addElement(api_text("datasources_view-dt-name"),api_tag("strong",$datasource_obj->name));
 $datasource_dl->addElement(api_text("datasources_view-dt-typology"),$datasource_obj->getTypology());
 if($datasource_obj->description){$datasource_dl->addElement(api_text("datasources_view-dt-description"),nl2br($datasource_obj->description));}
 // build group table
 $table_groups=new strTable(api_text("datasources_view-tr-unvalued"));
 // include tabs
 require_once(MODULE_PATH."datasources_view-informations.inc.php");
 $tab=new strTab();
 $tab->addItem(api_icon("fa-flag-o")." ".api_text("datasources_view-tab-informations"),$informations_dl->render(),("informations"==TAB?"active":null));
 $tab->addItem(api_icon("fa-file-text-o")." ".api_text("datasources_view-tab-events"),api_events_table($datasource_obj->getLogs())->render(),("events"==TAB?"active":null));
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($datasource_dl->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($tab->render(),"col-xs-12");
 // add content to application
 $app->addContent($grid->render());
 // renderize application
 $app->render();
 // debug
 api_dump($datasource_obj,"datasource");
?>