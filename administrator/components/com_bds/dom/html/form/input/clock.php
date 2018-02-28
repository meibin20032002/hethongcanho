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


class JDomHtmlFormInputClock extends JDomHtmlFormInput
{
	protected $timeFormat;
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
	 *	@timeFormat	: Time Format
	 *  @timezone	: Convert to the specified timezone. Can be : SERVER_UTC, USER_UTC
	 */
	function __construct($args)
	{
		parent::__construct($args);

		$this->arg('timeFormat'		, null, $args, "H:i");
		$this->arg('timezone' , null, $args);


		if ($this->timeFormat)
		{
			//Instance the validator
			$this->validatorRegex = $this->regexFromTimeFormat();
		}

		$this->addValidatorHandler();


	}

	function regexFromTimeFormat()
	{
		$d2 = '[0-9]{2}';
		$d4 = '[1-9][0-9]{3}';

		$patterns =
array(	'\\','/','#','!','^','$','(',')','[',']','{','}','|','?','+','*','.',
		'%Y','%y','%m','%d', '%H', '%I', '%l', '%M', '%S', ' ');
		$replacements =
array(	'\\\\', '\\/','\\#','\\!','\\^','\\$','\\(','\\)','\\[','\\]','\\{','\\}','\\|','\\?','\\+','\\*','\\.',
		$d4,$d2,$d2,$d2,$d2,$d2,$d2,$d2,$d2,'\s');

		return "^" . str_replace($patterns, $replacements, $this->timeFormat) . "$";
	}

	function build()
	{

		if ($this->dataValue
			&& ($this->dataValue != "0000-00-00")
			&& ($this->dataValue != "0000-00-00 00:00:00"))
		{
			jimport("joomla.utilities.date");

			// Convert to the correct expected timezone (SERVER_UTC, USER_UTC)
			if (isset($this->timezone))
				$date = self::getDateUtc($this->dataValue, $this->timezone);
			else
				$date = JFactory::getDate($this->dataValue);

			$formatedTime = $date->format($this->timeFormat, !empty($this->timezone));

		}
		else
			$formatedTime = "";


		$html =	'<%PREFIX%><input type="time" id="<%DOM_ID%>" name="<%INPUT_NAME%>"<%STYLE%><%CLASS%><%SELECTORS%>'
			.	' value="' . $formatedTime . '"'
			.	' size="6"'
			.	'/><%SUFFIX%>' .LN
			.	'<%VALIDOR_ICON%>'.LN
			.	'<%MESSAGE%>';

		return $html;


		return $html;
	}
}