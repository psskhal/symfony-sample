<?php

/**
 * Article form.
 *
 * @package    form
 * @subpackage jotag_articles
 * @version    SVN: $Id: sfPropelFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ArticleForm extends BaseArticleForm
{
  public function configure()
  {
  	// remove undesired fields
  	unset($this["created_at"],$this["updated_at"]);
  	
	// configure is_active
	$this->widgetSchema->setLabel("is_active","Published");
	
	// configure language_id
	//$this->widgetSchema["language_id"]->setOption("criteria",LanguagePeer::buildLanguageCriteria());
	
	// configure published_at
	$this->widgetSchema["published_at"]->setOption("date",array("format"=>"%month%<span>/</span>%day%<span>/</span>%year%"));
	$this->widgetSchema["published_at"]->setOption("time",array("format_without_seconds"=>"%hour%<span>:</span>%minute%"));
	if($this->getObject()->isNew())
		$this->getObject()->setPublishedAt(time());
		
  	// configure title
  	$this->validatorSchema["title"]->setOption("trim",true);
  	$this->validatorSchema["title"]->setMessage("required","Please enter the title");

  	// configure Summary
  	$this->validatorSchema["summary"]->setOption("trim",true);
  	$this->validatorSchema["summary"]->setMessage("required","Please enter the summary");
  	
  	// configure body
	$this->widgetSchema["body"] = new sfWidgetFormTextareaTinyMCE();
  }
}
