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

class JDomHtmlFlyFileImage extends JDomHtmlFlyFile
{
	var $fallback = null;		//Used for default


	protected $alt;
	protected $title;
	protected $frame;
	protected $altKey;
	protected $titleKey;

	/*
	 * Constuctor
	 * 	@namespace 	: requested class
	 *  @options	: Configuration
	 * 	@dataKey	: database field name
	 * 	@dataObject	: complete object row (stdClass or Array)
	 * 	@dataValue	: value  default = dataObject->dataKey
	 *	@indirect	: Indirect File access
	 *	@root		: Default folder (alias : ex [DIR_TABLE_FIELD]) -> Need a parser (Cook helper)
	 *	@width		: Thumb width
	 *	@height		: Thumb height
	 *	@preview	: Preview type
	 *	@href		: Link on the file
	 *	@target		: Target of the link  ('download', '_blank', 'modal', ...)
	 *
	 *	@alt		: Meta alt
	 *  @frame		: Using a frame to secure the image overflow
	 *
	 */
	function __construct($args)
	{
		parent::__construct($args);
		$this->arg('alt'	, null, $args);
		$this->arg('title'	, null, $args);


		$this->arg('frame'	, null, $args, array());
		$this->arg('altKey'	, null, $args);
		$this->arg('titleKey'	, null, $args);


		if (!empty($this->altKey))
			$this->alt = $this->parseKeys($this->dataObject, $this->altKey);

		if (!empty($this->titleKey))
			$this->title = $this->parseKeys($this->dataObject, $this->titleKey);


		// Legacy center attribute
		if (is_array($this->attrs) && in_array('center', $this->attrs))
			$this->frame['center'] = true;

	}

	function build()
	{
        $thumbUrl = $this->getFileUrl(true);

		// In case of 'physical' : Cannot show the image, only the file path
		if ($this->indirect == 'physical')
			return $thumbUrl;

	   	if (empty($thumbUrl))
			return;

		if ($this->title)
			$this->addSelector('title', $this->title);

		if ($this->alt)
			$this->addSelector('alt', $this->alt);


        $html = '<img src="' . $thumbUrl . '"'
            .   '<%CLASS%><%SELECTORS%>'
            .   '/>';


		// Embed the image inside a div for center, border, overflow,
		if (!empty($this->frame))
			$html = $this->imageFrame($html, $this->frame);


        return $html;
	}

	function imageFrame($html, $frameOptions)
	{
		if ($w = (int)$this->width)
			$this->styles['width'] = $w;

		if ($h = (int)$this->height)
			$this->styles['height'] = $h;


		if ($w && $h)
		{

			$remainH = $h;
			$remainW = $w;


			if (isset($this->frame['styles']) && is_array($this->frame['styles']))
			{
				$frameStyles = $this->frame['styles'];

				foreach($frameStyles as $property => $value)
				{
					$this->addStyle($property, $value);

					switch($property)
					{
						case 'width':
							$remainW = (int)$value;
							break;

						case 'height':
							$remainH = (int)$value;
							break;
					}
				}
			}

			$m = 0;
			if (isset($this->frame['margin']))
				$m = $this->frame['margin'];


			$remainW += 2 * $m;
			$remainH += 2 * $m;


			// Centering the photo in the frame
			if (isset($this->frame['center']) && $this->frame['center']
				&& $helperClass = $this->getComponentHelper()) // Component helper is required
			{

				// Get the image properties
				$filePath = $helperClass::getFile($this->getPath());

				if (file_exists($filePath))
				{
					$proprerties = JImage::getImageFileProperties($filePath);

					$ratioWith = $w / $proprerties->width;
					$ratioHeight = $h / $proprerties->height;


					if ($ratioWith < $ratioHeight)
						// Fit on the width
						$ratio = $ratioWith;
					else
						$ratio = $ratioHeight;



					// Set padding on the height
					$margin = (int)(($remainH - ($proprerties->height * $ratio))/2);


					$this->addStyle('padding-top', $margin . 'px');
					$this->addStyle('padding-bottom', $margin . 'px');

					// The size is affected by the padding
					$remainH = $remainH - ($margin*2);


					// Set padding on the width
					$margin = (int)(($remainW - ($proprerties->width * $ratio))/2);


					$this->addStyle('padding-left', $margin . 'px');
					$this->addStyle('padding-right', $margin . 'px');


					// The size is affected by the padding
					$remainW = $remainW - ($margin*2);
				}

			}

			$this->addStyle('width', $remainW . 'px');
			$this->addStyle('height', $remainH . 'px');
		}

		$html = '<div class="img-zone img-frame"'
			. 	'<%STYLE%>'
			.	'>'
			.	$html
			.	'</div>';


        return $html;
	}
}
