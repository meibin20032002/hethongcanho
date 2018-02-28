<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2015 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/fields/captcha.php';

class RSFormProFieldBootstrap2Captcha extends RSFormProFieldCaptcha
{
	protected function getRefreshAttributes() {
		$attr = array(
			'class="rsform-captcha-refresh-button btn"'
		);
		
		return implode(' ', $attr);
	}
}