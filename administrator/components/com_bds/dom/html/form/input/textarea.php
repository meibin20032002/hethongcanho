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


class JDomHtmlFormInputTextarea extends JDomHtmlFormInput
{
	var $cols;
	var $rows;
	var $width;
	var $height;


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
	 * 	@cols		: Textarea width (in caracters)
	 * 	@rows		: Textarea height (in caracters)
	 *	@width		: Apply CSS width and replace cols value
	 *	@height		: Apply CSS height and replace rows value
	 * 	@domClass	: CSS class
	 * 	@selectors	: raw selectors (Array) ie: javascript events
	 */
	function __construct($args)
	{

		parent::__construct($args);

		$this->arg('cols'	, null, $args, '32');
		$this->arg('rows'	, null, $args, '4');
		$this->arg('width'	, null, $args);
		$this->arg('height'	, null, $args);
		$this->arg('domClass'	, null, $args);
		$this->arg('selectors'	, null, $args);


	}

	function build()
	{

		if (!empty($this->width))
		{
			$this->cols = null;
			$this->addStyle('width', $this->width);
		}

		if (!empty($this->height))
		{
			$this->rows = null;
			$this->addStyle('height', $this->height);
		}


		$html =	'<%PREFIX%><textarea id="<%DOM_ID%>" name="<%INPUT_NAME%>"<%STYLE%><%CLASS%><%SELECTORS%>'
			.	($this->cols?' cols="' . $this->cols . '"':'')
			.	($this->rows?' rows="' . $this->rows . '"':'')
			.	'>'
			.	'<%VALUE%>'
			.	'</textarea><%SUFFIX%>' .LN
			.	'<%VALIDOR_ICON%>'.LN
			.	'<%MESSAGE%>';


		return $html;
	}


}
