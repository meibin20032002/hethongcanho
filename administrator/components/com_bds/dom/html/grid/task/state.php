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


class JDomHtmlGridTaskState extends JDomHtmlGridTask
{
	var $fallback = 'bool';	//Used for default

	protected $states = array();
	protected $togglable;
	protected $translate;
	protected $checkbox;
	protected $prefix;


	/*
	 * Constuctor
	 * 	@namespace 	: requested class
	 *  @options	: Configuration
	 * 	@dataKey	: database field name
	 * 	@dataObject	: complete object row (stdClass or Array)
	 * 	@dataValue	: value  default = dataObject->dataKey
	 * 	@num		: Num position in list
	 *  @commandAcl : ACL Command to see or not this
	 *  @enabled	: Determines if enabled
	 *  @tooltip	: Show the description in tooltip
	 *  @ctrl		: controller to call (prefix)
	 *	@task		: Task name (used also for the icon class if taskIcon is empty)
	 *	@taskIcon	: Task icon
	 *	@label		: Button title, Label text description
	 *  @description : Description of the task. (in tooltip)
	 *	@viewType	: View mode (icon/text/both) default: icon
	 *
	 *  @states		: States to config the JHtml states buttons
	 *	@togglable	: When not togglable, output a fly (no action)
	 */
	function __construct($args)
	{
		parent::__construct($args);
		$this->arg('states'		, null, $args, array());
		$this->arg('togglable'		, null, $args, true);

		$this->arg('translate'		, null, $args, true);
		$this->arg('checkbox'		, null, $args, 'cb');
		$this->arg('prefix'		, null, $args, ($this->ctrl?$this->ctrl . '.':''));

		if (!$this->togglable)
			$this->enabled = false;
	}


	function buildHtml()
	{
		$html = $this->state(
			$this->states,
			$this->dataValue,
			$this->num
		);

		return $html;
	}

	// Convert an indexed array to an associative array
	protected static function formatStateObject(&$state)
	{
		if (!$state)
			return;

		// Array map form legacy Joomla
		$map = array(
			0 => 'task',
			1 => 'text', // Deprecated
			2 => 'active_title',
			3 => 'inactive_title',
			4 => 'tip',	// Deprecated
			5 => 'active_class',
			6 => 'inactive_class',

		);

		foreach($map as $index => $key)
		{
			if (array_key_exists($index, $state))
			{
				$state[$key] = $state[$index];
				unset($state[$index]);
			}
		}
	}

	public function state($states = array(), $value = null, $i = null)
	{
		if (empty($states))
			$states = $this->states;

		if ($value === null)
			$value = $this->dataValue;

		if ($i === null)
			$i = $this->num;

		$state = JArrayHelper::getValue($states, $value, $states[0]);

		if (!$state)
			return 'State not found';

		// Convert states to an associative array
		self::formatStateObject($state);

		// Task to perform
		$task = $this->task;
		if (array_key_exists('task', $state))
			$task = $state['task'];

		// Active Title
		$active_title = JText::_($this->label) . '::' . JText::_($this->description);
		if (array_key_exists('active_title', $state))
			$active_title = $state['active_title'];

		// Inactive Title
		$inactive_title = JText::_($this->label) . '::' . JText::_($this->description);
		if (array_key_exists('inactive_title', $state))
			$inactive_title = $state['inactive_title'];

		// Tooltip
		$tip = $this->tooltip;
		if (array_key_exists('tip', $state))
			$tip = $state['tip'];

		// Active Class
		$active_class = $this->taskIcon;
		if (array_key_exists('active_class', $state))
			$active_class = $state['active_class'];

		// Inactive Class
		$inactive_class = $this->taskIcon;
		if (array_key_exists('inactive_class', $state))
			$inactive_class = $state['inactive_class'];

		// Enabled
		$enabled = $this->enabled;
		if (array_key_exists('enabled', $state))
			$enabled = $state['enabled'];

		// Prefix
		$prefix = ($this->ctrl?$this->ctrl.'.':'');
		if (array_key_exists('prefix', $state))
			$prefix = $state['prefix'];

		// Translate
		$translate = $this->translate;
		if (array_key_exists('translate', $state))
			$translate = $state['translate'];



		return JHTML::_('jgrid.action',
			$this->num,
			$task,
			array(
				'active_title' => $active_title,
				'inactive_title' => $inactive_title,
				'tip' => $tip,
				'active_class' => $active_class,
				'inactive_class' => $inactive_class,
				'enabled' => $enabled,
				'translate' => $this->translate,
				'checkbox' => $this->checkbox,
				'prefix' => $this->prefix,
			));

	}
}