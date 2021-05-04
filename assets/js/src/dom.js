import { Wait } from '../ext/src/loading.js';

/**
 * @param {any} object Any object to test
 * @returns if the object is defined somehow
 */
export const is = function is( object ) {
    return object !== null && object !== undefined;
};
/**
 * @param {any} object
 * @returns if the object is defined somehow but not an empty string
 */
export const isset = function isset( object ) {
    return is( object ) && object !== '';
};
/**
 * @param {any} variable
 * @returns if the variable is a Number
 */
export const isNumber = function isNumber( variable ) {
    return typeof variable === 'number' || variable instanceof Number;
};
/**
 * @param {any} variable
 * @returns if the variable is a String
 */
export const isString = function isString( variable ) {
    return typeof variable === 'string' || variable instanceof String;
};
/**
 * @param {any} variable
 * @returns if the variable is a strict Boolean value
 */
export const isBoolean = function isBoolean( variable ) {
    return typeof variable === 'boolean';
};
/**
 * @param {any} object
 * @returns if the object is a function
 */
export const isFunction = function isFunction( object ) {
    return typeof object === 'function' || object instanceof Function ? object : false;
};
/**
 * @param {any} variable
 * @returns if the variable is an object but not the null value
 */
export const isObject = function isObject( variable ) {
    return variable !== null && ( typeof variable === 'object' || variable instanceof Object );
};
/**
 * @param {any} object
 * @returns if the object is an URL or coercible to an URL
 */
export const isURL = function isURL( object ) {
    if ( isString( object ) ) {
        try {
            return new URL( object ) instanceof URL;
        }
        catch ( _ ) {
            return false;
        }
    }
    else {
        return object instanceof URL;
    }
};
/**
 * Delays logging of a message or an error as console.error and returns false
 *
 * @param {String|Error} caughtError
 * @returns {false}
 */
export const catchError = function catchError( errorPayload ) {
    let error;
    if ( typeof error === 'string' ) {
        error = new Error( errorPayload );
    }

    Wait.promiseDelay( console.error, 0, error || errorPayload );
    return false;
};
/**
 *
 * @param {Function} func
 * @param  {...any} args
 * @returns {number}
 */
export const requestFrame = function requestFrame( func, ...args ) {
    return window.requestAnimationFrame( timestamp => func( timestamp, ...args ) );
};
/**
 * @param {number} id
 * @returns {Boolean}
 */
export const cancelFrame = function cancelFrame( id ) {
    try {
        return !window.cancelAnimationFrame( id );
    }
    catch ( error ) {
        return catchError( error );
    }
};

/**
 * @param {String} elementId String that specifies the ID value.
 * @returns Returns a reference to the first object with the specified value of the ID attribute.
 */
export const byId = function byId( elementId ) {
    return document.getElementById( elementId );
};

/**
 * Returns a HTMLCollection of the elements in the object on which
 * the method was invoked (a document or an element) that have all the
 * classes given by classNames. The classNames argument is interpreted
 * as a space-separated list of classes.
 * @param {String} classNames
 * @param {Element} [element=document]
 * @returns {HTMLCollection<Element>}
 */
export const byClass = function byClass( classNames, element = document ) {
    return element.getElementsByClassName( classNames );
};

/**
 * Inhibits an event with #preventDefault and #stopPropagation
 *
 * @param {Event} event
 */
export const inhibitEvent = function inhibitEvent( event ) {
    event.preventDefault();
    event.stopPropagation();
};

export default {
    is,
    isset,
    isNumber,
    isString,
    isBoolean,
    isFunction,
    isObject,
    isURL,
    catchError,
    byId,
    byClass,
    requestFrame,
    cancelFrame,
    inhibitEvent
};
