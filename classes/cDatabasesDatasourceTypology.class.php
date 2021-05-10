<?php
/**
 * Databases - Datasource Typology
 *
 * @package Coordinator\Modules\Databases
 * @company Cogne Acciai Speciali s.p.a
 */

/**
 * Databases, Template Entry Typology class
 */
class cDatabasesDatasourceTypology extends cTranscoding{

	/** {@inheritdoc} */
	protected static function datas(){
		return array(
		 ["coordinator",api_text("cDatabasesDatasourceTypology-coordinator"),"fa-database"],
		 ["reporting",api_text("cDatabasesDatasourceTypology-reporting"),"fa-chart"]
		);
	}

}
