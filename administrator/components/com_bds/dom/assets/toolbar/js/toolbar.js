jQuery(document).ready(function(){
	jQuery("#adminForm").validationEngine();

	// Deprecated : Use Joomla.submitform()
	Joomla.submitformAjax = function(task, form)
	{
		return Joomla.submitform(task, form);
	};

	Joomla.submitform = function(task, form)
	{

		if (typeof(form) === 'undefined')
			form = jQuery('#adminForm');

		//No ajax when controller task is empty (ex: filters, search, ...)
		if ((typeof(task) == 'undefined') || (task.trim() == ''))
			return Joomla.submitPost(form);


		// Populate the task in the hidden input
		jQuery(form).find('input[name=task]').val(task);

		// Extract the single task name (without view.)
		var parts = task.split('.');
		var taskName = parts[parts.length-1];

		// Auto-detect if the toolbar is loaded in modal
		var modal = false;
		if (typeof(parent.SqueezeBox) != 'undefined')
			modal = parent.SqueezeBox.isOpen;


		var close = function()
		{
			// Nothing to do when form is not loaded in modal (should never be called)
			if (!modal)
				return;

			jQuery(form).validationEngine('detach');

			//Close modal
			parent.SqueezeBox.close();
		};


		var onSuccess = function(div, response)
		{
			switch(redirect)
			{
				case 'parentReload':
					//Reload parent page only if needed
					parent.holdForm = false;
					parent.location.reload(false);

					//Close modal
					close();
					break;

				case 'close':
					//Close modal
					close();
					break;

				case 'stay':
				default:
					//Keep modal opened
					break;
			}
		};


		// Trigger the form validator
		var validate = true;

		// Action after submitting the form
		var redirect = '';

		// Determines whethever using ajax method or not
		var method = '';


		switch(taskName)
		{
			case 'save':
			case 'delete':
				redirect = 'parentReload';
				method = 'ajax';
				break;

			case 'save2copy':
			case 'save2new':
			case 'apply':
				redirect = 'stay';
				break;


			case 'publish':
			case 'unpublish':
			case 'trash':
			case 'archive':
				validate = false;
				redirect = 'stay';
				break;


			case 'cancel':
				validate = false;
				if (modal)
				{
					method = 'ajax';
					redirect = 'close';
				}
				break;

			default:
				//Keep modal opened
				break;
		}

		// When the user stays on page, the ajax is not necessary
		if (redirect == 'stay')
			method = '';

		// Unactive the validator
		if (!validate)
			jQuery(form).validationEngine('detach');

		// When a form is loaded in modal, do not use ajax
		if (!modal)
			method = '';

		if (method == 'ajax')
		{
			//Exec the ajax call
			return Joomla.submitAjax(form, redirect, onSuccess);
		}

		// No ajax involved
		return Joomla.submitPost(form);
	};



	Joomla.submitPost = function(form)
	{
		// Unlock the page
		holdForm = false;

		// Submit the form in a regular classic way (POST)
		jQuery(form).submit();
	};


	Joomla.submitAjax = function(form, redirect, onSuccess, domSpinner)
	{
		// Ajax node (Hook)
		if (typeof($.jdomAjax) != 'undefined')
		{
			$(form).jdomAjax({
//				'debug':true,
				'plugin' : 'form',
				'onAfterSuccess' : onSuccess,
				'domSpinner' : ((typeof(domSpinner) != 'undefined')?domSpinner:null),
			});

			return;
		}

		// Fallback if Hook is missing or with error (does not handle files)
		jQuery.post("index.php?return=json", jQuery(form).serialize(), function(response)
		{
			response = jQuery.parseJSON(response);
			if (response.transaction.result)
			{
				onSuccess();
			}
			else
			{
				var msg = response.transaction.rawExceptions;
				if (msg.trim() == '')
					msg = 'Unknown error';

				alert(msg);
			}
		});
	};


});