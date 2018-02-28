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


class JDomHtmlFormInputSelect extends JDomHtmlFormInput
{
	var $fallback = 'combo';		//Used for default

	var $domClass;
	var $selectors;

	protected $list;
	protected $listKey;
	protected $labelKey;
	protected $iconKey;
	protected $colorKey;
	protected $nullLabel;
	protected $size;
	protected $groupBy;
	protected $applyAccess;

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
	 * 	@list		: Possibles values list (array of objects)
	 * 	@listKey	: ID key name of the list
	 * 	@labelKey	: Caption key name of the list
	 * 	@size		: Size in rows ( 0,null = combobox, > 0 = list)
	 * 	@nullLabel	: First choice label for value = '' (no null value if null)
	 * 	@groupBy	: Group values on key(s)  (Complex Array Struct)
	 * 	@domClass	: CSS class
	 * 	@selectors	: raw selectors (Array) ie: javascript events
	 * 	@applyAccess: Limit the items to their access, even for admin user with privileges
	 */
	function __construct($args)
	{
		parent::__construct($args);

		$this->arg('list'		, null, $args);
		$this->arg('listKey'	, null, $args, 'id');
		$this->arg('labelKey'	, null, $args, 'text');
		$this->arg('colorKey'	, null, $args);
		$this->arg('iconKey'	, null, $args);
		$this->arg('size'		, null, $args);
		$this->arg('nullLabel'	, null, $args);
		$this->arg('groupBy'	, null, $args);
		$this->arg('domClass'	, null, $args);
		$this->arg('selectors'	, null, $args);
		$this->arg('applyAccess'	, null, $args);

		//Reformate items
		if (count($this->list))
		{
			$newArray = array();
			$a = array_keys($this->list);
			if ($a == array_keys($a))//Not associative
			{
				$i = 0;
				foreach($this->list as $item)
				{
					if (is_array($item))
						$item = JArrayHelper::toObject($item);

					if (!$this->checkAccess($item))
						continue;

					$newArray[$i] = $item;
					$i++;
				}
			}
			else
			{
				foreach($this->list as $key => $value)
				{
					if (is_string($value))
					{
						$newItem = new stdClass();
						$newItem->id = $key;
						$newItem->text = $value;

						$newArray[] = $newItem;
					}
					else
					{
						$newArray[] = $value;
					}

				}

			}

			$this->list = $newArray;
		}

	}

	/*
	 * This function restrict the items depending on their access tag.
	 * This is dangerous in case of a foreign key that have been populated with an 'unpublished' item, then it will diseapear.
	 * So in that case, when the user edit that form and save, it can break that link.
	 */
	protected function checkAccess($item)
	{
		// Do not apply accesses
		if (!$this->applyAccess)
			return true;

		// Item do not contains access tags
		if (!isset($item->params))
			return true;

		$tags = $item->params;
		if (is_object($tags))
			$tags = JArrayHelper::fromObject($tags);


		if (isset($tags['access-view']) && ($tags['access-view'] == 0))
			return false;

		if (isset($tags['tag-published']) && ($tags['tag-published'] == 0))
			return false;

		return true;
	}
}