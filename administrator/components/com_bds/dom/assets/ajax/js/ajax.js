/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <  Generated with Cook       (by Jocelyn HUARD) |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo----------------------------------------------------- +
* @version		2.0
* @package		Cook Self Service
* @subpackage	JDom
* @copyright	Copyright 2011 - 100% vitamin
* @author		100% Vitamin - www.cpcv.net - info@cpcv.net
*
* /!\  Joomla! is free software.
* This version may have been modified pursuant to the GNU General Public License,
* and as distributed it includes or is derivative of works licensed under the
* GNU General Public License or other free or open source software licenses.
*
*             .oooO  Oooo.     See COPYRIGHT.php for copyright notices and details.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/


// Static AJAX caller : Entry point to instance a node
(function($) {
	$.fn.jdomAjax = function(options)
	{
		var thisp = this;

		// Load the correct Hook node plugin
		var plugin = 'defaults';
		if (typeof(options.plugin) != 'undefined')
			plugin = options.plugin;

	//Merge the options
	    var opts = $.extend({}, $.fn.jdomAjax[plugin], options);
		if (!opts.data)
			opts.data = new Object();


	//Data Object init
		var data = opts.data;
		if (typeof(opts.token) != 'undefined')
			data.token = opts.token;

	//Use a dotted namespace to find the MVC context (Cook Self Service)
		if (typeof(opts.namespace) != 'undefined')
		{
			var urlParts = opts.namespace.split('.');

			data.option = 'com_' + urlParts[0];
			data.view = urlParts[1];
			data.layout = urlParts[2];
			data.render = (urlParts[3]?urlParts[3]:'');
		}

	//Merge the vars with data
		if (typeof(opts.vars) != 'undefined')
		{
			for (var key in opts.vars)
			{
				data[key] = opts.vars[key];
			}
		}

		// End of definition : init script
		opts.initialize(this);

		//Return object class to sender
		return opts;
	};

// Hook base class
	$.fn.jdomAjax.hook =
	{

		domContents:null,
		domSpinner:null,
		domMessages:null,

		// Default function : Define all div as ajax wrapper, then send the request
		initialize: function(object)
		{
			this.domInit(object);
			this.request();
		},

		domInit: function(object)
		{
			this.domContents = object;

			if (this.domMessages == null)
			{
				var body = $(object).parents('body')[0];
				this.domMessages = $(body).find('#system-message-container');
			}

			if (this.domSpinner == null)
				this.domSpinner = object;
		},

	};

})(jQuery);






