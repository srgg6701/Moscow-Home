/**@license slideplus image rotator
 * @author  Levente Hunyadi
 * @version 1.5.0
 * @remarks Copyright (C) 2011 Levente Hunyadi
 * @see     http://hunyadi.info.hu/projects/slideplus
 **/

;
(function ($) {
	'use strict';

	function isVisible(el) {
		return !!(!el || el.offsetHeight || el.offsetWidth);
	};

	/**
	* Effective background color.
	* Skips transparent backgrounds until it encounters an element with background color set.
	*/
	function effectiveBackgroundColor(elem) {
		var rgba;
		do {
			rgba = [0,0,0,0];  // fully transparent
			var match;
			if (match = window.getComputedStyle(elem,null).getPropertyValue('background-color').match(/^rgba?\((.*)\)$/)) {  // get background color in format "rgb(0,0,0)" or "rgba(0,0,0,1)"
				rgba = match[1].split(',').map(parseFloat);
				rgba.push(1);  // add transparency component if missing
				rgba = rgba.slice(0,4);  // ignore transparency component appended if already present
			}
			elem = elem.getParent();
		} while (elem && rgba[3] == 0);  // loop while background color is transparent
		return rgba;
	}

	/**
	* @param {Array.<string>} cls An array of class name suffixes.
	* @return {string} A class annotation to be used as an Element "class" attribute value.
	*/
	function _class(cls) {
		return cls.map(function (item) {
			return 'slideplus-' + item;
		}).join(' ');
	}

	function _dotclass(cls) {
		return '.slideplus-' + cls;
	}

	Object.append(Element['NativeEvents'], {
		'dragstart': 2  // listen to browser-native drag-and-drop events
	});

	Elements.implement({
		/**
		* Circular indexing.
		* @type {number} k Index.
		* @return {Element} An element at the specified modulo index position.
		*/
		'at': function (k) {
			var len = this['length'];
			return this[(k % len + len) % len];
		}
	});

	/**
	* Loads one or more images inside a container element.
	*
	* Usage:
	*   // enable user-friendly progress indicator for images in this element
	*   var preloader = new Preloader(item);
	*
	*   // start fetching images
	*   preloader.load();
	*
	* While the image is being loaded, the following HTML is injected into the container element:
	* <div class="loadplus">
	*   <div class="loadplus-bar0"></div>
	*   <div class="loadplus-bar1"></div>
	*   <div class="loadplus-bar2"></div>
	*   <div class="loadplus-bar3"></div>
	*   <div class="loadplus-bar4"></div>
	*   <div class="loadplus-bar5"></div>
	*   <div class="loadplus-bar6"></div>
	*   <div class="loadplus-bar7"></div>
	* </div>
	*/
	var Preloader = new Class({
		/*
		_icon: null,
		_images: $$([]),
		*/

		/**
		* Associates a user-friendly pre-loader service with a set of images inside a container.
		* @param {Element} elem The container element in which to seek for descendant image elements to pre-load.
		*/
		'initialize': function (elem) {
			var self = this;

			// inject animated loader icon
			self._icon = new Element('div', {
				'class': 'loadplus'
			}).adopt(
				[0,1,2,3,4,5,6,7].map(function (item) {
					return new Element('div', {
						'class': 'loadplus-bar' + item
					});
				})
			).inject(elem);

			// remove "src" attribute from images to prevent browser from displaying a partial image as data is being transferred
			self._images = elem.getElements('img').each(function (image) {
				// the attribute "data-src" is understood by scripts as the image URL until the image is loaded
				image.setProperty('data-src', image.getProperty('src')).removeProperty('src').setStyle('visibility','hidden');
			});
		},

		/**
		* Starts retrieving images from the server.
		*/
		'load': function () {
			var self = this;

			// associate preloader with container element
			self._images.each(function (image) {
				function _preloaded() {  // triggered when the image has been preloaded
					// add "src" attribute, the image will display immediately as data has already been transferred
					image.removeProperty('data-src').setProperty('src', src).setStyle('visibility','visible');

					// check if there are further images in the container pending
					if (!self._images.erase(image).pick()) {  // no more images to load
						// remove animated loader icon
						self._icon.destroy();
					}
				}

				var src = image.getProperty('data-src');
				if (src) {
					$(new Image).addEvent('load', _preloaded).set('src', src);
				}
			});
		}
	});

	/**
	* Time between successive scroll animations [ms].
	* @type {number}
	* @const
	*/
	var SLIDEPLUS_SCROLL_INTERVAL = 10;

	var slideplus = new Class({
		'Implements': Options,

		// default configuration properties
		'options': {
			'size': {
				'rows': 1,  // number of rows per slider page
				'cols': 3   // number of columns per slider page
			},
			/**
			* Unit the slider advances in response to navigation buttons previous or next ['single'|'page'].
			* @type {string}
			*/
			'step': 'page',
			/**
			* Whether the rotator loops around in a circular fashion [false|true].
			* @type {boolean}
			*/
			'loop': false,
			/**
			* Whether the rotator randomizes the order of images on startup [false|true].
			* @type {boolean}
			*/
			'random': false,
			/**
			* Orientation of sliding image strip ['horizontal'|'vertical'].
			* @type {string}
			*/
			'orientation': 'horizontal',
			/**
			* Layout of sliding image strip ['natural'|'row'|'column'].
			* @type {string}
			*/
			'layout': 'natural',
			/**
			* Horizontal alignment of current image in sliding image strip ['center'|'start'|'end'].
			* @type {string}
			*/
			'horzalign': 'center',
			/**
			* Vertical alignment of current image in sliding image strip ['center'|'start'|'end'].
			* @type {string}
			*/
			'vertalign': 'center',
			/**
			* Position where navigation controls are displayed, a combination of ['top'|'bottom'|'over'] or false.
			* @type {(Array.<string>|boolean)}
			*/
			'navigation': ['over','bottom'],
			/**
			* Action to trigger advancing the slider using navigation buttons previous or next ['click'|'mouseover'].
			* @type {string}
			*/
			'trigger': 'click',
			/**
			* Whether to show navigation links [true|false].
			* @type {boolean}
			*/
			'links': true,
			/**
			* Whether to show page counter [true|false].
			* @type {boolean}
			*/
			'counter': true,
			/**
			* Edge effect ['none','fade'].
			* @type {string}
			*/
			'edges': 'none',
			/**
			* Whether the context menu appears when right-clicking an image [true|false].
			* @type {boolean}
			*/
			'protection': false,
			/**
			* Duration for slide animation [ms], or one of ['slow'|'fast']
			* @type {(number|string)}
			*/
			'duration': 800,
			/**
			* Transition effect for slide animation, takes a string or an Fx.Transitions object.
			*/
			'transition': 'sine',
			/**
			* Time between successive automatic slide steps [ms], or false to disable automatic sliding.
			* @type {(number|boolean)}
			*/
			'delay': false,
			/**
			* Scroll speed [px/s].
			* @type {number}
			*/
			'scrollspeed': 200,
			/**
			* Acceleration factor, multiplier of scroll speed in fast scroll mode.
			* @type {number}
			*/
			'scrollfactor': 5,
			/**
			* Whether to enable user-friendly progress indicator icon with pre-loader service.
			*/
			'preloader': true
		},

		_index: 0,             // zero-based index of the currently active list item
		/*
		_stepsize: 0,          // number of items the slider advances when a navigation button is activated
		_gallery: null,        // DOM Element that encapsules list items, navigation controls, etc.
		_list: null,           // DOM Element that represents the sliding viewpane
		_allitems: null,       // list of DOM Elements the sliding viewpane can be populated with
		_curitems: null,       // list of (possibly cloned) DOM Elements the sliding viewpane is currently populated with
		_paging: null,
		_quickaccess: null,

		_maxwidth: 0,          // maximum width of images
		_maxheight: 0,         // maximum height of images

		_scrollspeed: 0,
		_scrolltimer: null,

		_intervalID: null,     // shared interval timer
		*/

		/**
		* @param {Element} elem
		* @param {Object} options
		* @param {Object=} lightbox Lightbox engine associated with the slider. All animations stop while the lightbox is displayed.
		*        The engine must support the events "open" or "show", and the "close" or "hide".
		*/
		'initialize': function (elem, options, lightbox) {
			/**
			* Converts an [r,g,b,a] color array to an "rgba(r,g,b,a)" CSS color definition.
			* @param {Array.<number>} color A color with red, green, blue and transparency components.
			* @return {string} A color expression with the rgba CSS function.
			*/
			function color2rgba(color) {
				return 'rgba(' + color.join(',') + ')';
			}

			/**
			* Converts an [r,g,b,a] color array to an "#AARRGGBB" hex string.
			* @param {Array.<number>} color A color with red, green, blue and transparency components.
			* @return {string} A hexadecimal color expression.
			*/
			function color2ahex(color) {
				function hex(x) {
					return ("0" + x.toString(16)).slice(-2);
				}
				return "#" + hex(Math.floor(255*color[3])) + hex(color[0]) + hex(color[1]) + hex(color[2]);
			}

			/**
			* Adds buttons "Previous" and "Next" to a set of navigation bars.
			* @param {Elements} navbars A collection of navigation bar elements.
			* @param {string} dir A direction link such as 'prev', 'next', 'first' or last.
			* @param {string} text The link caption.
			*/
			function _addNavigation(navbars, dir, text) {
				navbars.each(function (bar) {
					bar.adopt(
						new Element('span', {
							'class': _class(['navbutton', dir]),
							'html': text
						})
					);
				});
			}

			// element existence test to ensure element is within DOM, some content management
			// systems may call the script even if the associated content is not on the page,
			// which is the case e.g. with Joomla category list layout or multi-page layout
			if (!elem) {
				return;
			}

			var self = this;
			self['setOptions'](options);
			options = self['options'];

			// save list of items
			var list = self._list = (self._gallery = elem).getElement('ul,ol');
			if (!list) {
				return;
			}

			// force width and height for images (browser rendering workaround)
			var images = elem.getElements('img');
			images.each(function (image) {
				image.setStyles({
					width: image.getProperty('width') + 'px',
					height: image.getProperty('height') + 'px'
				});
			});

			// select and save list items
			var listitems = self._allitems = list.getChildren('li');
			if (options['random']) {  // randomize order of elements in the list
				listitems.sort(function () { return Math.random() - 0.5; });
			}

			// disable looping if not meaningful
			if (listitems.length < 2) {
				options['loop'] = false;
			}

			// create a nesting <div><div class="slideplus"><ul>...</ul></div></div>
			var viewer = new Element('div', {
				'class': 'slideplus'
			}).inject(elem).grab(list.removeClass('slideplus'));  // ensure there is no "slideplus" CSS class on <ul>

			listitems.each(function (listitem) {
				// add current item selection
				listitem.addEvent('click', function () {
					// unselect elements no longer active
					$$([listitems, self._curitems].flatten()).removeClass(_class(['active']));  // iterate over both original and possibly cloned elements

					// select active element
					$$(listitem, this).addClass(_class(['active']));  // use "this" to support selection when element is cloned
				});

				// center items horizontally and vertically
				listitem.adopt(
					new Element('div', {
						'class': _class([
							'align',
							'horizontal-' + options['horzalign'],
							'vertical-' + options['vertalign']
						])
					}).adopt(listitem.getChildren())
				);
			});

			// set viewpane size
			var rows = options['size']['rows'];
			var cols = options['size']['cols'];
			if (rows > 0 && cols > 0) {
				// compute the width and height that fits all elements in the collection
				// show hidden elements temporarily to obtain valid values for width, height, padding, border and margin
				var maxwidth = 0;
				var maxheight = 0;
				images.concat(listitems).each(function (item) {
					var itemdims = item.getDimensions({'computeSize': true, 'styles': ['margin','border','padding']});
					maxwidth = Math.max(maxwidth, itemdims['totalWidth']);
					maxheight = Math.max(maxheight, itemdims['totalHeight']);
				});

				// get maximum width and height of image slider items
				$$(list, viewer).setStyles({
					'width': cols * (self._maxwidth = maxwidth),
					'height': rows * (self._maxheight = maxheight)
				});
				listitems.setStyles({
					'width': maxwidth,
					'height': maxheight
				});
			} else {
				// resolve parameter incompatibilities
				options['counter'] = false;
			}

			if (options['edges'] == 'fade') {
				// fading edges
				viewer.adopt(
					new Element('div', {
						'class': _class(['edge','edge-start',options['orientation']])
					}),
					new Element('div', {
						'class': _class(['edge','edge-end',options['orientation']])
					})
				);

				// set gradient color
				var colorSolid = effectiveBackgroundColor(elem);
				var colorTransparent = [colorSolid[0],colorSolid[1],colorSolid[2],0.0];  // set fully transparent near edges
				viewer.getElements(_dotclass('edge')).each(function (edge) {
					['filter','background-image'].each(function (property) {  // 'filter' for IE, 'background-image' for standard browsers
						var style = edge.getStyle(property);
						if (style) {
							// in CSS file, #ff000000 denotes 'from' color (opaque), #00000000 denotes 'to' color (transparent) (IE)
							style = style.replace(/#fffefefe/g,color2ahex(colorSolid)).replace(/#00fefefe/g,color2ahex(colorTransparent));

							// in CSS file, rgba(0,0,0,0) stands for 'from' color, rgba(0,0,0,1) stands for 'to' color (standard browsers)
							style = style.replace(/#fefefe|rgb\(254,\s*254,\s*254\)|black/g,color2rgba(colorSolid)).replace(/rgba\(254,\s*254,\s*254,\s*1\)|transparent/g,color2rgba(colorTransparent));

							edge.setStyle(property, style);
						}
					});
				});
			}

			// setup navigation and paging container
			var navigation = options['navigation'];  // e.g. ['over','bottom']
			var barnavigation = navigation.clone().erase('over');  // e.g. ['bottom']
			barnavigation.each(function (pos) {
				new Element('div', {
					'class': _class(['navbar'])
				}).setStyle('width', viewer.getStyle('width')).inject(elem, pos);
			});
			var quickaccess = self._quickaccess = elem.getElements(_dotclass('navbar'));

			// setup overlay navigation controls
			if (navigation.contains('over')) {
				var isvertical = options['orientation'] == 'vertical';
				var listsize = list.getSize();
				var clsOrientation = isvertical ? 'vertical' : 'horizontal';
				var clsSize = (isvertical ? listsize.x : listsize.y) < 120 ? 'small' : 'large';
				viewer.adopt(
					new Element('div', {
						'class': _class(['prev',clsOrientation,clsSize])
					}),
					new Element('div', {
						'class': _class(['next',clsOrientation,clsSize])
					})
				);
			}

			// setup navigation bar controls
			if (barnavigation.length && listitems.length > 1) {
				_addNavigation(quickaccess, 'prev', '&lt;');  // '\u21E6' or 'Previous'
				_addNavigation(quickaccess, 'next', '&gt;');  // '\u21E8' or 'Next'

				// enable first and last if there is a sufficient number of images
				if (rows > 0 && cols > 0 && rows*cols > 2*listitems.length) {
					_addNavigation(quickaccess, 'first', '|&lt;');
					_addNavigation(quickaccess, 'last', '&gt;|');
				}
			}

			// add navigation bar paging controls
			if (options['links']) {
				quickaccess.each(function (bar) {
					var paging = new Element('div', {
						'class': _class(['paging'])
					});

					var stepincrement = options['orientation'] == 'vertical' ? cols : rows;
					var itemcount = listitems.length;
					var pagecount = options['step'] == 'page' ? ((itemcount - 1) / (rows*cols)).floor() + 1 : itemcount;
					pagecount > 1 && pagecount.times(function (index) {  // do not create paging controls for a single page
						paging.adopt(
							new Element('span', {
								'html': index + 1,
								'events': {
									'click': function () {
										self._index =
											( options['step'] == 'page'
											// jump to indexed page
											? index*rows*cols
											// jump to image whose index starts the very last (full or partially full) page
											: index.min(itemcount - (itemcount%stepincrement > 0 ? itemcount%stepincrement : stepincrement) - (rows*cols - stepincrement))
											);
										self._layout();
									}
								}
							})
						);
					});
					bar.adopt(paging);
				});
			}
			self._paging = elem.getElements(_dotclass('paging'));

			// postpone loading images
			listitems.dispose();
			if (options['preloader'] && self._populous() && rows*cols < 16) {  // enable user-friendly preloader icon if there are sufficient but not too many images
				listitems.each(function (listitem) {
					listitem.store('preloader', new Preloader(listitem));
				});
			}

			// navigate to current image for galleries used as a menu
			listitems.each(function (listitem, index) {
				var anchor = listitem.getElement('a');  // each anchor takes the user to a different page
				if (anchor && anchor['href'] == window['location']['href']) {  // compare anchor target URL to window URL
					// set index to active element
					self._index = self._index = options['step'] == 'page' ? (index / (rows*cols)).floor() * (rows*cols) : index;

					// apply style to active element
					listitem.addClass(_class(['active']));
				}
			});

			// reset layout and sliding bar left and top coordinates (to minimize external template interference)
			self._advance(0);

			// scroll actions
			var prevbuttons = self._buttons('prev');
			var nextbuttons = self._buttons('next');
			if (options['trigger'] == 'mouseover') {
				self._stopScroll();  // reset scroll speed
				prevbuttons.addEvents({
					'mouseover': function () {
						self._startScroll(-1);
					},
					'mouseout': function () {
						self._stopScroll();
					}
				});
				nextbuttons.addEvents({
					'mouseover': function () {
						self._startScroll(1);
					},
					'mouseout': function () {
						self._stopScroll();
					}
				});
				$$([prevbuttons,nextbuttons].flatten()).addEvents({
					'mousedown': function () {
						self._accelerateScroll();
					},
					'mouseup': function () {
						self._decelerateScroll();
					}
				});
			} else {
				prevbuttons.addEvent('click', self['prev'].bind(self));
				nextbuttons.addEvent('click', self['next'].bind(self));

				// add swipe navigation to be used on portable devices
				var swipestart;
				var isvertical = options['orientation'] == 'vertical';
				viewer.addEvent('touchstart', function (evt) {
					evt.stop();
					var touch = evt.changedTouches[0];
					swipestart = isvertical ? touch.pageY : touch.pageX;
				});
				viewer.addEvent('touchend', function (evt) {
					evt.stop();
					var touch = evt.changedTouches[0];
					var pos = isvertical ? touch.pageY : touch.pageX;
					if (pos - swipestart >= 50) {  // swipe to the right
						self.prev();
					} else if (swipestart - pos >= 50) {  // swipe to the left
						self.next();
					}
				});
			}
			self._buttons('first').addEvent('click', self['first'].bind(self));
			self._buttons('last').addEvent('click', self['last'].bind(self));

			// suppress context menu and drag-and-drop
			if (options['protection']) {
				document.addEvents({  // subscribe to protected events
					'contextmenu': function (event) {  // prevent right-click on image
						return !list.contains(event.target);
					},
					'dragstart': function (event) {  // prevent drag-and-drop of image
						return !list.contains(event.target);
					}
				});
			}

			// slider animation
			if (options['delay']) {
				var suppressAnimation = false;  // whether to suppress animation even if mouse is not over rotator

				// stop animation when mouse mover over an image
				viewer.addEvents({
					'mouseover': function () {
						self._clearTimeout();
					},
					'mouseout': function () {
						suppressAnimation || self._setTimeout();  // do not keep animating if lightbox pop-up window is open
					}
				});

				if (lightbox) {
					lightbox.addEvents({
						'open': function () {
							suppressAnimation = true;
							self._clearTimeout();
						},
						'close': function () {
							suppressAnimation = false;
							self._setTimeout();
						}
					});
				}
			}
		},

		'prev': function () {
			this._slide(-1);
		},

		'next': function () {
			this._slide(1);
		},

		'first': function () {
			var self = this;
			self._index = 0;
			self._layout();
		},

		'last': function () {
			var self = this;
			var options = self['options'];
			var rows = options['size']['rows'];
			var cols = options['size']['cols'];
			var len = self._allitems.length;
			self._index = options['step'] == 'page' ? ((len - 1) / (rows*cols)).floor() * (rows*cols) : len - 1;
			self._layout();
		},

		/**
		* Sets the animation delay.
		*/
		_setTimeout: function () {
			var self = this;
			var delay = self['options']['delay'];
			if (delay && !self._intervalID) {  // start timer
				self._intervalID = window.setTimeout(function () {
					self._intervalID = false;
					if (isVisible(self._gallery)) {  // if gallery is visible, begin sliding
						self._slide(1);
					} else {  // if gallery is not visible, wait for the next opportunity
						self._setTimeout();
					}
				}, delay);
			}
		},

		/**
		* Clears the animation delay.
		*/
		_clearTimeout: function () {
			var self = this;
			if (self._intervalID) {  // if there is a running timer
				window.clearTimeout(self._intervalID);
				self._intervalID = false;
			}
		},

		_buttons: function (cls) {
			return this._gallery.getElements(_dotclass(cls));
		},

		/**
		* Determines if sufficient number of images are available for display without cloning.
		*/
		_populous: function () {
			var self = this;
			var options = self['options'];
			var rows = options['size']['rows'];
			var cols = options['size']['cols'];
			var length = self._allitems.length;
			return length >= rows*cols + 2 * (options['step'] == 'page'  // reserve for both forward and backward movement
				? (rows*cols)  // slider moves by an entire page, reserve a spare page
				: (options['orientation'] == 'vertical'  // reserve a row/column depending on orientation
					? cols  // slider moves by a single row vertically, reserve as many slots as columns
					: rows  // slider moves by a single column horizontally, reserve as many slots as rows
				)
			);
		},

		/**
		* Arrange items on sliding image strip.
		*/
		_layout: function () {
			/**
			* Copies a set of events from an element and all of its descendants to another element.
			* @param {Element} to The element to copy events to.
			* @param {Element} from The element to copy events from.
			* @param {string} type The event to copy, e.g. "click".
			*/
			function _cloneEventsDeep(to, from, type) {
				var toChildren = to.cloneEvents(from, type).getChildren();
				var fromChildren = from.getChildren();
				for (var k = 0; k < toChildren.length; k++) {
					_cloneEventsDeep(toChildren[k], fromChildren[k], type);
				}
			}

			var self = this;
			var options = self['options'];
			var rows = options['size']['rows'];
			var cols = options['size']['cols'];
			var maxwidth = self._maxwidth;
			var maxheight = self._maxheight;
			var length = self._allitems.length;
			var pagestep = options['step'] == 'page';  // whether to scroll in pages

			// stop timer
			self._clearTimeout();

			// extract part of array with loop semantics
			var listitems = self._curitems = $$([]);
			var isvertical = options['orientation'] == 'vertical';
			var stepincrement = isvertical ? cols : rows;
			var lowest = self._index - (pagestep ? rows*cols : stepincrement);  // start index
			var highest = self._index + rows*cols + (pagestep ? rows*cols : stepincrement);  // end index
			if (!options['loop']) {
				highest = highest.min(length);
			}

			for (var k = lowest; k < highest; k++) {
				var listitem = self._allitems['at'](k);  // call class extension "at" for Elements

				// schedule images for loading
				var preloader = listitem.retrieve('preloader');
				if (preloader) {
					preloader.load();
				}

				// add item to the group of those shown or about to be shown
				if (self._populous()) {  // sufficient number of images available to fill each position
					listitems.push(listitem);
				} else {  // not enough images to occupy each position, create duplicates (might be unsafe with other script libraries, e.g. jQuery)
					var cloneitem;
					var $j = window['jQuery'];
					if ($j) {
						cloneitem = $($j(listitem).clone(true)[0]);  // use jQuery to make a deep copy with jQuery events duplicated
					} else {
						cloneitem = listitem.clone();  // use MooTools to make a deep copy
					}
					_cloneEventsDeep(cloneitem, listitem);  // duplicate MooTools events
					listitems.push(cloneitem);
				}
			}

			// remove previous event bindings
			self._list.getChildren().each(function (listitem) {
				// remove (fade-in and fade-out) animation effects
				listitem.removeEvents(listitem.retrieve(_class(['events'])));  // remove events set exclusively by this script
			});

			// clear items currently displayed
			self._list.empty();

			// add new items displayed
			listitems.each(function (listitem, index) {
				// determine layout order
				var rowmajor = isvertical;  // initialize with layout that fits orientation model (row-major for vertical and column-major for horizontal)
				if (pagestep) {  // row-major and column-major layout make sense only for sliding by a whole page
					var layout = options['layout'];
					if (layout == 'row') {
						rowmajor = true;  // force row-major layout
					}
					if (layout == 'column') {
						rowmajor = false;  // force column-major layout
					}
				}

				// arrange list items on sliding canvas
				var left, top;
				if (rowmajor) {
					// row-major layout (layout by rows)
					left = (index%cols) * maxwidth;
					top = (index/cols).toInt() * maxheight - (pagestep ? rows : 1) * maxheight;
				} else {
					// column-major layout (layout by columns)
					left = (index/rows).toInt() * maxwidth - (pagestep ? cols : 1) * maxwidth;
					top = (index%rows) * maxheight;
				}
				self._list.adopt(listitem.setStyles({
					'left': left,
					'top': top
				}));

				// add (fade-in and fade-out) animation effects
				var effect = new Fx.Morph(listitem, {
					link: 'cancel'
				});
				effect.set(_dotclass('inactive'));
				var events = {
					'mouseenter': function () {
						effect.start(_dotclass('active'));
					},
					'mouseleave': function () {
						effect.start(_dotclass('inactive'));
					}
				};

				// associate events object with element storage
				listitem.store(_class(['events']), events).addEvents(events);
			});

			// show or hide navigation buttons previous and next (for non-looping mode)
			self._buttons('prev').toggleClass(_class(['hidden']), !options['loop'] && self._index <= 0);
			self._buttons('next').toggleClass(_class(['hidden']), !options['loop'] && self._index >= length - (pagestep ? 1 : rows*cols));

			// update current page
			self._paging.each(function (paging) {  // iterate over paging controls (e.g. upper and lower)
				// remove and set active page marker (if paging controls are present)
				var activeitem = paging.getChildren().removeClass(_class(['active']))['at'](self._index / (pagestep ? rows*cols : 1));

				if (activeitem) {
					// make page active
					activeitem.addClass(_class(['active']));

					// scroll active page into view
					var position_x = activeitem.getPosition(paging).x;  // ranges between 0 and container width if left edge is in view
					if (position_x + activeitem.getSize().x > paging.getSize().x || position_x < 0) {
						paging.scrollTo(paging.getScroll().x + position_x, 0);  // align left edge with container left edge
					}
				}
			});

			// start timer
			self._setTimeout();
		},

		_advance: function (increment) {
			var self = this;
			self._index += increment;
			self._layout();  // reset layout when animation is complete
			self._list.setStyles({
				'left': 0,
				'top': 0
			});
		},

		_increment: function (dir) {
			var self = this;
			var options = self['options']
			var rows = options['size']['rows'];
			var cols = options['size']['cols'];
			return dir * (options['step'] == 'page' ? rows*cols : (options['orientation'] == 'vertical' ? cols : rows));
		},

		/**
		* Advance the sliding image strip.
		* @param dir Specify -1 to slide backwards, 1 to slide forwards.
		*/
		_slide: function (dir) {
			var self = this;
			var options = self['options']
			var rows = options['size']['rows'];
			var cols = options['size']['cols'];
			var increment = self._increment(dir);

			// stop timer
			self._clearTimeout();

			// disallow circular repeat when looping is disabled; option "move by page" allows empty slots at the end
			if (!options['loop'] && (self._index + increment >= self._allitems.length - (options['step'] == 'page' ? 0 : rows*cols-1) || self._index + increment < 0)) {
				return;
			}

			// find source and target positions
			var source = self._list.getChildren()[rows*cols];
			var sourcepos = source.getPosition();
			var target = self._list.getChildren()[rows*cols + increment];
			var targetpos = target.getPosition();

			// launch animation
			var effect = new Fx.Morph(self._list, {
				'link': 'ignore',
				'duration': options['duration'],
				'transition': options['transition'],
				'onComplete': function () {
					self._advance(increment);
				}
			});
			effect.start({
				'left': sourcepos.x - targetpos.x,  // slide from source to target
				'top': sourcepos.y - targetpos.y
			});
		},

		/**
		* Starts scrolling the sliding strip either forward or backward.
		* @param {number} dir -1 to scroll backward, 1 to scroll forward, 0 to initialize controls (no scrolling)
		*/
		_startScroll: function (dir) {
			var self = this;
			var options = self['options'];

			// navigation bar to scroll
			var navbar = self._list;

			// current left/top offset of sliding strip w.r.t. left edge of viewer
			var property = options['orientation'] == 'vertical' ? 'top' : 'left';
			var x = navbar.getStyle(property).toInt();  // 0 > x > minpos
			x = isNaN(x) ? 0 : x;

			if (x == 0 && dir < 0) {
				self._advance(self._increment(dir));
			}

			// reference item size, which causes a layout update when scrolls to its final position
			var size = self._list.getChildren()[options['size']['rows']*options['size']['cols']].getSize();
			if (x == 0 && dir < 0) {
				x = -size.x;
				navbar.setStyle(property, x + 'px');
			}

			// minimum and maximum value permitted as left/top offset w.r.t. left/top edge of viewer
			var minpos = -size.x;

			// assign scroll function, avoid complex operations
			var func = function () {
				// whether to reset offsets and update layout
				var reset = false;

				x -= dir * self._scrollspeed;
				if (x <= minpos) {
					x = minpos;
					reset = true;
				}
				if (x >= 0) {
					x = 0;
					reset = true;
				}

				navbar.setStyle(property, x + 'px');

				if (reset) {
					window.clearInterval(self._scrolltimer);
					self._scrolltimer = null;
					if (dir > 0) {
						self._advance(self._increment(dir));
					}
					self._startScroll(dir);
				}
			};

			self._scrolltimer = window.setInterval(func, SLIDEPLUS_SCROLL_INTERVAL);
		},

		_stopScroll: function () {
			var self = this;
			self._decelerateScroll();
			if (self._scrolltimer) {
				window.clearInterval(self._scrolltimer);
				self._scrolltimer = null;
			}
		},

		_accelerateScroll: function () {
			var self = this;
			var options = self['options'];
			self._scrollspeed = options['scrollspeed'] * SLIDEPLUS_SCROLL_INTERVAL * options['scrollfactor'] / 1000;
		},

		_decelerateScroll: function () {
			this._scrollspeed = this['options']['scrollspeed'] * SLIDEPLUS_SCROLL_INTERVAL / 1000;
		}
	});

	/**
	* Automatically discovers static image sliders wrapped in an HTML <noscript> element and transforms them into a rotating gallery.
	*
	* Example HTML source code:
	* <noscript class="slideplus">
	* <ul>
	* <li><a href="images/example1.jpg"><img width="150" height="100" alt="First sample image" src="thumbs/example1.jpg" /></a></li>
	* <li><img width="150" height="100" alt="Second sample image" src="thumbs/example2.jpg" /></li>
	* </ul>
	* </noscript>
	*/
	slideplus['autodiscover'] = function (options) {
		window.addEvent('domready', function () {
			// lists not wrapped in <noscript>
			$$('ul.slideplus').each(function (item) {
				new slideplus(new Element('div').wraps(item), options);
			});

			// lists wrapped in <noscript>
			$$('noscript.slideplus').each(function (item) {
				// extracts the contents of a <noscript> element, and build a rotating gallery
				new slideplus(new Element('div', {
					'html': item.get('text')  // <noscript> elements are not parsed when javascript is enabled
				}).inject(item, 'after'), options);
				item.destroy();
			});
		});
	};

	window['slideplus'] = slideplus;
})(document.id);