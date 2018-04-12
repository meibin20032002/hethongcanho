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
* Enumerations Helper. Create the static lists.
*
* @package	Bds
*/
class BdsHelperEnum
{
	/**
	* Stores the lists in cache for optimization.
	*
	* @var array
	*/
	protected static $_cache = array();

	/**
	* Instanced name.
	*
	* @var string
	*/
	protected $enumName;

	/**
	* Instanced list.
	*
	* @var array
	*/
	public $list = array();

	/**
	* Instanced optional options.
	*
	* @var array
	*/
	protected $options = array();

	/**
	* Entry function to load a list.
	*
	* @access	public static
	* @param	string	$enumName	Name of the enumeration : [triad]_[field]
	* @param	array	$options	Optional config array for developer custom.
	*
	* @return	array	Associative array containing the list. Indexes are doubled (array index + value field).
	*/
	public static function _($enumName, $options = array())
	{
		$enumeration = self::getInstance($enumName);

		// Enumeration not found
		if (!$enumeration)
			return array();

		return $enumeration->getList($options);
	}

	/**
	* Construct the list : products_bedrooms
	*
	* @access	protected
	* @param	array	$options	Optional config array for developer custom.
	*
	* @return	array	Associative array containing the list. Indexes are doubled (array index + value field).
	*/
	protected function ___products_bedrooms($options = array())
	{
		return array(
			'1' => array(
				'value' => '1',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_1'
			),
			'2' => array(
				'value' => '2',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_2'
			),
			'3' => array(
				'value' => '3',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_3'
			),
			'4' => array(
				'value' => '4',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_4'
			),
			'5' => array(
				'value' => '5',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_5'
			),
			'6' => array(
				'value' => '6',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_6'
			),
			'7' => array(
				'value' => '7',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_7'
			),
			'8' => array(
				'value' => '8',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_8'
			),
			'9' => array(
				'value' => '9',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_9'
			),
			'10' => array(
				'value' => '10',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_10'
			),
			'11' => array(
				'value' => '11',
				'text' => 'BDS_ENUM_PRODUCTS_BEDROOMS_NHIU_HON_10'
			)
		);
	}

	/**
	* Construct the list : products_characteristics
	*
	* @access	protected
	* @param	array	$options	Optional config array for developer custom.
	*
	* @return	array	Associative array containing the list. Indexes are doubled (array index + value field).
	*/
	protected function ___products_characteristics($options = array())
	{
		return array(
			'Hẻm xe hơi' => array(
				'value' => 'Hẻm xe hơi',
				'text' => 'BDS_ENUM_PRODUCTS_CHARACTERISTICS_HM_XE_HOI'
			),
			'Mặt tiền' => array(
				'value' => 'Mặt tiền',
				'text' => 'BDS_ENUM_PRODUCTS_CHARACTERISTICS_MT_TIN'
			)
		);
	}

	/**
	* Construct the list : products_direction
	*
	* @access	protected
	* @param	array	$options	Optional config array for developer custom.
	*
	* @return	array	Associative array containing the list. Indexes are doubled (array index + value field).
	*/
	protected function ___products_direction($options = array())
	{
		return array(
			'Đông' => array(
				'value' => 'Đông',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_DONG'
			),
			'Tây' => array(
				'value' => 'Tây',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_TAY'
			),
			'Nam' => array(
				'value' => 'Nam',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_NAM'
			),
			'Bắc' => array(
				'value' => 'Bắc',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_BC'
			),
			'Đông Bắc' => array(
				'value' => 'Đông Bắc',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_DONG_BC'
			),
			'Đông Nam' => array(
				'value' => 'Đông Nam',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_DONG_NAM'
			),
			'Tây Bắc' => array(
				'value' => 'Tây Bắc',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_TAY_BC'
			),
			'Tây Nam' => array(
				'value' => 'Tây Nam',
				'text' => 'BDS_ENUM_PRODUCTS_DIRECTION_TAY_NAM'
			)
		);
	}

	/**
	* Construct the list : products_legal_documents
	*
	* @access	protected
	* @param	array	$options	Optional config array for developer custom.
	*
	* @return	array	Associative array containing the list. Indexes are doubled (array index + value field).
	*/
	protected function ___products_legal_documents($options = array())
	{
		return array(
			'Đã có sổ đỏ/sổ hồng' => array(
				'value' => 'Đã có sổ đỏ/sổ hồng',
				'text' => 'BDS_ENUM_PRODUCTS_LEGAL_DOCUMENTS_DA_CO_S_DS_HNG'
			),
			'Đang chờ bàn giao sổ' => array(
				'value' => 'Đang chờ bàn giao sổ',
				'text' => 'BDS_ENUM_PRODUCTS_LEGAL_DOCUMENTS_DANG_CH_BAN_GIAO_S'
			),
			'Giấy tay, giấy tờ khác' => array(
				'value' => 'Giấy tay, giấy tờ khác',
				'text' => 'BDS_ENUM_PRODUCTS_LEGAL_DOCUMENTS_GIY_TAY_GIY_T_KHAC'
			)
		);
	}

	/**
	* Construct the list : products_types
	*
	* @access	protected
	* @param	array	$options	Optional config array for developer custom.
	*
	* @return	array	Associative array containing the list. Indexes are doubled (array index + value field).
	*/
	protected function ___products_types($options = array())
	{
		return array(
			'mua-ban' => array(
				'value' => 'mua-ban',
				'text' => 'Mua Bán'
			),
			'cho-thue' => array(
				'value' => 'cho-thue',
				'text' => 'BDS_ENUM_PRODUCTS_TYPES_CHO_THUE'
			),
			'can-thue' => array(
				'value' => 'can-thue',
				'text' => 'BDS_ENUM_PRODUCTS_TYPES_CN_THUE'
			)
		);
	}

