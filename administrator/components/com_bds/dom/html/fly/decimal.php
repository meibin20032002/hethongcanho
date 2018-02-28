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


class JDomHtmlFlyDecimal extends JDomHtmlFly
{
	protected $decimals;
	protected $decimalPoint;
	protected $thousandsSeparator;
	protected $roundingMethod;
	protected $emptyZero;

	/*
	 * Constuctor
	 *
	 *  @decimals			: Number of decimals
	 *  @decimalPoint		: Decimal point char
	 *  @thousandsSeparator	: Split string in thousands, millions,... specify the character to use
	 *  @roundingMethod		: In case of decimals superior to the limit, how to convert ? 'round', 'floor', 'ceil'
	 *  @emptyZero			: Hide the string if value equals zero
	 *
	 */
	function __construct($args)
	{
		parent::__construct($args);
		$this->arg('decimals' , null, $args, 0);
		$this->arg('decimalPoint' , null, $args);
		$this->arg('thousandsSeparator' , null, $args, null);
		$this->arg('roundingMethod' , null, $args, "round");
		$this->arg('emptyZero' , null, $args, false);

		$this->decimals = (int)$this->decimals;
	}

	protected function getThousandsSeparator()
	{
		$thousandsSeparator = null;

		if ($this->thousandsSeparator === null)
			$thousandsSeparator = '';
		else if ($this->thousandsSeparator === false)
			$thousandsSeparator = '';
		else if ($this->thousandsSeparator === true)
		{
			$locale_info = localeconv();

			if (!empty($locale_info['thousands_sep']))
				$thousandsSeparator = $locale_info['thousands_sep'];
			else
				$thousandsSeparator = " ";
		}
		else
		{
			$thousandsSeparator = substr($this->thousandsSeparator, 0, 1);
		}

		return $thousandsSeparator;
	}

	protected function getDecimalPoint()
	{
		$decimalPoint = $this->decimalPoint;

		if (empty($decimalPoint))
		{
			$locale_info = localeconv();

			if (defined('DECIMAL_POINT'))
				$decimalPoint = DECIMAL_POINT;

			else if (!empty($locale_info['decimal_point']))
				$decimalPoint = $locale_info['decimal_point'];
			else
				$decimalPoint = '.';
		}


		return $decimalPoint;
	}


	protected function roundDecimal($value, $nbDecimals = null, $roundingMethod = null)
	{
		if (!$nbDecimals)
			$nbDecimals = $this->decimals;

		if (!$roundingMethod)
			$roundingMethod = $this->roundingMethod;


		$multiple = pow(10, $nbDecimals);

		// round the value to the decimals
		switch($roundingMethod)
		{
			// Round decimals to the lower value
			case 'floor':
				$value = floor($value * $multiple) / $multiple;
				break;

			// Round decimals to the upper value
			case 'ceil':
				$value = ceil($value * $multiple) /  $multiple;
				break;

			// Round decimals to the closest value
			case 'round':
			default:
				$value = round($value, $nbDecimals);
				break;
		}

		return $value;
	}

	function checkEmpty()
	{
		if (($this->emptyZero) && (($this->dataValue == '0') || ($this->dataValue === 0)))
			return true;

		return false;
	}


	function build()
	{
		// Hide the value when equals to zero
		if ($this->checkEmpty())
			return '';

		$value = $this->dataValue;
		$value = $this->roundDecimal($value);

		$thousandsSeparator = $this->getThousandsSeparator();
		$decimalPoint = $this->getDecimalPoint();

		$html = number_format($value, $this->decimals, $decimalPoint, $thousandsSeparator);

		return $html;
	}

}