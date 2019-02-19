var today = new Date();
var aemi_time = today.getHours();
var aemi_timetochange = ((aemi_time > 18) || (aemi_time < 8)) ? true : false;
var aemi = [];
var aemi_exist = function (f) {
	return (f === "function");
};
var aemi_lightbox = function () {
	var _const_name = 'aemisw',
	_const_class_prefix = _const_name,
	_const_id_prefix = _const_name,
	_const_dataattr = 'data-' + _const_name;
	var LX = this,
	isIE8 = false,
	isIE9 = false,
	body = document.getElementsByTagName('body')[0],
	template = '<div class="' + _const_name + '-contentwrapper" id="' + _const_name + '-contentwrapper" ></div>',
	imgRatio = false,
	currGroup = false,
	currThumbnail = false,
	currImage = {},
	currImages = [],
	isOpen = false,
	nextBtn = false,
	prevBtn = false,
	maxWidth,
	maxHeight,
	newImgWidth,
	newImgHeight;
	LX.opt = {};
	LX.box = false;
	LX.wrapper = false;
	LX.thumbnails = [];
	LX.thumbnails.push = function () {
		for (var i = 0, l = arguments.length; i < l; i++) {
			clckHlpr(arguments[i]);
		}
		return Array.prototype.push.apply(this, arguments);
	};
	function getHeight() {
		return window.innerHeight || document.documentElement.offsetHeight;
	}
	function getWidth() {
		return window.innerWidth || document.documentElement.offsetWidth;
	}
	function addEvent(el, e, callback, capture) {
		if (el.addEventListener) {
			el.addEventListener(e, callback, capture || false);
		}
		else if (el.attachEvent) {
			el.attachEvent('on' + e, callback);
		}
	}
	function hasClass(el, className) {
		if (!el || !className) {
			return;
		}
		return (new RegExp('(^|\\s)' + className + '(\\s|$)').test(el.className));
	}
	function removeClass(el, className) {
		if (!el || !className) {
			return;
		}
		el.className = el.className.replace(new RegExp('(?:^|\\s)' + className + '(?!\\S)'), '');
		return el;
	}
	function addClass(el, className) {
		if (!el || !className) {
			return;
		}
		if (!hasClass(el, className)) {
			el.className += ' ' + className;
		}
		return el;
	}
	function isset(obj) {
		return typeof obj !== 'undefined';
	}
	function getAttr(obj, attr) {
		if (!obj || !isset(obj)) {
			return false;
		}
		var ret;
		if (obj.getAttribute) {
			ret = obj.getAttribute(attr);
		}
		else if (obj.getAttributeNode) {
			ret = obj.getAttributeNode(attr).value;
		}
		if (isset(ret) && ret !== '') {
			return ret;
		}
		return false;
	}
	function hasAttr(obj, attr) {
		if (!obj || !isset(obj)) {
			return false;
		}
		var ret;
		if (obj.getAttribute) {
			ret = obj.getAttribute(attr);
		}
		else if (obj.getAttributeNode) {
			ret = obj.getAttributeNode(attr).value;
		}
		return typeof ret === 'string';
	}
	function clckHlpr(i) {
		addEvent(i, 'click', function (e) {
			stopPropagation(e);
			preventDefault(e);
			currGroup = getAttr(i, _const_dataattr + '-group') || false;
			currThumbnail = i;
			openBox(i, false, false, false);
		}, false);
	}
	function stopPropagation(e) {
		if (e.stopPropagation) {
			e.stopPropagation();
		}
		else {
			e.returnValue = false;
		}
	}
	function preventDefault(e) {
		if (e.preventDefault) {
			e.preventDefault();
		}
		else {
			e.returnValue = false;
		}
	}
	function getByGroup(group) {
		var arr = [];
		for (var i = 0; i < LX.thumbnails.length; i++) {
			if (getAttr(LX.thumbnails[i], _const_dataattr + '-group') === group) {
				arr.push(LX.thumbnails[i]);
			}
		}
		return arr;
	}
	function getPos(thumbnail, group) {
		var arr = getByGroup(group);
		for (var i = 0; i < arr.length; i++) {
			if (getAttr(thumbnail, 'src') === getAttr(arr[i], 'src') &&
				getAttr(thumbnail, _const_dataattr + '-index') === getAttr(arr[i], _const_dataattr + '-index') && getAttr(thumbnail, _const_dataattr) === getAttr(arr[i], _const_dataattr)) {
				return i;
		}
	}
}
function preload() {
	if (!currGroup) {
		return;
	}
	var prev = new Image();
	var next = new Image();
	var pos = getPos(currThumbnail, currGroup);
	if (pos === (currImages.length - 1)) {
		prev.src = getAttr(currImages[currImages.length - 1], _const_dataattr) || currImages[currImages.length - 1].src;
		next.src = getAttr(currImages[0].src, _const_dataattr) || currImages[0].src;
	}
	else if (pos === 0) {
		prev.src = getAttr(currImages[currImages.length - 1], _const_dataattr) || currImages[currImages.length - 1].src;
		next.src = getAttr(currImages[1], _const_dataattr) || currImages[1].src;
	}
	else {
		prev.src = getAttr(currImages[pos - 1], _const_dataattr) || currImages[pos - 1].src;
		next.src = getAttr(currImages[pos + 1], _const_dataattr) || currImages[pos + 1].src;
	}
}
function initControls() {
	if (!nextBtn) {
		nextBtn = document.createElement('span');
		addClass(nextBtn, _const_class_prefix + '-next');
		if (LX.opt.nextImg) {
			var nextBtnImg = document.createElement('img');
			nextBtnImg.setAttribute('src', LX.opt.nextImg);
			nextBtn.appendChild(nextBtnImg);
		}
		else {
			addClass(nextBtn, _const_class_prefix + '-no-img');
		}
		addEvent(nextBtn, 'click', function (e) {
			stopPropagation(e);
			LX.next();
		}, false);
		LX.box.appendChild(nextBtn);
	}
	addClass(nextBtn, _const_class_prefix + '-active');
	if (!prevBtn) {
		prevBtn = document.createElement('span');
		addClass(prevBtn, _const_class_prefix + '-prev');
		if (LX.opt.prevImg) {
			var prevBtnImg = document.createElement('img');
			prevBtnImg.setAttribute('src', LX.opt.prevImg);
			prevBtn.appendChild(prevBtnImg);
		}
		else {
			addClass(prevBtn, _const_class_prefix + '-no-img');
		}
		addEvent(prevBtn, 'click', function (e) {
			stopPropagation(e);
			LX.prev();
		}, false);
		LX.box.appendChild(prevBtn);
	}
	addClass(prevBtn, _const_class_prefix + '-active');
}
function setOpt(opt) {
	if (!opt) {
		opt = {};
	}
	function setTrueDef(val) {
		return typeof val === 'boolean' ? val : true;
	}
	LX.opt = {
		boxId: opt.boxId || false,
		controls: setTrueDef(opt.controls),
		dimensions: setTrueDef(opt.dimensions),
		captions: setTrueDef(opt.captions),
		prevImg: typeof opt.prevImg === 'string' ? opt.prevImg : false,
		nextImg: typeof opt.nextImg === 'string' ? opt.nextImg : false,
		hideCloseBtn: opt.hideCloseBtn || false,
		closeOnClick: typeof opt.closeOnClick === 'boolean' ? opt.closeOnClick : true,
		nextOnClick: setTrueDef(opt.nextOnClick),
		preload: setTrueDef(opt.preload),
		carousel: setTrueDef(opt.carousel),
		responsive: setTrueDef(opt.responsive),
		maxImgSize: opt.maxImgSize || 0.8,
		keyControls: setTrueDef(opt.keyControls),
		hideOverflow: opt.hideOverflow || true,
		onopen: opt.onopen || false,
		onclose: opt.onclose || false,
		onload: opt.onload || false,
		onresize: opt.onresize || false,
		onloaderror: opt.onloaderror || false
	};
	if (LX.opt.boxId) {
		LX.box = document.getElementById(LX.opt.boxId);
		var classes = LX.box.getAttribute('class');
		if (classes.search(_const_class_prefix + ' ') < 0) {
			LX.box.setAttribute('class', classes + ' ' + _const_class_prefix);
		}
	}
	else if (!LX.box) {
		var newEl = document.getElementById(_const_id_prefix);
		if (!newEl) {
			newEl = document.createElement('div');
		}
		newEl.setAttribute('id', _const_id_prefix);
		newEl.setAttribute('class', _const_class_prefix);
		LX.box = newEl;
		body.appendChild(LX.box);
	}
	LX.box.innerHTML = template;
	if (isIE8) {
		addClass(LX.box, _const_class_prefix + '-ie8');
	}
	LX.wrapper = document.getElementById(_const_id_prefix + '-contentwrapper');
	if (!LX.opt.hideCloseBtn) {
		var closeBtn = document.createElement('span');
		closeBtn.setAttribute('id', _const_id_prefix + '-close');
		closeBtn.setAttribute('class', _const_class_prefix + '-close');
		closeBtn.innerHTML = '\u00D7';
		LX.box.appendChild(closeBtn);
		addEvent(closeBtn, 'click', function (e) {
			stopPropagation(e);
			LX.close();
		}, false);
	}
	if (!isIE8 && LX.opt.closeOnClick) {
		addEvent(LX.box, 'click', function (e) {
			stopPropagation(e);
			LX.close();
		}, false);
	}
	if (LX.opt.responsive) {
		addEvent(window, 'resize', function () {
			LX.resize();
		}, false);
		addClass(LX.box, _const_class_prefix + '-nooverflow');
	}
	else {
		removeClass(LX.box, _const_class_prefix + '-nooverflow');
	}
	if (LX.opt.keyControls) {
		addEvent(document, 'keydown', function (e) {
			if (isOpen) {
				stopPropagation(e);
				if (e.keyCode === 39) {
					LX.next();
				} else if (e.keyCode === 37) {
					LX.prev();
				} else if (e.keyCode === 27) {
					LX.close();
				}
			}
		}, false);
	}
}
function openBox(el, group, cb, event) {
	if (!el && !group) {
		return false;
	}
	currGroup = group || currGroup || getAttr(el, _const_dataattr + '-group');
	if (currGroup) {
		currImages = getByGroup(currGroup);
		if (typeof el === 'boolean' && !el) {
			el = currImages[0];
		}
	}
	currImage.img = new Image();
	currThumbnail = el;
	var src;
	if (typeof el === 'string') {
		src = el;
	}
	else if (getAttr(el, _const_dataattr)) {
		src = getAttr(el, _const_dataattr);
	}
	else {
		src = getAttr(el, 'src');
	}
	imgRatio = false;
	if (!isOpen) {
		isOpen = true;
		if (LX.opt.onopen) {
			LX.opt.onopen(currImage);
		}
	}
	if (!LX.opt || !isset(LX.opt.hideOverflow) || LX.opt.hideOverflow) {
		body.setAttribute('style', 'overflow: hidden');
	}
	LX.box.setAttribute('style', 'padding-top: 0');
	LX.wrapper.innerHTML = '';
	LX.wrapper.appendChild(currImage.img);
	var captionText = getAttr(el, _const_dataattr + '-caption');
	if (captionText && LX.opt.captions) {
		var caption = document.createElement('p');
		caption.setAttribute('class', _const_class_prefix + '-caption');
		caption.innerHTML = captionText;
		LX.wrapper.appendChild(caption);
	}
	addClass(LX.box, _const_class_prefix + '-active');
	if (isIE8) {
		addClass(LX.wrapper, _const_class_prefix + '-active');
	}
	if (LX.opt.controls && currImages.length > 1) {
		initControls();
	}
	currImage.img.onerror = function (imageErrorEvent) {
		if (LX.opt.onloaderror) {
			imageErrorEvent._happenedWhile = event ? event : false;
			LX.opt.onloaderror(imageErrorEvent);
		}
	};
	currImage.img.onload = function () {
		currImage.originalWidth = this.naturalWidth || this.width;
		currImage.originalHeight = this.naturalHeight || this.height;
		if (isIE8 || isIE9) {
			var dummyImg = new Image();
			dummyImg.setAttribute('src', src);
			currImage.originalWidth = dummyImg.width;
			currImage.originalHeight = dummyImg.height;
		}
		var checkClassInt = setInterval(function () {
			if (hasClass(LX.box, _const_class_prefix + '-active')) {
				addClass(LX.wrapper, _const_class_prefix + '-wrapper-active');
				if (cb) {
					cb();
				}
				if (LX.opt.preload) {
					preload();
				}
				if (LX.opt.nextOnClick) {
					addClass(currImage.img, _const_class_prefix + '-next-on-click');
					addEvent(currImage.img, 'click', function (e) {
						stopPropagation(e);
						return false;
					}, false);
				}
				if (LX.opt.onimageclick) {
					addEvent(currImage.img, 'click', function (e) {
						stopPropagation(e);
						return false;
					}, false);
				}
				if (LX.opt.onload) {
					LX.opt.onload(event);
				}
				clearInterval(checkClassInt);
				LX.resize();
			}
		}, 10);
	};
	currImage.img.setAttribute('src', src);
}
LX.load = function (opt) {
	if (navigator.appVersion.indexOf('MSIE 8') > 0) {
		isIE8 = true;
	}
	if (navigator.appVersion.indexOf('MSIE 9') > 0) {
		isIE9 = true;
	}
	setOpt(opt);
	var arr = document.querySelectorAll('[' + _const_dataattr + ']');
	for (var i = 0; i < arr.length; i++) {
		if (hasAttr(arr[i], _const_dataattr)) {
			arr[i].setAttribute(_const_dataattr + '-index', i);
			LX.thumbnails.push(arr[i]);
		}
	}
};
LX.open = function (el, group) {
	if (el && group) {
		group = false;
	}
	openBox(el, group, false, false);
};
LX.resize = function () {
	if (!currImage.img) {
		return;
	}
	maxWidth = getWidth();
	maxHeight = getHeight();
	var boxWidth = LX.box.offsetWidth;
	var boxHeight = LX.box.offsetHeight;
	if (!imgRatio && currImage.img && currImage.img.offsetWidth && currImage.img.offsetHeight) {
		imgRatio = currImage.img.offsetWidth / currImage.img.offsetHeight;
	}
	if (Math.floor(boxWidth / imgRatio) > boxHeight) {
		newImgWidth = boxHeight * imgRatio;
		newImgHeight = boxHeight;
	}
	else {
		newImgWidth = boxWidth;
		newImgHeight = boxWidth / imgRatio;
	}
	newImgWidth = Math.floor(newImgWidth * LX.opt.maxImgSize);
	newImgHeight = Math.floor(newImgHeight * LX.opt.maxImgSize);
	if (LX.opt.dimensions && newImgHeight > currImage.originalHeight ||
		LX.opt.dimensions && newImgWidth > currImage.originalWidth) {
		newImgHeight = currImage.originalHeight;
	newImgWidth = currImage.originalWidth;
}
currImage.img.setAttribute('width', newImgWidth);
currImage.img.setAttribute('height', newImgHeight);
if (LX.opt.onresize) {
	LX.opt.onresize(currImage);
}
};
LX.next = function () {
	if (!currGroup) {
		return;
	}
	var pos = getPos(currThumbnail, currGroup) + 1;
	if (currImages[pos]) {
		currThumbnail = currImages[pos];
	}
	else if (LX.opt.carousel) {
		currThumbnail = currImages[0];
	}
	else {
		return;
	}
	openBox(currThumbnail, false, false, 'next');
};
LX.prev = function () {
	if (!currGroup) {
		return;
	}
	var pos = getPos(currThumbnail, currGroup) - 1;
	if (currImages[pos]) {
		currThumbnail = currImages[pos];
	}
	else if (LX.opt.carousel) {
		currThumbnail = currImages[currImages.length - 1];
	}
	else {
		return;
	}
	openBox(currThumbnail, false, false, 'prev');
};
LX.close = function () {
	currGroup = false;
	currThumbnail = false;
	var _currImage = currImage;
	currImage = {};
	currImages = [];
	isOpen = false;
	removeClass(LX.box, _const_class_prefix + '-active');
	removeClass(LX.wrapper, _const_class_prefix + '-wrapper-active');
	removeClass(nextBtn, _const_class_prefix + '-active');
	removeClass(prevBtn, _const_class_prefix + '-active');
	LX.box.setAttribute('style', 'padding-top: 0px');
	if (isIE8) {
		LX.box.setAttribute('style', 'display: none');
	}
	if (!LX.opt || !isset(LX.opt.hideOverflow) || LX.opt.hideOverflow) {
		body.setAttribute('style', 'overflow: auto');
	}
	if (LX.opt.onclose) {
		LX.opt.onclose(_currImage);
	}
};
};

