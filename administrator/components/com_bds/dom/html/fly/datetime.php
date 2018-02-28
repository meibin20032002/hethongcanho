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


class JDomHtmlFlyDatetime extends JDomHtmlFly
{
	protected $format;
	protected $timezone;


	/*
	 * Constuctor
	 * 	@namespace 	: requested class
	 *  @options	: Configuration
	 * 	@dataKey	: database field name
	 * 	@dataObject	: complete object row (stdClass or Array)
	 * 	@dataValue	: value  default = dataObject->dataKey
	 *
	 *	@format		: Date format  -   default='Y-m-d'
	 *  @timezone	: Convert to the specified timezone. Can be : SERVER_UTC, USER_UTC
	 *
	 */
	function __construct($args)
	{

		parent::__construct($args);
		$this->arg('dateFormat' , null, $args, "Y-m-d");
		$this->arg('timezone' , null, $args, 'USER_UTC');

	//JDate::toFormat() is deprecated. CONVERT Legacy Joomla Format
		//Minutes : ‰M > i
		$this->dateFormat = str_replace("%M", "i", $this->dateFormat);
		//remove the %
		$this->dateFormat = str_replace("%", "", $this->dateFormat);
	}

	function build()
	{
		$formatedDate = "";

		if (!empty($this->dataValue)
			&& ($this->dataValue != "0000-00-00")
			&& ($this->dataValue != "0000-00-00 00:00:00"))
		{
			jimport("joomla.utilities.date");

			// Convert to the correct expected timezone (SERVER_UTC, USER_UTC)
			if ($this->timezone)
				$date = self::getDateUtc($this->dataValue, $this->timezone);
			else
				$date = JFactory::getDate($this->dataValue);

			$formatedDate = $date->format($this->dateFormat, !empty($this->timezone));
		}

		$this->addClass('fly-date');

		$html = '<span <%STYLE%><%CLASS%><%SELECTORS%>>'
			.	$formatedDate
			.	'</span>';

		return $html;
	}

}