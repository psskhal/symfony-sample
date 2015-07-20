<?php
/**
 * sfSimpleCaptcha class
 *
 * @package    sfSimpleCaptcha
 * @author     Carlos Eduardo O. A. Barros
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class sfSimpleCaptcha
{
   protected $font, $code, $width, $height;
   
   protected function generateCode($characters) {
      /* list all possible characters, similar looking characters and vowels have been removed */
      $possible = '23456789bcdfghjkmnpqrstvwxyz';
      $code = '';
      $i = 0;
      while ($i < $characters) { 
         $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
         $i++;
      }
      return $code;
   }
   
   public function getCode()
   {
   	return $this->code;
   }
   
   public function setCode($code)
   {
   	$this->code = $code;
   }
 
   public function __construct($width='120',$height='40',$characters='6') {
   	
   	  // font path
   	  $this->font = "../plugins/sfSimpleCaptchaPlugin/data/".sfConfig::get('app_simple_captcha_font');
   	  
   	  // code
      $this->code = $this->generateCode($characters);
      
      // width
      $this->width = $width;
      
      // height
      $this->height = $height;
   }
   
   public function dump($save=true)
   {
      /* font size will be 75% of the image height */
      $font_size = $this->height * 0.75;
      if(!($image = imagecreate($this->width, $this->height))) throw new sfException('Cannot initialize new GD image stream');
      /* set the colours */
      $background_color = imagecolorallocate($image, 255, 255, 255);
      $text_color = imagecolorallocate($image, 20, 40, 100);
      $noise_color = imagecolorallocate($image, 100, 120, 180);
      /* generate random dots in background */
      for( $i=0; $i<($this->width*$this->height)/3; $i++ ) {
         imagefilledellipse($image, mt_rand(0,$this->width), mt_rand(0,$this->height), 1, 1, $noise_color);
      }
      /* generate random lines in background */
      for( $i=0; $i<($this->width*$this->height)/150; $i++ ) {
         imageline($image, mt_rand(0,$this->width), mt_rand(0,$this->height), mt_rand(0,$this->width), mt_rand(0,$this->height), $noise_color);
      }
      /* create textbox and add text */
      if(!($textbox = imagettfbbox($font_size, 0, $this->font, $this->code))) throw new sfException('Error in imagettfbbox function');
      $x = ($this->width - $textbox[4])/2;
      $y = ($this->height - $textbox[5])/2;
      if(!imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $this->code)) throw new sfException('Error in imagettftext function');
      /* output captcha image to browser */
      imagejpeg($image);
      imagedestroy($image);
      
      // save code
      if($save) self::setSecurityCode($this->code);
   }
   
	public static function setSecurityCode($code)
	{
		// we save current code in sfUser attribute holder, and then we cleanup once validator takes place.
		sfContext::getInstance()->getUser()->setAttribute('sfSimpleCaptchaCode',$code,'sfSimpleCaptchaCode'); 
	}
	
	public static function getSecurityCode($clear=false)
	{
		$code = sfContext::getInstance()->getUser()->getAttribute('sfSimpleCaptchaCode',null,'sfSimpleCaptchaCode');
		if($clear) self::clearSecurityCode();
		
		return $code;
	}
	
	public static function clearSecurityCode()
	{
		return sfContext::getInstance()->getUser()->getAttributeHolder()->remove('sfSimpleCaptchaCode',null,'sfSimpleCaptchaCode');
	}
}