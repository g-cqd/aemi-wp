'use strict';
function is(object) {
	return object !== null && object !== undefined;
}
function isset(object) {
	return is(object) && object !== '';
}
function getGlobal() {
	const value = globalThis || self || window || global;
	if (value) {
		return value;
	}
	throw new Error('Unable to get global object.');
}
function entries(object, func) {
	for (let key in object) {
		if (object.hasOwnProperty(key)) {
			func(key, object[key]);
		}
	}
}
function isNumber(variable) {
	return typeof variable === 'number' || variable instanceof Number;
}
function isString(variable) {
	return typeof variable === 'string' || variable instanceof String;
}
function isBoolean(variable) {
	return typeof variable === 'boolean';
}
function isFunction(object) {
	return typeof object === 'function' || object instanceof Function ? object : false;
}
function isObject(object) {
	return typeof object === 'object' || object instanceof Object;
}
function isURL(object) {
	if (isString(object)) {
		try {
			return new URL(object) instanceof URL;
		} catch (_) {
			return false;
		}
	} else {
		return object instanceof URL;
	}
}
function identifier(length) {
	'use script';
	const values = [];
	const list = [];
	for (let i = 0; i < 62; i += 1) {
		if (i < 10) {
			values[i] = 48 + i;
		} else if (i < 36) {
			values[i] = 65 + (i - 10);
		} else if (i < 62) {
			values[i] = 97 + (i - 36);
		}
	}
	for (let i = 0; i < (length || 16); i += 1) {
		list[i] = values[Math.floor(Math.random() * 62)];
	}
	return String.fromCharCode(...list);
}
function inhibitEvent(event) {
	event.preventDefault();
	event.stopPropagation();
}
function catchError(caughtError, customMessage) {
	if (typeof caughtError === 'string') {
		caughtError = new Error(caughtError);
	}
	Wait.delay(() => {
		console.group(caughtError.name);
		console.warn(caughtError.name);
		console.warn(caughtError.message);
		console.warn(caughtError.stack);
		console.groupEnd(caughtError.name);
	});
	return false;
}
function byId(string) {
	return document.getElementById(string);
}
function byClass(string,element) {
	return (element || document).getElementsByClassName(string);
}
function requestFrame() {
	const [func, ...args] = arguments;
	if (isFunction(func)) {
		return window.requestAnimationFrame(timestamp => func(timestamp, ...args));
	}
	throw new Error(`${func} is not a function.`);
}
function cancelFrame(id) {
	try {
		cancelAnimationFrame(id);
		return true;
	} catch (error) {
		catchError(error);
		return false;
	}
}
function hasClass(element, className) {
	if (is(element) && isset(className)) {
		return element.classList.contains(className);
	} else {
		return catchError(`element:${element} or class:${className} is undefined.`);
	}
}
function addClass(element, className, doNotRequestFrame) {
	doNotRequestFrame = doNotRequestFrame || true;
	if (is(element) && isset(className)) {
		if (doNotRequestFrame) {
			element.classList.add(className);
			return true;
		} else {
			return !!requestFrame(() => element.classList.add(className));
		}
	}
	return catchError(`element:${element} or class:${classname} is undefined.`);
}
function removeClass(element, className, doNotRequestFrame) {
	doNotRequestFrame = doNotRequestFrame || true;
	if (is(element) && isset(className)) {
		if (doNotRequestFrame) {
			element.classList.remove(className);
			return true;
		} else {
			return !!requestFrame(() => element.classList.remove(className));
		}
	}
	return catchError(`element:${element} or class:${className} is undefined.`);
}
function toggleClass(element, className) {
	if (is(element) && isset(className)) {
		const boolean = hasClass(element, className);
		if (isBoolean(boolean)) {
			requestFrame(() =>
				boolean ? !removeClass(element, className) : addClass(element, className)
			);
			return !boolean;
		}
	}
	return catchError(`element:${element} or class:${className} is undefined.`);
}

function attr() {
	const [element, attrName, value] = arguments;
	if (is(value)) {
		return element.setAttribute(attrName, value);
	}
	return element.getAttribute(attrName);
}