var lightbox = new aemi_lightbox();

var cies = {
	get : function ( cn ) {
		var cn_ = cn + "=";
		var dC = decodeURIComponent( document.cookie );
		var ca = dC.split(';');
		for ( var i=0 ; i < ca.length ; i++ ) {
			var c = ca[i];
			while ( c.charAt( 0 ) == ' ' ) {
				c = c.substring(1);
			}
			if ( c.indexOf( cn_ ) == 0 ) {
				return c.substring( cn_.length, c.length );
			}
		}
		return"";
	},
	set : function ( cn, cc ) {
		let d = new Date(),
		t = 365.25 * 24 * 3600 * 1000;
		d.setTime( d.getTime() + t );
		let e = "expires=" + d.toUTCString();
		document.cookie = cn + "=" + cc + ";" + e + ";path=/";
	},
	del : function ( cn ) {
		let d = new Date(),
		t = 365.25 * 24 * 3600 * 1000;
		d.setTime( d.getTime() - 1 );
		let e = "expires=" + d.toUTCString();
		document.cookie = cn + "=null;" + e + ";path=/";
	}
};

if ( !aemi_exist( aemi_menu ) ) {
	var aemi_menu = function () {
		var a = document.querySelectorAll(".menu");
		for (let i = 0; i < a.length; i++) {
			var b = a[i].querySelectorAll(".menu-item-has-children");
			for (let j = 0; j < b.length; j++) {
				let c = document.createElement("div");
				c.innerHTML = '<div class="toggle-element"><span></span><span></span></div>';
				c.classList.add("toggle");
				b[j].insertBefore(c, b[j].childNodes[1]);
			}
		}
	};
} aemi.push( aemi_menu );
if ( !aemi_exist( aemi_toggle ) ) {
	var aemi_toggle = function () {
		var s = [ "toggle-header-menu", "toggled", "no-overflow", "blurred" ],
		t = document.querySelectorAll( ".toggle" );
		for ( let i = 0 ; i < t.length ; i++ ) {
			t[i].addEventListener( "click", function () {
				this.classList.toggle( s[1] );
				if ( this === document.getElementById( s[0] ) )
				{
					document.body.classList.toggle( s[2] );
					document.body.classList.toggle( s[3] );
				}
			}, false );
		}
	};
} aemi.push( aemi_toggle );
if ( !aemi_exist( aemi_galleries ) ) {
	var aemi_galleries = function () {
		var a = document.querySelectorAll( "div.gallery, .wp-block-gallery, .justified-gallery" );
		if ( a !== null ) {
			for ( var i = 0 ; i < a.length ; i++ ) {
				let b = a[i].querySelectorAll( ".gallery-item, .blocks-gallery-item, .jg-entry" );
				for ( var j = 0 ; j < b.length ; j++ ) {
					let c = b[j].querySelector( "a" ) ? b[j].querySelector( "a" ) : b[j].querySelector( "img" ) ;
					c.setAttribute( "data-aemisw", c.href || c.src );
					c.setAttribute( "data-aemisw-group", i );
				}
			}
		}
	};
} aemi.push( aemi_galleries );
if ( !aemi_exist( aemi_dark ) ) {
	var aemi_dark = function () {
		var a = document.getElementById("darkmode");
		var b = cies.get("darkmode");
		var c = window.matchMedia('(prefers-color-scheme: dark)');
		if ( a !== null ) {
			if ( b === "" ) {
				if ( aemi_timetochange || c ) {
					document.body.classList.add( "darkui" );
					a.classList.add( "activated" );
				}
			} else {
				if ( b === "force-true" ) {
					document.body.classList.add( "darkui" );
					a.classList.add( "activated" );
				}
			}
			a.addEventListener( "click", function () {
				document.body.classList.toggle( "darkui" );
				if ( document.body.classList.contains( "darkui" ) ) {
					a.classList.add( "activated" );
					if ( aemi_timetochange || c ) {
						cies.del( "darkmode" );
					} else {
						cies.set( "darkmode", "force-true" );
					}
				} else {
					a.classList.remove( "activated" );
					if ( aemi_timetochange || c ) {
						cies.set( "darkmode", "force-false" );
					} else {
						cies.del( "darkmode" );
					}
				}
			}, false );
		}
	};
} aemi.push( aemi_dark );

aemi.push( function () { lightbox.load(); } );


for ( var i in aemi ) { aemi[i](); }
