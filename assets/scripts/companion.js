'use strict';
function currentGlobal() {
	if (typeof globalThis !== undefined) { return globalThis; }
	if (typeof self !== undefined) { return self; }
	if (typeof window !== undefined) { return window; }
	if (typeof global !== undefined) { return global; }
	throw new Error('Unable to get global object.');
}
function entries(object, func) {
	for (let key in object) {
		if (object.hasOwnProperty(key)) {
			func(key, object[key]);
		}
	}
}
function is(object) {
	return object !== null && object !== undefined;
}
function isset(object) {
	return is(object) && object !== '';
}
function isString(variable) {
	return typeof variable === 'string' || variable instanceof String;
}
function isBoolean(variable) {
	return typeof variable === 'boolean';
}
function isFunction(object) {
	return typeof object === 'function' ? object : false;
}
function inhibitEvent(event) {
	event.preventDefault();
	event.stopPropagation();
}
function catchError(caughtError, customMessage) {
	When.delay(() => {
		const error = is(customMessage) ? new Error(`${caughtError} ${customMessage}`) : caughtError;
		console.group(error.name);
		console.warn(error.message);
		console.warn(error.stack);
		console.groupEnd(error.name);
	});
	return false;
}
function id(string) {
	return document.getElementById(string);
}
function requestFrame() {
	const [func,...args] = arguments;
	if (isFunction(func)) {
		return window.requestAnimationFrame(() => func(...args));
	}
	return catchError(func, 'is not a function.');
}
function cancelFrame(id) {
	try {
		cancelAnimationFrame(id);
		return true;
	} catch (error) {
		return catchError(error);
	}
}
function hasClass(element, className) {
	if (is(element)) {
		return element.classList.contains(is(className) ? className : 'toggled');
	} else {
		return catchError(element, 'is undefined.');
	}
}
function addClass(element, className, doNotRequestFrame) {
	doNotRequestFrame = doNotRequestFrame || true;
	if (is(element) && is(className)) {
		if (doNotRequestFrame) {
			element.classList.add(className);
			return true;
		}
		else {
			return !!requestFrame(() => element.classList.add(className));
		}
	}
	if (!is(element)) {
		return catchError(element, 'is undefined.');
	}
	else if (!is(className)) {
		return catchError(className, 'is undefined.');
	}
}
function removeClass(element, className,doNotRequestFrame) {
	doNotRequestFrame = doNotRequestFrame || false;
	if (is(element) && is(className)) {
		if (doNotRequestFrame) {
			element.classList.remove(className);
			return true;
		}
		else {
			return !!requestFrame(() => element.classList.remove(className));
		}
	}
	if (!is(element)) {
		return catchError(element, 'is undefined.');
	}
	else if (!is(className)) {
		return catchError(className, 'is undefined.');
	}
}
function toggleClass(element, className,doNotRequestFrame) {
	doNotRequestFrame = doNotRequestFrame || false;
	if (is(element)) {
		className = is(className) ? className : 'toggled';
		const boolean = hasClass(element, className);
		if ((boolean === true) ^ (boolean === false)) {
			if (doNotRequestFrame) {
				boolean ? !removeClass(element, className) : addClass(element, className);
				return boolean;
			}
			else {
				return !!requestFrame(() => boolean ? !removeClass(element, className) : addClass(element, className));
			}
		}
	}
	return catchError(element, 'is undefined.');
}
function attr() {
	const [element, attrName, value] = arguments;
	if (is(value)) { return element.setAttribute(attrName, value); }
	return element.getAttribute(attrName);
}
/** @returns {HTMLElement} */
function ecs() {
	const ce = a => document.createElement(isset(a) ? a : 'div');
	const ac = (a, b) => { a.appendChild(b); return a; };
	const l = [...arguments].filter(isset);
	const { length: ll } = l;
	if (ll === 0) { return ce(); }
	else if (ll !== 1) {
		const a = ce();
		for (const b of l) { ac(a, ecs(b)); }
		return a;
	}
	let e = l.pop();
	if (e instanceof Element) { return ac(ce(), e); }
	const { attr, class: c, data, events, id, namespace, style, actions, _, $ } = e;
	if (id || c || $) {
		if (namespace) { e = document.createElementNS(namespace, $); }
		else { e = ce($); }
		if (id) { e.id = id; }
		if (c) { e.classList.add(...c); }
	}
	else { e = ce(); }
	if (attr) { entries(attr, (k, v) => { e.setAttribute(k, v); }); }
	if (data) { entries(data, (k, v) => { e.dataset[k] = v; }); }
	if (events) { events.forEach(ev => e.addEventListener(...ev)); }
	if (style) { entries(style, (k, v) => { e.style[k] = v; }); }
	if (_) {
		for (const i of _) {
			if (i instanceof Element) { ac(e, i); }
			else if (['string', 'number', 'bigint', 'boolean', 'symbol'].includes(typeof i)) {
				e.innerHTML += `${i}`;
			}
			else {
				try { ac(e, ecs(i)); }
				catch (_) { catchError(_); }
			}
		}
	}
	if (actions) {
		entries(actions, (k, v) => {
			const a = k.split(/\_\$/);
			if (a.length > 1) { e[a[0]](...v); }
			else { e[k](...v); }
		});
	}
	return e;
}
function ecsScript() {
	const c = document.currentScript;
	if (![document.head, document.documentElement].includes(c.parentElement)) {
		for (const b of arguments) { c.insertAdjacentElement('beforebegin', ecs(b)); }
		c.remove();
	}
}
class When {
	constructor() { }
	static delay() {
		const [func, ...args] = arguments;
		return setTimeout(func, 0, ...args);
	}
	static async desync() {
		const [func, ...args] = arguments;
		return func(...args);
	}
	static async asyncDelay() {
		const [func, ...args] = arguments;
		return When.delay(func, ...args);
	}
	static loading() {
		const [func, ...args] = arguments;
		if (document.readyState === 'loading') {
			func(...args);
		}
	}
	static interactive() {
		const [func, ...args] = arguments;
		if (document.readyState !== 'loading') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', () => func(...args));
		}
	}
	static complete() {
		const [func, ...args] = arguments;
		if (document.readyState === 'complete') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', () => {
				return document.readyState === 'complete' ? func(...args) : null;
			});
		}
	}
	static DOMContentLoaded() {
		const [func, ...args] = arguments;
		if (document.readyState === 'interactive' || document.readyState === 'complete') {
			func(...args);
		} else {
			document.addEventListener('DOMContentLoaded', () => func(...args));
		}
	}
	static ready() {
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
		const [func, ...args] = arguments;
		window.addEventListener('load', () => func(...args));
	}
}
class Environment {
	constructor() {
		this.actions = [];
	}
	push() {
		for (const func of arguments) {
			if (isFunction(func)) {
				this.actions.push(func);
			} else {
				catchError(func, 'is not a function.');
			}
		}
	}
	async run() {
		try {
			return Promise.all(this.actions.map(When.interactive));
		} catch (_) {
			return catchError(_);
		}
	}
}
class Cookies {
	constructor() { }
	static get(string) {
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
		const newDate = new Date();
		newDate.setTime(newDate.getTime() - 1);
		const expiration = 'expires=' + newDate.toUTCString();
		document.cookie = cookieName + '=;' + expiration + ';path=/';
	}
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
				resolves: [],
				rejects: []
			}
		}
		else if (!('resolves' in self.PromiseWorkers && 'rejects' in self.PromiseWorkers)) {
			self.PromiseWorkers.resolves = [];
			self.PromiseWorkers.rejecs = [];
		}
	}
	static postMessage(data, worker) {
		'use strict';
		const messageId = PromiseWorker.id();
		const message = { id: messageId, data: data };
		return new Promise((resolve, reject) => {
			PromiseWorker.resolves[messageId] = resolve;
			PromiseWorker.rejects[messageId] = reject;
			worker.postMessage(message);
		});
	}
	static onMessage(message) {
		const { id, err, data } = message.data;
		const resolve = PromiseWorker.resolves[id];
		const reject = PromiseWorker.rejects[id];
		if (is(data)) {
			if (resolve) { resolve(data); }
		}
		else if (is(reject)) {
			if (err) { reject(err); }
			else { reject('Got nothing'); }
		}
		PromiseWorker.delete(id);
	}
	static get resolves() {
		PromiseWorker.assert();
		return currentGlobal().PromiseWorkers.resolves;
	}
	static get rejects() {
		return currentGlobal().PromiseWorkers.rejects;
	}
	static delete(id) {
		delete PromiseWorker.resolves[id];
		delete PromiseWorker.rejects[id];
	}
	static id(length) {
		const values = [];
		const list = [];
		for (let i = 0; i < 62; i+=1) {
			if (i < 10) {
				values[i] = 48 + i;
			}
			else if (i < 36) {
				values[i] = 65 + (i - 10);
			}
			else if (i < 62) {
				values[i] = 97 + (i - 36);
			}
		}
		for (let i = 0; i < (length||16); i += 1) {
			list[i] = values[Math.floor(Math.random() * 62)];
		}
		return String.fromCharCode(...list);
	}
}