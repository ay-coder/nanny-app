var BaseCommon =
{
	/**
	 * Common Utility Functions
	 *
	 */
	Utils:
	{
		/**
		 * Check Browser Name
		 *
		 * @type {*}
		 */
		browserIs: function (browserName)
		{
			switch(browserName)
			{
				case 'opera':
					return (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
				break;

				case 'firefox':
					return typeof InstallTrigger !== 'undefined';
				break;

				case 'safari':
					return /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
				break;

				case 'ie':
					return /*@cc_on!@*/false || !!document.documentMode;
				break;

				case 'edge':
					return !FTXCommon.Utils.browserIs('ie') && !!window.StyleMedia;
				break;

				case 'chrome':
					return !!window.chrome && !!window.chrome.webstore;
				break;

				case 'blink':
					return (FTXCommon.Utils.browserIs('chrome') || FTXCommon.Utils.browserIs('opera')) && !!window.CSS;
				break;

				default:
					return false;
			}
		},

		/**
		 * Replace Strings
		 *
		 * @param str
		 * @param replaceWhat
		 * @param replaceTo
		 */
		replaceStrings: function(str, replaceWhat, replaceTo)
		{
			replaceWhat = replaceWhat.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
			var re = new RegExp(replaceWhat, 'g');
			str.replace(re,replaceTo);
		},

		/**
		 * Get Closest Element
		 *
		 * @param element
		 * @param selector
		 * @return {*}
		 */
		getClosestElement: function(element, selector)
		{
			var matchesFn,
				parent,
				vendorPrefixes = ['matches','webkitMatchesSelector','mozMatchesSelector','msMatchesSelector','oMatchesSelector'];

			// find vendor prefix
			vendorPrefixes.some(function(fn)
			{
				if(typeof document.body[fn] == 'function')
				{
					matchesFn = fn;

					return true;
				}
				return false;
			});

			// traverse parents
			while(element)
			{
				parent = element.parentElement;

				if(parent && parent[matchesFn](selector))
				{
					return parent;
				}
				element = parent;
			}

			return null;
		},

		/**
		 * Add Default Select2
		 *
		 * @param element
		 * @param options
		 */
		addSelect2: function(element, options)
		{
			element = jQuery(element);

			return element.select2(options);
		},

		/**
		 * Fire Custom Event
		 *
		 * @param element
		 * @param eventName
		 * @param bubbling
		 */
		fireCustomEvent: function(element, eventName, bubbling)
		{
			var event       = document.createEvent('Event');
				bubbling    = bubbling || false;

			event.initEvent(eventName, true, true);
			element.dispatchEvent(event, bubbling);
		},

		/**
		 * Remove from Array
		 *
		 * @param array
		 * @param value
		 * @returns {*}
		 */
		removeFromArray: function(array, value)
		{
			if(array && value)
			{
				array = _.without(array, value);
			}

			return array;
		},

		/**
		 * Character Count
		 *
		 * @param input
		 * @param infoBox
		 */
		characterCount: function(input, infoBox)
		{
			var input       = document.getElementById(input),
				counterBox  = document.getElementById(infoBox),
				MaxChars =  input.maxLengh;

			if(!input || !counterBox)
			{
				return false; // catches errors
			}

			if(!MaxChars)
			{
				MaxChars =  input.getAttribute('maxlength');
			}

			if(!MaxChars)
			{
				return false;
			}

			var remainingChars =   MaxChars - input.value.length;

			counterBox.innerHTML = remainingChars+" Characters Remaining (Maximum " + MaxChars + ')'
		},

		/**
		 * Is Valid JSON
		 *
		 * @param text
		 * @returns {boolean}
		 */
		isValidJSON: function(text)
		{
			if(/^[\],:{}\s]*$/.test(text.replace(/\\["\\\/bfnrtu]/g, '@').
				replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
				replace(/(?:^|:|,)(?:\s*\[)+/g, '')))
			{
				return true;
			}

			return false;
		},

		/**
		 * Set Table Headers
		 *
		 * @param element
		 * @param {json} headers
		 */
		setTableHeaders: function(element, headers)
		{
			var tableHeader = '';

			for(var i = 0; i < headers.length; i++)
			{
			    tableHeader += '<th>' + headers[i] + '</th>';
			}

			element.innerHTML  = tableHeader;
		},

		setTableColumns: function(element, fetchurl, method, columns)
		{
			jQuery(element).DataTable({
			    processing: true,
			    serverSide: true,
			    ajax: {
			        url: fetchurl,
			    	async: true,
			        type: method
			    },
			    columns: columns,
			    order: [[0, "desc"]],
			    searchDelay: 1200
			});
		}
	}
};
