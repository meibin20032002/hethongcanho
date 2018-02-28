<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2014 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RsformControllerSubmissions extends RsformController
{
	function __construct()
	{
		parent::__construct();
		
		$this->registerTask('apply', 			'save');
		$this->registerTask('exportCSV', 		'export');
		$this->registerTask('exportODS', 		'export');
		$this->registerTask('exportExcel', 		'export');
		$this->registerTask('exportExcelXML', 	'export');
		$this->registerTask('exportXML', 		'export');
		
		$this->_db = JFactory::getDbo();
	}

	function manage()
	{
		$app	= JFactory::getApplication();
		$model	= $this->getModel('submissions');
		$formId = $model->getFormId();
		
		// if the form is changed we need to reset the limitstart
		$app->setUserState('com_rsform.submissions.limitstart', 0);
		
		$app->redirect('index.php?option=com_rsform&view=submissions'.($formId ? '&formId='.$formId : ''));
	}
	
	function back() {
		$app	= JFactory::getApplication();
		$formId = $app->input->getInt('formId');
		$app->redirect('index.php?option=com_rsform&view=submissions&formId='.$formId);
	}
	
	function edit()
	{
		$model = $this->getModel('submissions');
		$cid   = $model->getSubmissionId();
		$app = JFactory::getApplication();
		$app->redirect('index.php?option=com_rsform&view=submissions&layout=edit&cid='.$cid);
	}
	
	function columns()
	{
		$app 	= JFactory::getApplication();
		$formId = JFactory::getApplication()->input->getInt('formId');
		
		$this->_db->setQuery("DELETE FROM #__rsform_submission_columns WHERE FormId='".$formId."'");
		$this->_db->execute();
		
		$staticcolumns = JRequest::getVar('staticcolumns', array());
		foreach ($staticcolumns as $column)
		{
			$this->_db->setQuery("INSERT INTO #__rsform_submission_columns SET FormId='".$formId."', ColumnName='".$this->_db->escape($column)."', ColumnStatic='1'");
			$this->_db->execute();
		}
		
		$columns = JRequest::getVar('columns', array());
		foreach ($columns as $column)
		{
			$this->_db->setQuery("INSERT INTO #__rsform_submission_columns SET FormId='".$formId."', ColumnName='".$this->_db->escape($column)."', ColumnStatic='0'");
			$this->_db->execute();
		}
		
		$app->redirect('index.php?option=com_rsform&view=submissions&formId='.$formId);
	}
	
	function save()
	{
		// Get the model
		$model = $this->getModel('submissions');
		
		// Save
		$model->save();
		
		$task = $this->getTask();
		switch ($task)
		{
			case 'apply':
				$cid  = $model->getSubmissionId();
				$link = 'index.php?option=com_rsform&view=submissions&layout=edit&cid='.$cid;
			break;
		
			case 'save':
				$link = 'index.php?option=com_rsform&view=submissions';
			break;
		}
		
		$this->setRedirect($link, JText::_('RSFP_SUBMISSION_SAVED'));
	}
	
	function resend()
	{
		$app 	= JFactory::getApplication();
		$formId = JFactory::getApplication()->input->getInt('formId');
		$cid 	= JRequest::getVar('cid', array(), 'post');
		JArrayHelper::toInteger($cid);
		
		foreach ($cid as $SubmissionId)
			RSFormProHelper::sendSubmissionEmails($SubmissionId);
		
		$this->setRedirect('index.php?option=com_rsform&view=submissions&formId='.$formId, JText::_('RSFP_SUBMISSION_MAILS_RESENT'));
	}
	
	function cancel()
	{
		$app = JFactory::getApplication();
		$app->redirect('index.php?option=com_rsform');
	}
	
	function cancelForm()
	{
		$app 	= JFactory::getApplication();
		$formId = $app->input->getInt('formId');
		$app->redirect('index.php?option=com_rsform&view=forms&layout=edit&formId='.$formId);
	}
	
	function clear()
	{
		$app 	= JFactory::getApplication();
		$formId = JFactory::getApplication()->input->getInt('formId');
		$model 	= $this->getModel('submissions');
		
		$model->deleteSubmissionFiles($formId);
		$total = $model->deleteSubmissions($formId);
		
		$this->setRedirect('index.php?option=com_rsform&view=forms', JText::sprintf('RSFP_SUBMISSIONS_CLEARED', $total));
	}
	
	function delete()
	{
		$app 	= JFactory::getApplication();
		$formId = JFactory::getApplication()->input->getInt('formId');
		$cid 	= JRequest::getVar('cid', array(), 'post');
		JArrayHelper::toInteger($cid);
		
		$model = $this->getModel('submissions');
		$model->deleteSubmissionFiles($cid);
		$model->deleteSubmissions($cid);
		
		$app->redirect('index.php?option=com_rsform&view=submissions&formId='.$formId);
	}
	
	function export()
	{
		$app 	  = JFactory::getApplication();
		$config   = JFactory::getConfig();
		$tmp_path = $config->get('tmp_path');
		if (!is_writable($tmp_path))
		{
			$app->enqueueMessage(JText::sprintf('RSFP_EXPORT_ERROR_MSG', $tmp_path), 'warning');
			$app->redirect('index.php?option=com_rsform&view=submissions');
		}
		
		$view 	= $this->getView('submissions', 'html');
		$model 	= $this->getModel('submissions');
		$view->setLayout('export');
		$view->setModel($model, true);
		
		$view->display();
	}
	
	function exportProcess()
	{
		$mainframe = JFactory::getApplication();
		
		$config = JFactory::getConfig();
	
		// Get post
		$session = JFactory::getSession();
		$post = $session->get('com_rsform.export.data', serialize(array()));
		$post = unserialize($post);
		
		// Limit
		$start = JFactory::getApplication()->input->getInt('exportStart');
		$mainframe->setUserState('com_rsform.submissions.limitstart', $start);
		$limit = JFactory::getApplication()->input->getInt('exportLimit', 500);
		$mainframe->setUserState('com_rsform.submissions.limit', $limit);
		
		// Tmp path
		$tmp_path = $config->get('tmp_path');
		$file = $tmp_path.'/'.$post['ExportFile'];
		
		$formId = $post['formId'];
		
		// Type
		$type = strtolower($post['exportType']);
		
		// Selected rows or all rows
		$rows = !empty($post['ExportRows']) ? explode(',', $post['ExportRows']) : '';
		
		// Use headers ?
		$use_headers = (int) $post['ExportHeaders'];
		
		// Headers and ordering
		$staticHeaders = $post['ExportSubmission'];
		$headers = $post['ExportComponent'];
		$order = $post['ExportOrder'];
		
		// Remove headers that we're not going to export
		foreach ($order as $name => $id)
		{
			if (!isset($staticHeaders[$name]) && !isset($headers[$name]))
				unset($order[$name]);
		}
		
		// Adjust order array
		$order = array_flip($order);
		ksort($order);
		
		$model = $this->getModel('submissions');
		$model->export = true;
		$model->rows = $rows;
		$model->_query = $model->_buildQuery();
		$submissions = $model->getSubmissions();
		
		// CSV Options
		if ($type == 'csv')
		{
			$delimiter = str_replace(array('\t', '\n', '\r'), array("\t","\n","\r"), $post['ExportDelimiter']);
			$enclosure = str_replace(array('\t', '\n', '\r'), array("\t","\n","\r"), $post['ExportFieldEnclosure']);
			
			// Create and open file for writing if this is the first call
			// If not, just append to the file
			// Using fopen() because JFile::write() lacks such options
			$handle = fopen($file, $start == 0 ? 'w' : 'a');
			
			if ($start == 0 && $use_headers)
			{
				fwrite($handle, $enclosure.implode($enclosure.$delimiter.$enclosure,$order).$enclosure);
				fwrite($handle, "\n");
			}
			
			if (empty($submissions))
			{
				fclose($handle);
				// Adjust pagination
				$mainframe->setUserState('com_rsform.submissions.limitstart', 0);
				$mainframe->setUserState('com_rsform.submissions.limit', JFactory::getConfig()->get('list_limit'));
				echo 'END';
			}
			else
			{
				foreach ($submissions as $submissionId => $submission)
				{
					foreach ($order as $orderId => $header)
					{
						if (isset($submission['SubmissionValues'][$header]))
						{
							$submission['SubmissionValues'][$header]['Value'] = str_replace(array("\r\n", "\r"), "\n", $submission['SubmissionValues'][$header]['Value']);
							// Is this right ?
							if (strpos($submission['SubmissionValues'][$header]['Value'],"\n") !== false)
								$submission['SubmissionValues'][$header]['Value'] = str_replace("\n",' ',$submission['SubmissionValues'][$header]['Value']);
						}
						fwrite($handle, $enclosure.(isset($submission['SubmissionValues'][$header]) ? str_replace(array('\\r','\\n','\\t',$enclosure), array("\015","\012","\011",$enclosure.$enclosure), $submission['SubmissionValues'][$header]['Value']) : (isset($submission[$header]) ? $submission[$header] : '')).$enclosure.($header != end($order) ? $delimiter : ""));
					}
					fwrite($handle, "\n");
				}
				fclose($handle);
			}
		}
		// Excel XML Options
		elseif ($type == 'excelxml')
		{
			require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/excelxml.php';
			
			$xls = new RSFormProXLS($model->getFormTitle());
			$xls->open($file, $start == 0 ? 'w' : 'a');
			
			if ($start == 0 && $use_headers)
				$xls->writeHeaders($order);
			
			if (empty($submissions))
			{
				$xls->close();
				// Adjust pagination
				$mainframe->setUserState('com_rsform.submissions.limitstart', 0);
				$mainframe->setUserState('com_rsform.submissions.limit', JFactory::getConfig()->get('list_limit'));
				echo 'END';
			}
			else
			{
				$array = array();
				foreach ($submissions as $submissionId => $submission)
				{
					$item = array();
					foreach ($order as $orderId => $header)
					{
						if (isset($submission['SubmissionValues'][$header]))
							$item[$header] = $submission['SubmissionValues'][$header]['Value'];
						elseif (isset($submission[$header]))
							$item[$header] = $submission[$header];
						else
							$item[$header] = '';
					}
					
					$array[] = $item;
				}
				$xls->write($array);
				$xls->close();
			}
		}
		// Excel Options
		elseif ($type == 'excel')
		{
			require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/excel.php';
			
			$xls = new RSFormProXLSX();
			$xls->name 			= $model->getFormTitle();
			$xls->useHeaders 	= $use_headers;
			
			if ($start == 0) {
				$xls->open($file, 'w', $start, $model->getTotal(), count($order) - 1);
			} else {
				$xls->open($file, 'a', $start);
			}
			
			if ($start == 0 && $use_headers) {
				$xls->writeHeaders($order);
			}
			
			if (empty($submissions))
			{
				$xls->close();
				// Adjust pagination
				$mainframe->setUserState('com_rsform.submissions.limitstart', 0);
				$mainframe->setUserState('com_rsform.submissions.limit', JFactory::getConfig()->get('list_limit'));
				echo 'END';
			}
			else
			{
				$array = array();
				foreach ($submissions as $submissionId => $submission)
				{
					$item = array();
					foreach ($order as $orderId => $header)
					{
						if (isset($submission['SubmissionValues'][$header]))
							$item[$header] = $submission['SubmissionValues'][$header]['Value'];
						elseif (isset($submission[$header]))
							$item[$header] = $submission[$header];
						else
							$item[$header] = '';
					}
					
					$array[] = $item;
				}
				$xls->write($array);
			}
		}
		// XML Options
		elseif ($type == 'xml')
		{
			$handle = fopen($file, $start == 0 ? 'w' : 'a');
			
			if ($start == 0)
			{
				$buffer = '';
				$buffer .= '<?xml version="1.0" encoding="utf-8"?>'."\n";
				$buffer .= '<form>'."\n";
				$buffer .= '<title><![CDATA['.$model->getFormTitle().']]></title>'."\n";
				$buffer .= "\t".'<submissions>'."\n";
				fwrite($handle, $buffer);
			}
			
			if (empty($submissions))
			{
				$buffer = '';
				$buffer .= "\t".'</submissions>'."\n";
				$buffer .= '</form>';
				fwrite($handle, $buffer);
				fclose($handle);
				// Adjust pagination
				$mainframe->setUserState('com_rsform.submissions.limitstart', 0);
				$mainframe->setUserState('com_rsform.submissions.limit', JFactory::getConfig()->get('list_limit'));
				echo 'END';
			}
			else
			{
				foreach ($submissions as $submissionId => $submission)
				{
					fwrite($handle, "\t\t".'<submission>'."\n");
					$buffer = '';
					foreach ($order as $orderId => $header)
					{
						if (isset($submission['SubmissionValues'][$header]))
							$item = $submission['SubmissionValues'][$header]['Value'];
						elseif (isset($submission[$header]))
							$item = $submission[$header];
						else
							$item = '';
						
						if (!is_numeric($item))
							$item = '<![CDATA['.$item.']]>';
						
						$header = preg_replace('#\s+#', '', $header);
						
						$buffer .= "\t\t\t".'<'.$header.'>'.$item.'</'.$header.'>'."\n";
					}
					fwrite($handle, $buffer);
					fwrite($handle, "\t\t".'</submission>'."\n");
				}
				fclose($handle);
			}
		} elseif ($type == 'ods') {
			require_once JPATH_COMPONENT.'/helpers/ods.php';
			
			$ods = new RSFormProODS($file);
			if ($start == 0) {
				$ods->startDoc();
				$ods->startSheet();
				if ($use_headers) {
					foreach ($order as $orderId => $header) {
						$ods->addCell($orderId, $header, 'string');
					}
					$ods->saveRow();
				}
			}
			
			if (empty($submissions)) {
				$ods->endSheet();
				$ods->endDoc();
				$ods->saveOds();
				
				// Adjust pagination
				$mainframe->setUserState('com_rsform.submissions.limitstart', 0);
				$mainframe->setUserState('com_rsform.submissions.limit', JFactory::getConfig()->get('list_limit'));
				echo 'END';
			} else {
				foreach ($submissions as $submissionId => $submission) {
					foreach ($order as $orderId => $header) {
						if (isset($submission['SubmissionValues'][$header]))
							$item = $submission['SubmissionValues'][$header]['Value'];
						elseif (isset($submission[$header]))
							$item = $submission[$header];
						else
							$item = '';
						
						if (is_numeric($item)) {
							$ods->addCell($orderId, (float) $item, 'float');
						} else {
							$ods->addCell($orderId, $item, 'string');
						}
					}
					$ods->saveRow();
				}
			}
		}
		
		exit();
	}
	
	function exportTask()
	{
		$session = JFactory::getSession();
		$session->set('com_rsform.export.data', serialize(JRequest::get('post', JREQUEST_ALLOWRAW)));
		
		$view 	= $this->getView('submissions', 'html');
		$model 	= $this->getModel('submissions');
		$view->setLayout('exportprocess');
		$view->setModel($model, true);
		$view->display();
	}
	
	function exportFile()
	{
		$config = JFactory::getConfig();
		$file = JFactory::getApplication()->input->getCmd('ExportFile');
		$file = $config->get('tmp_path').'/'.$file;
		
		$type = JFactory::getApplication()->input->getCmd('ExportType');
		$extension = 'csv';
		
		switch ($type) {
			default:
				$extension = $type;
			break;
			
			case 'ods':	
				$extension = 'ods';
				$file = $file.'.ods';
			break;
			
			case 'excelxml':
				$extension = 'xml';
			break;
			
			case 'excel':
				$file .= '.zip';
				$extension = 'xlsx';
			break;
		}
		
		RSFormProHelper::readFile($file, JFactory::getDate()->format('Y-m-d').'_rsform.'.$extension);
	}
	
	public function viewFile()
	{
		$app	= JFactory::getApplication();
		$db		= &$this->_db;
		$id 	= $app->input->getInt('id');
		
		$query = $db->getQuery(true);
		$query->select('*')
			  ->from($db->qn('#__rsform_submission_values'))
			  ->where($db->qn('SubmissionValueId').'='.$db->q($id));
		$result = $db->setQuery($query)->loadObject();
		
		// Not found
		if (empty($result)) {
			$app->redirect('index.php?option=com_rsform&view=submissions');
		}
		
		$query->clear()
			  ->select($db->qn('c.ComponentTypeId'))
			  ->from($db->qn('#__rsform_properties', 'p'))
			  ->leftJoin($db->qn('#__rsform_components', 'c').' ON ('.$db->qn('p.ComponentId').' = '.$db->qn('c.ComponentId').')')
			  ->where($db->qn('p.PropertyName').' = '.$db->q('NAME'))
			  ->where($db->qn('p.PropertyValue').' = '.$db->q($result->FieldName))
			  ->where($db->qn('c.FormId').' = '.$db->q($result->FormId));
		$type = $db->setQuery($query)->loadResult();
		
		// Not an upload field
		if ($type != 9) {
			return $this->setRedirect('index.php?option=com_rsform&view=submissions', JText::_('RSFP_VIEW_FILE_NOT_UPLOAD'));
		}
		
		if (file_exists($result->FieldValue)) {
			RSFormProHelper::readFile($result->FieldValue);
		}
		
		$this->setRedirect('index.php?option=com_rsform&view=submissions', JText::_('RSFP_VIEW_FILE_NOT_FOUND'));
	}
}