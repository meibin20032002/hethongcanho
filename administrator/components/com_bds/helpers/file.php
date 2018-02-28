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

defined('BDS_UPLOAD_DEFAULT_DIR') or define("BDS_UPLOAD_DEFAULT_DIR", 'COM_MEDIAS');
defined('BDS_UPLOAD_DEFAULT_RENAME') or define("BDS_UPLOAD_DEFAULT_RENAME", '{ALIAS}.{MIMEXT}');
defined('BDS_UPLOAD_CHMOD_FOLDER') or define("BDS_UPLOAD_CHMOD_FOLDER", 0754);
defined('BDS_UPLOAD_CHMOD_FILE') or define("BDS_UPLOAD_CHMOD_FILE", 0644);
defined('BDS_IMAGES_MAX_WIDTH') or define("BDS_IMAGES_MAX_WIDTH", 1000);
defined('BDS_IMAGES_MAX_HEIGHT') or define("BDS_IMAGES_MAX_HEIGHT", 1000);
defined('BDS_IMAGES_ALLOWED_SIZES') or define("BDS_IMAGES_ALLOWED_SIZES", '');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');


/**
* File Helper. Contains usefull utilities for images transformations and uploads.
*
* @package	Bds
*/
class BdsHelperFile
{
	/**
	* Cache for directories aliases.
	*
	* @var array
	*/
	protected static $directories = array();

	/**
	* Define the files directories fields
	*
	* @var array
	*/
	public static $directoriesFields = array();

	/**
	* Stores the component alias.
	*
	* @var string
	*/
	protected static $extension = 'com_bds';

	/**
	* Handle multi part known special extensions.
	*
	* @var array
	*/
	protected static $knownExtensions = array('tar.gz');

	/**
	* Contains the list of known mime-types and their respective file extensions.
	*
	* @var array
	*/
	protected static $mimesTable = array();

	/**
	* Create the folders and protect directory with index.html empty file.
	*
	* @access	public static
	* @param	string	$base	The base directory where to start putting files.
	* @param	string	$dir	A relative folder to create and complete with a blank files.
	*
	* @return	void
	*/
	public static function blankFiles($base, $dir = null)
	{
		$blankContent = '<html><body bgcolor="#FFFFFF"></body></html>';
		$path = JPath::clean($base . '/');

		if($path && !file_exists($path))
			return;

		// Create a blank index.html file to the given base
		if(!file_exists($path . 'index.html'))
			JFile::write($path . 'index.html', $blankContent);

		if (!$dir)
			return;

		jimport('joomla.filesystem.folder');

		// Create blank index.html files to every sub folder
		$folders = explode('/', $dir);
		foreach($folders as $folder)
		{
			$path .= $folder . '/';

			if(!is_dir($path))
				JFolder::create($path);

			if(!file_exists($path . 'index.html'))
				JFile::write($path . 'index.html', $blankContent);

		}
	}

	/**
	* Stringify a bytes value.
	*
	* @access	public static
	* @param	string	$bytes	Bytes.
	*
	* @return	string	Formated bytes string.
	*/
	public static function bytesToString($bytes)
	{
		$suffix = "";
		$units = array('K', 'M', 'G', 'T');

		$i = 0;
		while ($bytes >= 1024)
		{
			$bytes = $bytes / 1024;
			$suffix = $units[$i];
			$i++;
		}

		return round($bytes, 2) . $suffix;
	}

	/**
	* Rename the file if it already exists.
	*
	* @access	protected static
	* @param	string	$dir	Base directory.
	* @param	object	$file	File object containing all major informations (name, extension, mime, ...).
	* @param	string	$suffix	File suffix.
	*
	* @return	string	True if exists, False otherwise.
	*/
	protected static function checkFileExists($dir, $file, $suffix = null)
	{
		$s = (isset($suffix)?"-" . $suffix:"");

		return file_exists($dir .'/'. $file->base . $s . '.' . $file->extension);
	}

	/**
	* Check if the file is already present.
	*
	* @access	protected static
	* @param	string	$dir	Base directory.
	* @param	object	$file	File object containing all major informations (name, extension, mime, ...).
	* @param	string	$options	Contains override options.
	*
	* @return	string	True is already present, False otherwise.
	*
	* @throws	Exception	When file already exist and overrwrite is set to no.
	*/
	protected static function checkFilePresence($dir, $file, $options)
	{
		if (static::checkFileExists($dir, $file))
		{
			switch(strtolower($options["overwrite"]))
			{
				case 'no':
				case 'false':
				case '0':
					// Error file already present
					throw new \Exception(JText::sprintf( "BDS_UPLOAD_EXISTS", $file->filename));
					break;


				// Overwrite
				case 'yes':
				case 'true':
				case '1':
					return; break;


				// Add a file suffix
				case 'suffix':
				default:
					static::suffixIfExists($dir, $file);
					break;
			}
		}
	}

	/**
	* Return a safe file name.
	*
	* @access	public static
	* @param	string	$str	file name to alias.
	* @param	string	$toCase	Change case.
	*
	* @return	string	Aliased string.
	*/
	public static function createAlias($str, $toCase = 'lower')
	{
		//ACCENTS
		$accents = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
		$replacements = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
		$str = str_replace($accents, $replacements, $str);

		//SPACES
		$str = preg_replace("/\s+/", "-", $str);

		switch($toCase)
		{
			case 'lower': $str = strtolower($str); break;
			case 'upper': $str = strtoupper($str); break;
			case 'ucfirst': $str = ucfirst($str); break;
			case 'ucwords': $str = ucwords($str); break;
		}

		return JFile::makeSafe($str);
	}

	/**
	* Return a random alias from composed from a list of chars.
	*
	* @access	protected static
	* @param	integer	$length	Length of the random.
	*
	* @return	string	Random string.
	*/
	protected static function createRandomAlias($length)
	{
		$randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		$lenChars = strlen($randomChars);
		$random = "";

		if ((int)$length == 0)
			$length = 8;

		for($i = 0 ; $i < $length ; $i++)
		{
			$pos = rand(0, $lenChars);
			$random .= substr($randomChars, $pos, 1);
		}

		return $random;
	}

