<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormI18nSelectCulture represents a language HTML select tag.
 *
 * @package    symfony
 * @subpackage widget
 */
class sfWidgetFormI18nSelectCulture extends sfWidgetFormSelect
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * culture:   The culture to use for internationalized strings (required)
   *  * languages: An array of language codes to use (ISO 639-1)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormSelect
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    // populate choices with all cultures
    $choices = array();
    $cultures = sfCultureInfo::getCultures(sfCultureInfo::SPECIFIC);
    foreach($cultures as $culture)
    {
    	// skip en_US_POSIX
    	if($culture == "en_US_POSIX") continue;
    	
    	try
    	{
    		$choices[$culture] = sfCultureInfo::getInstance($culture)->getEnglishName();
    	}
    	catch(sfException $e) {}
    }
    asort($choices);

    $this->setOption('choices', $choices);
  }
}
