<?php
/**
 * Databases - Datasources Edit
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // check authorizations
 api_checkAuthorization("databases-manage","dashboard");
 // get objects
 $datasource_obj=new cDatabasesDatasource($_REQUEST['idDatasource']);
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(($datasource_obj->id?api_text("datasources_edit",$datasource_obj->name):api_text("datasources_edit-add")));
 // build datasource form
 $form=new strForm("?mod=".MODULE."&scr=submit&act=datasource_save&idDatasource=".$datasource_obj->id."&return_scr=".$_REQUEST['return_scr'],"POST",null,"datasources_edit");
 $form->addField("text","name",api_text("datasources_edit-ff-name"),$datasource_obj->name,api_text("datasources_edit-ff-name-placeholder"),null,null,null,"required");
 $form->addField("textarea","description",api_text("datasources_edit-ff-description"),$datasource_obj->description,api_text("datasources_edit-ff-description-placeholder"),null,null,null,"rows='2'");
 $form->addField("select","typology",api_text("datasources_edit-ff-typology"),$datasource_obj->typology,api_text("datasources_edit-ff-typology-select"),null,null,null,"required");
 foreach(cDatabasesDatasource::availableTypologies() as $typology_fobj){$form->addFieldOption($typology_fobj->code,$typology_fobj->text);}
 $form->addField("select","connector",api_text("datasources_edit-ff-connector"),$datasource_obj->connector,api_text("datasources_edit-ff-connector-select"),null,null,null,"required");
 foreach(cDatabasesDatasource::availableConnectors() as $connector_fobj){$form->addFieldOption($connector_fobj->code,$connector_fobj->text);}
 $form->addField("text","hostname",api_text("datasources_edit-ff-hostname"),$datasource_obj->hostname,api_text("datasources_edit-ff-hostname-placeholder"),null,"code");
 $form->addField("text","database",api_text("datasources_edit-ff-database"),$datasource_obj->database,api_text("datasources_edit-ff-database-placeholder"),null,"code");
 $form->addField("text","username",api_text("datasources_edit-ff-username"),$datasource_obj->username,api_text("datasources_edit-ff-username-placeholder"),null,"code");
 $form->addField("text","password",api_text("datasources_edit-ff-password"),$datasource_obj->password,api_text("datasources_edit-ff-password-placeholder"),null,"code");
 $form->addField("textarea","tns",api_text("datasources_edit-ff-tns"),$datasource_obj->tns,api_text("datasources_edit-ff-tns-placeholder"),null,"code",null,"rows='2'");
 $form->addField("textarea","queries",api_text("datasources_edit-ff-queries"),$datasource_obj->queries,api_text("datasources_edit-ff-queries-placeholder"),null,"code",null,"rows='2'");
 // controls
 $form->addControl("submit",api_text("form-fc-submit"));
 if($datasource_obj->id){
  $form->addControl("button",api_text("form-fc-cancel"),"?mod=".MODULE."&scr=".api_return_script("datasources_view")."&idDatasource=".$datasource_obj->id);
  if(!$datasource_obj->deleted){
   $form->addControl("button",api_text("form-fc-delete"),"?mod=".MODULE."&scr=submit&act=datasource_delete&idDatasource=".$datasource_obj->id,"btn-danger",api_text("datasources_edit-fc-delete-confirm"));
  }else{
   $form->addControl("button",api_text("form-fc-undelete"),"?mod=".MODULE."&scr=submit&act=datasource_undelete&idDatasource=".$datasource_obj->id,"btn-warning");
   $form->addControl("button",api_text("form-fc-remove"),"?mod=".MODULE."&scr=submit&act=datasource_remove&idDatasource=".$datasource_obj->id,"btn-danger",api_text("datasources_edit-fc-remove-confirm"));
  }
 }else{$form->addControl("button",api_text("form-fc-cancel"),"?mod=".MODULE."&scr=datasources_list");}
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($form->render(),"col-xs-12");
 // add content to application
 $app->addContent($grid->render());
 // renderize application
 $app->render();
 // debug
 api_dump($datasource_obj,"datasource");
?>