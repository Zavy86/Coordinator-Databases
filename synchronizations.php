<?php
/**
 * Databases - Synchronizations
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // check authorizations
 api_checkAuthorization("databases-manage","dashboard");
 // get objects
 $datasource_obj=new cDatabasesDatasource($_REQUEST['idDatasource'],$_REQUEST['datasource']);

  // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(api_text("synchronizations"));


 // check for tab
 if(!defined(TAB)){define("TAB","datasources");}


 // build settings tabs
 $tabs_nav=new strNav("nav-pills");
 $tabs_nav->addItem(api_text("synchronizations-datasources"),"?mod=".MODULE."&scr=synchronizations&tab=datasources");
 $tabs_nav->addItem(api_text("synchronizations-tables"),"?mod=".MODULE."&scr=synchronizations&tab=tables&idDatasource=".$datasource_obj->id,false);
 $tabs_nav->addItem(api_text("synchronizations-confirm"),"?mod=".MODULE."&scr=synchronizations&tab=confirm",false);
 // add tabs to application
 $app->addContent($tabs_nav->render(false));


 switch(TAB){
  case "datasources":require_once(MODULE_PATH."synchronizations-datasources.inc.php");break;
  case "tables":require_once(MODULE_PATH."synchronizations-tables.inc.php");break;
  case "confirm":require_once(MODULE_PATH."synchronizations-confirm.inc.php");break;
 }

/*

 // build datasource form
 $form=new strForm("?mod=".MODULE."&scr=submit&act=synchronizations"/*&return_scr=".$_REQUEST['return_scr']/,"POST",null,null,"synchronizations");
 $form->addField("select","datasource",api_text("datasources_edit-ff-datasource"),$_REQUEST['idDatasource'],api_text("datasources_edit-ff-datasource-select"),null,null,null,"required");
 foreach(cDatabasesDatasource::availables("`deleted`='0' AND `typology`='coordinator'","`name`") as $datasource_fobj){$form->addFieldOption($datasource_fobj->id,$datasource_fobj->getLabel());}


 // controls
 $form->addControl("submit",api_text("form-fc-save"));
 if($datasource_obj->id){
  $form->addControl("button",api_text("form-fc-cancel"),"?mod=".MODULE."&scr=".api_return_script("datasources_view")."&idDatasource=".$datasource_obj->id);
 }else{$form->addControl("button",api_text("form-fc-cancel"),"?mod=".MODULE."&scr=datasources_list");}   /** @todo da fare *


 $script=<<<EOS
$("#form_synchronizations_input_datasource").on("change",function(){
 alert(this.value);
});
EOS;

 // add script to application
 $app->addScript($script);

 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($form->render(),"col-xs-12");

 // add content to application
 $app->addContent($grid->render());*/

 // renderize application
 $app->render();

 // debug
 api_dump($datasource_obj,"datasource");

?>