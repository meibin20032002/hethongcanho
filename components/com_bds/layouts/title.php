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



?>

<?php
// Initialize variables
$params = $displayData['params'];


// Show the Header ?
$showHeading = $params->get('show_page_heading', true);
$menu = JFactory::getApplication()->getMenu()->getActive();
if ($menu)
	$showHeading = $params->get('show_page_heading', $menu->params->get('show_page_heading', true));


// Retreive the title to display
if (isset($displayData['title']))
	$title = $displayData['title'];
else
{
	$title = $params->get('title', $params->get('page_heading'));

	// Fallback using menu parameters
	if (empty($title) && $menu)
		$title = $menu->params->get('page_heading', $menu->title);
}


// Redefine the browser title
if (isset($displayData['browserTitle']))
{
	$browserTitle = $displayData['browserTitle'];
	$document	= JFactory::getDocument();
	$document->setTitle($browserTitle);
}

?>

<?php if ($showHeading) : ?>
<div class="page-header">
	<h1> <?php echo $this->escape($title); ?> </h1>
</div>
<?php endif; ?>