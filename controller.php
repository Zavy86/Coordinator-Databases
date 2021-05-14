<?php
/**
 * Databases - Controller
 *
 * @package Coordinator\Modules\Databases
 * @company Cogne Acciai Speciali s.p.a
 */

// debug
api_dump($_REQUEST,"_REQUEST");
// check if object controller function exists
if(function_exists($_REQUEST["obj"]."_controller")){
	// call object controller function
	call_user_func($_REQUEST["obj"]."_controller",$_REQUEST["act"]);
}else{
	api_alerts_add(api_text("alert_controllerObjectNotFound",[MODULE,$_REQUEST["obj"]."_controller"]),"danger");
	api_redirect("?mod=".MODULE);
}

/**
 * Datasource controller
 *
 * @param string $action Object action
 */
function cDatabasesDatasource_controller($action){
	// check authorizations
	api_checkAuthorization("databases-manage","dashboard");
	// get object
	$datasource_obj=new cDatabasesDatasource($_REQUEST["idDatasource"]);
	api_dump($datasource_obj,"datasource object");
	// check object
	if($action!="store" && !$datasource_obj->exists()){api_alerts_add(api_text("cDatabasesDatasource-alert-exists"),"danger");api_redirect(api_url(["scr"=>"databases_list"]));}
	// execution
	try{
		switch($action){
			case "store":
				$datasource_obj->store($_REQUEST);
				api_alerts_add(api_text("cDatabasesDatasource-alert-stored"),"success");
				break;
			case "duplicate":
				$datasource_obj->duplicate();
				api_alerts_add(api_text("cDatabasesDatasource-alert-duplicated"),"success");
				break;
			case "delete":
				$datasource_obj->delete();
				api_alerts_add(api_text("cDatabasesDatasource-alert-deleted"),"warning");
				break;
			case "undelete":
				$datasource_obj->undelete();
				api_alerts_add(api_text("cDatabasesDatasource-alert-undeleted"),"warning");
				break;
			case "remove":
				$datasource_obj->remove();
				api_alerts_add(api_text("cDatabasesDatasource-alert-removed"),"warning");
				break;
			default:
				throw new Exception("Datasource action \"".$action."\" was not defined..");
		}
		// redirect
		api_redirect(api_return_url(["scr"=>"datasources_list","idDatasource"=>$datasource_obj->id]));
	}catch(Exception $e){
		// dump, alert and redirect
		api_redirect_exception($e,api_url(["scr"=>"datasources_list","idDatasource"=>$datasource_obj->id]),"cDatabasesDatasource-alert-error");
	}
}
