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



/**
* Bds Product Controller
*
* @package	Bds
* @subpackage	Product
*/
class BdsControllerProduct extends BdsClassControllerItem
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'product';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'product';

	/**
	* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'products';

	/**
	* Constructor
	*
	* @access	public
	* @param	array	$config	An optional associative array of configuration settings.
	*
	* @return	void
	*/
	public function __construct($config = array())
	{
		parent::__construct($config);
		$app = JFactory::getApplication();

	}

	/**
	* Override method when the author allowed to delete own.
	*
	* @access	protected
	* @param	array	$data	An array of input data.
	* @param	string	$key	The name of the key for the primary key; default is id..
	*
	* @return	boolean	True on success
	*/
	protected function allowDelete($data = array(), $key = id)
	{
		return parent::allowDelete($data, $key, array(
		'key_author' => 'created_by'
		));
	}

	/**
	* Override method when the author allowed to edit own.
	*
	* @access	protected
	* @param	array	$data	An array of input data.
	* @param	string	$key	The name of the key for the primary key; default is id..
	*
	* @return	boolean	True on success
	*/
	protected function allowEdit($data = array(), $key = id)
	{
		return parent::allowEdit($data, $key, array(
		'key_author' => 'created_by'
		));
	}

	/**
	* Method to cancel an element.
	*
	* @access	public
	* @param	string	$key	The name of the primary key of the URL variable.
	*
	* @return	void
	*/
	public function cancel($key = null)
	{
		$this->_result = $result = parent::cancel();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'product.cancel':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'post.cancel':
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				));
				break;
		}
	}

	/**
	* Return the current layout.
	*
	* @access	protected
	* @param	bool	$default	If true, return the default layout.
	*
	* @return	string	Requested layout or default layout
	*/
	protected function getLayout($default = null)
	{
		if ($default === 'edit')
			return 'post';

		if ($default)
			return 'post';

		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'post', 'CMD');
	}

	/**
	* Method to save an element.
	*
	* @access	public
	* @param	string	$key	The name of the primary key of the URL variable.
	* @param	string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	*
	* @return	void
	*/
	public function save($key = null, $urlVar = null)
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		//Check the ACLs
		$model = $this->getModel();
		$item = $model->getItem();
		$result = false;
		if ($model->canEdit($item, true))
		{
			$result = parent::save();
			//Get the model through postSaveHook()
			if ($this->model)
			{
				$model = $this->model;
				$item = $model->getItem();	
			}
		}
		else
			JError::raiseWarning( 403, JText::sprintf('ACL_UNAUTORIZED_TASK', JText::_('BDS_JTOOLBAR_SAVE')) );

		$this->_result = $result;

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			default:
                if($result)
                    JFactory::getApplication()->enqueueMessage('Xin cảm ơn, Tin sẽ được duyệt 30 ngày sẽ lên');
				$this->applyRedirection($result, array(
					'stay',
					'com_bds.products.default'
				));
				break;
		}
	}

    public function ajaxSave(){
        JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $model = $this->getModel();
        $user = JFactory::getUser();
        
        $files = JRequest::getVar('file', null, 'files', 'array');
        
        $result = false;
        $dir_name = '';
        //upload file
        if (isset($files)) {
            $folder = "images" . DS . "product";
            jimport( 'joomla.filesystem.folder' );
            jimport( 'joomla.filesystem.file' );
            
	    	if (!JFolder::exists( $folder )) {
	           JFolder::create( $folder, 0777 );
	    	}
            
            if($files['name'] !=''){
                $files['name'] = preg_replace('/\s+/','',$files['name']);                
                $filename = time().$user->id.$files['name'];
    	   	 	$src = $files['tmp_name'];
    	    	$dir_name = JPATH_SITE . DS . $folder . DS . $filename;
                
                $allowed =  array('bmp','jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'gif', 'doc', 'docx', 'pdf', 'xls', 'xlsx');
                $ext = strtolower(JFile::getExt($filename)); 
                if(in_array($ext, $allowed) ) {
    	        	if(JFile::upload($src, $dir_name)){
                    
                        $profile = new stdClass();
                        $profile->key = $filename;
                        $profile->user_id = $user->id;
                        $profile->upload = $folder . DS . $filename;
                        $profile->create_date = JFactory::getDate()->toSql();
                        
                        // Insert
                        $model = $this->getModel();
                        $result = $model->insertTemp($profile);
                    }
                }else{
                    $message = JText::_('You’ve exceeded the allocated space for each policy. 
                    Simply reduce the content or try saving to a different format. 
                    Do reach us if you require further assistance.');
                }
            }

        }
        
        // Return
        $json['result'] = $result;
        $json['href'] = JUri::base().$folder . DS . $filename;
        $json['name'] = $filename;
        echo json_encode($json);
        JFactory::getApplication()->close(); // or jexit();      
    }
    
    public function ajaxDelete(){
        JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        
        $result  = false;
        if($key = JRequest::getVar('name')){
            $model = $this->getModel();
            if($item = $model->itemTemp($key)){
                $result = $model->deleImage($item);
            }
        }
        $json['result'] = $result;
        echo json_encode($json);
        JFactory::getApplication()->close(); // or jexit();
    }
    
    public function snapSave(){
        JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $model = $this->getModel();
        $user = JFactory::getUser();
        
        //Image format
        $imageData = JRequest::getVar('imagebase');
        list($type, $imageData) = explode(';', $imageData);
        list(,$extension) = explode('/',$type);
        list(,$imageData)      = explode(',', $imageData);
        $files = base64_decode($imageData);           
        
        $result = false;
        $dir_name = '';
        //upload file
        if (isset($files)) {
            $folder = "images" . DS . "product";
            jimport( 'joomla.filesystem.folder' );
            jimport( 'joomla.filesystem.file' );
            
	    	if (!JFolder::exists( $folder )) {
	           JFolder::create( $folder, 0777 );
	    	}
            
    
            $filename = uniqid(mktime()).'snap.'.$extension;;
	    	$dir_name = JPATH_SITE . DS . $folder . DS . $filename;
            
            $success = file_put_contents($dir_name, $files);
            if($success){
                $profile = new stdClass();
                $profile->key = $filename;
                $profile->user_id = $user->id;
                $profile->upload = $folder . DS . $filename;
                $profile->create_date = JFactory::getDate()->toSql();
                
                // Insert
                $model = $this->getModel();
                $result = $model->insertTemp($profile);
            }else{
                $json['messeage'] = 'Unable to save the file.';
            }
        }else{
            $json['messeage'] = 'Error upload file.'.$files;
        }
        
        // Return
        $json['result'] = $result;
        $json['href'] = JUri::base().$folder . DS . $filename;
        $json['name'] = $filename;
        echo json_encode($json);
        JFactory::getApplication()->close(); // or jexit();      
    }
}



