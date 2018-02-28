<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <     JDom Class - Cook Self Service library    |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		2.6.1
* @package		Cook Self Service
* @subpackage	JDom
* @license		GNU General Public License
* @author		Jocelyn HUARD
*
* @addon		Google map API v3
* @author		Girolamo Tomaselli - http://bygiro.com
* @version		0.0.1
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class JDomHtmlFlyMapGoogle extends JDomHtmlFlyMap
{
	var $assetName = 'google';

	var $attachJs = array(
		'map.js'
	);

	/*
	 * Constuctor
	 * 	@namespace 	: requested class
	 *  @options	: Configuration
	 *
	 *
	 */
	function __construct($args)
	{
		parent::__construct($args);
	}

	function buildStaticUrl()
	{
		$params = array();

		// Center
		if (isset($this->request['center']))
		{
			$center = $this->request['center'];
			if (isset($center['lat']) && isset($center['lng']))
				$params['center'] = $center['lat'] . ',' . $center['lng'];
		}
		else if (isset($this->request['address']))
			$params['center'] = $this->request['address'];

		// Zoom
		if (isset($this->request['zoom']))
			$params['zoom'] = (int)$this->request['zoom'];


		// Map Type
		if (isset($this->request['mapType']))
			$params['maptype'] = strtolower($this->request['mapType']);


		// Size (Not working with the % suffix)
		$params['size'] = (int)$this->width . 'x' . (int)$this->height;


		// Styles
		if (isset($this->request['googleStyles']))
		{
			$styles = array();
			foreach($this->request['googleStyles'] as $style)
			{
				$parts = array();
				if (isset($style['elementType']))
					$parts[] = 'element:' . $style['elementType'];

				if (isset($style['featureType']))
					$parts[] = 'feature:' . $style['featureType'];

				if (isset($style['stylers']))
				{
					if (!empty($style['stylers']))
					foreach($style['stylers'] as $stylers)
					{
						foreach($stylers as $property => $value)
						{
							$parts[] = $property . ':' . $value;
						}
					}
				}


				$styles[] = implode('|', $parts);
			}

		}

		// build the url
		$url = "http://maps.googleapis.com/maps/api/staticmap?key=" . $this->keyAPI;

		foreach($params as $var => $value)
			$url .= "&$var=$value";

		// The styles are set in multiple times the same url var : 'style'
		if (!empty($styles))
		foreach($styles as $style)
			$url .= "&style=$style";

		return $url;
	}

	function buildJs()
	{
		if ($this->static)
			return;


		if (isset($this->request['googleStyles']))
		{
			$this->request['styles'] = $this->request['googleStyles'];
			unset($this->request['googleStyles']);
		}

		$mapOptions = array(
			'data' => $this->request,
			'markers' => $this->getMarkers(),
			'directions' => $this->directions
		);

		// Initialize the request
		$js = "ck_maps['" . $this->instance . "'] = " . json_encode($mapOptions) . ";";
		$this->addScriptInline($js);

		// Load the map
		$js = "ck_loadMap('" . $this->instance . "', '" . $this->keyAPI . "');";
		$this->addScriptInline($js, true);

	}
}