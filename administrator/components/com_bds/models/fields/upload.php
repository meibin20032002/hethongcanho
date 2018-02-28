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



/**
* Uploader Form Field. Able to upload and delete/trash the files of your component. Requires the File Helper.
*
* @package	Bds
*/
class JFormFieldUpload extends JFormField
{
	/**
	* The Form object of the form attached to the form field.
	*
	* @var Form
	*/
	protected $form;

	/**
	* The item being rendered in a repeatable form field.
	*
	* @var DataModel
	*/
	public $item;

	/**
	* Repeatable field output.
	*
	* @var string
	*/
	protected $repeatable;

	/**
	* A monotonically increasing number, denoting the row number in a repeatable view.
	*
	* @var int
	*/
	public $rowid;

	/**
	* Static field output.
	*
	* @var string
	*/
	protected $static;

	/**
	* Method to get the field input markup.
	*
	* @access	protected
	*
	* @return	string	The field input markup.
	*/
	protected function getInput()
	{
		$html = ''

		// Display the file preview before the control
			.	$this->getInputThumb()


		// Wrap in a div
			.	'<div style="display:inline-block">' .LN

		// Show the max allowed size (floating right)
			.	$this->getInputMaxsize()


		// Uploader control (Bootstrap style)
			.	$this->getInputUploader()


		// Show allowed Extensions
			. $this->getInputExtensions()


		// close the div control
			. '</div>' .LN;


		return $html;
	}

	/**
	* Render the allowed uploadable file extensions.
	*
	* @access	protected
	*
	* @return	string	The allowed file extensions list as HTML
	*/
	protected function getInputExtensions()
	{
		// Per default, always show
		if (isset($this->element['uploadShowExtensions']) && in_array(strtolower($this->element['uploadShowExtensions']), array('false', 'no', '0')))
			return null;

		if (!isset($this->element['uploadExtensions']))
			return null;

		$exts = explode('|', preg_replace('/\,/', '|', $this->element['uploadExtensions']));

		$html = '<br/><span class="allowed-file-extensions">(' . implode(', ', $exts) . ')</span>';

		return $html;
	}

	/**
	* Render the input file control (part of the uploader).
	*
	* @access	protected
	*
	* @return	string	File control as HTML
	*/
	protected function getInputFile()
	{
		$html = '';
		$id = $this->id;
		$name = $this->name;
		$idView = $id . '-view'; //Optimized


		// Per default, always show file
		$uploadShowFile = true;
		if (isset($this->element['uploadShowFile']) && in_array(strtolower($this->element['uploadShowFile']), array('false', 'no', '0')))
			$uploadShowFile = false;


		//Create hidden input (file)
		$onchange = "jQuery(this).closest('div').find('#" . $idView . "').val(jQuery(this).val());";
		$htmlInputHidden = '<input '
			.	' onChange="'. htmlspecialchars($onchange, ENT_COMPAT, 'UTF-8') . '"'
			.	' type="file"'
			.	' id="' .$id.'"'
			.	' name="' .$name. '"'
			. 	' style="display:none;"'
			.	' value="' . $this->value . '"'
			.	'/>' .LN;


		//Create a visible text field (stylable)
		$jsBrowse = "jQuery(this).closest('div').find('input[id=\"$id\"]').trigger('click');";

		$htmlInputView = '<input '
			.	' type="text" '
			.	' id="' . $idView . '"'
			.	' value="' . $this->value . '"'
			.	' class="input-large inputfix ' . $this->class . '"' //inputfix : for cross compatibility (remove margin and float)
			.	' readonly=""'
				// In case, hide the file name to make the control shorter
			.	($uploadShowFile?'':' style="display:none;"')
			.	' onFocus="' . htmlspecialchars($jsBrowse, ENT_COMPAT, 'UTF-8') . '"'
			.	' />';


		// Create the upload button
		$htmlIconBrowse = '<i class="icon-folder-open"></i>';


		//Create the button to trigger the input
		$htmlButtonBrowse = '<a '
			.	' class="btn buttonfix"'
			.	' onClick="' . htmlspecialchars($jsBrowse, ENT_COMPAT, 'UTF-8') . '"'
			.	'>'
			.	$htmlIconBrowse
			.	'</a>';


		// Original file input is hidden
		$html .= $htmlInputHidden;

		//Visible input
		$html .= $htmlInputView;

		//Browse button
		$html .= $htmlButtonBrowse;

		return $html;
	}

	/**
	* Render the maximum allowed file size to upload.
	*
	* @access	protected
	*
	* @return	string	The max size string as HTML
	*/
	protected function getInputMaxsize()
	{
		if (!isset($this->element['uploadShowMaxsize']))
			return null;

		if (!in_array(strtolower($this->element['uploadShowMaxsize']), array('true', 'yes', '1')))
			return null;

		$uploadMaxsize = null;
		if (isset($this->element['uploadMaxsize']))
			$uploadMaxsize = $this->element['uploadMaxsize'];


		$maxsize = BdsHelperFile::getUploadMaxSize(true, $uploadMaxsize);


		$html = '<br/><span'
			.	' class="allowed-file-maxsize pull-right"'
			.	'>'
			. $maxsize
			.'</span>';

		$html .= '<div class="clearfix"></div>';


		return $html;
	}

