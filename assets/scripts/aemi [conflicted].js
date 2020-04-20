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
			in: _ => `${this.name}${isset(_) ? '-' + _ : ''}`,
			/** ClassName Formatter */
			cn: _ => `${this.name}${isset(_) ? '-' + _ : ''}`,
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
		this.thumbnails.push(...arguments);
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
		const {
			options: { loadingAnimation: lA },
		} = this;
		removeClass(this.box, this.cn('loading'));
		if (typeof lA !== 'string' && lA) {
			clearInterval(this.animInterval);
			for (const child of this.animChildren) {
				removeClass(child, this.cn('active'));
			}
		}
	}
	initializeControls() {
		if (!this.nextButton) {
			const ni = this.options.nextImage;
			this.nextButton = ecs({
				$: 'span',
				class: [this.cn('next'), ...(!ni ? [this.cn('no-img')] : [])],
				_: [...(ni ? [{ $: 'img', attr: { src: this.options.nextImage } }] : [])],
				events: [['click', ev => { inhibitEvent(ev); this.next(); }]]
			});
			this.box.appendChild(this.nextButton);
		}
		addClass(this.nextButton, this.cn('active'));
		if (!this.prevButton) {
			const pi = this.options.prevImage;
			this.prevButton = ecs({
				$: 'span',
				class: [this.cn('prev'), ...(!pi ? [this.cn('no-img')] : [])],
				_: [...(pi ? [{ $: 'img', attr: { src: this.options.prevImage } }] : [])],
				events: [['click', ev => { inhibitEvent(ev); this.prev(); }]]
			});
			this.box.appendChild(this.prevButton);
		}
		addClass(this.prevButton, this.cn('active'));
	}
	repositionControls() {
		if (this.options.responsive && this.nextButton && this.prevButton) {
			const shift = this.height / 2 - this.nextButton.offsetHeight / 2;
			this.nextButton.style.top = shift + 'px';
			this.prevButton.style.top = shift + 'px';
		}
	}
	setOptions(_) {
		_ = _ || {};
		function setBooleanValue(variable,def) {
			return isBoolean(variable) ? variable : (def || false);
		}
		function setStringValue(variable, def) {
			return isString(variable) ? variable : (def || false);
		}
		this.options = {
			boxId: _.boxId || false,
			controls: isBoolean(_.controls) ? _.controls || true,
			dimensions: isBoolean(_.dimensions) ? _.dimensions || true,
			captions: isBoolean(_.captions) ? _.controles || true,
			prevImage: typeof _.prevImage === 'string' ? _.prevImage : false,
			nextImage: typeof _.nextImage === 'string' ? _.nextImage : false,
			hideCloseButton: _.hideCloseButton || false,
			closeOnClick: _.closeOnClick || true,
			nextOnClick: _.nextOnClick || true,
			loadingAnimation: _.loadingAnimation || true,
			animationElementCount: _.animationElementCount || 4,
			preload: _.preload || true,
			carousel: _.carousel || true,
			animation: typeof _.animation === 'number' || _.animation === false ? _.animation : 400,
			responsive: _.responsive || true,
			maxImageSize: _.maxImageSize || 0.8,
			keyControls: _.keyControls || true,
			hideOverflow: _.hideOverflow || true,
			onopen: _.onopen || false,
			onclose: _.onclose || false,
			onload: _.onload || false,
			onresize: _.onresize || false,
			onloaderror: _.onloaderror || false,
			onimageclick: _.onimageclick || false,
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
		else {
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
			this.animElement = new Image();
			this.animElement.src = loadingAnimation;
			addClass(this.animElement, this.cn('loading-animation'));
			this.box.appendChild(this.animElement);
		} else if (loadingAnimation) {
			loadingAnimation = typeof loadingAnimation === 'number' ? loadingAnimation : 200;
			this.animElement = document.createElement('div');
			addClass(this.animElement, this.cn('loading-animation'));
			for (let $5 = 0; $5 < animationElementCount; $5 += 1) {
				this.animChildren.push(this.animElement.appendChild(document.createElement('span')));
			}
			this.box.appendChild(this.animElement);
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
		this.currGroup = $1 || this.currGroup || attr($0,this.dn('group'));
		if (this.currGroup) {
			this.currImages = this.getByGroup(this.current.group);
			if ($0 === false) {
				$0 = this.current.images[0];
			}
		}
		this.currImage.img = new Image();
		this.currThumbnail = $0;
		let $4;
		if (typeof $0 === 'string') {
			$4 = $0;
		} else if (attr($0,this.dn())) {
			$4 = attr($0,this.dn());
		} else {
			$4 = $0.src;
		}
		this.currImgRatio = false;
		if (!this.isOpen) {
			if (typeof this.options.animation === 'number') {
				addClass(this.currImage.img, this.cn('animate-transition'));
				addClass(this.currImage.img, this.cn('animate-init'));
			}
			this.isOpen = true;
			if (this.options.onopen) {
				this.options.onopen(this.currImage);
			}
		}
		if (!this.options || !('hideOverflow' in this.options) || this.options.hideOverflow) {
			blockScroll(this.options.env);
		}
		this.box.style.paddingTop = '0';
		this.wrapper.innerHTML = '';
		this.wrapper.appendChild(this.currImage.img);
		if (this.options.animation) {
			addClass(this.wrapper, this.cn('animate'));
		}
		const $5 = attr($0,this.dn('caption'));
		if ($5 && this.options.captions) {
			let $6 = document.createElement('p');
			addClass($6, this.cn('caption'));
			$6.innerHTML = $5;
			this.wrapper.appendChild($6);
		}
		addClass(this.box, this.cn('active'));
		if (this.options.controls && this.currImages.length > 1) {
			this.initializeControls();
			this.repositionControls();
		}
		this.current.image.img.addEventListener('error', $0 => {
			if (this.options.onloaderror) {
				$0._happenedWhile = $3 ? $3 : false;
				this.options.onloaderror($0);
			}
		});
		this.currImage.img.addEventListener('load', ({ target: $0 }) => {
			this.currImage.originalWidth = $0.naturalWidth || $0.width;
			this.currImage.originalHeight = $0.naturalHeight || $0.height;
			const $1 = setInterval(() => {
				if (hasClass(this.box, this.cn('active'))) {
					addClass(this.wrapper, this.cn('wrapper-active'));
					if (typeof this.options.animation === 'number') {
						addClass(this.currImage.img, this.cn('animate-transition'));
					}
					if ($2) {
						$2();
					}
					this.stopAnimation();
					clearTimeout(this.animTimeout);
					if (this.options.preload) {
						this.preload();
					}
					if (this.options.nextOnClick) {
						addClass(this.currImage.img, this.cn('next-on-click'));
						this.currImage.img.addEventListener('click', $0 => {
							$0.stopPropagation();
							this.next();
						});
					}
					if (this.options.onimageclick) {
						this.currImage.img.addEventListener('click', $0 => {
							$0.stopPropagation();
							this.options.onimageclick(this.currImage);
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
			if (attr($3,this.dn())) {
				attr($3,this.dn('index'), $2);
				this.push($3);
			}
		}
	}
	resize() {
		if (!this.currImage.img) {
			return;
		}
		this.maxWidth = this.width;
		this.maxHeight = this.height;
		const $0 = this.box.offsetWidth;
		const $1 = this.box.offsetHeight;
		if (!this.currImgRatio && this.currImage.img && this.currImage.img.offsetWidth && this.currImage.img.offsetHeight) {
			this.currImgRatio = this.currImage.img.offsetWidth / this.currImage.img.offsetHeight;
		}
		// Height of image is too big to fit in viewport
		if (Math.floor($0 / this.currImgRatio) > $1) {
			this.newImageWidth = $1 * this.currImgRatio;
			this.newImageHeight = $1;
		}
		// Width of image is too big to fit in viewport
		else {
			this.newImageHeight = $0;
			this.newImageWidth = $0 / this.currImgRatio;
		}
		// decrease size with modifier
		this.newImageWidth = Math.floor(this.newImageWidth * this.options.maxImageSize);
		this.newImageHeight = Math.floor(this.newImageHeight * this.options.maxImageSize);
		// check if image exceeds maximum size
		if ((this.options.dimensions && this.r.newImageHeight > this.current.image.originalHeight) || (this.options.dimensions && this.r.newImageWidth > this.current.image.originalWidth)) {
			this.newImageHeight = this.currImage.originalHeight;
			this.newImageWidth = this.currImage.originalWidth;
		}
		attr(this.currImage.img, 'width', this.newImageWidth);
		attr(this.currImage.img, 'height', this.newImageHeight);
		// reposition controls after timeout
		setTimeout(() => {
			this.repositionControls();
		}, 200);
		if (this.options.onresize) {
			this.options.onresize(this.currImage);
		}
	}
	next() {
		if (!this.currGroup) {
			return;
		}
		const $0 = this.getPosition(this.currThumbnail, this.currGroup) + 1;
		if (this.currImages[$0]) {
			this.currThumbnail = this.currImages[$0];
		} else if (this.options.carousel) {
			this.currThumbnail = this.currImages[0];
		} else {
			return;
		}
		if (this.options.animation === 'number') {
			removeClass(this.currImage.img, this.cn('animating-next'));
			setTimeout(() => {
				this.open(
					this.currThumbnail,
					false,
					() => {
						setTimeout(() => {
							addClass(this.currImage.img, this.cn('animating-next'));
						}, this.options.animation / 2);
					},
					'next'
					);
				}, this.options.animation / 2);
			} else {
				this.open(this.currThumbnail, false, false, 'next');
			}
		}
		prev() {
			if (!this.currGroup) {
				return;
			}
			const $0 = this.getPosition(this.currThumbnail, this.currGroup) - 1;
			if (this.currImages[$0]) {
				this.current.thumbnail = this.currImages[$0];
			} else if (this.options.carousel) {
				this.current.thumbnail = this.currImages[this.currImages.length - 1];
			} else {
				return;
			}
			if (this.options.animation === 'number') {
				removeClass(this.currImage.img, this.cn('animating-next'));
				setTimeout(() => {
					this.open(
						this.currThumbnail,
						false,
						() => {
							setTimeout(() => {
								addClass(this.currImage.img, this.cn('animating-next'));
							}, this.options.animation / 2);
						},
						'prev'
						);
					}, this.options.animation / 2);
				} else {
					this.open(this.currThumbnail, false, false, 'prev');
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
				