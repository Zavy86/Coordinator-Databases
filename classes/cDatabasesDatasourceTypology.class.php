<?php
/**
 * Subsidiaries Reports - Template Entry Typology
 *
 * @package Coordinator\Modules\SubsidiariesReports
 * @company Cogne Acciai Speciali s.p.a
 */

/**
 * Subsidiaries Reports, Template Entry Typology class
 */
class cSubsidiariesReportsTemplateEntryTypology extends cTranscoding{

	/** {@inheritdoc} */
	protected static function datas(){
		return array(
		 ["fillable",api_text("cSubsidiariesReportsTemplateEntryTypology-fillable"),"fa-edit"],
		 ["calculated",api_text("cSubsidiariesReportsTemplateEntryTypology-calculated"),"fa-cog"]
		);
	}

}
