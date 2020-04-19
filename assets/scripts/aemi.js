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
		this.Pr = {
			na: name || 'lightbox',
			bo: document.body,
			te: ecs({ id: this.in('content-wrapper'), class: [this.cn('content-wrapper')] }),
			Cu: { ir: null, gr: null, th: null, im: {}, is: [] },
			An: { el: null, in: null, ch: [], ti: null },
			Co: { nb: null, pb: null },
			Re: { mh: null, mw: null, nh: null, nw: null },
			St: { op: false },
			/** ID Formatter */
			in: _ => `${this.name}${iss(_) ? '-' + _ : ''}`,
			/** ClassName Formatter */
			cn: _ => `${this.name}${iss(_) ? '-' + _ : ''}`,
			/** Dataset Attribute Name Formatter */
			dn: _ => `data-${this.cn(_)}`
		};
		this.Pu = {
			op: options || {},
			bo: null,
			wr: null,
			th: []
		};
		Object.preventExtensions(this.Pr);
		Object.preventExtensions(this.Pu);
	}
	/** Lightbox Name */
	get name() { return this.Pr.na; }
	get in() { return this.Pr.in; }
	get cn() { return this.Pr.cn; }
	get dn() { return this.Pr.dn; }
	/** Document Body */
	get body() { return this.Pr.bo; }
	/** Template */
	get template() { return this.Pr.te; }
	/** Current Image Ratio */
	get currImgRatio() { return this.Pr.Cu.ir; }
	set currImgRatio(value) { this.Pr.Cu.ir = value; }
	/** Current Group */
	get currGroup() { return this.Pr.Cu.gr; }
	set currGroup(value) { this.Pr.Cu.gr = value; }
	/** First Clicked Image */
	get currThumbnail() { return this.Pr.Cu.th; }
	set currThumbnail(value) { this.Pr.Cu.th = value; }
	/** Currently Shown Image */
	get currImage() { return this.Pr.Cu.im; }
	set currImage(value) { this.Pr.Cu.im = value; }
	/** Images belonging to current group */
	get currImages() { return this.Pr.Cu.is; }
	/** Reference to Animation Element */
	get animElement() { return this.Pr.An.el; }
	set animElement(value) { this.Pr.An.el = value; }
	/** Animation Interval */
	get animInterval() { return this.Pr.An.in; }
	set animInterval(value) { this.Pr.An.in = value; }
	/** Childs to Animate */
	get animChildren() { return this.Pr.An.ch; }
	/** Timeout until animation starts */
	get animTimeout() { return this.Pr.An.ti; }
	set animTimeout(value) { this.Pr.An.ti = value; }
	/** Next Button */
	get nextButton() { return this.Pr.Co.nb; }
	set nextButton(value) { this.Pr.Co.nb = value; }
	/** Previous Button */
	get prevButton() { return this.Pr.Co.pb; }
	set prevButton(value) { this.Pr.Co.pb = value; }
	get maxHeight() { return this.Pr.Re.mh; }
	set maxHeight(value) { this.Pr.Re.mh = value; }
	get maxWidth() { return this.Pr.Re.mw; }
	set maxWidth(value) { this.Pr.Re.mw = value; }
	get newImageHeight() { return this.Pr.Re.nh; }
	set newImageHeight(value) { this.Pr.Re.nh = value; }
	get newImageWidth() { return this.Pr.Re.nw; }
	set newImageWidth(value) { this.Pr.Re.nw = value; }
	/** Is box opened ? */
	get isOpen() { return this.Pr.St.op; }
	set isOpen(value) { this.Pr.St.op = value; }
	/** Lightbox Options */
	get options() { return this.Pu.op; }
	set options(value) { this.Pu.op = value; }
	/** Lightbox */
	get box() { return this.Pu.bo; }
	set box(value) { this.Pu.bo = value; }
	/** Lightbox Wrapper */
	get wrapper() { return this.Pu.wr; }
	set wrapper(value) { this.Pu.wr = value; }
	/** List of Thumbnails */
	get thumbnails() { return this.Pu.th; }
	/** Window Height */
	get height() { return window.innerHeight; }
	/** Window Width */
	get width() { return window.innerWidth; }
	
	push() {
		for (const el of arguments) {
			el.addEventListener('click', event => {
				inhibitEvent(event);
				this.currGroup = attr(el,this.dn('group')) || false;
				this.currThumbnail = el;
				this.open(el, false, false, false);
			});
		}
		return this.thumbnails.push(...arguments);
	}
	getByGroup(g) {
		return [...this.thumbnails.filter(t => attr(t,this.dn('group')) === g)];
	}
	getPosition(t, g) {
		const ts = this.getByGroup(g);
		for (let i = 0, l = ts.length; i < l; i += 1) {
			const c1 = attr(t,'src') === attr(ts[i],'src');
			const c2 = attr(t,this.dn('index')) === attr(ts[i],this.dn('index'));
			const c3 = attr(t,this.dn()) === attr(ts[i],this.dn());
			if (c1 && c2 && c3) { return i; }
		}
	}
	prepare( arg ) {
		const {
			wrapperSelectors: ws,
			itemSelectors: is,
			captionSelectors: cs
		} = arg;
		const jws = (ws[0] ? [...ws] : [ws]).join(',');
		const jis = (is[0] ? [...is] : [is]).join(',');
		const jcs = (cs[0] ? [...cs] : [cs]).join(',');
		const qws = [...document.querySelectorAll(jws)];
		if (qws.length > 0) {
			qws.forEach((qwsi, i) => {
				for (const item of qwsi.querySelectorAll(jis)) {
					const el = item.getElementsByTagName('a')[0] || item.getElementsByTagName('img')[0];
					if (el.tagName === 'A') {
						if (/\.(jpg|gif|png)$/.test(el.href)) {
							attr(el,this.dn(), el.href);
							attr(el,this.dn('group'), i);
							const caption = item.querySelector(jcs);
							if (is(caption)) { attr(el, this.dn('caption'), caption.innerText); }
						}
					} else {
						attr(el, this.dn(), el.src);
						attr(el, this.dn('group'), i);
						const caption = item.querySelector(jcs);
						if (is(caption)) { attr(el, this.dn('caption'), caption.innerText); }
					}
				}
			});
			this.load();
			for (const arg of qws) {
				for (const item of arg.querySelectorAll(jis)) {
					const caption = item.querySelector(jcs);
					if (is(caption)) {
						caption.addEventListener('click', event => {
							inhibitEvent(event);
							item.querySelector('a, img').dispatchEvent(new Event('click'));
						});
					}
				}
			}
		}
	}
	preload() {
		const {
			currGroup: cg,
			currImages: cis,
			currThumbnail: ct
		} = this;
		if (!cg) { return false; }
		const prev = new Image();
		const next = new Image();
		const pos = this.getPosition(ct, cg);
		if (pos === cis.length - 1) {
			prev.src = attr(cis[cis.length - 1], this.dn()) || cis[cis.length - 1].src;
			next.src = attr(cis[0], this.dn()) || cis[0].src;
		}
		else if (pos === 0) {
			prev.src = attr(cis[cis.length - 1], this.dn()) || cis[cis.length - 1].src;
			next.src = attr(cis[1], this.dn()) || cis[1].src;
		}
		else {
			prev.src = attr(cis[pos - 1],this.dn()) || cis[pos - 1].src;
			next.src = attr(cis[pos + 1],this.dn()) || cis[pos + 1].src;
		}
	}
	startAnimation() {
		const {
			options: { loadingAnimation: lA },
		} = this;
		this.stopAnimation();
		this.animTimeout = setTimeout(() => {
			addClass(this.box, this.cn('loading'));
			if (typeof lA === 'number') {
				let index = 0;
				this.animInterval = setInterval(() => {
					addClass(this.animChildren[index], this.cn('active'));
					setTimeout(() => {
						removeClass(this.animChildren[index], this.cn('active'));
					}, lA);
					index = index >= this.animChildren.length ? 0 : ++index;
				}, lA);
			}
		}, 500);
	}
	stopAnimation() {
		'use strict';
		const {
			options: { loadingAnimation: $0 },
		} = this;
		removeClass(this.box, this.cn('loading'));
		if (typeof $0 !== 'string' && $0) {
			clearInterval(this.animation.interval);
			for (const $1 of this.animation.children) {
				removeClass($1, this.cn('active'));
			}
		}
	}
	initializeControls() {
		'use strict';
		const $s = this;
		if (!this.controls.nextButton) {
			let _ = [];
			let c = [this.cn('next')];
			if (this.options.nextImage) {
				_.push({$:'img',attr:{src:this.options.nextButtonImage}});
			} else {
				c.push( this.cn('no-img') )
			}
			this.controls.nextButton = ecs({$:'span',class:c,_:_,events:[['click',ev=>{ev.stopPropagation();this.next();}]]});
			this.box.appendChild(this.controls.nextButton);
		}
		addClass(this.controls.nextButton, this.cn('active'));
		if (!this.controls.prevButton) {
			let _ = [];
			let c = [this.cn('prev')];
			if (this.options.prevImage) {
				_.push( {$:'img',attr:{src:this.options.previousImage}} )
			} else {
				c.push( this.cn('no-img') );
			}
			this.controls.prevButton = ecs({$:'span',class:c,_:_,events:[['click',ev=>{ev.stopPropagation();this.prev();}]]});
			this.box.appendChild(this.controls.prevButton);
		}
		addClass(this.controls.prevButton, this.cn('active'));
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
			addClass(this.box, this.cn());
		}
		else if (!this.box) {
			let $1 = id(this.cn()) || document.createElement('div');
			$1.id = this.cn();
			addClass($1, this.cn());
			this.box = $1;
			this.body.appendChild(this.box);
		}
		this.box.innerHTML = this.template.outerHTML;
		this.wrapper = id(this.cn('content-wrapper'));
		if (!hideCloseButton) {
			const $2 = document.createElement('span');
			$2.id = this.cn('close');
			addClass($2, this.cn('close'));
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
			addClass(this.animation.element, this.cn('loading-animation'));
			this.box.appendChild(this.animation.element);
		} else if (loadingAnimation) {
			loadingAnimation = typeof loadingAnimation === 'number' ? loadingAnimation : 200;
			this.animation.element = document.createElement('div');
			addClass(this.animation.element, this.cn('loading-animation'));
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
				if (this.isOpen) {
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
		if (!this.isOpen) {
			if (typeof this.options.animation === 'number') {
				addClass(this.current.image.img, this.cn('animate-transition'));
				addClass(this.current.image.img, this.cn('animate-init'));
			}
			this.isOpen = true;
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
			addClass(this.wrapper, this.cn('animate'));
		}
		const $5 = $0.getAttribute(this.dn('caption'));
		if ($5 && this.options.captions) {
			let $6 = document.createElement('p');
			addClass($6, this.cn('caption'));
			$6.innerHTML = $5;
			this.wrapper.appendChild($6);
		}
		addClass(this.box, this.cn('active'));
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
				if (hasClass(this.box, this.cn('active'))) {
					addClass(this.wrapper, this.cn('wrapper-active'));
					if (typeof this.options.animation === 'number') {
						addClass(this.current.image.img, this.cn('animate-transition'));
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
						addClass(this.current.image.img, this.cn('next-on-click'));
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
			removeClass(this.current.image.img, this.cn('animating-next'));
			setTimeout(() => {
				this.open(
					this.current.thumbnail,
					false,
					() => {
						setTimeout(() => {
							addClass(this.current.image.img, this.cn('animating-next'));
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
				removeClass(this.current.image.img, this.cn('animating-next'));
				setTimeout(() => {
					this.open(
						this.current.thumbnail,
						false,
						() => {
							setTimeout(() => {
								addClass(this.current.image.img, this.cn('animating-next'));
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
				this.currGroup = null;
				this.currThumbnail = null;
				const img = this.currImage;
				this.currImage = {};
				while (this.currImages.length) { this.currImages.pop(); }
				this.isOpen = false;
				removeClass(this.box, this.cn('active'));
				removeClass(this.wrapper, this.cn('wrapper-active'));
				removeClass(this.nextButton, this.cn('active'));
				removeClass(this.prevButton, this.cn('active'));
				this.box.style.paddingTop = '0px';
				this.stopAnimation();
				if (!this.options || !('hideOverflow' in this.options) || this.options.hideOverflow) {
					freeScroll(this.options.env);
				}
				if (this.options.onclose) {
					this.options.onclose(img);
				}
			}
		}
		const aemi = new Environment();
		try {
			if (isFunction(aemi_menu)) {
				aemi.push(aemi_menu);
			}
		} catch (_) {
			aemi.push(function aemi_menu() {
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
		} catch (_) {
			aemi.push(function aemi_toggle() {
				const $2 = ['navigation-toggle', 'search-toggle'];
				function $f1($0) {
					const $1 = id($0.dataset.target) || id(attr($0,'data-target'));
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
		} catch (_) {
			aemi.push(() => new Lightbox({ env: aemi }).prepare({
				wrapperSelectors: ['div.gallery', '.wp-block-gallery', '.justified-gallery'],
				itemSelectors: ['.gallery-item', '.blocks-gallery-item', '.jg-entry'],
				captionSelectors: ['figcaption', '.gallery-caption'],
			}));
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
		} catch (_) {
			aemi.push(() => {
				const classScrolled = 'page-scrolled';
				const classHidden = 'header-hidden';
				const aemi_header_auto_hide = () =>
				requestFrame(() => {
					const currentState = {
						startTime: Math.round(window.performance.now()),
						height: document.body.clientHeight,
						position: window.scrollY,
					};
					setTimeout(
						(observable, currentState) =>
						requestFrame(
							(observable, currentState) => {
								const { startTime, height, position } = currentState;
								const currentTime = Math.round(window.performance.now());
								const currentPosition = window.scrollY;
								const menuToggler = id('navigation-toggle');
								const searchToggler = id('search-toggle');
								if (position > 0) {
									addClass(observable, classScrolled);
								} else {
									removeClass(observable, classScrolled);
								}
								if ((!menuToggler || !hasClass(menuToggler)) && (!searchToggler || !hasClass(searchToggler))) {
									const elapsedTime = currentTime - startTime;
									if (elapsedTime > 100) {
										const elapsedDistance = currentPosition - position;
										const $11 = Math.round((1000 * elapsedDistance) / elapsedTime);
										console.log($11)
										if (!hasClass(observable, classHidden)) {
											if ($11 > 0 && position > 0 && position + window.innerHeight < height) {
												addClass(observable, classHidden);
											}
										} else if (($11 < 0 && position > 0 && position + window.innerHeight < height) || position <= 0 || position + window.innerHeight >= height) {
											removeClass(observable, classHidden);
										}
									}
								}
							},
							observable,
							currentState
							),
							100,
							document.body,
							currentState
							);
						});
						const aemi_progress_bar = progressBar => requestFrame(() => {
							const totalHeight = document.body.clientHeight - window.innerHeight;
							const progress = window.scrollY / totalHeight;
							progressBar.style.width = `${100 * (progress > 1 ? 1 : progress)}vw`;
						});
						const features = [
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
						
						const toRun = [];
						
						features.forEach( ({test, useTest, func, args}) => {
							if (test.filter($ => $).length > 0) {
								toRun.push(useTest ? {args: [...args, ...test], func: func } : { args: [...args], func: func });
							}
						});
						
						window.addEventListener('scroll', () => {
							toRun.forEach( ({func,args}) => func(...args) );
						});
						
					});
					
					
				}
				aemi.run();
				