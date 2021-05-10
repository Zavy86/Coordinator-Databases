<?php
/**
 * Databases - Datasources View (Informations)
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 *
 * @var strApplication $app
 * @var cDatabasesDatasource $datasource_obj
 */
// make informations description list
$informations_dl=new strDescriptionList("br","dl-horizontal");
$informations_dl->addElement(api_text("cDatabasesDatasource-property-connector"),$datasource_obj->getConnector()->getLabel());
if($datasource_obj->hostname){$informations_dl->addElement(api_text("cDatabasesDatasource-property-hostname"),api_tag("samp",$datasource_obj->hostname));}
if($datasource_obj->database){$informations_dl->addElement(api_text("cDatabasesDatasource-property-database"),api_tag("samp",$datasource_obj->database));}
if($datasource_obj->username){$informations_dl->addElement(api_text("cDatabasesDatasource-property-username"),api_tag("samp",$datasource_obj->username));}
if($datasource_obj->password){
	if($_GET['password']){$informations_dl->addElement(api_text("cDatabasesDatasource-property-password"),api_link(api_url(["scr"=>"datasources_view","tab"=>"informations","idDatasource"=>$datasource_obj->id,"password"=>false]),api_tag("samp",$datasource_obj->password)));}
	else{$informations_dl->addElement(api_text("cDatabasesDatasource-property-password"),api_link(api_url(["scr"=>"datasources_view","tab"=>"informations","idDatasource"=>$datasource_obj->id,"password"=>true]),api_tag("samp",str_repeat("*",16))));}
}
if($datasource_obj->tns){$informations_dl->addElement(api_text("cDatabasesDatasource-property-tns"),api_tag("pre",$datasource_obj->tns));}
if($datasource_obj->queries){$informations_dl->addElement(api_text("cDatabasesDatasource-property-queries"),api_tag("pre",$datasource_obj->queries));}
