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

class JDomHtmlFormInputCalendar extends JDomHtmlFormInput
{
	protected $dateFormat;
	protected $filter;
	protected $timezone;

	/*
	 * Constuctor
	 * 	@namespace 	: requested class
	 *  @options	: Configuration
	 * 	@dataKey	: database field name
	 * 	@dataObject	: complete object row (stdClass or Array)
	 * 	@dataValue	: value  default = dataObject->dataKey
	 * 	@domID		: HTML id (DOM)  default=dataKey
	 *
	 *
	 *	@dateFormat	: Date Format
	 *  @timezone	: Convert to the specified timezone. Can be : SERVER_UTC, USER_UTC
	 */
	function __construct($args)
	{

		parent::__construct($args);

		$this->arg('dateFormat'	, null, $args, "Y-m-d");
		$this->arg('filter'		, null, $args);  // Deprecated : use timezone
		$this->arg('timezone' , null, $args, 'USER_UTC');

		if (!empty($this->filter) && empty($this->timezone))
			$this->timezone = $this->filter;

	//JDate::toFormat() is deprecated. CONVERT Legacy Joomla Format
		//Minutes : ‰M > i
		$this->dateFormat = str_replace("%M", "i", $this->dateFormat);
		//remove the %
		$this->dateFormat = str_replace("%", "", $this->dateFormat);

	}

	function build()
	{
		$formatedDate = $this->dataValue;

		if ($this->dataValue
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
		else
			$formatedDate = "";

		//Create the input
		$dom = JDom::getInstance('html.form.input.text', array_merge($this->options, array(
			'dataValue' => $formatedDate,

			// Does not herit the event
			'submitEventName' => null
		)));
		$dom->addClass('input-small');
		$htmlInput = $dom->output();

		//Create the icon
		$htmlIcon = JDom::_('html.icon', array('icon' => 'calendar'));

		//Create the button (suffix -btn is to trigger the calendar)
		$htmlButton = JDom::_('html.link.button', array(
			'content' => $htmlIcon,
			'domClass' => 'btn',
			'domId' => $this->getInputId() . '-btn',
		));


		$html = '<%PREFIX%>';
		$html .= '<div class="btn-group">';

		$html .= '<div class="input-append">' .LN;
		$html .= $htmlInput .LN;
		$html .= $htmlButton .LN;
		$html .= '</div>' .LN;

		$html .= '</div><%SUFFIX%>';

		return $html;
	}

	function buildJs()
	{
		$config = array();
		if ($this->submitEventName == 'onchange')
		{
			$jsEvent = $this->getSubmitAction();

			$config['onClose'] = "function(cal){if(cal.dateClicked){"
			. $jsEvent
			. "}cal.hide();}";
		}

		$jsonConfig = "";
		foreach($config as $key => $quotedValue)
			$jsonConfig .= "," . $key . ":" . $quotedValue;

		// Load the calendar behavior
		JHtml::_('behavior.calendar');
		JHtml::_('behavior.tooltip');

		$jsonConfig .= ",firstDay: " . JFactory::getLanguage()->getFirstDay();

		$id = $this->getInputId();
		$format = $this->legacyDateFormat($this->dateFormat);

		$js = 'window.addEvent(\'domready\', function() {if($("' . $id . '")) Calendar.setup({
					// Id of the input field
					inputField: "' . $id . '",
					// Format of the input field
					ifFormat: "' . $format . '",
					// Trigger for the calendar (button ID)
					button: "' . $id . '-btn",
					// Alignment (defaults to "Bl")
					align: "Tl",
					singleClick: true' . $jsonConfig . '
					});});';

		$this->addScriptInline($js, true);
	}
}