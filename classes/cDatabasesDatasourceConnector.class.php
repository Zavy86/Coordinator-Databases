<?php
/**
 * Databases - Datasource Connector
 *
 * @package Coordinator\Modules\Databases
 * @company Cogne Acciai Speciali s.p.a
 */

/**
 * Databases, Template Entry Connector class
 */
class cDatabasesDatasourceConnector extends cTranscoding{

	/** {@inheritdoc} */
	protected static function datas(){
		return array(
		 ["mysql",api_text("cDatabasesDatasourceConnector-mysql"),"fa-maxcdn"],
		 ["oci",api_text("cDatabasesDatasourceConnector-oci"),"fa-opera"]
		);
	}

}