	/**
	* Decode the filters values in the url params.
	*
	* @access	protected static
	* @param	string|array	$filters	List of filters
	*
	* @return	array	Return an array of file filters attributes.
	*/
	protected static function decodeFiltersAttributes($filters)
	{
		// Filters
		if (!is_array($filters))
			$filters = explode(",", $filters);


		foreach($filters as $filter)
		{
			$params = null;
			if (preg_match("/^(.+):(.+)$/", $filter, $matches))
			{
				$filter = $matches[1];
				array_shift($matches);
				array_shift($matches);
				$params = $matches;
			}


			$value = (isset($params[0])?$params[0]:null);
			if (empty($filter))
				continue;


			// Check if filter exists
			if (!in_array($filter, array('backgroundfill', 'grayscale', 'edgedetect', 'emboss', 'negate', 'sketchy', 'smooth', 'brightness', 'contrast')))
				continue;


			$filterOptions = array();
			switch($filter)
			{
				case 'backgroundfill':
					$filterOptions['color'] = $value;
					break;

				case 'smooth':
					$filterOptions[IMG_FILTER_SMOOTH] = (int)$value;
					break;

				case 'brightness':
					$filterOptions[IMG_FILTER_BRIGHTNESS] = (int)$value;
					break;

				case 'contrast':
					$filterOptions[IMG_FILTER_CONTRAST] = (int)$value;
					break;


				default:
					if ($value)
						$filterOptions[] = $value;
					break;
			}

			$attribsFilters->$filter = $filterOptions;
		}


		return $attribsFilters;
	}

	/**
	* Get the size of a folder.
	*
	* @access	public static
	* @param	string	$dir	Directory to scan.
	* @param	integer	&$currentSize	Folder size
	*
	* @return	void
	*/
	public static function folderGetSize($dir, &$currentSize)
	{
		if (JFolder::exists($dir))
		{
			foreach(JFolder::files($dir) as $file)
			{
				$currentSize += filesize($dir .'/'. $file);
			}

			foreach(JFolder::folders($dir) as $folder)
			{
				// Recursivity
				static::folderGetSize($dir .'/'. $folder, $currentSize);
			}
		}
	}

	/**
	* Read the attributes of the file from a form field.
	*
	* @access	public static
	* @param	JFormField	$element	Form field containing the attributes.
	*
	* @return	array	Return an array of file attributes.
	*/
	public static function getAttributesFromElement($element)
	{
		$attribs = new stdClass();


		// Size
		$attribs->size = new stdClass();
		if ($element['width'] && (trim($element['width']) != 'auto'))
			$attribs->size->width = (int) $element['width'];


		if ($element['height'] && (trim($element['height']) != 'auto'))
			$attribs->size->height = (int) $element['height'];



		// Attribs
		$attribs->attrs = new stdClass();


		$mapAttribs = array(
			'nocache' => 'BOOL',
			'fit' => 'BOOL',
			'crop' => 'BOOL',
			'rotate' => 'INT',
			'area' => 'STRING',
			'format' => 'STRING',
			'quality' => 'INT',
		);


		foreach($mapAttribs as $att => $filter)
		{
			if (isset($element[$att]))
			{
				$ignore = false;
				$value = $element[$att];
				switch($filter)
				{
					case 'BOOL':
						// In this case, continue and avoid the param
						if (!in_array(strtolower($value), array('1', 'true', 'yes')))
							$ignore = true;
						else
						// In case of bool, simply instance the property with a null value
							$value = null;


						break;
					case 'INT':
						$value = (int)$value;
						break;

					case 'STRING':

						break;
				}

				if (!$ignore)
					$attribs->attrs->$att = $value;
			}

		}



		// Filters
		if (isset($element['filters']))
		{
			// Filters
			$attribsFilters = static::decodeFiltersAttributes($element['filters']);

			if (count(get_object_vars($attribsFilters)))
				$attribs->filters = $attribsFilters;
		}


		// For raw download (target=download)
		if ($element['target'])
			$attribs->target = (string) $element['target'];



		return $attribs;
	}

	/**
	* Read the attributes from the request.
	*
	* @access	public static
	*
	* @return	array	Return an array of file attributes.
	*/
	public static function getAttributesFromInput()
	{
		$attribs = new \stdClass();

		$jinput = \JFactory::getApplication()->input;
		$size = $jinput->get('size', null, 'CMD');
		$att = $jinput->get('attrs', null, 'STRING');
		$filters = $jinput->get('filter', null, 'STRING');


		if ($size && preg_match("/([0-9]+)x([0-9]+)/", $size, $matches))
		{
			$attribs->size = new stdClass;
			$attribs->size->width = $matches[1];
			$attribs->size->height = $matches[2];
		}


		if (!is_array($att))
			$att = explode(",", $att);

		$attrs = new stdClass;
		foreach($att as $attribute)
		{
			if (preg_match("/^(.+):(.+)$/", $attribute, $matches))
			{
				$attribute = $matches[1];
				array_shift($matches);
				array_shift($matches);
				$params = $matches;
			}

			$value = (isset($params[0])?$params[0]:null);
			$name = $attribute;
			if (trim($name) == '')
				continue;

			$attrs->$name = $value;
		}

		if (count(get_object_vars($attrs)))
			$attribs->attrs = $attrs;


		// Filters
		if (!empty($filters))
		{
			$attribsFilters = static::decodeFiltersAttributes($filters);
			if (count(get_object_vars($attribsFilters)))
				$attribs->filters = $attribsFilters;
		}



		return $attribs;
	}

	/**
	* Convert the attribute of an image from the legacy format (array type).
	*
	* @access	public static
	* @param	array	$options	Attributes in legacy format, or from JDom.
	*
	* @return	array	Return an array of file attributes.
	*/
	public static function getAttributesFromLegacy($options)
	{
		$attribs = new stdClass();

		// Size
		$attribs->size = new stdClass();
		if (isset($options['width']) && (trim($options['width']) != 'auto'))
			$attribs->size->width = (int) $options['width'];


		if (isset($options['height']) && (trim($options['height']) != 'auto'))
			$attribs->size->height = (int) $options['height'];

		// Attribs
		$attribs->attrs = new stdClass();
		if (isset($options['attrs']))
		{
			foreach($options['attrs'] as $att)
			{
				switch($att)
				{
					case 'center': $attribs->attrs->center = true; break;
					case 'crop': $attribs->attrs->crop = true; break;
					case 'fit': $attribs->attrs->fit = true; break;

					default:

						$parts = explode(':', $att);

						if (count($parts) > 1)
						{
							switch ($parts[0])
							{
								case 'format':
									$attribs->attrs->format = $parts[1];

									break;

							}
						}

						break;
				}

			}

			if (in_array('center', $options['attrs']))
				$attribs->attrs->center = true;

			if (in_array('crop', $options['attrs']))
				$attribs->attrs->crop = true;

			if (in_array('fit', $options['attrs']))
				$attribs->attrs->fit = true;
		}


		// For raw download (target=download)
		if (isset($options['download']) && ($options['download']))
			$attribs->target = 'download';

		return $attribs;
	}

