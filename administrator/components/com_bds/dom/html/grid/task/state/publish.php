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


class JDomHtmlGridTaskStatePublish extends JDomHtmlGridTaskState
{
	protected $publishUp;
	protected $publishDown;

	// Customize the icons here
	protected $icons = array(
		'' => 'warning',	// question-sign | warning
		0 => 'unpublish',	// unpublish | cancel
		1 => 'publish',		// publish | ok
		2 => 'archive',		// archive
		-2 => 'trash'		// trash

	);

	/*
	 * Constuctor
	 * 	@namespace 	: requested class
	 *  @options	: Configuration
	 * 	@dataKey	: database field name
	 * 	@dataObject	: complete object row (stdClass or Array)
	 * 	@dataValue	: value  default = dataObject->dataKey
	 * 	@num		: Num position in list
	 *  @ctrl		: Prefix for tasks
	 *	@commandAcl		: ACL rights to toggle
	 *  @enabled		: Define if the control is togglable (default : true)
	 *  @tooltip		: Show the tooltip (default : true)
	 *	@taskYes		: task to execute when value is true
	 *	@taskNo			: task to execute when value is no
	 *	@strYES			: text to show when value is true
	 *	@strNO			: text to show when value is no
	 *	@strUndefined	: text to show when value is undefined
	 *
	 *  @publishUp	: Time to start publish
	 *  @publishDown : Time to unpublish
	 *
	 */
	function __construct($args)
	{
		parent::__construct($args);

		$this->arg('publishUp'		, null, $args);
		$this->arg('publishDown'	, null, $args);


		// You can customize the behaviors icons and strings here, or in the caller
		if (empty($this->states))
		{
			$icons = $this->icons;
			$this->states = array(
				'' => array('publish', 'JUNPUBLISHED', 'JLIB_HTML_PUBLISH_ITEM', 'JUNPUBLISHED', true, $icons[''], $icons['']),
				0 => array('publish', 'JUNPUBLISHED', 'JLIB_HTML_PUBLISH_ITEM', 'JUNPUBLISHED', true, $icons[0], $icons[0]),
				1 => array('unpublish', 'JPUBLISHED', 'JLIB_HTML_UNPUBLISH_ITEM', 'JPUBLISHED', true, $icons[1], $icons[1]),
				2 => array('unpublish', 'JARCHIVED', 'JLIB_HTML_UNPUBLISH_ITEM', 'JARCHIVED', true, $icons[2], $icons[2]),
				-2 => array(
					'publish', 					// Task to execute
					'JTRASHED', 				// Text
					'JLIB_HTML_PUBLISH_ITEM',   // Tooltip description when button is enabled
					'JTRASHED', 				// Tooltip description when button is disabled
					true, 						// Show tooltip ?
					$icons[-2], 				// Css class when active (enabled)
					$icons[-2])					// Css class when inactive (disabled)
				);
		}

	}

	function build()
	{
		// Adjust the states depending of the current time
		if ($this->publishUp || $this->publishDown)
			$this->populateStatesPublishTime($this->states, $this->publishUp, $this->publishDown);

		$html = $this->state();
		return $html;
	}


	protected function populateStatesPublishTime(&$states, $publish_up, $publish_down)
	{
		// Special states for dates
		if ($publish_up || $publish_down)
		{
			$nullDate = JFactory::getDbo()->getNullDate();
			$nowDate = JFactory::getDate()->toUnix();

			$tz = new DateTimeZone(JFactory::getUser()->getParam('timezone', JFactory::getConfig()->get('offset')));

			$publish_up = ($publish_up != $nullDate) ? JFactory::getDate($publish_up, 'UTC')->setTimeZone($tz) : false;
			$publish_down = ($publish_down != $nullDate) ? JFactory::getDate($publish_down, 'UTC')->setTimeZone($tz) : false;

			// Create tip text, only we have publish up or down settings
			$tips = array();

			if ($publish_up)
			{
				$tips[] = JText::sprintf('JLIB_HTML_PUBLISHED_START', $publish_up->format(JDate::$format, true));
			}

			if ($publish_down)
			{
				$tips[] = JText::sprintf('JLIB_HTML_PUBLISHED_FINISHED', $publish_down->format(JDate::$format, true));
			}

			$tip = empty($tips) ? false : implode('<br />', $tips);

			// Add tips and special titles
			foreach ($states as $key => $state)
			{
				// Create special titles for published items
				if (($key == 1))
				{
					$states[$key][2] = $states[$key][3] = 'JLIB_HTML_PUBLISHED_ITEM';

					if ($publish_up > $nullDate && $nowDate < $publish_up->toUnix())
					{
						$states[$key][2] = $states[$key][3] = 'JLIB_HTML_PUBLISHED_PENDING_ITEM';
						$states[$key][5] = $states[$key][6] = 'pending';
					}

					if ($publish_down > $nullDate && $nowDate > $publish_down->toUnix())
					{
						$states[$key][2] = $states[$key][3] = 'JLIB_HTML_PUBLISHED_EXPIRED_ITEM';
						$states[$key][5] = $states[$key][6] = 'expired';
					}
				}

				// Add tips to titles
				if ($tip)
				{
					$states[$key][1] = JText::_($states[$key][1]);
					$states[$key][2] = JText::_($states[$key][2]) . '<br />' . $tip;
					$states[$key][3] = JText::_($states[$key][3]) . '<br />' . $tip;
					$states[$key][4] = true;

					// Already translated before
					$this->translate = false;
				}
			}
		}

	}
}
