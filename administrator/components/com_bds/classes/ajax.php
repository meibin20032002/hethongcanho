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
* Ajax Class for Bds.
*
* @package	Bds
* @subpackage	Class
*/
class BdsClassAjax extends JObject
{
	/**
	* Cook Self Service proposal transaction format. Communicate with 'Hook', our
	* Ajax framework.
	*
	* @access	public static
	* @param	array	$options	Options
	* @param	string	$version	Version of the Hook header.
	*
	*
	* @since	Cook 2.6.5
	*
	* @return	string	Return a JSON string from the controller result.
	*/
	public static function responseHook($options = array(), $version)
	{
		if (!isset($options['renderExceptions']))
			$options['renderExceptions'] = 'HTML';

		$return = (object)array(
			//format of the JSON transaction. May change through versions, this header is for preventing conflicts.
			'header' => 'hook-' . $version,

			// Transaction handle the ajax system, errors, events, etc...
			'transaction' => new stdClass(),

			// Response handle datas in different formats (HTML, JSON, ...)
			'response' => new stdClass()
		);


		$result = true;

		// Handle errors
		if (isset($options['result']))
		{
			$result = $options['result'];
		}


		// Check if errors
		$app = JFactory::$application;
		if (is_callable(array($app, 'getMessageQueue')))
		{
			$messages = $app->getMessageQueue();

			// Build the sorted messages list
			if (is_array($messages) && count($messages))
				foreach ($messages as $message)
					if (isset($message['type']) && isset($message['message']))
						if ($message['type'] == 'error')
							$result = false;
		}

		switch(strtoupper($options['renderExceptions']))
		{
			case 'IGNORE':
				// Do not send any exceptions
				break;

			case 'HTML':
				$return->transaction->htmlExceptions = BdsClassView::renderMessages('HTML');
				break;

			case 'TEXT':
				$return->transaction->rawExceptions = BdsClassView::renderMessages('TEXT');
				break;

			case 'JSON':
			default:

				if (version_compare($version, '1.0', '<='))
				{
					$app = JFactory::$application;
					$messages = $app->getMessageQueue();

					// Return the Joomla exceptions in the same object structure as the Joomla exceptions
					$return->transaction->exceptions = $messages;
				}
				else
				{
					// Since Hook 1.1 : Return sorted array
					$return->transaction->exceptions = BdsClassView::renderMessages(null);

				}

				break;
		}

		$return->transaction->result = $result;

		// Optional vars in TRANSACTION
		if (isset($options['message']))
			$return->transaction->message = $options['message'];

		if (isset($options['refresh']))
			$return->transaction->refresh = $options['refresh'];

		if (isset($options['redirect']))
			$return->transaction->redirect = $options['redirect'];

		if (isset($options['redirectTarget']))
			$return->transaction->redirectTarget = $options['redirectTarget'];


		// Optional vars in RESPONSE
		if (isset($options['data']))
			$return->response->data = $options['data'];

		if (isset($options['headers']))
			$return->response->headers = $options['headers'];


		$buffer = ob_get_clean();
		// At the very end.
		$return->response->html = $buffer;
		if (isset($options['html']))
			$return->response->html .= $options['html'];


		jexit(json_encode($return));
	}

	/**
	* Uses the native Joomla transaction format. (JResponseJson)
	*
	* @access	public static
	* @param	array	$options	Options
	*
	*
	* @since	Cook 2.6.5
	*
	* @return	string	Return a JSON string from the controller result.
	*/
	public static function responseJoomla($options = array())
	{
		$response = $options['data'];
		$message = $options['message'];
		$error = !$options['result'];

		$ignoreMessages = false;
		if (isset($options['renderExceptions']) && strtoupper($options['renderExceptions']) == 'IGNORE')
			$ignoreMessages = true;

		// Joomla native
		$response = new JResponseJson($response, $message, $error, $ignoreMessages);

		jexit($response);
	}

	/**
	* Handle transaction informations in JSON response.
	*
	* @access	public static
	* @param	array	$options	Options
	* @param	string	$header	Header format. determines the map of the object.
	*
	*
	* @since	Cook 2.6.3
	*
	* @return	string	Return a JSON string from the controller result.
	*/
	public static function responseJson($options = array(), $header = 'hook-1.1')
	{
		// When native Joomla respnse class not exists, use the latest Hook handler
		if (($header == 'joomla') && (!class_exists('JResponseJson')))
			$header = null;

		switch ($header)
		{
			case 'joomla':
				self::responseJoomla($options);
				break;


			case 'hook-1.0':
				self::responseHook($options, '1.0');
				break;


			case 'hook-1.1':
			default:
				self::responseHook($options, '1.1');
				break;
		}
	}


}



