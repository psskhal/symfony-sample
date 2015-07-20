<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfValidatorI18nChoiceLanguage validates than the value is a valid language.
 *
 * @package    symfony
 * @subpackage validator
 */
class sfValidatorI18nChoiceCulture extends sfValidatorChoice
{
  /**
   * Configures the current validator.
   *
   * @param array $options   An array of options
   * @param array $messages  An array of error messages
   *
   * @see sfValidatorChoice
   */
  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);

    // populate choices with all cultures
    $choices = array();
    $cultures = sfCultureInfo::getCultures(sfCultureInfo::SPECIFIC);
    foreach($cultures as $culture)
    {
    	// skip en_US_POSIX
    	if($culture == "en_US_POSIX") continue;
    	
    	try
    	{
    		$choices[] = sfCultureInfo::getInstance($culture)->getName();
    	}
    	catch(sfException $e) {}
    }
    sort($choices);

    $this->setOption('choices', $choices);
  }
}
