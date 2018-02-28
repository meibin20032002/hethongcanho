<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	BDS
* @copyright	
* @author		 -  - 
* @license		
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if (!class_exists('BdsHelper'))
	require_once(JPATH_ADMINISTRATOR . '/components/com_bds/helpers/loader.php');


/**
* Form field for Bds.
*
* @package	Bds
* @subpackage	Form
*/
class JFormFieldModalpicker extends JFormField
{
	/**
	* Extension name.
	*
	* @var string
	*/
	protected static $extension = 'bds';

	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'modalpicker';

	/**
	* Method to get the field input markup.
	*
	* @access	protected
	*
	* @return	string	The field input markup.
	*/
	protected function getInput()
	{
		// Get the input settings

		$label = JText::_($this->getAttribute('label', 'JSELECT'));
		$nullLabel = JText::_($this->getAttribute('nullLabel', $label));

		$modalWidth = JText::_($this->getAttribute('modalWidth', 500));
		$modalHeight = JText::_($this->getAttribute('modalHeight', 500));
		$id = $this->id;


		// Get the selected item label string
		$selectedLabel = $this->getSelectedLabel();


		// Get the preset buttons
		$presets = $this->getPresets();

		$htmlPresets = '';
		if (count($presets))
		foreach($presets as $preset)
		{

			// Override the current select value when present in presets
			if ($this->value == $preset->value)
				$selectedLabel = $preset->label;

			$scriptPreset = "document.id('" . $this->id . "_id').value = '" . $preset->value . "';"
				. "document.id('" . $this->id . "_name').value = '" . htmlspecialchars($preset->label, ENT_QUOTES, 'UTF-8') . "';";



			$caption = '';
			if (in_array($preset->display, array('icon', 'both')))
				$caption .= ' <i class="icon-' . $preset->icon . '"></i> ';

			if (in_array($preset->display, array('text', 'both')))
				$caption .= $preset->label;


			$desc = (!empty($preset->desc)?$preset->desc:$preset->label);

			$htmlPresets .= '	<a class="btn hasTooltip" title="'.htmlspecialchars($desc, ENT_QUOTES, 'UTF-8').'"'
					.	($scriptPreset?' onclick="'.htmlspecialchars($scriptPreset, ENT_QUOTES, 'UTF-8').'"':'')
					.	'>' .LN;
			$htmlPresets .= $caption;
			$htmlPresets .= ' </a>' .LN;
		}



		// Get the title to display
		$title = $selectedLabel;
		if (empty($title)) {
			$title = $nullLabel;
		}



		// Reset button
		$scriptReset = "document.id('" . $id . "_id').value = '';";
		$scriptReset .= "document.id('" . $id . "_name').value = '" . htmlspecialchars($nullLabel, ENT_QUOTES, 'UTF-8') . "';";

		$htmlReset = '	<a class="btn"'
				.	' onclick="' . htmlspecialchars($scriptReset, ENT_QUOTES, 'UTF-8') . '"'
				.	'>' . LN;

		$htmlReset .= ' <i class="icon-delete"></i>' . LN;
		$htmlReset .= ' </a>' . LN;



		// Text Input (readonly)
		$htmlInput = '<input type="text"'
		.	' id="' . $id . '_name"'
		.	' name="' . $this->name . '"'
		.	' value="' . $title . '"'
		.	' class="inputbox input-medium"'
		.	' disabled="disabled"'
		.	' readonly="readonly"'
		.	' size="40"'
		.	'/>' . LN;



		// Modal Picker - Select button
		JHtml::_('behavior.modal', 'a.modal');


		$link = $this->getPickUrl();

		$rel = '{handler: \'iframe\', size: {x: ' . $modalWidth . ', y: ' . $modalHeight . '}}';

		$htmlSelect = '	<a class="modal btn btn-primary" title="'. htmlspecialchars($label, ENT_QUOTES, 'UTF-8') .'" '
		.	' href="'. htmlspecialchars($link, ENT_QUOTES, 'UTF-8').'"'
		.	' rel="' . htmlspecialchars($rel, ENT_QUOTES, 'UTF-8') . '">' . LN;



		$htmlSelect .= ' <i class="icon-list icon-white"></i> ' . JText::_('JSELECT') .LN;
		$htmlSelect .= ' </a>' .LN;


		$htmlHidden = '<input '
		.	' type="hidden"'
		.	' id="' . $id . '_id"'
		.	' name="' . $this->name . '"'
		.	' value="' . $title . '"'
		.	'/>';


		// Construct the control
		$html = $htmlReset . $htmlInput . $htmlSelect . $htmlPresets;

		// Embed in bootsrap btn-group
		$html = '<span class="input-append input-prepend">' . $html . '</span>';

		// Add the hidden field (storing the value)
		$html.= $htmlHidden;



		// Append the script
		$script = '	function jSelectItem(id, title, object) {'
		.	'		document.id(object + "_id").value = id;'
		.	'		document.id(object + "_name").value = title;'
		.	'		SqueezeBox.close();'
		.	'	}';

		\JFactory::getDocument()->addScriptDeclaration($script);


		return $html;
	}

