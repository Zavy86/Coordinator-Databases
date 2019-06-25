<?php
/**
 * Databases - Datasources View (Informations)
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // make informations description list
 $informations_dl=new strDescriptionList("br","dl-horizontal");
 $informations_dl->addElement(api_text("datasources_view-informations-dt-connector"),$datasource_obj->getConnector());
 if($datasource_obj->hostname){$informations_dl->addElement(api_text("datasources_view-informations-dt-hostname"),api_tag("samp",$datasource_obj->hostname));}
 if($datasource_obj->database){$informations_dl->addElement(api_text("datasources_view-informations-dt-database"),api_tag("samp",$datasource_obj->database));}
 if($datasource_obj->username){$informations_dl->addElement(api_text("datasources_view-informations-dt-username"),api_tag("samp",$datasource_obj->username));}
 if($datasource_obj->password){
  if($_GET['password']){$informations_dl->addElement(api_text("datasources_view-informations-dt-password"),api_tag("samp",$datasource_obj->password));}
  else{$informations_dl->addElement(api_text("datasources_view-informations-dt-password"),api_link("?mod=".MODULE."&scr=datasources_view&tab=informations&password=1&idDatasource=".$datasource_obj->id,api_tag("samp",str_repeat("*",strlen($datasource_obj->password)))));}
 }
 if($datasource_obj->tns){$informations_dl->addElement(api_text("datasources_view-informations-dt-tns"),api_tag("pre",$datasource_obj->tns));}
 if($datasource_obj->queries){$informations_dl->addElement(api_text("datasources_view-informations-dt-queries"),api_tag("pre",$datasource_obj->queries));}
?>