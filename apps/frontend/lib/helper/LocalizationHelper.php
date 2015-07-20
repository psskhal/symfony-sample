<?php

/**
 * Format a number
 *
 * @param float $number
 * @param string $culture
 * 
 * @return string
 */
function format_number($number, $culture = null)
{
  if (is_null($number))
  {
    return null;
  }

  $numberFormat = new sfNumberFormat(_current_language($culture));

  return $numberFormat->format($number);
}

/**
 * Get current language
 *
 * @param string $culture
 * 
 * @return string
 */
function _current_language($culture = null)
{
  return $culture ? $culture : sfContext::getInstance()->getUser()->getCulture();
}