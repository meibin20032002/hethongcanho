<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V3.1.9   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		
* @package		BDS
* @subpackage	Products
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


JHtml::addIncludePath(JPATH_ADMIN_BDS.'/helpers/html');
JHtml::_('behavior.tooltip');
//JHtml::_('behavior.multiselect');

$model		= $this->model;
$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'a.ordering' && $listDirn != 'desc';
JDom::_('framework.sortablelist', array(
	'domId' => 'grid-products',
	'listOrder' => $listOrder,
	'listDirn' => $listDirn,
	'formId' => 'adminForm',
	'ctrl' => 'products',
	'proceedSaveOrderButton' => true,
));
?>

<div class="clearfix"></div>
<div class="">
	<table class='table' id='grid-products'>
		<thead>
			<tr>
				<?php if ($model->canSelect()): ?>
				<th>
					<?php echo JDom::_('html.form.input.checkbox', array(
						'dataKey' => 'checkall-toggle',
						'title' => JText::_('JGLOBAL_CHECK_ALL'),
						'selectors' => array(
							'onclick' => 'Joomla.checkAll(this);'
						)
					)); ?>
				</th>
				<?php endif; ?>

				<?php if ($model->canEditState()): ?>
				<th style="text-align:center">
					<?php echo JHTML::_('grid.sort',  "BDS_HEADING_ORDERING", 'a.ordering', $listDirn, $listOrder ); ?>
				</th>
				<?php endif; ?>

				<?php if ($model->canEditState()): ?>
				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_PUBLISHED"); ?>
				</th>
				<?php endif; ?>

				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_TITLE"); ?>
				</th>
                
                <th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_CATEGORY"); ?>
				</th>
                
				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_PROJECT"); ?>
				</th>

				<th style="text-align:center">
					<?php echo JText::_("Location"); ?>
				</th>

				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_BEDROOMS"); ?>
				</th>

				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_DIRECTION"); ?>
				</th>

				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_LEGAL_DOCUMENTS"); ?>
				</th>

				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_WHO"); ?>
				</th>
                
                <th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_HITS"); ?>
				</th>

				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_CREATED_BY"); ?>
				</th>

				<th style="text-align:center">
					<?php echo JText::_("BDS_FIELD_CREATION_DATE"); ?>
				</th>

				<th style="text-align:center">

				</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$k = 0;
		for ($i=0, $n=count( $this->items ); $i < $n; $i++):
			$row = $this->items[$i];

			?>

			<tr class="<?php echo "row$k"; ?>" sortable-group-id="<?php echo $row->category_id; ?>">
				<?php if ($model->canSelect()): ?>
				<td>
					<?php if ($row->params->get('access-edit') || $row->params->get('tag-checkedout')): ?>
						<?php echo JDom::_('html.grid.checkedout', array(
													'dataObject' => $row,
													'num' => $i
														));
						?>
					<?php endif; ?>
				</td>
				<?php endif; ?>

				<?php if ($model->canEditState()): ?>
				<td style="text-align:center">
					<?php echo JDom::_('html.grid.ordering', array(
						'aclAccess' => 'core.edit.state',
						'dataKey' => 'ordering',
						'dataObject' => $row,
						'enabled' => $saveOrder
					));?>
				</td>
				<?php endif; ?>

				<?php if ($model->canEditState()): ?>
				<td style="text-align:center">
					<?php echo JDom::_('html.grid.publish', array(
						'ctrl' => 'products',
						'dataKey' => 'published',
						'dataObject' => $row,
						'num' => $i
					));?>
				</td>
				<?php endif; ?>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => 'title',
						'dataObject' => $row,
						'route' => array('view' => 'product','layout' => 'product','cid[]' => $row->id)
					));?>
				</td>
                
                <td style="text-align:center">
                    <?php echo $row->_types_title?>
                    <?php echo $row->_category_id_title?> 
				</td>

				<td style="text-align:center">
                    <?php echo $row->_project_id_title?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => '_main_location_title',
						'dataObject' => $row
					));?>, 
                    <?php echo JDom::_('html.fly', array(
						'dataKey' => '_sub_location_title',
						'dataObject' => $row
					));?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly.enum', array(
						'dataKey' => 'bedrooms',
						'dataObject' => $row,
						'labelKey' => 'text',
						'list' => BdsHelperEnum::_('products_bedrooms'),
						'listKey' => 'value'
					));?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly.enum', array(
						'dataKey' => 'direction',
						'dataObject' => $row,
						'labelKey' => 'text',
						'list' => BdsHelperEnum::_('products_direction'),
						'listKey' => 'value'
					));?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly.enum', array(
						'dataKey' => 'legal_documents',
						'dataObject' => $row,
						'labelKey' => 'text',
						'list' => BdsHelperEnum::_('products_legal_documents'),
						'listKey' => 'value'
					));?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly.enum', array(
						'dataKey' => 'who',
						'dataObject' => $row,
						'labelKey' => 'text',
						'list' => BdsHelperEnum::_('products_who'),
						'listKey' => 'value'
					));?>
				</td>
                
                <td style="text-align:center">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => 'hits',
						'dataObject' => $row
					));?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => '_created_by_name',
						'dataObject' => $row
					));?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly.datetime', array(
						'dataKey' => 'creation_date',
						'dataObject' => $row,
						'dateFormat' => 'Y-m-d H:i'
					));?>
				</td>

				<td style="text-align:center">
					<?php echo JDom::_('html.fly', array(
						'dataKey' => 'id',
						'dataObject' => $row
					));?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		endfor;
		?>
		</tbody>
	</table>
</div>