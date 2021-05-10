<?php
/**
 * Databases - Datasources Edit
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
$datasource_obj=new cDatabasesDatasource($_REQUEST['idDatasource']);
// include module template
require_once(MODULE_PATH."template.inc.php");
// set application title
$app->setTitle(($datasource_obj->exists()?api_text("datasources_edit",$datasource_obj->name):api_text("datasources_edit-new")));
// get form
$form=$datasource_obj->form_edit(["return"=>api_return(["scr"=>"datasources_view"])]);
// additional controls
if($datasource_obj->exists()){
	$form->addControl("button",api_text("form-fc-cancel"),api_return_url(["scr"=>"datasources_view","idDatasource"=>$datasource_obj->id]));
	if(!$datasource_obj->deleted){
		$form->addControl("button",api_text("form-fc-delete"),api_url(["scr"=>"controller","act"=>"delete","obj"=>"cDatasourcesDatasource","idDatasource"=>$datasource_obj->id]),"btn-danger",api_text("cDatasourcesDatasource-confirm-delete"));
	}else{
		$form->addControl("button",api_text("form-fc-undelete"),api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cDatasourcesDatasource","idDatasource"=>$datasource_obj->id,"return"=>["scr"=>"datasources_view"]]),"btn-warning");
		$form->addControl("button",api_text("form-fc-remove"),api_url(["scr"=>"controller","act"=>"remove","obj"=>"cDatasourcesDatasource","idDatasource"=>$datasource_obj->id]),"btn-danger",api_text("cDatasourcesDatasource-confirm-remove"));
	}
}else{$form->addControl("button",api_text("form-fc-cancel"),api_url(["scr"=>"datasources_list"]));}
// build grid
$grid=new strGrid();
$grid->addRow();
$grid->addCol($form->render(),"col-xs-12");
// add content to application
$app->addContent($grid->render());
// renderize application
$app->render();
// debug
api_dump($datasource_obj,"datasource");
