function entries( object, func ) {
	'use strict';
	for ( let key in object ) {
		if ( object.hasOwnProperty( key ) ) {
			func( key, object[key] );
		}
	}
}
function is(object) {
	'use strict';
	return object !== null && object !== undefined;
}
function iss(object) {
	'use strict';
	return is(object) && object !== '';
}
function isFunction(object) {
	'use strict';
	return typeof object === 'function' ? object : false;
}
function inhibitEvent(event) {
	'use strict';
	event.preventDefault();
	event.stopPropagation();
}
function catchError(caughtError, customMessage) {
	'use strict';
	when.delay(function delayed() {
		const error = is(customMessage) ? new Error(`${caughtError} ${customMessage}`) : caughtError;
		console.group(error.name);
		console.warn(error.message);
		console.warn(error.stack);
		console.groupEnd(error.name);
	});
	return;
}
function id(string) {
	'use strict';
	return document.getElementById(string);
}

function requestFrame() {
	'use strict';
	const [func,...args] = arguments;
	if (isFunction(func)) {
		return window.requestAnimationFrame(function framed() {
			return func(...args);
		});
	}
	return catchError(func, 'is not a function.');
}

function cancelFrame(id) {
	'use strict';
	try {
		cancelAnimationFrame(id);
		return true;
	} catch (error) {
		catchError(error);
		return false;
	}
}

function hasClass(element, className) {
	'use strict';
	if (is(element)) {
		className = is(className) ? className : 'toggled';
		return element.classList.contains(className);
	} else {
		if (!is(element)) {
			return catchError(element, 'is undefined.');
		}
		if (!is(className)) {
			return catchError(className, 'is undefined.');
		}
	}
}

function addClass(element, className, doNotRequestFrame) {
	'use strict';
	doNotRequestFrame = doNotRequestFrame || true;
	if (is(element) && is(className)) {
		if ( doNotRequestFrame ) {
			element.classList.add(className);
			return true;
		}
		else {
			return !!requestFrame(function framed() {
				element.classList.add(className);
			});
		}
	}
	return catchError(className, 'is undefined.');
}

function removeClass(element, className,doNotRequestFrame) {
	'use strict';
	doNotRequestFrame = doNotRequestFrame || false;
	if (is(element) && is(className)) {
		if ( doNotRequestFrame ) {
			element.classList.remove(className);
			return true;
		}
		else {
			return !!requestFrame(function framed() {
				element.classList.remove(className);
			});
		}
	}
	return catchError(className, 'is undefined.');
}

function toggleClass(element, className) {
	'use strict';
	if (is(element)) {
		className = is(className) ? className : 'toggled';
		const boolean = hasClass(element, className);
		if ((boolean === true) ^ (boolean === false)) {
			return !!requestFrame(() => boolean ? !removeClass(element, className) : addClass(element, className) );
		}
	}
	return catchError(element, 'is undefined.');
}

/** @returns {HTMLElement} */
function ecs() {
    'use strict';
    const ce = a => document.createElement( iss( a ) ? a : 'div' );
	const ac = (a,b) => { a.appendChild( b ); return a; };
    const l = [...arguments].filter( iss );
	const {length: ll} = l;
    if (ll === 0) { return ce(); }
	else if (ll !== 1) {
        const a = ce();
        for (const b of l) { ac(a, ecs(b)); }
        return a;
    }
	else {
        let e = l.pop();
        if ( e instanceof Element ) { return ac( ce(), e ); }
        const { attr, class: c, data, events, id, namespace, style, actions, _, $ } = e;
        if (id || c || $) {
            if (namespace) { e = document.createElementNS(namespace, $); }
            else { e = ce($); }
            if (id) { e.id = id; }
            if (c) { e.classList.add(...c); }
        }
        else { e = ce(); }
        if (attr) { entries( attr, (k,v) => { e.setAttribute( k, v ); }); }
        if (data) { entries( data, (k,v) => { e.dataset[k] = v; }); }
		if (events) { events.forEach( ev => e.addEventListener( ...ev ) ); }
        if (style) { entries( style, (k,v) => { e.style[k] = v; }); }
        if (_) {
            for (const i of _) {
                if (i instanceof Element) { ac(e,i); }
                else if ( ['string', 'number', 'bigint', 'boolean', 'symbol'].includes(typeof i) ) {
                    e.innerHTML += `${i}`;
                }
				else {
                    try { ac( e, ecs( i ) ); }
                    catch (error) { catchError( error ); }
                }
            }
        }
        if (actions) {
			entries( actions, (k,v) => {
				const a = k.split(/\_\$/);
                if (a.length > 1) { e[a[0]](...v); }
				else { e[k](...v); }
			});
        }
        return e;
    }
}

function ecsScript() {
	'use script';
    const c = document.currentScript;
    if (![document.head, document.documentElement].includes(c.parentElement)) {
        for(const b of arguments) {c.insertAdjacentElement('beforebegin',ecs(b));}
        c.remove();
    }
}


