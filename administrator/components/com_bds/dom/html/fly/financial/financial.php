<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <     JDom Class - Cook Self Service library    |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		2.5
* @package		Cook Self Service
* @subpackage	JDom
* @license		GNU General Public License
* @author		Jocelyn HUARD
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class JDomHtmlFlyDecimalFinancial extends JDomHtmlFlyDecimal
{
	protected $format;

	/*
	 * Constuctor
	 *
	 *	@format				: Currency format  -   uses %s to place the value	 *
	 */
	function __construct($args)
	{
		parent::__construct($args);
		$this->arg('format' , null, $args, "%s" . (defined('CURRENCY_SYMBOL')?" " . CURRENCY_SYMBOL:''));
	}

	function build()
	{
		$html = parent::build();
		$html = sprintf($this->format, $html);

		return $html;
	}

}