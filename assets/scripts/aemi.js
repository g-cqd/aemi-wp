'use script';
function blockScroll(env) {
	env.set('lastScroll',window.scrollY);
	console.log(env.get('lastScroll'));
	addClass( document.body, 'no-overflow', false );
}

function freeScroll( env ) {
	When.delay(()=> {
		removeClass( document.body, 'no-overflow', false );      
    	window.scrollBy(0,env.get('lastScroll'));
	}, 200 );
}

class Lightbox {
	constructor(options, name) {
		'use strict';
		/** Lightbox Name */
		this.name = name || 'lightbox';
		/** Options */
		this.options = options || {};
		/** Box */
		this.box = null;
		/** Wrapper */
		this.wrapper = null;
		/** Thumbnails */
		this.thumbnails = [];
		/** Avoid Scoping */
		const $s = this;
		/** ClassName Formatter */
		this.an = function($0) {
			$0 = $0 || '';
			return $s.name + ($0 && $0 !== '' ? '-' + $0 : '');
		};
		/** Dataset Attribute Name Formatter */
		this.dn = function($0) {
			$0 = $0 || '';
			return 'data-' + $s.name + ($0 && $0 !== '' ? '-' + $0 : '');
		};
		/** Document Body */
		this.body = document.body;
		/** Template */
		this.template = ecs({id:this.an('content-wrapper'),class:[this.an('content-wrapper')]});
		/** Current Values */
		this.current = {
			imageRatio: null,
			group: null,
			thumbnail: null,
			image: {},
			images: [],
		};
		this.openState = false;
		/** Animation Parameters */
		this.animation = {
			element: null,
			interval: null,
			children: [],
			timeout: null,
		};
		/** Controls */
		this.controls = {
			nextButton: null,
			prevButton: null,
		};
		/** Resize Values */
		this.r = {
			maxWidth: null,
			maxHeight: null,
			nIw: null,
			nIh: null,
		};
	}
	get height() {
		'use strict';
		return window.innerHeight;
	}
	get width() {
		'use strict';
		return window.innerWidth;
	}
	push() {
		'use strict';
		try {
			for (const element of arguments) {
				element.addEventListener('click', event => {
					'use strict';
					event.stopPropagation();
					event.preventDefault();
					this.current.group = element.getAttribute(this.dn('group')) || false;
					this.current.thumbnail = element;
					this.open(element, false, false, false);
				});
				this.thumbnails.push(element);
			}
		} catch (error) {
			return catchError(error);
		}
		return true;
	}
	getByGroup(group) {
		'use strict';
		return [...this.thumbnails.filter(thumb => thumb.getAttribute(this.dn('group')) === group)];
	}
	getPosition(thumbnail, group) {
		'use strict';
		const thumbnails = this.getByGroup(group);
		for (let i = 0, l = thumbnails.length; i < l; i += 1) {
			const clause1 = thumbnail.getAttribute('src') === thumbnails[i].getAttribute('src');
			const clause2 = thumbnail.getAttribute(this.dn('index')) === thumbnails[i].getAttribute(this.dn('index'));
			const clause3 = thumbnail.getAttribute(this.dn()) === thumbnails[i].getAttribute(this.dn());
			if (clause1 && clause2 && clause3) {
				return i;
			}
		}
	}
	prepare($0) {
		'use strict';
		const { wrapperSelectors: $1, itemSelectors: $2, captionSelectors: $3 } = $0;
		const $4 = ($1[0] ? [...$1] : [$1]).join(',');
		const $5 = ($2[0] ? [...$2] : [$2]).join(',');
		const $6 = ($3[0] ? [...$3] : [$3]).join(',');
		const $7 = document.querySelectorAll($4);
		if ($7.length > 0) {
			for (let $8 = 0, $n = $7.length; $8 < $n; $8 += 1) {
				const $9 = $7.item($8);
				for (const $10 of $9.querySelectorAll($5)) {
					const $11 = $10.getElementsByTagName('a')[0] || $10.getElementsByTagName('img')[0];
					if ($11.tagName === 'A') {
						if (/\.(jpg|gif|png)$/.test($11.href)) {
							$11.setAttribute(this.dn(), $11.href);
							$11.setAttribute(this.dn('group'), $8);
							const $12 = $10.querySelector($6);
							if ($12) {
								$11.setAttribute(this.dn('caption'), $12.innerText);
							}
						}
					} else {
						$11.setAttribute(this.dn(), $11.src);
						$11.setAttribute(this.dn('group'), $8);
						const $13 = $10.querySelector($6);
						if ($13) {
							$11.setAttribute(this.dn('caption'), $13.innerText);
						}
					}
				}
			}
			this.load();
			for (const $0 of $7) {
				for (const $1 of $0.querySelectorAll($5)) {
					try {
						const $2 = $1.querySelector($6);
						if (is($2)) {
							$2.addEventListener('click', $0 => {
								$0.preventDefault();
								$0.stopPropagation();
								$1.querySelector('a, img').dispatchEvent(new Event('click'));
							});
						}
					} catch ($e) {
						catchError($e);
					}
				}
			}
		}
	}
	preload() {
		'use strict';
		const {
			current: { group, images, thumbnail },
		} = this;
		if (!group) {
			return false;
		}
		try {
			const $0 = new Image();
			const $1 = new Image();
			const $2 = this.getPosition(thumbnail, group);
			if ($2 === images.length - 1) {
				$0.src = images[images.length - 1].getAttribute(this.dn()) || images[images.length - 1].src;
				$1.src = images[0].getAttribute(this.dn()) || images[0].src;
			} else if ($2 === 0) {
				$0.src = images[images.length - 1].getAttribute(this.dn()) || images[images.length - 1].src;
				$1.src = images[1].getAttribute(this.dn()) || images[1].src;
			} else {
				$0.src = images[$2 - 1].getAttribute(this.dn()) || images[$2 - 1].src;
				$1.src = images[$2 + 1].getAttribute(this.dn()) || images[$2 + 1].src;
			}
		} catch ($e) {
			return catchError($e);
		}
	}
	startAnimation() {
		'use strict';
		const {
			options: { loadingAnimation: $0 },
		} = this;
		this.stopAnimation();
		this.animation.timeout = setTimeout(() => {
			addClass(this.box, this.an('loading'));
			if (typeof $0 === 'number') {
				let $1 = 0;
				this.animation.interval = setInterval(() => {
					addClass(this.animation.children[$1], this.an('active'));
					setTimeout(() => {
						removeClass(this.animation.children[$1], this.an('active'));
					}, $0);
					$1 = $1 >= this.animation.children.length ? 0 : ($1 += 1);
				}, $0);
			}
		}, 500);
	}
	stopAnimation() {
		'use strict';
		const {
			options: { loadingAnimation: $0 },
		} = this;
		removeClass(this.box, this.an('loading'));
		if (typeof $0 !== 'string' && $0) {
			clearInterval(this.animation.interval);
			for (const $1 of this.animation.children) {
				removeClass($1, this.an('active'));
			}
		}
	}
	initializeControls() {
		'use strict';
		const $s = this;
		if (!this.controls.nextButton) {
			let _ = [];
			let c = [this.an('next')];
			if (this.options.nextImage) {
				_.push({$:'img',attr:{src:this.options.nextButtonImage}});
			} else {
				c.push( this.an('no-img') )
			}
			this.controls.nextButton = ecs({$:'span',class:c,_:_,events:[['click',ev=>{ev.stopPropagation();this.next();}]]});
			this.box.appendChild(this.controls.nextButton);
		}
		addClass(this.controls.nextButton, this.an('active'));
		if (!this.controls.prevButton) {
			let _ = [];
			let c = [this.an('prev')];
			if (this.options.prevImage) {
				_.push( {$:'img',attr:{src:this.options.previousImage}} )
			} else {
				c.push( this.an('no-img') );
			}
			this.controls.prevButton = ecs({$:'span',class:c,_:_,events:[['click',ev=>{ev.stopPropagation();this.prev();}]]});
			this.box.appendChild(this.controls.prevButton);
		}
		addClass(this.controls.prevButton, this.an('active'));
	}
	repositionControls() {
		'use strict';
		if (this.options.responsive && this.controls.nextButton && this.controls.prevButton) {
			const $0 = this.height / 2 - this.controls.nextButton.offsetHeight / 2;
			this.controls.nextButton.style.top = $0 + 'px';
			this.controls.prevButton.style.top = $0 + 'px';
		}
	}
	setOptions($0) {
		'use strict';
		$0 = $0 || {};
		this.options = {
			boxId: $0.boxId || false,
			controls: $0.controls || true,
			dimensions: $0.dimensions || true,
			captions: $0.captions || true,
			prevImage: typeof $0.prevImage === 'string' ? $0.prevImage : false,
			nextImage: typeof $0.nextImage === 'string' ? $0.nextImage : false,
			hideCloseButton: $0.hideCloseButton || false,
			closeOnClick: $0.closeOnClick || true,
			nextOnClick: $0.nextOnClick || true,
			loadingAnimation: $0.loadingAnimation || true,
			animationElementCount: $0.animationElementCount || 4,
			preload: $0.preload || true,
			carousel: $0.carousel || true,
			animation: typeof $0.animation === 'number' || $0.animation === false ? $0.animation : 400,
			responsive: $0.responsive || true,
			maxImageSize: $0.maxImageSize || 0.8,
			keyControls: $0.keyControls || true,
			hideOverflow: $0.hideOverflow || true,
			onopen: $0.onopen || false,
			onclose: $0.onclose || false,
			onload: $0.onload || false,
			onresize: $0.onresize || false,
			onloaderror: $0.onloaderror || false,
			onimageclick: $0.onimageclick || false,
		};
		let {
			boxId,
			controls,
			dimensions,
			captions,
			prevImage,
			nextImage,
			hideCloseButton,
			closeOnClick,
			nextOnClick,
			loadingAnimation,
			animationElementCount,
			preload,
			carousel,
			animation,
			responsive,
			maxImageSize,
			keyControls,
			hideOverflow,
			onopen,
			onclose,
			onload,
			onresize,
			onloaderror,
			onimageclick,
		} = this.options;
		if (boxId) {
			this.box = id(this.options.boxId);
			addClass(this.box, this.an());
		}
		else if (!this.box) {
			let $1 = id(this.an()) || document.createElement('div');
			$1.id = this.an();
			addClass($1, this.an());
			this.box = $1;
			this.body.appendChild(this.box);
		}
		this.box.innerHTML = this.template.outerHTML;
		this.wrapper = id(this.an('content-wrapper'));
		if (!hideCloseButton) {
			const $2 = document.createElement('span');
			$2.id = this.an('close');
			addClass($2, this.an('close'));
			$2.innerHTML = '&#x2717;';
			$2.addEventListener('click', ev => {
				ev.stopPropagation();
				this.close();
			});
			this.box.appendChild($2);
		}
		if (closeOnClick) {
			this.box.addEventListener('click', ev => {
				ev.stopPropagation();
				this.close();
			});
		}
		if (typeof loadingAnimation === 'string') {
			this.animation.element = new Image();
			this.animation.element.src = loadingAnimation;
			addClass(this.animation.element, this.an('loading-animation'));
			this.box.appendChild(this.animation.element);
		} else if (loadingAnimation) {
			loadingAnimation = typeof loadingAnimation === 'number' ? loadingAnimation : 200;
			this.animation.element = document.createElement('div');
			addClass(this.animation.element, this.an('loading-animation'));
			for (let $5 = 0; $5 < animationElementCount; $5 += 1) {
				this.animation.children.push(this.animation.element.appendChild(document.createElement('span')));
			}
			this.box.appendChild(this.animation.element);
		}
		if (responsive) {
			window.addEventListener('resize', () => {
				this.resize();
			});
			blockScroll( this.options.env );
		} else {
			freeScroll( this.options.env );
		}
		if (keyControls) {
			document.addEventListener('keydown', $0 => {
				if (this.openState) {
					$0.stopPropagation();
					switch ($0.keyCode) {
						case 39: {
							this.next();
							break;
						}
						case 37: {
							this.prev();
							break;
						}
						case 27: {
							this.close();
							break;
						}
						default: {
							break;
						}
					}
				}
			});
		}
	}
	open($0, $1, $2, $3) {
		if ($0 && $1) {
			$1 = false;
		}
		if (!$0 && !$1) {
			return false;
		}
		this.current.group = $1 || this.current.group || $0.getAttribute(this.dn('group'));
		if (this.current.group) {
			this.current.images = this.getByGroup(this.current.group);
			if ($0 === false) {
				$0 = this.current.images[0];
			}
		}
		this.current.image.img = new Image();
		this.current.thumbnail = $0;
		let $4;
		if (typeof $0 === 'string') {
			$4 = $0;
		} else if ($0.getAttribute(this.dn())) {
			$4 = $0.getAttribute(this.dn());
		} else {
			$4 = $0.src;
		}
		this.current.imageRatio = false;
		if (!this.openState) {
			if (typeof this.options.animation === 'number') {
				addClass(this.current.image.img, this.an('animate-transition'));
				addClass(this.current.image.img, this.an('animate-init'));
			}
			this.openState = true;
			if (this.options.onopen) {
				this.options.onopen(this.current.image);
			}
		}
		if (!this.options || !('hideOverflow' in this.options) || this.options.hideOverflow) {
			blockScroll(this.options.env);
		}
		this.box.style.paddingTop = '0';
		this.wrapper.innerHTML = '';
		this.wrapper.appendChild(this.current.image.img);
		if (this.options.animation) {
			addClass(this.wrapper, this.an('animate'));
		}
		const $5 = $0.getAttribute(this.dn('caption'));
		if ($5 && this.options.captions) {
			let $6 = document.createElement('p');
			addClass($6, this.an('caption'));
			$6.innerHTML = $5;
			this.wrapper.appendChild($6);
		}
		addClass(this.box, this.an('active'));
		if (this.options.controls && this.current.images.length > 1) {
			this.initializeControls();
			this.repositionControls();
		}
		this.current.image.img.addEventListener('error', $0 => {
			if (this.options.onloaderror) {
				$0._happenedWhile = $3 ? $3 : false;
				this.options.onloaderror($0);
			}
		});
		this.current.image.img.addEventListener('load', ({ target: $0 }) => {
			this.current.image.originalWidth = $0.naturalWidth || $0.width;
			this.current.image.originalHeight = $0.naturalHeight || $0.height;
			const $1 = setInterval(() => {
				if (hasClass(this.box, this.an('active'))) {
					addClass(this.wrapper, this.an('wrapper-active'));
					if (typeof this.options.animation === 'number') {
						addClass(this.current.image.img, this.an('animate-transition'));
					}
					if ($2) {
						$2();
					}
					this.stopAnimation();
					clearTimeout(this.animation.timeout);
					if (this.options.preload) {
						this.preload();
					}
					if (this.options.nextOnClick) {
						addClass(this.current.image.img, this.an('next-on-click'));
						this.current.image.img.addEventListener('click', $0 => {
							$0.stopPropagation();
							this.next();
						});
					}
					if (this.options.onimageclick) {
						this.current.image.img.addEventListener('click', $0 => {
							$0.stopPropagation();
							this.options.onimageclick(this.current.image);
						});
					}
					if (this.options.onload) {
						this.options.onload($3);
					}
					clearInterval($1);
					this.resize();
				}
			}, 10);
		});
		this.current.image.img.src = $4;
		this.startAnimation();
	}
	load($0) {
		$0 = $0 || this.options;
		this.setOptions($0);
		const $1 = document.querySelectorAll('[' + this.dn() + ']');
		for (let $2 = 0, $n = $1.length; $2 < $n; $2 += 1) {
			const $3 = $1.item($2);
			if ($3.hasAttribute(this.dn())) {
				$3.setAttribute(this.dn('index'), $2);
				this.push($3);
			}
		}
	}
	resize() {
		if (!this.current || !this.current.image.img) {
			return;
		}
		this.r.maxWidth = this.width;
		this.r.maxHeight = this.height;
		const $0 = this.box.offsetWidth;
		const $1 = this.box.offsetHeight;
		if (!this.current.imageRatio && this.current.image.img && this.current.image.img.offsetWidth && this.current.image.img.offsetHeight) {
			this.current.imageRatio = this.current.image.img.offsetWidth / this.current.image.img.offsetHeight;
		}
		// Height of image is too big to fit in viewport
		if (Math.floor($0 / this.current.imageRatio) > $1) {
			this.r.newImageWidth = $1 * this.current.imageRatio;
			this.r.newImageHeight = $1;
		}
		// Width of image is too big to fit in viewport
		else {
			this.r.newImageHeight = $0;
			this.r.newImageWidth = $0 / this.current.imageRatio;
		}
		// decrease size with modifier
		this.r.newImageWidth = Math.floor(this.r.newImageWidth * this.options.maxImageSize);
		this.r.newImageHeight = Math.floor(this.r.newImageHeight * this.options.maxImageSize);
		// check if image exceeds maximum size
		if ((this.options.dimensions && this.r.newImageHeight > this.current.image.originalHeight) || (this.options.dimensions && this.r.newImageWidth > this.current.image.originalWidth)) {
			this.r.newImageHeight = this.current.image.originalHeight;
			this.r.newImageWidth = this.current.image.originalWidth;
		}
		this.current.image.img.setAttribute('width', this.r.newImageWidth);
		this.current.image.img.setAttribute('height', this.r.newImageHeight);
		// reposition controls after timeout
		setTimeout(() => {
			this.repositionControls();
		}, 200);
		if (this.options.onresize) {
			this.options.onresize(this.current.image);
		}
	}
	next() {
		if (!this.current.group) {
			return;
		}
		const {
			current: { thumbnail, group, images },
		} = this;
		const $0 = this.getPosition(thumbnail, group) + 1;
		if (images[$0]) {
			this.current.thumbnail = images[$0];
		} else if (this.options.carousel) {
			this.current.thumbnail = images[0];
		} else {
			return;
		}
		if (this.options.animation === 'number') {
			removeClass(this.current.image.img, this.an('animating-next'));
			setTimeout(() => {
				this.open(
					this.current.thumbnail,
					false,
					() => {
						setTimeout(() => {
							addClass(this.current.image.img, this.an('animating-next'));
						}, this.options.animation / 2);
					},
					'next'
				);
			}, this.options.animation / 2);
		} else {
			this.open(this.current.thumbnail, false, false, 'next');
		}
	}
	prev() {
		if (!this.current.group) {
			return;
		}
		const {
			current: { thumbnail, group, images },
		} = this;
		const $0 = this.getPosition(thumbnail, group) - 1;
		if (images[$0]) {
			this.current.thumbnail = images[$0];
		} else if (this.options.carousel) {
			this.current.thumbnail = images[images.length - 1];
		} else {
			return;
		}
		if (this.options.animation === 'number') {
			removeClass(this.current.image.img, this.an('animating-next'));
			setTimeout(() => {
				this.open(
					this.current.thumbnail,
					false,
					() => {
						setTimeout(() => {
							addClass(this.current.image.img, this.an('animating-next'));
						}, this.options.animation / 2);
					},
					'prev'
				);
			}, this.options.animation / 2);
		} else {
			this.open(this.current.thumbnail, false, false, 'prev');
		}
	}
	close() {
		this.current.group = false;
		this.current.thumbnail = false;
		const $0 = this.current.image;
		this.current.image = {};
		this.current.images = [];
		this.openState = false;
		removeClass(this.box, this.an('active'));
		removeClass(this.wrapper, this.an('wrapper-active'));
		removeClass(this.controls.nextButton, this.an('active'));
		removeClass(this.controls.prevButton, this.an('active'));
		this.box.style.paddingTop = '0px';
		this.stopAnimation();
		if (!this.options || !('hideOverflow' in this.options) || this.options.hideOverflow) {
			freeScroll(this.options.env);
		}
		if (this.options.onclose) {
			this.options.onclose($0);
		}
	}
}
const aemi = new Environment();
try {
	if (isFunction(aemi_menu)) {
		aemi.push(aemi_menu);
	}
} catch ($e) {
	aemi.push(function aemi_menu() {
		'use strict';
		for (const menu of document.getElementsByClassName('menu')) {
			if (!['header-menu', 'header-social', 'footer-menu'].includes(menu.id)) {
				for (const parent of menu.getElementsByClassName('menu-item-has-children')) {
					if (parent.getElementsByTagName('li').length > 0) {
						parent.insertBefore(ecs({class:['toggle'],_:[{class:['toggle-element']}]}), parent.childNodes[1]);
					}
				}
			}
		}
	});
}
try {
	if (isFunction(aemi_toggle)) {
		aemi.push(aemi_toggle);
	}
} catch ($e) {
	aemi.push(function aemi_toggle() {
		'use strict';
		const $2 = ['navigation-toggle', 'search-toggle'];
		function $f1($0) {
			const $1 = id($0.dataset.target) || id($0.getAttribute('data-target'));
			toggleClass($1);
		}
		for (const $0 of document.getElementsByClassName('toggle')) {
			$0.addEventListener('click', () => {
				const { id: $1 } = $0;
				if (!$1 || !$2.includes($1)) {
					$f1($0);
					toggleClass($0);
				} else {
					$f1($0);
					const $7 = !toggleClass($0);
					for (const $8 of $2.filter(str => str !== $1)) {
						const $8_1 = id($8);
						if ($8_1 && hasClass($8_1)) {
							$f1($8_1);
							toggleClass($8_1);
						}
					}
					if ($1 === 'search-input') {
						setTimeout(() => {
							const $0 = id('search-input');
							return $0 ? $0.focus() : false;
						}, 200);
					}
					if (!hasClass(document.body, 'no-overflow') || $7) {
						if ( $2.filter( str => hasClass( id( str ) ) ) || $7 ) {
							blockScroll(aemi);
						}
					}
					else {
						freeScroll(aemi);
					}
				}
			});
		}
	});
}
try {
	if (isFunction(aemi_galleries)) {
		aemi.push(aemi_galleries);
	}
} catch ($e) {
	aemi.push(function aemi_galleries() {
		'use strict';
		return new Lightbox({env:aemi}).prepare({
			wrapperSelectors: ['div.gallery', '.wp-block-gallery', '.justified-gallery'],
			itemSelectors: ['.gallery-item', '.blocks-gallery-item', '.jg-entry'],
			captionSelectors: ['figcaption', '.gallery-caption'],
		});
	});
}
try {
	if (isFunction(aemi_dark)) {
		aemi.push(aemi_dark);
	}
} catch ($e) {
	aemi.push(function aemi_dark() {
		'use strict';
		const $0 = document.body;
		const $1 = id('color-scheme-selector');
		const $2 = {
			dark: 'dark',
			light: 'light',
		};
		const $3 = {
			dark: 'color-scheme-dark',
			light: 'color-scheme-light',
		};
		const $4 = {
			light: id('light-scheme-option'),
			dark: id('dark-scheme-option'),
			auto: id('auto-scheme-option'),
		};
		const $5 = {
			dark: !!window.matchMedia('( prefers-color-scheme: dark )').matches,
			light: !!window.matchMedia('( prefers-color-scheme: light )').matches,
		};
		function $f1($1) {
			removeClass($0, $3.dark);
			addClass($0, $3.light);
			if ($1) {
				Cookies.set('color-scheme', $2.light);
			}
		}
		function $f2($1) {
			removeClass($0, $3.light);
			addClass($0, $3.dark);
			if ($1) {
				Cookies.set('color-scheme', $2.dark);
			}
		}
		function $f3($1) {
			if ($5.dark ^ $5.light) {
				if ($5.dark) {
					removeClass($0, $3.light);
					addClass($0, $3.dark);
				} else {
					removeClass($0, $3.dark);
					addClass($0, $3.light);
				}
			} else {
				removeClass($0, $3.dark);
				addClass($0, $3.light);
			}
			if ($1) {
				Cookies.delete('color-scheme');
			}
		}
		function $f4() {
			let $1 = Cookies.get('color-scheme') || Cookies.get('darkmode');
			if ($1) {
				if (Cookies.has('darkmode')) {
					Cookies.delete('darkmode');
				}
				switch ($1) {
					case 'force-true':
					case 'dark': {
						$1 = 'dark';
						break;
					}
					case 'force-false':
					case 'light': {
						$1 = 'light';
						break;
					}
					default: {
						$1 = undefined;
						break;
					}
				}
				if ($1) {
					if ($1 === 'light') {
						removeClass($0, $3.dark);
						addClass($0, $3.light);
						$4.light.checked = true;
						Cookies.set('color-scheme', $2.light);
					} else {
						removeClass($0, $3.light);
						addClass($0, $3.dark);
						$4.dark.checked = true;
						Cookies.set('color-scheme', $2.dark);
					}
				}
			} else {
				$f3();
			}
		}
		$1.addEventListener('input', () =>
			requestFrame(() => {
				switch (true) {
					case $4.light.checked: $f1(true); break;
					case $4.dark.checked: $f2(true); break;
					case $4.auto.checked: $f3(true); break;
					default: break;
				}
			})
		);
		requestFrame($f4);
	});
}
try {
	if (isFunction(aemi_scroll_handler)) {
		aemi.push(aemi_scroll_handler);
	}
} catch ($e) {
	aemi.push(function aemi_scroll_handler() {
		'use strict';
		const $c1 = 'page-scrolled';
		const $c2 = 'header-hidden';
		const aemi_header_auto_hide = () =>
			requestFrame(() => {
				const $1 = {
					start: Math.round(window.performance.now()),
					height: document.body.clientHeight,
					scroll: window.scrollY,
				};
				setTimeout(
					($0, $1) =>
						requestFrame(
							($0, $1) => {
								const { start: $2, height: $3, scroll: $4 } = $1;
								const $5 = Math.round(window.performance.now());
								const $6 = window.scrollY;
								const $7 = id('navigation-toggle');
								const $8 = id('search-toggle');
								if ($4 > 0) {
									addClass($0, $c1);
								} else {
									removeClass($0, $c1);
								}
								if ((!$7 || !hasClass($7)) && (!$8 || !hasClass($8))) {
									const $9 = $5 - $2;
									if ($9 > 100) {
										const $10 = $6 - $4;
										const $11 = Math.round((1000 * $10) / $9);
										if (!hasClass($0, $c2)) {
											if ($11 > 0 && $4 > 0 && $4 + window.innerHeight < $3) {
												addClass($0, $c2);
											}
										} else if (($11 < 0 && $4 > 0 && $4 + window.innerHeight < $3) || $4 <= 0 || $4 + window.innerHeight >= $3) {
											removeClass($0, $c2);
										}
									}
								}
							},
							$0,
							$1
						),
					100,
					document.body,
					$1
				);
			});
		const aemi_progress_bar = $0 =>
			requestFrame(() => {
				const $1 = document.body.clientHeight - window.innerHeight;
				const $2 = window.scrollY / $1;
				console.log( document.body.clientHeight, window.innerHeight );
				$0.style.width = `${100 * ($2 > 1 ? 1 : $2)}vw`;
			}, $0);
		const $0 = [
			{
				test: [id('site-progress-bar')],
				useTest: true,
				func: aemi_progress_bar,
				args: [],
			},
			{
				test: [hasClass(document.body, 'auto-hide')],
				useTest: false,
				func: aemi_header_auto_hide,
				args: [],
			},
		];

		const $1 = [];

		$0.forEach( ({test, useTest, func, args}) => {
			if (test.filter($ => $).length > 0) {
				$1.push(useTest ? {args: [...args, ...test], func: func } : { args: [...args], func: func });
			}
		});

		window.addEventListener('scroll', function scroll() {
			$1.forEach( ({func,args}) => func(...args) );
		});
	});
}
aemi.run();