class when {
	constructor() {
		'use strict';
	}
	static delay() {
		'use strict';
		const [func, ...args] = arguments;
		return setTimeout(func, 0, ...args);
	}
	static async desync() {
		'use strict';
		const [func, ...args] = arguments;
		return func(...args);
	}
	static async asyncDelay() {
		'use strict';
		const [func, ...args] = arguments;
		return when.delay(func, ...args);
	}
	static loading() {
		'use strict';
		const [func, ...args] = arguments;
		if (document.readyState === 'loading') {
			func(...args);
		}
	}
	static interactive() {
		'use strict';
		const [func, ...args] = arguments;
		if (document.readyState !== 'loading') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', function interactive() {
				return func(...args);
			});
		}
	}
	static complete() {
		'use strict';
		const [func, ...args] = arguments;
		if (document.readyState === 'complete') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', function readyStateHasChanged() {
				return document.readyState === 'complete' ? func(...args) : null;
			});
		}
	}
	static DOMContentLoaded() {
		'use strict';
		const [func, ...args] = arguments;
		if (document.readyState === 'interactive' || document.readyState === 'complete') {
			func(...args);
		} else {
			document.addEventListener('DOMContentLoaded', function DOMContentLoaded() {
				return func(...args);
			});
		}
	}
	static ready() {
		'use strict';
		const [func, ...args] = arguments;
		if (document.readyState !== 'loading') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', function readyStateHasChanged() {
				return document.readyState === 'complete' ? func(...args) : null;
			});
		}
	}
	static load() {
		'use strict';
		const [func, ...args] = arguments;
		window.addEventListener('load', function loaded() {
			return func(...args);
		});
	}
}

class Environment {
	constructor() {
		'use strict';
		this.actions = [];
	}
	push() {
		'use strict';
		for (const func of arguments) {
			if (isFunction(func)) {
				this.actions.push(func);
			} else {
				catchError(func, 'is not a function.');
			}
		}
	}
	run() {
		'use strict';
		try {
			for (const action of this.actions) {
				when.interactive(action);
			}
		} catch (error) {
			return catchError(error);
		}
	}
}
class cookies {
	constructor() {
		'use strict';
	}
	static get(string) {
		'use strict';
		const cookiesString = decodeURIComponent(document.cookie);
		const cookiesList = cookiesString.split(/;/);
		for (let cookie of cookiesList) {
			while (cookie.charAt(0) === ' ') {
				cookie = cookie.substring(1);
			}
			if (cookie.indexOf(string + '=') === 0) {
				const cookieValue = cookie.substring(string.length + 1, cookie.length);
				if (cookieValue !== '' && is(cookieValue)) {
					return cookieValue;
				} else {
					return;
				}
			}
		}
		return;
	}
	static has(string) {
		'use strict';
		const cookiesString = decodeURIComponent(document.cookie);
		const cookiesList = cookiesString.split(/;/);
		for (let cookie of cookiesList) {
			while (cookie.charAt(0) === ' ') {
				cookie = cookie.substring(1);
			}
			if (cookie.indexOf(string + '=') === 0) {
				const cookieValue = cookie.substring(string.length + 1, cookie.length);
				if (cookieValue !== '' && is(cookieValue)) {
					return true;
				} else {
					return false;
				}
			}
		}
		return false;
	}
	static set(cookieName, cookieValue, expiration) {
		'use strict';
		if (expiration === undefined) {
			const newDate = new Date();
			const year = 365.25 * 24 * 3600 * 1000;
			newDate.setTime(newDate.getTime() + year);
			expiration = newDate.toUTCString();
		}
		const expirationString = 'expires=' + expiration;
		document.cookie = cookieName + '=' + encodeURIComponent(cookieValue) + ';' + expirationString + ';path=/';
	}
	static delete(cookieName) {
		'use strict';
		const newDate = new Date();
		newDate.setTime(newDate.getTime() - 1);
		const expiration = 'expires=' + newDate.toUTCString();
		document.cookie = cookieName + '=;' + expiration + ';path=/';
	}
}

function currentGlobal() {
	'use strict';
	if (typeof globalThis !== undefined) return globalThis;
	if (typeof self !== undefined) return self;
	if (typeof window !== undefined) return window;
	if (typeof global !== undefined) return global;
	throw new Error('Unable to get global object.');
}

class PromiseWorker {
	constructor(url) {
		'use strict';
		PromiseWorker.assert();
		this.worker = new Worker(url);
		this.worker.onmessage = PromiseWorker.onMessage;
	}
	get env() {
		'use strict';
		return currentGlobal().PromiseWorkers;
	}
	get onmessage() {
		'use strict';
		return this.worker.onmessage;
	}
	postMessage(data) {
		'use strict';
		return PromiseWorker.postMessage(data, this.worker);
	}
	static assert() {
		'use strict';
		const self = currentGlobal();
		if (!('PromiseWorkers' in self)) {
			self.PromiseWorkers = {
				resolves: {},
				rejects: {}
			}
		}
		else if (!('resolves' in self.PromiseWorkers && 'rejects' in self.PromiseWorkers)) {
			self.PromiseWorkers.resolves = {};
			self.PromiseWorkers.rejecs = {};
		}
	}
	static postMessage(data, worker) {
		'use strict';
		const messageId = Date.now();
		const message = { id: messageId, data: data };
		return new Promise((resolve, reject) => {
			PromiseWorker.resolves[messageId] = resolve;
			PromiseWorker.rejects[messageId] = reject;
			worker.postMessage(message);
		});
	}
	static onMessage(message) {
		'use strict';
		const { id, err, data } = message.data;
		const resolve = PromiseWorker.resolves[id];
		const reject = PromiseWorker.rejects[id];
		if (data) {
			if (resolve) resolve(data);
		}
		else if (reject) {
			if (err) reject(err);
			else reject('Got nothing');
		}
		PromiseWorker.delete(id);
	}
	static get resolves() {
		'use strict';
		PromiseWorker.assert();
		return currentGlobal().PromiseWorkers.resolves;
	}
	static get rejects() {
		'use strict';
		return currentGlobal().PromiseWorkers.rejects;
	}
	static delete(id) {
		'use strict';
		delete PromiseWorker.resolves[id];
		delete PromiseWorker.rejects[id];
	}
}