	/**
	* Method to get the modal frame url.
	*
	* @access	protected
	*
	* @return	string	Modal URL.
	*/
	protected function getPickUrl()
	{
		// Get the input settings
		$view = $this->getAttribute('view', $this->getAttribute('model'));
		$layout = $this->getAttribute('layout', 'modal');

		$id = $this->id;


		if (empty($view))
			return '';


		$extension = 'bds';

		$parts = explode('.', $view);
		if (count($parts) > 1)
		{
			if ($parts[0] != $extension)
			{
				$extension = $parts[0];
				$this->loadExtension($extension);
			}
			$view = $parts[1];
		}

		$option = $this->getAttribute('option', 'com_' . $extension);

		$url = "index.php?"
			.	"option=" . $option
			.	"&tmpl=component"
			.	"&view=" . $view
			. 	"&layout=" . $layout
			. 	"&pick=modal"
			. 	"&object=" . $id;

		return $url;
	}

	/**
	* Method to get the picker preset values.
	*
	* @access	protected
	*
	* @return	array	List of preset values.
	*/
	protected function getPresets()
	{
		$presets = array();

		foreach ($this->element->children() as $option)
		{
			// Only get from <preset /> elements.
			if ($option->getName() != 'preset')
				continue;

			$preset = new \stdClass();
			$preset->value = (string) $option['value'];
			$preset->icon = (string) $option['icon'];
			$preset->desc = (string) $option['desc'];

			$preset->display = (string) $option['display'];

			$preset->label = (string) $option;



			if (empty($preset->display))
				if (!empty($preset->icon))
					$preset->display = 'icon';
				else
					$preset->display = 'text';


			$presets[] = $preset;
		}

		return $presets;
	}

	/**
	* Get the rendering of this field type for a repeatable (grid) display, e.g.
	* in a view listing many item (typically a "browse" task)
	*
	* @access	public
	*
	*
	* @since	2.0
	*
	* @return	string	The field HTML
	*/
	public function getRepeatable()
	{
		// Not available for lists
		return '';

	}

	/**
	* Method to get the field input markup.
	*
	* @access	protected
	*
	* @return	string	The item label string.
	*/
	protected function getSelectedLabel()
	{
		if (!$this->value)
			return '';

		$labelKey = $this->getAttribute('labelKey');

		if (empty($labelKey))
			return "";

		$view = $this->getAttribute('view', $this->getAttribute('model'));
		$extension = 'bds';
		$selectedLabel = '';

		$model = JModelLegacy::getInstance($view, $extension . 'Model');
		if (!$model)
			return '';

		$selectedItem = BdsHelper::getData($model->getNameItem(), array(
			// Remove the default context
			'context' => '',

			// Select the labelKey field
			'select' => array($labelKey)
		), $this->value);


		if ($selectedItem)
			$selectedLabel = $selectedItem->$labelKey;

		return $selectedLabel;
	}

	/**
	* Get the rendering of this field type for static display, e.g. in a single
	* item view (typically a "read" task).
	*
	* @access	public
	*
	*
	* @since	2.0
	*
	* @return	string	The field HTML
	*/
	public function getStatic()
	{
		return $this->getInput();
	}

	/**
	* Method to load a third required extension.
	*
	* @access	protected
	* @param	string	$extension	Extension name to load (without 'com_' prefix).
	*
	* @return	void
	*/
	protected function loadExtension($extension)
	{
		if (!class_exists(ucfirst($extension) . 'Helper'))
			require_once(JPATH_ADMINISTRATOR . "/components/com_$extension/helpers/loader.php");
	}


}



