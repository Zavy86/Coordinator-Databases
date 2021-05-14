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

/**
 * Datasources
 *
 * @var cDatabasesDatasource $datasource_obj
 */
$nav->addItem(api_text("nav-datasources-list"),api_url(["scr"=>"datasources_list"]));
if(api_script_prefix()=="datasources"){
	if(SCRIPT=="datasources_edit" && !$datasource_obj->exists()){$nav->addItem(api_text("nav-datasources-add"),api_url(["scr"=>"datasources_edit"]),(api_checkAuthorization("datasources-manage")));}
	elseif(is_object($datasource_obj) && $datasource_obj->exists() && in_array(SCRIPT,array("datasources_view","datasources_edit"))){
		$nav->addItem(api_text("nav-operations"),null,null,"active");
		$nav->addSubItem(api_text("nav-datasources-operations-edit"),api_url(["scr"=>"datasources_edit","idDatasource"=>$datasource_obj->id]),(api_checkAuthorization("datasources-manage")));
		$nav->addSubItem(api_text("nav-datasources-operations-duplicate"),api_url(["scr"=>"controller","act"=>"duplicate","obj"=>"cDatabasesDatasource","idDatasource"=>$datasource_obj->id]),(api_checkAuthorization("datasources-manage")),api_text("cDatabasesDatasource-confirm-duplicate"));
		$nav->addSubSeparator();
		$nav->addSubItem(api_text("nav-datasources-operations-test"),api_url(["scr"=>"datasources_view","tab"=>"informations","act"=>"test","idDatasource"=>$datasource_obj->id]),(api_checkAuthorization("datasources-manage")));
		//$nav->addSubSeparator();$nav->addSubItem(api_text("nav-datasources-operations-member_add"),api_url(["scr"=>"datasources_view","tab"=>"members","act"=>"member_add","idDatasource"=>$datasource_obj->id]),(api_checkAuthorization("datasources-manage")));
	}
}

// add nav to html
$app->addContent($nav->render(false));