/* Hook Ajax Base Class: Contains all actions and application layer */
(function($) {

	$.fn.jdomAjax.ajax = $.extend({}, $.fn.jdomAjax.hook,
	{

		url:'index.php?tmpl=component',
		method:'POST',
		data:null,
		dom:null,
		token:parseInt(Math.random() * 9999999999),


		loadingStart: function()
		{
			$('<div/>', {'class':'jdom-ajax-spinner'}).appendTo($(this.domSpinner));
		},

		loadingEnd: function()
		{
			$(this.domSpinner).find('.jdom-ajax-spinner').remove();
		},


		request: function()
		{

			this.loadingStart();


			// Deprecated var : opts.result - Use opts.format
			if (typeof(this.format) != 'undefined')
				this.result = this.format;

			this.format = this.result;


			switch(this.format)
			{
				case 'JSON':
					this.url = 'index.php?return=json';
					break;

				case 'HTML':
					this.url = 'index.php?tmpl=component';
					break;
			}


			var thisp = this;
			$.ajax({
				'type': this.method,
				'url': this.url,
				'data': this.data,
				'cache': false,
		        'dataType': this.format,
				'success': function(data, textStatus, jqXHR){
					thisp.successXHR(data, textStatus, jqXHR);

				},
				'error' : function(jqXHR, textStatus, errorThrown){
					thisp.errorXHR(jqXHR, textStatus, errorThrown);
				}

				// TODO Handle timeout


			});

		},


		errorXHR: function(jqXHR, textStatus, errorThrown)
		{
			this.loadingEnd();

			var response = this.transaction.createResponse();
			this.transaction.createException(response, 'error', errorThrown);
			this.transaction.outputExceptions(this, response);
		},


		successXHR: function(data, textStatus, jqXHR)
		{
			this.loadingEnd();

			var object = this.domContents;
			var thisp = this;
			var isObject = false;

			if ($.isPlainObject(data))
				isObject = true;
			else
			{
				if (this.format == 'JSON')
				{
					try {
					  data = $.parseJSON(data);
					  isObject = true;
					}
					catch (err) {
					}
				}
			}

			var response = null;

			if (isObject){

				// Check the answer
				response = this.hookResponse(data);

				if (this.transaction.isError(response))
				{
					this.onError(response);

					return;
				}
				else
				{
					// Deprecated
					this.onBeforeSuccess(object, response);


					// User event callback
					var responseData = response.response.data;
					var responseTransaction = response.transaction;

					this.onSuccess(responseData, responseTransaction, object, response);

					this.successObject(object, response);

				}


//				this.successObject(object, data, textStatus, jqXHR);
			}
			else{

				// Populate a new response object
				response = this.transaction.createResponse();
				this.transaction.setHtml(response, data);

				// Deprecated
				this.onBeforeSuccess(object, response);

				// User event callback
				var responseHtml = response.response.html;
				var responseTransaction = response.transaction;

				this.onSuccess(responseHtml, responseTransaction, object, response);



				this.successHTML(object, response);
			}


			// DEPRECATED
			this.onAfterSuccess(object, response);


		},

		successHTML: function(object, response)
		{
			var thisp = this;

			//fill the object with the returned html
			$(object).html('').html(response.response.html);
			$(object).ready(function()
			{
				if (typeof(thisp.ready) != 'undefined')
					thisp.ready(object, response);

				// User trigger
				thisp.onReady(object, response);
			});
		},


		successObject: function(object, response)
		{
			this.transaction.outputExceptions(this, response);
		},


		// User can override those events - No stack possible, only one function to share
		onBeforeSuccess: function(object, response){

		},
		onAfterSuccess: function(object, response){

		},

		onError: function(response)
		{
			this.transaction.outputExceptions(this, response);
		},


		// User Callback
		onSuccess: function(response){

		},

		// User Callback
		onFailure: function(response){

		},

		// User callback after Dom ready
		onReady: function(object, response)
		{

		},



		hookResponse: function(data)
		{
			var response = {};

			if (!$.isPlainObject(data))
			{
				response = this.transaction.createResponse();
				this.transaction.createException(response, 'error', 'Object expected');
				this.transaction.outputExceptions(this, response);

				return;
			}


			if (this.debug)
			{
				console.log('HHR response:');
				console.log(data);
			}




			// Native Joomla response (JResponseJson)
			if (typeof(data.header) == 'undefined')
			{

				response = this.transaction.createResponse();

				if (typeof(data.success) != 'undefined')
					response.transaction.result = data.success;

				if (typeof(data.messages) != 'undefined')
					response.transaction.exceptions = data.messages;

				if (typeof(data.data) != 'undefined')
					response.response.data = data.data;

			}
			else
			{
				response = data;

				// Hook formated answer
				switch (data.header)
				{
					case 'hook-1.0':
						// LEGACY : Upgrade to Hook 1.1 format
						// Build the sorted messages list
						if ((typeof(response.transaction) != 'undefined') && (typeof(response.transaction.exceptions) != 'undefined'))
						{
							var list = {};

							$.each(response.transaction.exceptions, function(key, exception)
							{
								var type = message = '';
								if (typeof(exception.type) != 'undefined')
									type = exception.type;

								if (typeof(exception.message) != 'undefined')
									message = exception.message;

								if (typeof(list[type]) == 'undefined')
									list[type] = [];

								list[type].push(message);

							});
							response.transaction.exceptions = list;
						}


						break;


					//Latest
					case 'hook-1.1':
					default:
						// Already formated by the PHP Response Class

						break;
				}




			}


			if (this.debug)
			{
				console.log('Hook response:');
				console.log(response);
			}



			return response;
		},

		transaction: {
			isError: function(response)
			{
				if (typeof(response.transaction.result) == 'undefined')
					return false;

				return !response.transaction.result;
			},

			outputExceptions: function(hook, response)
			{
				var transac = response.transaction;

				if (typeof(transac.exceptions) != 'undefined')
				{

					// JSON : TODO handle it better
					var html = [];
					$.each(transac.exceptions, function(type, exceptions)
					{
						$.each(exceptions, function(index, message)
						{
							html.push(type.toUpperCase() + ' : ' + message);
						});
					});

					hook.domMessages.append('<div>' + html.join('<br/>') + '</div>');

				}
				else if (typeof(transac.htmlExceptions) != 'undefined')
				{
					// HTML
					hook.domMessages.append(transac.htmlExceptions);
				}
				else if (typeof(transac.rawExceptions) != 'undefined')
				{
					// TEXT
					if (transac.rawExceptions.trim() != '')
						alert(transac.rawExceptions);
				}

			},

			createResponse: function()
			{
				var response = {
					'header' : 'hook-1.1',
					'transaction' : {
						'exceptions': {

						},
			//			'htmlExceptions': '',
			//			'rawExceptions':'',

						'result' : true,
//						'message':'',

					},

					'response' :
					{
//						'data':null,
//						'html':null
					}


				};

				return response;
			},

			createException: function(response, type, message)
			{
				if (typeof(response.transaction.exceptions[type] == 'undefined'))
					response.transaction.exceptions[type] = [];

				response.transaction.exceptions[type].push(message);

			},

			setHtml: function(response, html)
			{
				if (typeof(response.response == 'undefined'))
					response.response = {};

				response.response.html = html;
			},

		},

		ready: function(object, response)
		{
			if (typeof(callback['_' + this.token]) == 'function')
			{
				(callback['_' + this.token])();
				callback['_' + this.token] = null;
			}
		},



	});


})(jQuery);






/* Hook Node Base Class */
(function($) {
	$.fn.jdomAjax.node = $.extend({}, $.fn.jdomAjax.ajax,
	{





	});
})(jQuery);