function data() {
	const [element, dataset, value] = arguments;
	if (isset(dataset)) {
		if (is(value)) {
			element.dataset[dataset] = value;
			return element.dataset[dataset];
		}
		return element.dataset[dataset];
	}
	return element.dataset;
}

class Easing {
	constructor() {}
	static linearTween(t, b, c, d) {
		return (c * t) / d + b;
	}
	static easeInQuad(t, b, c, d) {
		t /= d;
		return c * t * t + b;
	}
	static easeOutQuad(t, b, c, d) {
		t /= d;
		return -c * t * (t - 2) + b;
	}
	static easeInOutQuad(t, b, c, d) {
		t /= d / 2;
		if (t < 1) {
			return (c / 2) * t * t + b;
		}
		t--;
		return (-c / 2) * (t * (t - 2) - 1) + b;
	}
	static easeInCubic(t, b, c, d) {
		t /= d;
		return c * t * t * t + b;
	}
	static easeOutCubic(t, b, c, d) {
		t /= d;
		t--;
		return c * (t * t * t + 1) + b;
	}
	static easeInOutCubic(t, b, c, d) {
		t /= d / 2;
		if (t < 1) {
			return (c / 2) * t * t * t + b;
		}
		t -= 2;
		return (c / 2) * (t * t * t + 2) + b;
	}
	static easeInQuart(t, b, c, d) {
		t /= d;
		return c * t * t * t * t + b;
	}
	static easeOutQuart(t, b, c, d) {
		t /= d;
		t--;
		return -c * (t * t * t * t - 1) + b;
	}
	static easeInOutQuart(t, b, c, d) {
		t /= d / 2;
		if (t < 1) {
			return (c / 2) * t * t * t * t + b;
		}
		t -= 2;
		return (-c / 2) * (t * t * t * t - 2) + b;
	}
	static easeInQuint(t, b, c, d) {
		t /= d;
		return c * t * t * t * t * t + b;
	}
	static easeOutQuint(t, b, c, d) {
		t /= d;
		t--;
		return c * (t * t * t * t * t + 1) + b;
	}
	static easeInOutQuint(t, b, c, d) {
		t /= d / 2;
		if (t < 1) {
			return (c / 2) * t * t * t * t * t + b;
		}
		t -= 2;
		return (c / 2) * (t * t * t * t * t + 2) + b;
	}
	static easeInSine(t, b, c, d) {
		return -c * Math.cos((t / d) * (Math.PI / 2)) + c + b;
	}
	static easeOutSine(t, b, c, d) {
		return c * Math.sin((t / d) * (Math.PI / 2)) + b;
	}
	static easeInOutSine(t, b, c, d) {
		return (-c / 2) * (Math.cos((Math.PI * t) / d) - 1) + b;
	}
	static easeInExpo(t, b, c, d) {
		return c * Math.pow(2, 10 * (t / d - 1)) + b;
	}
	static easeOutExpo(t, b, c, d) {
		return c * (-Math.pow(2, (-10 * t) / d) + 1) + b;
	}
	static easeInOutExpo(t, b, c, d) {
		t /= d / 2;
		if (t < 1) {
			return (c / 2) * Math.pow(2, 10 * (t - 1)) + b;
		}
		t--;
		return (c / 2) * (-Math.pow(2, -10 * t) + 2) + b;
	}
	static easeInCirc(t, b, c, d) {
		t /= d;
		return -c * (Math.sqrt(1 - t * t) - 1) + b;
	}
	static easeOutCirc(t, b, c, d) {
		t /= d;
		t--;
		return c * Math.sqrt(1 - t * t) + b;
	}
	static easeInOutCirc(t, b, c, d) {
		t /= d / 2;
		if (t < 1) {
			return (-c / 2) * (Math.sqrt(1 - t * t) - 1) + b;
		}
		t -= 2;
		return (c / 2) * (Math.sqrt(1 - t * t) + 1) + b;
	}
}

