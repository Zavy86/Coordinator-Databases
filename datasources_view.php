<?php
/**
 * Databases - Datasources View
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 *
 * @var strApplication $app
 */
// check authorizations
api_checkAuthorization("databases-manage","dashboard");
// get objects
$datasource_obj=new cDatabasesDatasource($_REQUEST["idDatasource"]);
// check objects
if(!$datasource_obj->exists()){api_alerts_add(api_text("cDatabasesDatasource-alert-exists"),"danger");api_redirect(api_url(["scr"=>"databases_list"]));}
// deleted alert
if($datasource_obj->isDeleted()){api_alerts_add(api_text("cDatabasesDatasource-warning-deleted"),"warning");}
// include module template
require_once(MODULE_PATH."template.inc.php");
// set application title
$app->setTitle(api_text("datasources_view",$datasource_obj->name));
// check for test action
if(ACTION=="test"){
	try{
		// try to connect
		$database_obj=new cDatabasesDatabase($datasource_obj);
    $database_obj->connect();
		api_alerts_add(api_text("cDatabasesDatasource-success-connection"),"info");
	}catch(Exception $e){api_alerts_add(api_tag("strong",api_text("cDatabasesDatasource-danger-connection"))."<br>".$e->getMessage(),"danger");}
}
// build databases description list
$dl=new strDescriptionList("br","dl-horizontal");
$dl->addElement(api_text("cDatabasesDatasource-property-name"),api_tag("strong",$datasource_obj->name));
if($datasource_obj->description){$dl->addElement(api_text("cDatabasesDatasource-property-description"),nl2br($datasource_obj->description));}
// check for tab
if(!defined(TAB)){define("TAB","informations");}
/**
 * Informations
 *
 * @var strDescriptionList $informations_dl
 */
require_once(MODULE_PATH."datasources_view-informations.inc.php");
// build tabs
$tab=new strTab();
$tab->addItem(api_icon("fa-flag-o")." ".api_text("datasources_view-tab-informations"),$informations_dl->render(),("informations"==TAB?"active":null));
$tab->addItem(api_icon("fa-file-text-o")." ".api_text("datasources_view-tab-logs"),api_logs_table($datasource_obj->getLogs((!$_REQUEST["all_logs"]?10:null)))->render(),("logs"==TAB?"active":null));
// build grid
$grid=new strGrid();
$grid->addRow();
$grid->addCol($dl->render(),"col-xs-12");
$grid->addRow();
$grid->addCol($tab->render(),"col-xs-12");
// add content to application
$app->addContent($grid->render());
// renderize application
$app->render();
// debug
api_dump($datasource_obj,"datasource");