/* Hook Default Node Controller Class: Contains all actions and application layer */
(function($) {

	$.fn.jdomAjax.defaults = $.extend({}, $.fn.jdomAjax.node,
	{

		debug:false,


//CONTROLLER

		display: function()
		{

			//Create the HTML structure

			//create the contents div


		},

		edit: function()
		{
			//TODO s ...
			// Use jQuery namespacing to find the strings and replace with inputs.

			// Create the FORM
			// Create every single input
			// Optionaly show extra informations or controls bigger than Fly > problem.


			// Names conventions must be the same for grid, form, everithing...

		},

		save: function()
		{

		},


		remove: function()
		{

		},

		addRow: function()
		{


		},


		refresh: function()
		{


		},

		reorder: function()
		{

		},




//VIEW
		renderToolbar: function()
		{


		},

		renderForm: function()
		{


		},


		renderContents: function()
		{

		},



	});

})(jQuery);




/* Form */
(function($) {

	$.fn.jdomAjax.form = $.extend({}, $.fn.jdomAjax.defaults,
	{
		method:'POST',
		format:'JSON',
		formPrefix:'jform',

		//When files are contained in the form
		files:{},
		form:null,


		initialize: function(object)
		{
			// Initialize the reference to the involved dom elements
			this.domInit(object);
			this.form = object;

			var thisp = this;
			var hasFiles = false;

			// Appends all files in the files array
			$(this.form).find('input[type=file]').each(function(key, input)
			{
				if (typeof(input.files[0]) == 'undefined')
					return;

				thisp.files[input.name] = input.files[0];

				// Unset the value in file input, so it is not processed by the regular post.
				$(input).val('');

				hasFiles = true;
			});

			var formData = $(this.form).serialize();

			// Files management
			if (hasFiles)
			{
				// 1. Lock the execution until Second ajax is confirmed
				var afterSuccess = this.onAfterSuccess;

				// Prevent from executing the ending event
				this.onAfterSuccess = function(){};

				// 2. Chain a second specific ajax call for files
				// Keep the parent user event
				var beforeSuccess = this.onBeforeSuccess;
				this.onBeforeSuccess = function(object, response)
				{
					this.sendFiles(function(object, response)
					{
						// Trigger the parent event
						var response = beforeSuccess(object, response);

						afterSuccess(object, response);
					});
				};
			}


			this.data = formData;


			this.request();
		},

		sendFiles: function(callbackSuccess)
		{
			var thisp = this;

			if (this.debug)
				console.log('sendFiles');

			// Create a formdata object and add the files
			var data = new FormData();
			$.each(this.files, function(key, value)
			{
				data.append(key, value);
			});


			// Populate the url with the correct item localization
			var url = this.url + '&' + this.getUrlFromForm();

			// Ignore the simple returned message (if not an error), to avoid returning it twice after ajax chaining
			url += '&ignoreMsg=1';

			// Send the files with POST only
		    $.ajax({
		        url: url,
		        type: 'POST',
		        data: data,
		        cache: false,
		        dataType: 'json',
		        processData: false, // Don't process the files
		        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
		        success: function(data, textStatus, jqXHR)
		        {
		        	// check response
					if (thisp.debug)
					{
						console.log('Response upload:');
						console.log(data);
					}

		        	var response = thisp.hookResponse(data);

					if (thisp.transaction.isError(response))
						thisp.onError(response);
					else
						callbackSuccess(thisp.domContents, response);
		        },
		        error: function(jqXHR, textStatus, errorThrown)
		        {
		        	thisp.errorXHR(jqXHR, textStatus, errorThrown);
		        }
		    });

		},

		getFormToken: function()
		{
			// Return the LAST, HIDDEN input in form where VALUE = 1 (No other way to retrieve it)
			var tokenSearch = this.form.find('input[type=hidden][value=1]');
			if (tokenSearch.length == 0)
				return '';

			return tokenSearch[tokenSearch.length-1].name;
		},

		getUrlFromForm: function(followers)
		{
			var thisp = this;

			if (typeof(followers) == 'undefined')
				followers = ['option', 'view', 'layout', 'task', 'id', 'cid', 'render', 'tmpl'];


			var params = [];

			$.each(followers, function(key, follower)
			{
				var input = thisp.form.find('input[type=hidden]#' + follower);

				if (input.val() == null)
					return;


				params.push(follower + '=' + input.val());

			});

			//Token
			params.push(this.getFormToken() + '=1');

			return params.join('&');
		},


	});;

}(jQuery));






(function($) {
	'use strict';

	/**
	* Multiple parallel getScript > getScripts()
	* https://gist.github.com/vseventer/1378913
	*
	* @access public
	* @param Array|String url (one or more URLs)
	* @param callback fn (oncomplete, optional)
	* @returns void
	*/
	$.getScripts = function(url, fn)
	{
		if(!$.isArray(url)) {
			url = [url];
		}

		$.when.apply(null, $.map(url, $.getScript)).done(function() {
			fn && fn();
		});
	};

}(jQuery));

var callback = {};
var registerCallback = function(token, fct)
{
	callback['_' + token] = fct;
};