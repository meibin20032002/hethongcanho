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


JFormHelper::loadFieldClass('model');

/**
* Form field for Bds.
*
* @package	Bds
* @subpackage	Form
*/
class JFormFieldRelation extends JFormFieldModel
{
	/**
	* The form field type.
	*
	* @var string
	*/
	public $type = 'relation';

	/**
	* Method to get the field input markup.
	*
	* @access	protected
	*
	*
	* @since	11.1
	*
	* @return	string	The field input markup.
	*/
	protected function getInput()
	{
		if ($relation = $this->getRelation())
		{
			// Define the default Label Key
			if (!$this->getAttribute('labelKey'))
				$this->setAttribute('labelKey', $relation->selectFields[0]);


			// Reformate the values
			if ($relation->type == 'belongsToMany')
				$foreignKey = $relation->foreignKey;
			else if ($relation->type == 'hasMany')
				$foreignKey = $relation->localKey;
			else // Fallback
				$foreignKey = 'id';

			// Parse values
			$values = array();
			if (!empty($this->value))
			{
				foreach($this->value as $row)
				{
					$val = $row;
					if (is_object($row))
						$val = (int)$row->$foreignKey;

					$values[] = $val;
				}

				$this->value = $values;
			}
		}


		// This hidden input fix permits to send empty data
		$htmlInputHiden = '<input type="hidden" name=' . $this->name . ' value=""/>';

		return $htmlInputHiden . parent::getInput();
	}

	/**
	* Get the model name to use for this relation.
	*
	* @access	public
	*
	* @return	string	The model name.
	*/
	public function getModelName()
	{
		$relation = $this->getRelation();
		if ($relation)
			$model = $relation->foreignModelClass;
		else
			$model = $this->getAttribute('model');

		return $model;
	}

	/**
	* Method to get a model relation.
	*
	* @access	protected
	*
	* @return	object	Model relation object.
	*/
	protected function getRelation()
	{
		// Uses the name as relation name if relation is not defined
		$relation = $this->getAttribute('relation', $this->getAttribute('name'));

		// Get this model (item)
		$formInstance = $this->form->getName();
		$parts = explode('.', $formInstance);
		$modelName = $parts[1];

		// Get the relation config
		$model = CkJModel::getInstance($modelName, 'BdsModel');
		$relation = $model->getRelation($relation);

		return $relation;
	}

	/**
	* Method to prepare the Model before to get the items.
	*
	* @access	public
	* @param	JModel	&$model	The model sent by the parent.
	*
	* @return	void
	*/
	public function prepareModel(&$model)
	{
		$where = null;

		// In case of Many to One, the options are limted to the available ones
		$relation = $this->getRelation();
		if ($relation && $relation->type == 'hasMany')
		{
			$fkField = 'a.' . $relation->foreignKey;
			$where = (empty($this->value)?'':'(' . $relation->foreignPkey . ' IN (' . implode(', ', $this->value). ')) OR')
				. '(' . $fkField . ' IS NULL)'
				. ' OR (' . $fkField . ' = 0)';
		}

		if ($where)
			$model->addWhere($where);
	}


}



