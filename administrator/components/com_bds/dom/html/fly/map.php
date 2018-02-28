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


class JDomHtmlFlyMap extends JDomHtmlFly
{

//TODO
	protected static $loaded = array();


	protected $keyAPI;
	protected $static;
	protected $instance;
	protected $request;
	protected $markers;
	protected $directions;
	protected $width;
	protected $height;

	public $fallback = 'google';

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

		$this->arg('keyAPI'	, null, $args);
		$this->arg('static'	, null, $args, false);
		$this->arg('instance'	, null, $args, 'default');
		$this->arg('request'	, null, $args, array());
		$this->arg('markers'	, null, $args, array());
		$this->arg('directions'	, null, $args, array());
		$this->arg('width'	, null, $args, '100%');
		$this->arg('height'	, null, $args, 400);

		if (isset($this->request['center']))
		{
			$center = $this->request['center'];
			if ((isset($center->lat) && !(float)$center->lat)
			|| (isset($center->lng) && !(float)$center->lng))
				$this->request['center'] = null;
		}

	}

	function build()
	{
		if ($this->static)
			return $this->buildStatic();


		$w = $this->width;
		if (is_numeric($w))
			$w .= 'px';

		$h = $this->height;
		if (is_numeric($h))
			$h .= 'px';

		$html = '<div id="map_' . $this->instance . '" '
			.	' style="width:' . $w . '; height:' . $h . ';"'
			.	' >'
			.	'</div>';

		return $html;
	}

	function buildStatic()
	{
		$alt = "Map";
		if (isset($this->request['title']))
			$alt = $this->request['title'];

		if (isset($this->request['address']))
			$alt = $this->request['address'];


		$src = $this->buildStaticUrl();
		$html = '<img src="' . $src . '"'
			.	' width"' . (int)$this->width . '"'
			.	' height"' . (int)$this->height . '"'
			.	' alt="' . $alt . '"'
			.	'/>';

		return $html;
	}


	function getMarkers()
	{
		if (isset($this->markers['data']))
			return $this->markers;

		if (!isset($this->markers['list']))
			return array();


		if (isset($this->markers['dataKeys']))
		{

			$list = $this->markers['list'];
			$dataKeys = $this->markers['dataKeys'];


			$data = array();
			$markerKeys = array('address', 'title', 'content', 'icon', 'iconWidth', 'iconHeight');
			$markerKeysPosition = array('lat', 'lng');
			foreach($list as $item)
			{
				$markerData = array();
				$markerPosition = array();
				foreach($markerKeys as $markerKey)
				{
					if (isset($dataKeys[$markerKey]))
					{
						$key = $dataKeys[$markerKey];
						$markerData[$markerKey] = $this->parseKeys($item, $key);
					}
					else if (isset($item->$markerKey))
						$markerData[$markerKey] = $item->$markerKey;

				}

				//$markerData['position'] = array();
				foreach($markerKeysPosition as $markerKey)
				{
					if (isset($dataKeys[$markerKey]))
					{
						$key = $dataKeys[$markerKey];
						$value = (float)$item->$key;
						if ($value) // Do not accept 0.00000
							$markerData['position'][$markerKey] = $value;

					}
					else if (isset($item->$markerKey))
					{
						$value = (float)$item->$markerKey;
						if ($value)
							$markerData['position'][$markerKey] = $value;
					}

				}

				$data[] = $markerData;

			}

		}
		else
			$data = $this->markers['list'];

		$this->markers['data'] = $data;
		return $this->markers;
	}


}