	/**
	* Generate the direct file url.
	*
	* @access	public static
	* @param	string	$path	File path. Can contain directories aliases.
	* @param	array	$attribs	File attributes for creating a transformed thumb of filtered image.
	*
	* @return	string	Url to access directly the file.
	*/
	public static function getDirectUrl($path, $attribs = null)
	{
		$urlFilePath = static::getDirectory($path);

		if ($attribs)
		{
			$filePath = static::getFilePhysical($path);

			// Image not found
			if (!file_exists($filePath))
				return '';

			// Create the thumb if missing
			static::getThumb($filePath, $attribs);

			$urlFilePath = static::thumbFileName($urlFilePath, $attribs);
		}

		$urlFilePath = JUri::root() . $urlFilePath;

		return $urlFilePath;
	}

	/**
	* Return the directories aliases full paths.
	*
	* @access	public static
	*
	* @return	array	Arrays of aliases relative path from site root.
	*/
	public static function getDirectories()
	{
		if (!empty(static::$directories))
			return static::$directories;

		$extension = static::$extension;

		$configMedias = \JComponentHelper::getParams('com_media');
		$config = \JComponentHelper::getParams($extension);

		$directoriesFields = self::$directoriesFields;

		$directories = array(
			'DIR_FILES' => "[COM_SITE]/files",
			'DIR_TRASH' => $config->get("trash_dir", 'images/trash'),
		);

		foreach($directoriesFields as $directoryField)
		{
			$parts = explode(':', $directoryField);
			if (count($parts) < 2)
				continue;

			$table = $parts[0];
			$field = $parts[1];


			$fieldAlias = strtolower($table) . '_' . strtolower($field);
			$dirAlias = 'DIR_' . strtoupper($fieldAlias);


			// Add directory entry, with default value
			$directories[$dirAlias] =  $config->get("upload_dir_$fieldAlias", "[COM_SITE]/files/$fieldAlias");


		}


		$bases = array(
			'COM_ADMIN' => "administrator/components/$extension",
			'ADMIN' => "administrator",
			'COM_SITE' => "components/$extension",
			'IMAGES' => $config->get('image_path', 'images'),

			// Root directory of the Media Manager. USes the Files Path config
			'MEDIAS' => $configMedias->get('file_path', 'images'),

			// Media folder, with a component suffix
			'COM_MEDIAS' => "media/$extension",
			'ROOT' => '',
		);



		// Parse the directory aliases
		foreach($directories as $alias => $directory)
		{
			// Parse the component base folders
			foreach($bases as $aliasBase => $directoryBase)
				$directories[$alias] = preg_replace("/\[" . $aliasBase . "\]/", $directoryBase, $directories[$alias]);

			// Clean tags if remains
			$directories[$alias] = preg_replace("/\[.+\]/", "", $directories[$alias]);
		}

		static::$directories = $directories;
		return static::$directories;
	}

	/**
	* Parse the directory aliases.
	*
	* @access	public static
	* @param	string	$path	File path. Can contain directories aliases.
	*
	* @return	string	Litteral unaliased file path or url.
	*/
	public static function getDirectory($path)
	{
		$markers = static::getDirectories();

		$foundDir = false;

		// Search and parse the folders aliases
		foreach($markers as $marker => $pathStr)
		{
			// Make sure at least one folder alias has been defined
			if (preg_match("/^\[" . $marker . "\]/", $path))
				$foundDir = true;

			$path = preg_replace("/^\[" . $marker . "\]/", $pathStr, $path);
		}

		// A Marker directory MUST be defined > Local File Inclusion security
		if (!$foundDir)
			return null;

		// Protect against Local File Inclusion
		$path = preg_replace("/\.\.+/", "", $path);

		return $path;
	}

	/**
	* Return the file extension. Manage special doubled extensions known in
	* class. (ex : tar.gz)
	*
	* @access	public static
	* @param	string	$file	Filename, can be a path
	*
	* @return	string	Return the File extention.
	*/
	public static function getExt($file)
	{
		foreach(static::$knownExtensions as $ext)
		{
			// Handle special case known extensions
			if ($pos = strrpos($file, '.' . $ext))
				if (($pos + strlen($ext) + 1) == strlen($file))
					return strtolower($ext);
		}

		return strtolower(JFile::getExt($file));
	}

	/**
	* Generate the physical file path.
	*
	* @access	public static
	* @param	string	$path	File path. Can contain directories aliases.
	* @param	array	$attribs	File attributes for creating a transformed thumb of filtered image.
	*
	* @return	string	Physical file location.
	*/
	public static function getFilePhysical($path, $attribs = null)
	{
		if ($attribs)
			$path = static::thumbFileName($path, $attribs);

		$dir = static::getDirectory($path);
		if (empty($dir))
			return null;

		return JPATH_ROOT .'/'. $dir;
	}

	/**
	* Return the file url of the given path.
	*
	* @access	public static
	* @param	string	$path	File path. Can contain directories aliases.
	* @param	string	$method	Method to access the file : [direct,indirect]
	* @param	array	$attribs	
	*
	* @return	string	File url.
	*/
	public static function getFileUrl($path, $method = 'indirect', $attribs = null)
	{
		switch ($method)
		{
			case 'direct':	// Direct file access url to the file thumb
				return static::getDirectUrl($path, $attribs);
				break;

			case 'indirect': // Indirect file access (through controller url)
			default:
				return static::getIndirectUrl($path, $attribs);
				break;
		}

		return $url;
	}

	/**
	* Return the file url of the given form field.
	*
	* @access	public static
	* @param	JForm	$form	Form containing the field
	* @param	JFormField	$element	Form field containing the file attributes
	* @param	string	$value	Value of the field containing a path.
	*
	* @return	string	File url.
	*/
	public static function getFileUrlFromElement($form, $element, $value)
	{
		$dir = $element['dir'];

		// Auto create the directory alias when missing
		if (!$dir)
		{
			// Prepare the directory alias from the context
			$model = $form->getModel()->getName();
			$field = $element['name'];
			$dir = 'DIR_' .strtoupper($model). '_' .strtoupper($field). '';


			// Search if this auto generated directory is known by the application, in case, use default
			$directories = static::getDirectories();
			if (!in_array($dir, array_keys($directories)))
				$dir = BDS_UPLOAD_DEFAULT_DIR;


			// Wrap in bracelets
			$dir = "[$dir]";
		}


		$method = ($element['method']?$element['method']:'direct');

		$indirectPath = $dir . '/' . $value;
		$attribs = BdsHelperFile::getAttributesFromElement($element);

		$url = (($method == 'indirect') && JFactory::getApplication()->isAdmin()?'administrator/':'')
			. BdsHelperFile::getFileUrl($indirectPath, $method, $attribs);

		return $url;
	}

