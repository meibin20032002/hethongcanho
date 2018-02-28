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


class JDomHtmlFlyMapOpenstreet extends JDomHtmlFlyMap
{
	var $assetName = 'openstreetmap';

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


	function buildJs()
	{
		if ($this->static)
			return;


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