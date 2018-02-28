<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Filter
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted Access' );
/**
 * Joomla! Content Management System
 *
 * @copyright  Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('JPATH_PLATFORM') or die;

use Joomla\Filter\OutputFilter as BaseOutputFilter;
use Joomla\String\StringHelper;
use Joomla\CMS\Language\Language;

/**
 * OutputFilter
 *
 * @since  11.1
 */
 
class JFilterOutput
{
	/**
	 * Makes an object safe to display in forms
	 *
	 * Object parameters that are non-string, array, object or start with underscore
	 * will be converted
	 *
	 * @param   object   &$mixed        An object to be parsed
	 * @param   integer  $quote_style   The optional quote style for the htmlspecialchars function
	 * @param   mixed    $exclude_keys  An optional string single field name or array of field names not
	 *                                  to be parsed (eg, for a textarea)
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
	public static function objectHTMLSafe(&$mixed, $quote_style = ENT_QUOTES, $exclude_keys = '')
	{
		if (is_object($mixed))
		{
			foreach (get_object_vars($mixed) as $k => $v)
			{
				if (is_array($v) || is_object($v) || $v == null || substr($k, 1, 1) == '_')
				{
					continue;
				}

				if (is_string($exclude_keys) && $k == $exclude_keys)
				{
					continue;
				}
				elseif (is_array($exclude_keys) && in_array($k, $exclude_keys))
				{
					continue;
				}

				$mixed->$k = htmlspecialchars($v, $quote_style, 'UTF-8');
			}
		}
	}

	/**
	 * This method processes a string and replaces all instances of & with &amp; in links only.
	 *
	 * @param   string  $input  String to process
	 *
	 * @return  string  Processed string
	 *
	 * @since   11.1
	 */
	public static function linkXHTMLSafe($input)
	{
		$regex = 'href="([^"]*(&(amp;){0})[^"]*)*?"';
		return preg_replace_callback("#$regex#i", array('JFilterOutput', '_ampReplaceCallback'), $input);
	}

	/**
	 * This method processes a string and replaces all accented UTF-8 characters by unaccented
	 * ASCII-7 "equivalents", whitespaces are replaced by hyphens and the string is lowercase.
	 *
	 * @param   string  $string  String to process
	 *
	 * @return  string  Processed string
	 *
	 * @since   11.1
	 */
	public static function stringURLSafe($string)
	{
    	/** viet4777: overwriting the text function for alias replacing
    	* Joomla! 1.7 checks if a class is already loaded so we can load the whole class and overwrite it :)
    	*/
    	$plugin =  JPluginHelper::getPlugin('system', 'vietalias');
    	$params = new JRegistry( $plugin->params );
    	$transformtext = $params->get('transformtext','');
    	$vi_trans = $params->get('vi_trans',1);	
    
    	if($vi_trans >0 ) {
    		$trans = array(
            "đ"=>"d","ă"=>"a","â"=>"a","á"=>"a","à"=>"a",        
            "ả"=>"a","ã"=>"a","ạ"=>"a",        
            "ấ"=>"a","ầ"=>"a","ẩ"=>"a","ẫ"=>"a","ậ"=>"a",        
            "ắ"=>"a","ằ"=>"a","ẳ"=>"a","ẵ"=>"a","ặ"=>"a",        
            "é"=>"e","è"=>"e","ẻ"=>"e","ẽ"=>"e","ẹ"=>"e",        
            "ế"=>"e","ề"=>"e","ể"=>"e","ễ"=>"e","ệ"=>"e",        
            "í"=>"i","ì"=>"i","ỉ"=>"i","ĩ"=>"i","ị"=>"i",        
            "ư"=>"u","ô"=>"o","ơ"=>"o","ê"=>"e",        
            "Ư"=>"u","Ô"=>"o","Ơ"=>"o","Ê"=>"e",        
            "ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",        
            "ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",        
            "ó"=>"o","ò"=>"o","ỏ"=>"o","õ"=>"o","ọ"=>"o",        
            "ớ"=>"o","ờ"=>"o","ở"=>"o","ỡ"=>"o","ợ"=>"o",        
            "ố"=>"o","ồ"=>"o","ổ"=>"o","ỗ"=>"o","ộ"=>"o",        
            "ú"=>"u","ù"=>"u","ủ"=>"u","ũ"=>"u","ụ"=>"u",        
            "ứ"=>"u","ừ"=>"u","ử"=>"u","ữ"=>"u","ự"=>"u",        
            "ý"=>"y","ỳ"=>"y","ỷ"=>"y","ỹ"=>"y","ỵ"=>"y",        
            "Ý"=>"y","Ỳ"=>"y","Ỷ"=>"y","Ỹ"=>"y","Ỵ"=>"y",        
            "Đ"=>"D","Ă"=>"a","Â"=>"a","Á"=>"a","À"=>"a",        
            "Ả"=>"a","Ã"=>"a","Ạ"=>"a",        
            "Ấ"=>"a","Ầ"=>"a","Ẩ"=>"a","Ẫ"=>"a","Ậ"=>"a",        
            "Ắ"=>"a","Ằ"=>"a","Ẳ"=>"a","Ẵ"=>"a","Ặ"=>"a",        
            "É"=>"e","È"=>"e","Ẻ"=>"e","Ẽ"=>"e","Ẹ"=>"e",        
            "Ế"=>"e","Ề"=>"e","Ể"=>"e","Ễ"=>"e","Ệ"=>"e",        
            "Í"=>"i","Ì"=>"i","Ỉ"=>"i","Ĩ"=>"i","Ị"=>"i",        
            "Ư"=>"u","Ô"=>"o","Ơ"=>"o","Ê"=>"e",        
            "Ư"=>"u","Ô"=>"o","Ơ"=>"o","Ê"=>"e",        
            "Ú"=>"u","Ù"=>"u","Ủ"=>"u","Ũ"=>"u","Ụ"=>"u",        
            "Ứ"=>"u","Ừ"=>"u","Ử"=>"u","Ữ"=>"u","Ự"=>"u",        
            "Ó"=>"o","Ò"=>"o","Ỏ"=>"o","Õ"=>"o","Ọ"=>"o",        
            "Ớ"=>"o","Ờ"=>"o","Ở"=>"o","Ỡ"=>"o","Ợ"=>"o",        
            "Ố"=>"o","Ồ"=>"o","Ổ"=>"o","Ỗ"=>"o","Ộ"=>"o",        
            "Ú"=>"u","Ù"=>"u","Ủ"=>"u","Ũ"=>"u","Ụ"=>"u",        
            "Ứ"=>"u","Ừ"=>"u","Ử"=>"u","Ữ"=>"u","Ự"=>"u");
    	}
        
    	if($transformtext !='') {
    		eval("\$trans = array(".$transformtext.");");
    	}

		// Remove any '-' from the string since they will be used as concatenaters
		$str = str_replace('-', ' ', $string);
        
        //Add New
        $str = strtr($str, $trans);

		// Transliterate on the language requested (fallback to current language if not specified)
		$lang = JFactory::getLanguage();
		$str = $lang->transliterate($str);

		// Trim white spaces at beginning and end of alias and make lowercase
		$str = trim(StringHelper::strtolower($str));

		// Remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);

		// Trim dashes at beginning and end of alias
		$str = trim($str, '-');

		return $str;
	}