	/**
	* Construct the list : products_who
	*
	* @access	protected
	* @param	array	$options	Optional config array for developer custom.
	*
	* @return	array	Associative array containing the list. Indexes are doubled (array index + value field).
	*/
	protected function ___products_who($options = array())
	{
		return array(
			'p' => array(
				'value' => 'p',
				'text' => 'BDS_ENUM_PRODUCTS_WHO_CA_NHAN'
			),
			'c' => array(
				'value' => 'c',
				'text' => 'BDS_ENUM_PRODUCTS_WHO_CONG_TY'
			)
		);
	}
    
    protected function ___products_acreage($options = array())
	{
		return array(
			'40' => array(
				'value' => '40',
				'text' => '0 - 40m²'
			),
			'100' => array(
				'value' => '100',
				'text' => '40m² - 100m²'
			),
			'300' => array(
				'value' => '300',
				'text' => '100m² - 300m²'
			),
            '1000' => array(
				'value' => '1000',
				'text' => '> 300m²'
			)
		);
	}
    
    protected function ___products_alley($options = array())
	{
		return array(
			'3' => array(
				'value' => '3',
				'text' => '< 3m²'
			),
			'5' => array(
				'value' => '5',
				'text' => '3m² - 5m²'
			),
            '1000' => array(
				'value' => '1000',
				'text' => '> 5m²'
			)
		);
	}
    
    protected function ___products_price($options = array())
	{
		$model = CkJModel::getInstance('products', 'BdsModel');
        if($types = $model->getState('filter.types')){
            if ($types == 'cho-thue' || $types == 'can-thue'){
                return array(
                    '5' => array(
        				'value' => '5',
        				'text' => '0 - 5 triệu'
        			),
        			'10' => array(
        				'value' => '10',
        				'text' => '5 triệu - 10 triệu'
        			),
        			'20' => array(
        				'value' => '20',
        				'text' => '10 triệu - 20 triệu'
        			),
                    '50' => array(
        				'value' => '50',
        				'text' => '20 triệu - 50 triệu'
        			),
        			'30000' => array(
        				'value' => '30000',
        				'text' => '> 50 triệu'
        			)
        		);
            }
        }
        
        return array(
			'3000' => array(
				'value' => '3000',
				'text' => '0 - 3 tỷ'
			),
			'7000' => array(
				'value' => '7000',
				'text' => '3 tỷ - 7 tỷ'
			),
			'12000' => array(
				'value' => '12000',
				'text' => '7 tỷ - 12 tỷ'
			),
            '30000' => array(
				'value' => '30000',
				'text' => '> 12 tỷ'
			)
		);
        
	}

	/**
	* Enumeration constructor.
	*
	* @access	public
	* @param	string	$enumName	Name of the enumeration
	*
	* @return	void
	*/
	public function __construct($enumName)
	{
		$this->enumName = $enumName;
	}

	/**
	* Get an enumeration instance.
	*
	* @access	public static
	* @param	string	$enumName	Name of the enumeration
	*
	* @return	object	Enumeration instance (BdsHelperEnum)
	*/
	public static function getInstance($enumName)
	{
		if (empty($enumName))
			return null;

		if (isset(static::$_cache[$enumName]))
			return static::$_cache[$enumName];

		$enumeration = new BdsHelperEnum($enumName);

		static::$_cache[$enumName] = $enumeration;

		return $enumeration;
	}

	/**
	* Get an enumeration item (from enumeration instance).
	*
	* @access	public
	* @param	string	$value	Index value
	*
	* @return	array	Enumeration item
	*/
	public function getItem($value)
	{
		if (!isset($this->list[$value]))
			return null;

		return $this->list[$value];
	}

	/**
	* Load the list and return it.
	*
	* @access	protected
	* @param	array	$options	Optional configuration. (Advanced custom, not used in native)
	*
	* @return	array	Associative enumeration list.
	*/
	protected function getList($options = array())
	{
		$enumName = '___' . $this->enumName;

		if (!method_exists($this, $enumName))
			return null;

		$this->list = $this->$enumName($options);

		$this->translate();

		return $this->list;
	}

	/**
	* Get an item text (from enumeration instance).
	*
	* @access	public
	* @param	string	$value	Index value
	*
	* @return	string	Item text
	*/
	public function getText($value)
	{
		if (!$item = $this->getItem($value))
			return '';

		return $item['text'];
	}

	/**
	* Get the item of an enumeration.
	*
	* @access	public static
	* @param	string	$enumName	Name of the enumeration
	* @param	string	$value	Value index of the list.
	*
	* @return	array	Found item.
	*/
	public static function item($enumName, $value)
	{
		$enumeration = self::getInstance($enumName);

		// Enumeration not found
		if (!$enumeration)
			return null;

		// Load the enumeration
		$enumeration->getList();

		return $enumeration->getItem($value);
	}

	/**
	* Get the text value of an enumeration.
	*
	* @access	public static
	* @param	string	$enumName	Name of the enumeration
	* @param	string	$value	Value index of the list.
	*
	* @return	string	Translated text value of the found item.
	*/
	public static function text($enumName, $value)
	{
		$enumeration = self::getInstance($enumName);

		// Enumeration not found
		if (!$enumeration)
			return '';

		// Load the enumeration
		$enumeration->getList();

		return $enumeration->getText($value);
	}

	/**
	* Translate the list.
	*
	* @access	protected
	* @param	string	$source	Text field.
	* @param	string	$target	Translated Text field.
	*
	* @return	void
	*/
	protected function translate($source = 'text', $target = 'text')
	{
		if (empty($this->list))
			return;

		// Translate the texts
		foreach ($this->list as $value => $item)
			$this->list[$value][$target] = JText::_($item[$source]);
	}


}



