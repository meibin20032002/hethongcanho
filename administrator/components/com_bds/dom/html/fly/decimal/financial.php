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
	protected $currencyFormat;
	protected $localTag;
	protected $format;



	/*
	 * Constuctor
	 *
	 *	@currencyFormat		: Currency format  - JDom formating uses %s to place the value: ie: '$ %s'
	 *
	 *  The following parameters are used when currencyFormat is not defined
	 * 	@localTag		    : local tag for the currency (ie : en_GB.UTF-8)
	 *  @format				: PHP money_format() format  - For advanced used.
	 */
	function __construct($args)
	{
		parent::__construct($args);


		// Run before the parent class
		$this->arg('currencyFormat' , null, $args);

		if ($this->currencyFormat && ($this->thousandsSeparator === null))
			$this->thousandsSeparator = true;


		if (empty($this->decimals))
			$this->decimals = 2;


		if ($this->currencyFormat)
		{
			// Format manually

		}
		else
		{
			// Format using PHP money_format() function
			$this->arg('localTag' , null, $args, str_replace('-', '_', JFactory::getLanguage()->getTag()) . '.UTF-8');
			$this->arg('format' , null, $args, "%.2n");
		}

	}


	function build()
	{
		// Hide the value when equals to zero
		if ($this->checkEmpty())
			return '';


		if ($this->currencyFormat)
		{
			$html = parent::build();
			$html = sprintf($this->currencyFormat, $html);
		}
		else
		{
			// Register the locale monetary symbol
			setlocale(LC_MONETARY, $this->localTag);

			// Format the financial string
			$html = money_format($this->format, $this->dataValue);
		}

		return $html;
	}


}