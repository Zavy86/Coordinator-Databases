<?php
/**
 * Databases - Datasources List
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 *
 * @var strApplication $app
 */

// check authorizations
api_checkAuthorization("databases-manage","dashboard");
// include module template
require_once(MODULE_PATH."template.inc.php");
// set application title
$app->setTitle(api_text("datasources_list"));
// build filters
$filter=new strFilter();
$filter->addSearch(array("name","description"));
$filter->addItem(api_text("cDatabasesDatasourceTypology"),api_transcodingsFromObjects(cDatabasesDatasourceTypology::availables(),"code","text"),"typology");
$filter->addItem(api_text("cDatabasesDatasourceConnector"),api_transcodingsFromObjects(cDatabasesDatasourceConnector::availables(),"code","text"),"connector");
// build query object
$query=new cQuery("databases__datasources",$filter->getQueryWhere());
$query->addQueryOrderField("name");
// build pagination object
$pagination=new strPagination($query->getRecordsCount());
// get records
$datasources_array=array();
foreach($query->getRecords($pagination->getQueryLimits()) as $result_f){$datasources_array[$result_f->id]=new cDatabasesDatasource($result_f);}
// build table
$table=new strTable(api_text("datasources_list-tr-unvalued"));
$table->addHeader($filter->link(api_icon("fa-filter",api_text("filters-modal-link"),"hidden-link")),"text-center",16);
$table->addHeader(api_text("cDatabasesDatasource-property-name"),"nowrap");
$table->addHeader("&nbsp;",null,16);
$table->addHeader(api_text("cDatabasesDatasource-property-description"),null,"100%");
$table->addHeader("&nbsp;",null,16);
// cycle all datasources
foreach($datasources_array as $datasource_fobj){
	// build operation button
	$ob=new strOperationsButton();
	$ob->addElement(api_url(["scr"=>"datasources_edit","idDatasource"=>$datasource_fobj->id,"return"=>["scr"=>"datasources_list"]]),"fa-pencil",api_text("table-td-edit"));
	if($datasource_fobj->deleted){$ob->addElement(api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cDatabasesDatasource","idDatasource"=>$datasource_fobj->id,"return"=>["scr"=>"management","tab"=>"templates"]]),"fa-trash-o",api_text("table-td-undelete"),true,api_text("cDatabasesDatasource-confirm-undelete"));}
	else{$ob->addElement(api_url(["scr"=>"controller","act"=>"delete","obj"=>"cDatabasesDatasource","idDatasource"=>$datasource_fobj->id,"return"=>["scr"=>"management","tab"=>"templates"]]),"fa-trash",api_text("table-td-delete"),true,api_text("cDatabasesDatasource-confirm-delete"));}
	// make table row class
	$tr_class_array=array();
	if($datasource_fobj->id==$_REQUEST['idDatasource']){$tr_class_array[]="currentrow";}
	if($datasource_fobj->deleted){$tr_class_array[]="deleted";}
	// make datasource row
	$table->addRow(implode(" ",$tr_class_array));
	$table->addRowFieldAction(api_url(["scr"=>"datasources_view","idDatasource"=>$datasource_fobj->id]),"fa-search",api_text("table-td-view"));
	$table->addRowField($datasource_fobj->name,"nowrap");
	$table->addRowField($datasource_fobj->getTypology()->getLabel(false,true),"nowrap");
	$table->addRowField($datasource_fobj->description,"truncate-ellipsis");
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