	/**
	* Generate the Url to access the file through controller.
	*
	* @access	public static
	* @param	string	$path	File path. Can contain directories aliases.
	* @param	array	$attribs	File attributes for creating a transformed thumb of filtered image.
	*
	* @return	string	Indirect file url.
	*/
	public static function getIndirectUrl($path, $attribs = null)
	{
		$extension = static::$extension;

		$url = "index.php?option=$extension&task=file";

		$url .= static::urlThumbAttribs($attribs);

		//File name always at the end
		$url .= "&path=" . $path;

		return $url;
	}

	/**
	* Get the mime type header of a file.
	*
	* @access	public static
	* @param	string	$file	Complete physical file path
	*
	* @return	string	Mime type.
	*/
	public static function getMime($file)
	{
		if (!JFile::exists($file))
			return null;

		$mime = null;

		//prefered order methods to call the mime decodage
		$mimeMethods = array(
			'mime_content_type',
			'finfo_file',
			'image_check',
			'system',
			'shell_exec',
		);

		foreach($mimeMethods as $method)
		{
			if (!$mime)
			switch($method)
			{

				case 'system':
					if (!function_exists('system'))
						continue;

					$mime = system("file -i -b " . $file);
					break;

				case 'shell_exec':
					if (!function_exists('shell_exec'))
						continue;

					$mime = trim( @shell_exec( 'file -bi ' . escapeshellarg( $file ) ) );
					break;

				case 'mime_content_type':
					if (!function_exists('mime_content_type'))
						continue;
					$mime = mime_content_type($file);
					break;


				case 'finfo_file':
					if (!function_exists('finfo_file'))
						continue;
					$finfo = finfo_open(FILEINFO_MIME);
					$mime = finfo_file($finfo, $file);
					finfo_close($finfo);
					break;


				case 'image_check':
					$file_info = getimagesize($file);
					$mime = $file_info['mime'];
					break;

			}

		}

		//DEFAULT MIME
		if (!$mime)
			$mime = "application/force-download";

		return $mime;
	}

	/**
	* Get the known mimes table for the given extensions.
	*
	* @access	public static
	* @param	string|array	$filterExtensions	The extensions that we are interrested to know the mimes.
	*
	* @return	array	indexed array containing extensions and mimes types.
	*/
	public static function getMimeTable($filterExtensions = null)
	{
		if (!$filterExtensions)
			return static::$mimesTable;

		if (!is_array($filterExtensions))
		{
			// Can also uses comma
			$filterExtensions = preg_replace('/,/', '|', $filterExtensions);

			// Remove spaces
			$filterExtensions = preg_replace('/\s+/', '', $filterExtensions);
			$filterExtensions = explode('|', $filterExtensions);
		}

		$mimes = array();
		foreach(static::$mimesTable as $ext => $mime)
		{
			if (in_array($ext, $filterExtensions))
				$mimes[$ext] = $mime;
		}

		return $mimes;
	}

	/**
	* Create a thumb image according to the attributes in a cache file and return
	* the path to it.
	*
	* @access	public static
	* @param	string	$filePath	File path
	* @param	array	$attributes	File attributes for creating a transformed thumb of filtered image.
	*
	* @return	string	Thumb file name.
	*/
	public static function getThumb($filePath, $attributes)
	{
		// No not need to transform the image if non tranformations are requested.
		if (!static::hasTransformations($attributes))
			return $filePath;


		// Generate the expected thumb file name
		$thumbFileName = static::thumbFileName($filePath, $attributes);


		$attrs = new stdClass;
		if (isset($attributes->attrs) && $attributes->attrs)
			$attrs = $attributes->attrs;


		$w = $h = 0;
		if (isset($attributes->size))
		{
			$size = $attributes->size;
			if (isset($size->width))
				$w = (int)$size->width;


			if (isset($size->height))
				$h = (int)$size->height;
		}

		// Cache file already exists
		if (file_exists($thumbFileName) && !(property_exists($attrs, 'nocache')))
			return $thumbFileName;


		// Instance an Image object
		$image = new JImage($filePath);


		// Apply the filters
		$bgFill = null;
		if (isset($attributes->filters) && $attributes->filters && count($attributes->filters))
		{
			foreach($attributes->filters as $filter => $options)
			{
				// Format the filter parameters to array
				if (is_object($options))
					$options = JArrayHelper::fromObject($options);
				else if (!is_array($options))
					$options = array($options);


				// Apply Image filters
				$image->filter($filter, $options);

				if ($filter == 'backgroundfill')
					$bgFill = hexdec($options['color']);
			}
		}


		// Rotate the image (Always done before an eventual zoom)
		if (isset($attrs->rotate) && $rotate = $attrs->rotate)
		{
			$image->rotate((int)$rotate, (int)$bgFill, false);
		}



		// Apply CropArea : Crop the ORIGINAL image on Width, Height, Left, Right
		if (isset($attrs->area) && $area = $attrs->area)
		{
			$areaValues = explode(';', $area);

			$areaW = $areaH = $areaL = $areaT = null;
			if (count($areaValues) > 0)
				$areaW = (int)$areaValues[0];

			if (count($areaValues) > 1)
				$areaH = (int)$areaValues[1];

			if (count($areaValues) > 2)
				$areaL = (int)$areaValues[2];

			if (count($areaValues) > 3)
				$areaT = (int)$areaValues[3];

			$image->crop($areaW, $areaH, $areaL, $areaT, false);
		}


		// When one of the dimensions is empty (0, or 'auto'), retrieve the expected size
		if ($w xor $h)
			static::populateSizes($filePath, $w, $h);


		if ($w && $h)
		{
			// In case of crop, first scale image outside
			if (property_exists($attrs, 'crop'))
			{
				$thumbs = $image->generateThumbs(array($w .'x'. $h), JImage::SCALE_OUTSIDE);

				// Impossible to create thumb, return original file
				if (!count($thumbs))
					return $filePath;

				$image = $thumbs[0];
			}
		}


		// Cannot combine crop + fit (crop is prioritary)
		$creationMethod = JImage::SCALE_INSIDE;
		if (property_exists($attrs, 'crop'))
			$creationMethod = JImage::CROP;
		else if (property_exists($attrs, 'fit'))
			$creationMethod = JImage::SCALE_FILL;




		if ($w && $h)
		{
			$thumbs = $image->generateThumbs(array($w .'x'. $h), $creationMethod);

			// Impossible to create thumb, return original file
			if (!count($thumbs))
				return $filePath;

			$thumb = $thumbs[0];
		}
		else
		{
			// Keep original size file
			$thumb = $image;
		}


		$extFormat = strtolower(static::getExt($filePath));

		if (property_exists($attrs, 'format'))
			$extFormat = $attrs->format;


		$fileOptions = array();

		switch($extFormat)
		{
			case 'gif':
				$type = IMAGETYPE_GIF;
				break;

			case 'png':
				$type = IMAGETYPE_PNG;

				// For a PNG, the 'quality' represents a compression: From 0 (best quality) to 9 (smaller file)
				$quality = 8; // Default compression
				if (property_exists($attrs, 'quality'))
				{
					// For us, quality attribute is alawys between 0-100
					$compression = 100 - $attrs->quality; // Invert scale

					// Scale from 0 to 9
					$quality = round($compression/100 * 9);
				}

				$fileOptions['quality'] = $quality;
				break;

			case 'jpg':
			case 'jpeg':
			default:
				$type = IMAGETYPE_JPEG;

				$quality = 75; // Per default
				if (property_exists($attrs, 'quality'))
					$quality = $attrs->quality;

				$fileOptions['quality'] = $quality;
				break;
		}


		// Save thumb to file (override)
		$thumb->toFile($thumbFileName, $type, $fileOptions);

		return $thumbFileName;
	}

