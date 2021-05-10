<?php
/**
 * Databases - Datasource
 *
 * @package Coordinator\Modules\Databases
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

/**
 * Databases, Datasource class
 */
class cDatabasesDatasource extends cObject{

	/** Parameters */
	static protected $table="databases__datasources";
	static protected $logs=true;

	/** Properties */
	protected $id;
	protected $deleted;
	protected $name;
	protected $description;
	protected $typology;
	protected $connector;
	protected $hostname;
	protected $database;
	protected $username;
	protected $password;
	protected $tns;
	protected $queries;

	/**
	 * Check
	 *
	 * @return boolean
	 * @throws Exception
	 */
	protected function check(){
		// check properties
		if(!strlen(trim($this->name))){throw new Exception("Datasource name is mandatory..");}
		if(!strlen(trim($this->typology))){throw new Exception("Datasource typology is mandatory..");}
		if(!array_key_exists($this->typology,cDatabasesDatasourceTypology::availables())){throw new Exception("Datasource typology \"".$this->typology."\" is not defined..");}
		if(!strlen(trim($this->connector))){throw new Exception("Datasource connector is mandatory..");}
		if(!array_key_exists($this->connector,static::availableConnectors())){throw new Exception("Datasource connector \"".$this->connector."\" is not defined..");}
		// return
		return true;
	}

	/**
	 * Get Typology
	 *
	 * @return cDatabasesDatasourceTypology
	 */
	public function getTypology(){return new cDatabasesDatasourceTypology($this->typology);}

	/**
	 * Get Connector
	 *
	 * @return cDatabasesDatasourceConnector
	 */
	public function getConnector(){return new cDatabasesDatasourceConnector($this->connector);}

	/**
	 * Get Label
	 *
	 * @return string
	 */
	public function getLabel(){
		return $this->name.($this->description?" (".$this->description.")":null);
	}

	/**
	 * Edit form
	 *
	 * @param string[] $additional_parameters Array of url additional parameters
	 * @return object Form structure
	 */
	public function form_edit(array $additional_parameters=array()){
		// build form
		$form=new strForm(api_url(array_merge(["mod"=>"databases","scr"=>"controller","act"=>"store","obj"=>"cDatabasesDatasource","idDatasource"=>$this->id],$additional_parameters)),"POST",null,null,"databases__datasource-edit_form");
		// fields
		$form->addField("text","name",api_text("cDatabasesDatasource-property-name"),$this->name,api_text("cDatabasesDatasource-placeholder-name"),null,null,null,"required");
		$form->addField("textarea","description",api_text("cDatabasesDatasource-property-description"),$this->description,api_text("cDatabasesDatasource-placeholder-description"),null,null,null,"rows='2'");
		$form->addField("select","typology",api_text("cDatabasesDatasource-property-typology"),$this->typology,api_text("cDatabasesDatasource-placeholder-typology"),null,null,null,"required");
		foreach(cDatabasesDatasourceTypology::availables() as $typology_fobj){$form->addFieldOption($typology_fobj->code,$typology_fobj->text);}
		$form->addField("select","connector",api_text("cDatabasesDatasource-property-connector"),$this->connector,api_text("cDatabasesDatasource-placeholder-connector"),null,null,null,"required");
		foreach(cDatabasesDatasourceConnector::availables() as $connector_fobj){$form->addFieldOption($connector_fobj->code,$connector_fobj->text);}
		$form->addField("text","hostname",api_text("cDatabasesDatasource-property-hostname"),$this->hostname,api_text("cDatabasesDatasource-placeholder-hostname"),null,"code");
		$form->addField("text","database",api_text("cDatabasesDatasource-property-database"),$this->database,api_text("cDatabasesDatasource-placeholder-database"),null,"code");
		$form->addField("text","username",api_text("cDatabasesDatasource-property-username"),$this->username,api_text("cDatabasesDatasource-placeholder-username"),null,"code");
		$form->addField("text","password",api_text("cDatabasesDatasource-property-password"),$this->password,api_text("cDatabasesDatasource-placeholder-password"),null,"code");
		$form->addField("textarea","tns",api_text("cDatabasesDatasource-property-tns"),$this->tns,api_text("cDatabasesDatasource-placeholder-tns"),null,"code",null,"rows='2'");
		$form->addField("textarea","queries",api_text("cDatabasesDatasource-property-queries"),$this->queries,api_text("cDatabasesDatasource-placeholder-queries"),null,"code",null,"rows='2'");
		// controls
		$form->addControl("submit",api_text("form-fc-submit"));
		// return
		return $form;
	}

	// debug
	//protected function event_triggered($event){api_dump($event);}

}