	/**
	 * This method implements unicode slugs instead of transliteration.
	 *
	 * @param   string  $string  String to process
	 *
	 * @return  string  Processed string
	 *
	 * @since   11.1
	 */
	public static function stringURLUnicodeSlug($string)
	{
		// Replace double byte whitespaces by single byte (East Asian languages)
		$str = preg_replace('/\xE3\x80\x80/', ' ', $string);

		// Remove any '-' from the string as they will be used as concatenator.
		// Would be great to let the spaces in but only Firefox is friendly with this

		$str = str_replace('-', ' ', $str);

		// Replace forbidden characters by whitespaces
		$str = preg_replace('#[:\#\*"@+=;!><&\.%()\]\/\'\\\\|\[]#', "\x20", $str);

		// Delete all '?'
		$str = str_replace('?', '', $str);

		// Trim white spaces at beginning and end of alias and make lowercase
		$str = trim(JString::strtolower($str));

		// Remove any duplicate whitespace and replace whitespaces by hyphens
		$str = preg_replace('#\x20+#', '-', $str);

		return $str;
	}

	/**
	 * Replaces &amp; with & for XHTML compliance
	 *
	 * @param   string  $text  Text to process
	 *
	 * @return  string  Processed string.
	 *
	 * @since   11.1
	 *
	 * @todo There must be a better way???
	 */
	public static function ampReplace($text)
	{
		$text = str_replace('&&', '*--*', $text);
		$text = str_replace('&#', '*-*', $text);
		$text = str_replace('&amp;', '&', $text);
		$text = preg_replace('|&(?![\w]+;)|', '&amp;', $text);
		$text = str_replace('*-*', '&#', $text);
		$text = str_replace('*--*', '&&', $text);

		return $text;
	}

	/**
	 * Callback method for replacing & with &amp; in a string
	 *
	 * @param   string  $m  String to process
	 *
	 * @return  string  Replaced string
	 *
	 * @since   11.1
	 */
	public static function _ampReplaceCallback($m)
	{
		$rx = '&(?!amp;)';

		return preg_replace('#' . $rx . '#', '&amp;', $m[0]);
	}

	/**
	 * Cleans text of all formatting and scripting code
	 *
	 * @param   string  &$text  Text to clean
	 *
	 * @return  string  Cleaned text.
	 *
	 * @since   11.1
	 */
	public static function cleanText(&$text)
	{
		$text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text);
		$text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
		$text = preg_replace('/<!--.+?-->/', '', $text);
		$text = preg_replace('/{.+?}/', '', $text);
		$text = preg_replace('/&nbsp;/', ' ', $text);
		$text = preg_replace('/&amp;/', ' ', $text);
		$text = preg_replace('/&quot;/', ' ', $text);
		$text = strip_tags($text);
		$text = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');

		return $text;
	}

	/**
	 * Strip img-tags from string
	 *
	 * @param   string  $string  Sting to be cleaned.
	 *
	 * @return  string  Cleaned string
	 *
	 * @since   11.1
	 */
	public static function stripImages($string)
	{
		return preg_replace('#(<[/]?img.*>)#U', '', $string);
	}

	/**
	 * Strip iframe-tags from string
	 *
	 * @param   string  $string  Sting to be cleaned.
	 *
	 * @return  string  Cleaned string
	 *
	 * @since   12.2
	 */
	public static function stripIframes($string)
	{
		return preg_replace('#(<[/]?iframe.*>)#U', '', $string);
	}
}