	/**
	* Return the authorized max upload size.
	*
	* @access	public static
	* @param	string	$string	Stringify the result, adding the unit.
	* @param	string	$maxSizeCustom	Restrict the max file size upload.
	*
	* @return	integer|string	Max file size.
	*/
	public static function getUploadMaxSize($string = false, $maxSizeCustom = null)
	{
		$maxSize = intval(ini_get('upload_max_filesize')) * 1024 * 1024;
		$config	= \JComponentHelper::getParams(static::$extension);
		$maxSizeConfig = (int)$config->get('upload_maxsize') * 1024 * 1024;

		if ($maxSizeConfig)
			$maxSize = min($maxSize, $maxSizeConfig);

		if ($maxSizeCustom)
			$maxSize = min($maxSize, $maxSizeCustom);

		if ($string)
			$maxSize = JText::sprintf("BDS_UPLOAD_MAX", static::bytesToString($maxSize));

		return $maxSize;
	}

	/**
	* Check if the attributes contains tranformations for the image.
	*
	* @access	protected static
	* @param	array	$attributes	File attributes for creating a transformed thumb of filtered image.
	*
	* @return	array	Return an array of transformations names if the requested image has transformations. Null otherwise
	*/
	protected static function hasTransformations($attributes)
	{
		$transformations = array();

		if (isset($attributes->size) && count(get_object_vars($attributes->size)))
			$transformations[] = 'size';

		// Check if ATTRS are defined
		if (isset($attributes->attrs) && count(get_object_vars($attributes->attrs)))
			$transformations[] = 'attrs';

		// Check if FILTERS are defined
		if (isset($attributes->filters) && count(get_object_vars($attributes->filters)))
			$transformations[] = 'filters';



		// No not need to transform the image if none of the previous tranformations are requested.
		if (!count($transformations))
			return null;

		return $transformations;
	}

	/**
	* Parse the renaming patterns.
	*
	* @access	protected static
	* @param	string	&$pattern	File name pattern to override.
	* @param	string	$name	Name of the pattern tag.
	* @param	string	$value	Value.
	*
	* @return	void
	*/
	protected static function parsePattern(&$pattern, $name, $value)
	{
		$name = strtoupper($name);

		if (preg_match("/{" . $name . "(\(.+\))?(\#?[0-9]+)?}/", $pattern))
		{
			//Trim to length
			if (preg_match("/{" . $name . "(\(.+\))?\#?[0-9]+}/", $pattern))
			{
				$length = static::patternLength($name, $pattern);

				$value = substr($value, 0, $length);
			}

			$pattern = preg_replace("/{" . $name . "(\(.+\))?(\#?[0-9]+)?}/", $value, $pattern);
		}
	}

	/**
	* Return the lenght specified in a tag pattern.
	*
	* @access	protected static
	* @param	string	$name	Tag name.
	* @param	string	$pattern	Pattern.
	*
	* @return	integer	Length.
	*/
	protected static function patternLength($name, $pattern)
	{
		$name = strtoupper($name);

		if (!preg_match("/{" . $name . "\#[0-9]+}/", $pattern))
			return;

		$length = preg_replace("/^(.+)?{" . $name . "(\(.+\))?\#?([0-9]+)(}(.+)?)$/", '$'.'3', $pattern);

		return $length;
	}

	/**
	* Get the params of a tag pattern.
	*
	* @access	protected static
	* @param	string	$name	Tag name.
	* @param	string	$pattern	Pattern.
	*
	* @return	string	Tag parameters.
	*/
	protected static function patternParam($name, $pattern)
	{
		$name = strtoupper($name);

		if (!preg_match("/{" . $name . "\(.+\)(\#[0-9]+)?}/", $pattern))
			return null;

		$param = preg_replace("/^(.+)?{" . $name . "\((.+)?\)\#?([0-9]+)?(}(.+)?)$/", '$'.'2', $pattern);

		return $param;
	}

	/**
	* Autopopulate the waited sizes when of of the dimensiosn are missing.
	*
	* @access	protected static
	* @param	string	$file	File path
	* @param	integer	&$width	Width size, can be null, or empty. In this case the value will be completed
	* @param	integer	&$height	Height size, idem than width
	*
	* @return	void
	*/
	protected static function populateSizes($file, &$width, &$height)
	{
		if ((int)$width && (int)$height)
			return;

		$properties = JImage::getImageFileProperties($file);
		$ratio = $properties->width / $properties->height;

		if (!(int)$width)
			$width = round($height * $ratio);
		else if (!(int)$height)
			$height = round($width / $ratio);
	}

	/**
	* Delete a file and possibly its thumbs.
	*
	* @access	public static
	* @param	string	$path	File path. Can contain directories aliases.
	* @param	string	$remove	Method to use (thumbs, trash, delete).
	*
	* @return	void
	*
	* @throws	Exception	When file cannot be moved to trash or deleted.
	*/
	public static function removeFile($path, $remove = 'delete')
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');

		$op = array('thumbs', 'trash', 'delete');
		$filePath = static::getFilePhysical($path);


		if (JFile::exists($filePath))
		{
			// Trash image
			if (in_array($remove, array('trash')))
			{
				$trashPath = static::getFilePhysical("[DIR_TRASH]");

				if (!JFolder::exists($trashPath))
					JFolder::create($trashPath);

				if (!JFile::move($filePath, $trashPath .'/'. JFile::getName($filePath)))
					throw new \Exception(JText::_("BDS_UPLOAD_TRASH_IMPOSSIBLE"));

			}

			// Delete image
			else if (in_array($remove, array('delete')))
			{
				if (!JFile::delete($filePath))
					throw new \Exception(JText::_("BDS_UPLOAD_DELETE_IMPOSSIBLE"));

			}
		}