function smoothScrollTo(selector, duration) {
	const easing = Easing.easeInOutCubic;
	let target = document.querySelector(selector);
	if (!(target instanceof HTMLElement)) return;
	let startPosition = window.pageYOffset;
	let targetPosition = startPosition + target.getBoundingClientRect().top;
	duration = duration || 1000;
	let distance = targetPosition - startPosition;
	let startTime = null;
	function animation(currentTime) {
		startTime = is(startTime) ? startTime : currentTime;
		let timeElapsed = currentTime - startTime;
		let run = easing(timeElapsed, startPosition, distance, duration);
		window.scrollTo(0, run);
		if (timeElapsed < duration) {
			requestFrame(animation);
		}
	}
	requestFrame(animation);
}

/** @returns {HTMLElement} */
function ecs() {
	const ce = a => document.createElement(isset(a) ? a : 'div');
	const ac = (a, b) => {
		a.appendChild(b);
		return a;
	};
	const l = [...arguments].filter(isset);
	const ll = l.length;
	if (ll === 0) {
		return ce();
	} else if (ll !== 1) {
		const a = ce();
		for (const b of l) {
			ac(a, ecs(b));
		}
		return a;
	}
	let e = l.pop();
	if (e instanceof Element) {
		return ac(ce(), e);
	}
	const { attr: a, class: c, data, events, id, ns, style, actions, _, $ } = e;
	if (id || c || $) {
		if (ns) {
			e = document.createElementNS(ns, $);
		} else {
			e = ce($);
		}
		if (id) {
			e.id = id;
		}
		if (c) {
			e.classList.add(...c);
		}
	} else {
		e = ce();
	}
	if (a) {
		entries(a, (k, v) => {
			attr(e, k, v);
		});
	}
	if (data) {
		entries(data, (k, v) => {
			e.dataset[k] = v;
		});
	}
	if (events) {
		events.forEach(ev => e.addEventListener(...ev));
	}
	if (style) {
		entries(style, (k, v) => {
			e.style[k] = v;
		});
	}
	if (_) {
		for (const i of _) {
			if (i instanceof Element) {
				ac(e, i);
			} else if (['string', 'number', 'bigint', 'boolean', 'symbol'].includes(typeof i)) {
				e.innerHTML += `${i}`;
			} else {
				try {
					ac(e, ecs(i));
				} catch (_) {
					catchError(_);
				}
			}
		}
	}
	if (actions) {
		entries(actions, (k, v) => {
			const a = k.split(/\_\$/);
			if (a.length > 1) {
				e[a[0]](...v);
			} else {
				e[k](...v);
			}
		});
	}
	return e;
}
function ecsScript() {
	const c = document.currentScript;
	if (![document.head, document.documentElement].includes(c.parentElement)) {
		for (const b of arguments) {
			c.insertAdjacentElement('beforebegin', ecs(b));
		}
		c.remove();
	}
}
class Wait {
	constructor() {}
	static time(time) {
		return new Promise(resolve => setTimeout(resolve, time));
	}
	static async first() {
		return Promise.race(...arguments);
	}
	static async delay() {
		const [func, timeout, ...args] = arguments;
		return setTimeout(func, timeout || 0, ...args);
	}
	static async async() {
		const [func, ...args] = arguments;
		return func(...args);
	}
	static async asyncDelay() {
		const [func, ...args] = arguments;
		return Wait.delay(func, ...args);
	}
	static async loading() {
		const [func, ...args] = arguments;
		if (document.readyState === 'loading') {
			func(...args);
		}
	}
	static async interactive() {
		const [func, ...args] = arguments;
		if (document.readyState !== 'loading') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', () => func(...args));
		}
	}
	static async complete() {
		const [func, ...args] = arguments;
		if (document.readyState === 'complete') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', () =>
				document.readyState === 'complete' ? func(...args) : null
			);
		}
	}
	static async DOMContentLoaded() {
		const [func, ...args] = arguments;
		if (document.readyState === 'interactive' || document.readyState === 'complete') {
			func(...args);
		} else {
			document.addEventListener('DOMContentLoaded', () => func(...args));
		}
	}
	static async ready() {
		const [func, ...args] = arguments;
		if (document.readyState !== 'loading') {
			func(...args);
		} else {
			document.addEventListener('readystatechange', () =>
				document.readyState === 'complete' ? func(...args) : null
			);
		}
	}
	static async load() {
		const [func, ...args] = arguments;
		window.addEventListener('load', () => func(...args));
	}
}
class Environment {
	constructor() {
		this.actions = [];
		this.properties = new Object(null);
	}
	async set(key, value) {
		return this.properties[key] = value;
	}
	async parallel(array) {
		try {
			return Promise.all(array);
		}
		catch (_) {
			return array;
		}
		return;
	}
	has(key) {
		return key in this.properties;
	}
	get(key) {
		return this.properties[key];
	}
	assert(key, value) {
		if (this.has(key)) {
			if (is(value)) {
				return this.get(key) === value;
			}
			return is(this.get(key));
		}
		return false;
	} 
	push() {
		for (const func of arguments) {
			if (isFunction(func)) {
				this.actions.push(func);
			} else {
				catchError(`func:${func} is not a function.`);
			}
		}
	}
	async run() {
		try {
			return Promise.all(this.actions.map(Wait.interactive));
		} catch (_) {
			return catchError(_);
		}
	}
}
class Cookies {
	constructor() {}
	static get(string) {
		return new Map(
			decodeURIComponent(document.cookie)
				.split(/;/)
				.map(string => string.trim().split(/=/))
		).get(string);
	}
	static has(string) {
		return new Map(
			decodeURIComponent(document.cookie)
				.split(/;/)
				.map(string => string.trim().split(/=/))
		).has(string);
	}
	static set(cookieName, cookieValue, options) {
		options = is(options) && isObject(options) ? options : {};
		let { expiration, sameSite } = options;
		if (!is(expiration)) {
			const newDate = new Date();
			const year = 365.244 * 24 * 3600 * 1000;
			newDate.setTime(newDate.getTime() + year);
			expiration = newDate.toGMTString();
		}
		const expirationString = `expires=${expiration}`;
		const sameSiteString = `SameSite=${sameSite||'Strict'};Secure`;
		document.cookie =
			`${cookieName}=${encodeURIComponent(cookieValue)};path=/;${expirationString};${sameSiteString}`;
	}
	static delete(cookieName) {
		const newDate = new Date();
		const year = 365.244 * 24 * 3600 * 1000;
		newDate.setTime(newDate.getTime() - year);
		const expirationString = `expires=${newDate.toGMTString()}`;
		document.cookie = `${cookieName}=${''};${expirationString};`;
	}
}
class PromiseWorker {
	constructor(url) {
		PromiseWorker.assert();
		this.worker = new Worker(url);
		this.worker.onmessage = PromiseWorker.onMessage;
	}
	get env() {
		return getGlobal().PromiseWorkers;
	}
	get onmessage() {
		return this.worker.onmessage;
	}
	postMessage(data) {
		return PromiseWorker.postMessage(data, this.worker);
	}
	static assert() {
		const self = getGlobal();
		if (!('PromiseWorkers' in self)) {
			self.PromiseWorkers = {
				resolves: [],
				rejects: [],
			};
		} else if (!('resolves' in self.PromiseWorkers && 'rejects' in self.PromiseWorkers)) {
			self.PromiseWorkers.resolves = [];
			self.PromiseWorkers.rejecs = [];
		}
	}
	static postMessage(data, worker) {
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
			if (resolve) {
				resolve(data);
			}
		} else if (is(reject)) {
			if (err) {
				reject(err);
			} else {
				reject('Got nothing');
			}
		}
		PromiseWorker.delete(id);
	}
	static get resolves() {
		PromiseWorker.assert();
		return getGlobal().PromiseWorkers.resolves;
	}
	static get rejects() {
		return getGlobal().PromiseWorkers.rejects;
	}
	static delete(id) {
		delete PromiseWorker.resolves[id];
		delete PromiseWorker.rejects[id];
	}
	static id(length) {
		const values = [];
		const list = [];
		for (let i = 0; i < 62; i += 1) {
			if (i < 10) {
				values[i] = 48 + i;
			} else if (i < 36) {
				values[i] = 65 + (i - 10);
			} else if (i < 62) {
				values[i] = 97 + (i - 36);
			}
		}
		for (let i = 0; i < (length || 16); i += 1) {
			list[i] = values[Math.floor(Math.random() * 62)];
		}
		return String.fromCharCode(...list);
	}
}