	/**
	* Render the file preview.
	*
	* @access	protected
	*
	* @return	string	File preview as HTML
	*/
	protected function getInputThumb()
	{
		if (!isset($this->element['preview']))
			return null;

		if (!in_array(strtolower($this->element['preview']), array('true', 'yes', '1')))
			return null;

		$html = '';

		// If an image file if found
		if (!empty($this->value))
		{

			// Dashed border style
			$pickerStyle = 'border:dashed 3px #ccc; padding:5px; margin:5px;display:inline-block';


			$html = "<div style='" . $pickerStyle . "'>";

			// Use the Helper to handle the image url source, including all possible transformations of the image in the preview
			$previewUrlSrc = BdsHelperFile::getFileUrlFromElement($this->form, $this->element, $this->value);

			$html .= '<img'
				.	' src="' . $previewUrlSrc . '"'
				.	'/>';

			$html .= "</div>";

			$html .= '<div class="clearfix"></div>';

		}

		return $html;
	}

	/**
	* Render the complete file uploader control.
	*
	* @access	protected
	*
	* @return	string	Uploader control as HTML
	*/
	protected function getInputUploader()
	{
		$id = $this->id;
		$name = $this->name;

		$formControl = $this->form->getFormControl();

		$isNew = (empty($this->value));


		$html = '';

		// Current
		$idCurrent =  $id.'-current';
		$nameCurrent = $name. '-current';
		if ($formControl)
			$nameCurrent = $formControl . '[' . ltrim($id, $formControl . '_') . '-current]';

		//Current value is important for the removing features features
		$htmlHiddenCurrent = '<input '
			.	' type="hidden"'
			.	' id="' .$idCurrent.'"'
			.	' name="' .$nameCurrent.'"'
			.	' value="' . $this->value . '"'
			.	'/>' .LN;


		// Remove
		$idRemove =  $id.'-remove';
		$nameRemove = $name. '-remove';
		if ($formControl)
			$nameRemove = $formControl . '[' . ltrim($id, $formControl . '_') . '-remove]';

		$idRemoveBtn = $id . '-deletebtn';

		//Store and send the 'remove' value
		$htmlHiddenRemove = '<input '
			.	' type="hidden"'
			.	' id="' .$idRemove.'"'
			.	' name="' .$nameRemove.'"'
			.	' value=""'
			.	'/>' .LN;


		//Hidden inputs in top of the control
		$html .= $htmlHiddenCurrent .LN;
		$html .= $htmlHiddenRemove .LN;

		// Group in a bootstrap appended input
		$html .= '<div class="btn-group">';
		$html .= '<div class="input-prepend input-append">' .LN;

		//Prepend
		$html .= '<span class="add-on">'
			.	'<i class="icon-eye-open"></i>'
			.	'</span>';


		// Create the remove actions list
		if (!$isNew)
		{
			if ($removeList = $this->uploadActionsList())
			{

				$html .= '<a '
					.	' class="btn dropdown-toggle"'
					.	' id="' . $idRemoveBtn . '"'
					.	' data-toggle="dropdown">'

					. 		'<i class="icon-delete"></i>'

					.	'</a>' .LN;


				$html .= '<ul class="dropdown-menu">' .LN;
				foreach($removeList as $item)
				{
					$icon = $item['icon'];
					$iconClass = 'icon-' . $item['icon'];
					$itemIcon = '<i'
						.	' class="' . $iconClass . '"'
						.	' style="margin-left:1em; float:right;"'
						.	'></i>';


					$htmlLink =  $itemIcon . $item['text'];

					$html .= '<li>' .LN;

					$jsRemove = 'jQuery(\'input[id=' . $idRemove . ']\').val(\'' . $item['value'] . '\');';
					$jsRemove .= 'jQuery(\'a[id=' . $idRemoveBtn . '] i\').attr(\'class\','
								.	' \'' . $iconClass . '\');';

					$html .= '<a '
						.	' onclick="' . htmlspecialchars($jsRemove, ENT_COMPAT, 'UTF-8') . '"'
						.	'>'
						. 		$htmlLink
						. 	'</a>' .LN;

					$html .= '</li>' .LN;
				}
				$html .= '</ul>' .LN;
			}


		}

		//Create the input
		$html .= $this->getInputFile() .LN;


		//Close the control
		$html .= '</div>' .LN;
		$html .= '</div>' .LN;


		return $html;
	}

	/**
	* Get the rendering of this field type for a repeatable (grid) display, e.g.
	* in a view listing many item (typically a "browse" task)
	*
	* @access	public
	*
	* @return	string	The field HTML
	*/
	public function getRepeatable()
	{

	}

	/**
	* Get the rendering of this field type for static display, e.g. in a single
	* item view (typically a "read" task).
	*
	* @access	public
	*
	* @return	string	The field HTML
	*/
	public function getStatic()
	{

	}

	/**
	* Render the list of the available actions on this file.
	*
	* @access	protected
	*
	* @return	array	Formated array containing strings and icons of the availables tasks.
	*/
	protected function uploadActionsList()
	{
		if (!isset($this->element['uploadActions']))
			return null;

		if (empty($this->element['uploadActions']))
			return null;

		$actions = explode('|', preg_replace('/\,/', '|', $this->element['uploadActions']));

		$list = array();

		$list[] = array('value' => '', 'text' => JText::_("BDS_UPLOAD_REMOVE_KEEP"), 'icon' => 'cancel');

		if (in_array('remove', $actions))
			$list[] = array('value' => 'remove', 'text' => JText::_("BDS_UPLOAD_REMOVE_EJECT"), 'icon' => 'out');

		if (in_array('thumbs', $actions))
			$list[] = array('value' => 'thumbs', 'text' => JText::_("BDS_UPLOAD_REMOVE_THUMBS_ONLY"), 'icon' => 'pictures');

		if (in_array('trash', $actions))
			$list[] = array('value' => 'trash', 'text' => JText::_("BDS_UPLOAD_REMOVE_TRASH"), 'icon' => 'trash');

		if (in_array('delete', $actions))
			$list[] = array('value' => 'delete', 'text' => JText::_("BDS_UPLOAD_REMOVE_DELETE"), 'icon' => 'remove');

		return $list;
	}


}