		// What to do of the thumbs ?
		if (!in_array($remove, array('thumbs', 'trash', 'delete')))
			return;


		$dir = dirname($filePath);
		if (!JFolder::exists($dir))
			return;


		$fileName = JFile::getName($filePath);

		// Delete thumbs
		$len = strlen($fileName);
		foreach(JFolder::files($dir,'.',false,false,array('.svn', 'CVS','.DS_Store','__MACOSX'),array()) as $file)
			if (substr($file, 0, $len +1) == "_" . $fileName)
				JFile::delete($dir .'/'. $file);

		return true;
	}

	/**
	* Rewrite the file name before upload
	* PATTERNS :
	* 	{EXT}				: Original extension
	* 	{MIMEXT} 			: Corrected extension from Mime-header
	* 	{BASE}				: Original file name without extension
	* 	{ALIAS}				: Safe aliased original file name
	* 	{RAND}				: Randomized value
	* 	{DATE(Y-m-d)} 		: formated date
	* 	{ID}				: Current item id
	* 
	* MODIFIERS :
	* 	{[PATTERN]#6} 		: Limit to 6 chars
	*
	* @access	protected static
	* @param	string	&$file	Filename
	* @param	array	$options	Renaming options.
	*
	* @return	void
	*/
	protected static function renameFile(&$file, $options)
	{
		$pattern = (isset($options["rename"])?$options["rename"]:BDS_UPLOAD_DEFAULT_RENAME);

		if (isset($options['id']))
		{
			//Original extension
			static::parsePattern($pattern, "ID", $options['id']);
		}

		//Original extension
		static::parsePattern($pattern, "EXT", $file->extension);


		// Corrected extension from Mime-header
		$mimeExt = null;
		if ($file->mime)
		{
			// Search in the mimes table
			foreach(static::$mimesTable as $ext => $mime)
			{
				if (!$mimeExt && ($file->mime == $mime))
					$mimeExt = $ext;
			}
		}


		if (!$mimeExt)
			// Fallback, use the regular extension if mime not found, so the MIMEXT pattern is replaced
			$mimeExt = $file->extension;


		static::parsePattern($pattern, "MIMEXT", $mimeExt);


		//Original file name without extension
		static::parsePattern($pattern, "BASE", $file->base);


		//Convert spaces
		$spaces = (isset($options['spaces'])?$options['spaces']:'');
		$pattern = preg_replace("/\s+/", $spaces, $pattern);


		//Safe aliased original file name
		static::parsePattern($pattern, "ALIAS", static::createAlias($file->base, 'lower'));


		//Randomized value
		$length = static::patternLength("RAND", $pattern);
		static::parsePattern($pattern, "RAND", static::createRandomAlias($length));

		// Format the date  : DATE(format)
		$format = static::patternParam("DATE", $pattern);
		if (!$format)
			$format = "Y-m-d";

		static::parsePattern($pattern, "DATE", date($format));


		//remove backdir
		$pattern = preg_replace("/\.\./", "", $pattern);

		//Non empty string
		if (trim($pattern) == "")
			$pattern = static::createRandomAlias(8);

		$file->filename = $pattern;



		$file->base = static::stripExt($file->filename);
		$file->extension = static::getExt($file->filename);
	}

	/**
	* Indirect File Access. Output a file on request.
	*
	* @access	public static
	*
	* @return	void
	*
	* @throws	Exception	When the given thumb size is not supported.
	*/
	public static function returnFile()
	{
		$extension = static::$extension;

		$jinput = JFactory::getApplication()->input;

		$path = $jinput->get('path', null, 'STRING');
		$action = $jinput->get('action', null, 'CMD');

		if (!$path)
			jexit();


		// Read the attributes configuration for this thumb
		$attributes = static::getAttributesFromInput();


		$filePath = static::getFilePhysical($path);
		$ext = JFile::getExt($filePath);


		jimport('joomla.filesystem.file');

		// Files recognized as images, thumbs are availables
		$imagesExt = array('jpg', 'jpeg', 'gif', 'png', 'bmp');

		// System files forbidden to download
		$forbiddenExt = array('php', 'xml', 'ini', 'sql', 'js');


		$mime = null;
		if ($action == 'download')
			$mime = 'application/force-download';  // OU    application/octet-stream
		else if (JFile::exists($filePath))
			$mime = static::getMime($filePath);

		$isImage = false;

		if (
			($action != 'download') &&
			(in_array($ext, $imagesExt)						//Check on file extension
			|| ($mime && preg_match("/^image/", $mime)))	//Check on fiel mime type
			)
		{


			if ($size = $attributes->size)
			{
				$w = (int)min($size->width, BDS_IMAGES_MAX_WIDTH);
				$h = (int)min($size->height, BDS_IMAGES_MAX_HEIGHT);


				$size =  $w ."x". $h;


				//CREATE PHYSICAL THUMB
				if (($size != "0x0") && !in_array($size, explode(",", BDS_IMAGES_ALLOWED_SIZES)))
				{
					throw new \Exception(JText::_("This image size is not supported"));
				}
			}


			// Create a thumb when $attributes are defined, skip otherwise
			$filePath = static::getThumb($filePath, $attributes);

			$isImage = true;
		}


		// File not founded or not allowed to download.
		else if (!JFile::exists($filePath) || in_array($ext, $forbiddenExt))
		{
			$pathNoDir = preg_replace('/^\[[A-Z_]+\]\/?/', "", $path);
			$msg = JText::sprintf( "BDS_UPLOAD_FILE_NOT_FOUND", $pathNoDir);
			jexit($msg);
		}


		// Force download : For non image and non outputable mimes
		// When action=download, the mime has already been changed, so it naturaly enters here
		if (!$isImage && !in_array($mime, array(
			'application/x-shockwave-flash'
		))){
			header('Content-Description: File Transfer');
		    header("Content-Disposition: attachment; filename=\"".basename($filePath) . "\"");
		}


		//Read and return file contents with original mime header
		header('Content-Type: ' . $mime);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		ob_clean();
		flush();

		readfile($filePath);

		jexit();
	}

	/**
	* Sanitize a folder.
	*
	* @access	public static
	* @param	string	$path	The path folder to sanitize.
	*
	* @return	string	Cleaned path.
	*
	* @throws	Exception	When the the folder is not writable.
	*/
	public static function sanitizeFolder($path)
	{
		$folder = static::getFilePhysical($path);
		if (empty($folder))
			return;

		jimport('joomla.filesystem.folder');

		//Clean upload path
		$folder = JPath::clean(html_entity_decode($folder . '/'));
		$folder = JPath::clean($folder);


		//Check if upload directory exists
		if(!is_dir($folder))
			JFolder::create($folder);

		if (!is_dir($folder))
			return false;


		// Place a index.html file in folder for preventing users to list folder contents
		static::blankFiles($folder);


		//Protect against execution and set writable
		@chmod($folder, BDS_UPLOAD_CHMOD_FOLDER);
		if(!is_writable($folder))
			throw new \Exception(JText::sprintf( "BDS_UPLOAD_READONLY_FOLDER",$path));

		return true;
	}

	/**
	* Return the file base name. Manage special doubled extensions known in
	* class. (ex : tar.gz)
	*
	* @access	public static
	* @param	string	$file	Filename, can be a path
	*
	* @return	string	Return the Filename (and path), without extention.
	*/
	public static function stripExt($file)
	{
		foreach(static::$knownExtensions as $ext)
		{
			// Handle special case known extensions
			if ($pos = strrpos($file, '.' . $ext))
				if (($pos + strlen($ext) + 1) == strlen($file))
					return substr($file, 0, $pos);
		}


		return JFile::stripExt($file);
	}

	/**
	* Rename the file if it already exists.
	*
	* @access	protected static
	* @param	string	$dir	Base directory.
	* @param	object	$file	File object containing all major informations (name, extension, mime, ...).
	*
	* @return	string	True is already present, False otherwise.
	*/
	protected static function suffixIfExists($dir, $file)
	{
		if (static::checkFileExists($dir, $file))
		{
			$suffix = 1;
			while(static::checkFileExists($dir, $file, $suffix))
				$suffix++;

			$file->base = $file->base . "-" . $suffix;
			$file->filename = $file->base . "." . $file->extension;
		}
	}

	/**
	* Create the thumb filename according to the attributes. Thumbs are cached
	* and name depends of attributes, filters and size. Not all attributes are
	* affecting the name.
	*
	* @access	public static
	* @param	string	$filePath	File path
	* @param	array	$attributes	File attributes for creating a transformed thumb of filtered image.
	*
	* @return	string	Thumb file name.
	*/
	public static function thumbFileName($filePath, $attributes)
	{
		// No not need to transform the image path if no tranformations are requested.
		if (!static::hasTransformations($attributes))
			return $filePath;

		$dir = dirname($filePath);
		$name = JFile::getName(static::stripExt($filePath));
		$ext = strtolower(static::getExt($filePath));

		$attrs = $attributes->attrs;

		$opts = "";
		$thumbExt = $ext;

		if ($attrs)
		{

			if (isset($attrs->crop) && $attrs->crop)
				$opts .= "c";

			if (isset($attrs->fit) && $attrs->fit)
				$opts .= "f";

			if (isset($attrs->center) && $attrs->center)
				$opts .= "m";

			if (isset($attrs->rotate) && $attrs->rotate)
				$opts .= "r";

			if (isset($attrs->area) && $attrs->area)
				$opts .= "a";


			if (isset($attrs->format) && in_array($attrs->format, array('jpeg', 'jpg', 'gif', 'png')))
				$thumbExt = ($attrs->format=='jpeg'?'jpg':$attrs->format);

		}


		$optFilters = "";
		if (isset($attributes->filters) && count($attributes->filters))
		{
			foreach($attributes->filters as $filter => $value)
				$optFilters .= substr($filter, 0, 2);
		}

		$w = $h = 0;
		if (isset($attributes->size))
		{
			$size = $attributes->size;
			if (isset($size->width))
				$w = (int)$size->width;


			if (isset($size->height))
				$h = (int)$size->height;
		}


		$thumbName =
			// Same Directory
				$dir . '/'

			// Thumb prefix character
			.	'_'

			// Original name + original extension
			. 	$name .'.'. $ext

			// Concat with size
			.	(($w || $h)?'-' . $w . 'x' . $h:'')

			// Codificate some attribs options for cache (not all options)
			.	(($opts != "")?'-'. $opts:'')

			// Codificate filters attribs options for cache
			.	(($optFilters != "")?'!'. $optFilters:'')


			// Eventually change the extensions if format attribute is specified
			.	'.'. $thumbExt;



		return $thumbName;
	}

	/**
	* Method to update a file and eventually upload.
	*
	* @access	public static
	* @param	DataModel	$model	The model attempting to update a file field.
	* @param	string	$fieldName	Name of the field storing the file path.
	* @param	array	$options	Some options for the upload.
	* @param	string	$dir	Root folder (can be a pattern).
	*
	* @return	boolean	True when the filename has been changed, Null otherwise.
	*/
	public static function updateFile($model, $fieldName, $options = array(), $dir = null)
	{
		if (!$dir)
			$dir = '[DIR_' . strtoupper($model->getName() . '_' . $fieldName) . ']';

		// Init some global vars
		$config	= \JComponentHelper::getParams(static::$extension);

		$jinput = JFactory::getApplication()->input;

		//Get the submited files
		$fileInput = new \JInput($_FILES);
		$uploadFile = $fileInput->get($fieldName, null, 'array');


		// Get file from a jform[] group POST (native Joomla)
		if (!$uploadFile && ($uploadFiles = $fileInput->get('jform', null, 'array')))
		{
			$uploadFile = array();
			//Process a conversion to get the right datas
			if (!empty($uploadFiles))
				foreach($uploadFiles as $key => $params)
					$uploadFile[$key] = $params[$fieldName];
		}



		// Send the id for eventual name or path parsing in upload
		$options['id'] = $model->getId();

		// Copy the result item in the options, in order to be able to get some informations during the renaming process
		$options['item'] = $model->getItem();

		if ($jform = $jinput->get('jform', null, 'array'))
		{
			$remove	= (isset($jform[$fieldName . '-remove'])?$jform[$fieldName . '-remove']:null);
			$previous	= (isset($jform[$fieldName . '-current'])?$jform[$fieldName . '-current']:null);
		}
		else
		{

			// Remove parameter
			$remove	= $jinput->get($fieldName . '-remove', null, 'CMD');
			// Previous value parameter
			$previous	= $jinput->get($fieldName . '-current', null, 'STRING');
		}


		// Upload file name
		$upload = (isset($uploadFile['name'])?$uploadFile['name']:null);


		// New value
		$fileName = null;

		//Check method
		$method = '';
		$changed = false;
		if (!empty($upload))
		{
			$method = 'upload';
			$changed = ($upload != $previous);
		}


		//Check if needed to delete files
		if (in_array($remove, array('remove', 'delete', 'thumbs', 'trash')))
		{
			$fileName = "";		//Clear DB link (remove)
			$changed = true;

			//Process physical removing of the files (All, only thumbs, Move to trash)
			if (in_array($remove, array('delete', 'thumbs', 'trash')))
			{
				$f = (preg_match("/\[.+\]/", $previous)?"":$dir.'/') . $previous;

				static::removeFile($f, $remove);
			}
		}



		// Process Upload
		if ($method == 'upload')
		{

			$result = static::uploadFile($dir, $uploadFile, $options);

			// Very important to avoid infinite loop in some cases : Unset the post when the file is transferred
			unset($_FILES[$fieldName]);


			$fileName = $result->filename;
			$changed = true;

		}

		if ($changed)
		{
			return $fileName;
		}

		return null;
	}

	/**
	* File uploader.
	*
	* @access	public static
	* @param	string	$dir	The base directory where to upload.
	* @param	array	$uploadFile	The file object comming from the $_FILE request. Contains major informations.
	* @param	array	$options	Some upload options.
	*
	* @return	object	File object containing the formated datas.
	*
	* @throws	Exception	Various possible errors when upload fail (Empty file, Forbiden file, Too big, ...).
	*/
	public static function uploadFile($dir, $uploadFile, $options = array())
	{
		$dir = static::getFilePhysical($dir);

		if (!$dir)
			throw new \Exception(JText::_("BDS_UPLOAD_FOLDER_NOT_FOUND"));

		static::sanitizeFolder($dir);


		$config	= \JComponentHelper::getParams(static::$extension);
		$checkMime = $config->get('upload_check_mime', true);


		$maxSize = static::getUploadMaxSize();

		//Overwrite maxSize
		if (isset($options["maxSize"]))
			$maxSize = $options["maxSize"];



		//File name is empty
		if(empty($uploadFile['name']))
			throw new \Exception(JText::_("BDS_UPLOAD_PLEASE_BROWSE"));


		// More easy to handle all informations relative to the file in a grouped object, in case...
		$file = new stdClass();

		$file->filename = $uploadFile['name'];
		$file->tmp = $uploadFile['tmp_name'];
		$file->size = $uploadFile['size'];

		$file->extension = static::getExt($file->filename);
		if ($checkMime)
			$file->mime = static::getMime($file->tmp);
		$file->base = static::stripExt($file->filename);


		$extensions = static::getMimeTable(isset($options['extensions'])?$options['extensions']:null);


		// Check extension
		if (!in_array($file->extension, array_keys($extensions)))
		{
			throw new \Exception(JText::sprintf( "BDS_UPLOAD_REFUSED_EXTENSION",
				$file->extension,
				implode(",", array_keys($extensions))
			));
		}



		// Check Mime header
		if ($checkMime)
		if (!in_array($file->mime, $extensions))
		{
			throw new \Exception(JText::sprintf( "BDS_UPLOAD_REFUSED_MIME",
				$file->mime,
				implode(" - ", $extensions))
			);
		}



		//CHECK SIZE
		if ($file->size > $maxSize)
		{
			throw new \Exception(JText::sprintf( "BDS_UPLOAD_REFUSED_SIZE",
				static::bytesToString($file->size),
				static::bytesToString($maxSize)));
		}


		// Check PHP injection
		$contents = JFile::read($file->tmp);
		if (preg_match("/\<\?php\s/", $contents))
			throw new \Exception(JText::_( "BDS_UPLOAD_CONTAINS_ERRORS"));



		// Rename the file
		static::renameFile($file, $options, $extensions);



		// Check file presence, prefix the file AFTER rename, or skip it if override in options
		static::checkFilePresence($dir, $file, $options);



		//PROCESS UPLOAD
		if (!static::uploadFileProcess($dir, $file->filename, $file->tmp))
		{

		}

		return $file;
	}

	/**
	* Process the upload.
	*
	* @access	protected static
	* @param	string	$dirBase	The base directory where to upload.
	* @param	array	$filePath	The physical file path where to upload.
	* @param	array	$fileTmp	The file to upload (temporaly file when called from post $_FILES).
	*
	* @return	boolean	True on success, False otherwise.
	*
	* @throws	Exception	When php upload function fail for unknwon reason.
	*/
	protected static function uploadFileProcess($dirBase, $filePath, $fileTmp)
	{
		$dirBase = JPath::clean($dirBase);

		//Clean the (eventually renamed) path
		$filePath = JPath::clean($filePath);


		//Check if upload autocreate directory exists + Create index.html
		$relDir = dirname($filePath);

		//Create the directories and protect with index.html empty file
		static::blankFiles($dirBase, $relDir);

		//Upload file
		$fileDest = $dirBase .'/'. $filePath;
		if (!move_uploaded_file($fileTmp, $fileDest))
			if(!JFile::upload($fileTmp, $fileDest))
			{

				throw new \Exception(JText::sprintf( "BDS_UPLOAD_ERROR_UPLOAD", $file->filename));
			}


		//Protect file against execution
		@chmod($fileDest, BDS_UPLOAD_CHMOD_FILE);

		return true;
	}

	/**
	* Generate the url params corresponding to the requested attributes.
	*
	* @access	public static
	* @param	array	$attribs	File attributes for creating a transformed thumb of filtered image.
	*
	* @return	string	Url suffix containing the attributes to call the controller.
	*/
	public static function urlThumbAttribs($attribs = null)
	{
		if (!$attribs)
			return;

		$params = '';

		// Sizes
		if (isset($attribs->size) && $s = $attribs->size)
		{
			$w = (isset($s->width)?$s->width:0);
			$h = (isset($s->width)?$s->height:0);

			if ($w || $h)
				$params .= "&size=" . $w ."x". $h;
		}

		// Attributes
		if (isset($attribs->attrs) && $attrs = $attribs->attrs)
		{
			$att = array();
			foreach(get_object_vars($attrs) as $attr => $value)
			{
				$att[] = $attr . ($value?':'.$value:'');
			}

			if (count($att))
				$params .= "&attrs=" . implode(",", $att);
		}


		// Filters
		$filters = array();
		if (isset($attribs->filters) && $attribs->filters && count(get_object_vars($attribs->filters)))
		{
			foreach(get_object_vars($attribs->filters) as $filter => $value)
			{
				if (is_object($value))
					$value = JArrayHelper::fromObject($value);

				if (is_array($value))
				{
					$keys = array_keys($value);
					if (!is_array($keys))
					    $keys = array(0);

					$value = $value[$keys[0]];
				}

				$filters[] = $filter . ($value?':'.$value:'');
			}
		}

		if (count($filters))
			$params .= "&filter=" . implode(",", $filters);


		// Action download
		if (isset($attribs->target) && $attribs->target == 'download')
			$params .= "&action=download";

		return $params;
	}


}



