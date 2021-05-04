/** eslint-env module */

import { Wait } from '../ext/src/loading.js';
import { byClass, byId, catchError, is, isFunction } from './dom.js';


export class Environment {

    constructor() {
        this.actions = [];
        this.cache = Object.create( null );
    }

    has( key ) {
        return key in this.cache;
    }

    set( key, value, force = false ) {
        if ( force || !this.has( key ) ) {
            return ( this.cache[key] = value );
        }
        throw new Error( `"${ key }" has already been saved in environment.` );
    }

    get( key ) {
        if ( !this.has( key ) ) {
            throw new Error( `"${ key }" did not have been saved in environment yet.` );
        }
        return this.cache[key];
    }

    /**
     * @param {String} elementId String that specifies the ID value.
     * @returns Returns a reference to the first object with the specified value of the ID attribute.
     */
    async byId( elementId ) {
        if ( this.has( elementId ) ) {
            return this.cache[elementId];
        }
        return this.set( elementId, byId( elementId ), true );

    }

    /**
     * Returns a HTMLCollection of the elements in the object on which
     * the method was invoked (a document or an element) that have all the
     * classes given by classNames. The classNames argument is interpreted
     * as a space-separated list of classes.
     * @param {String} classNames
     * @param {Element} [element=document]
     * @returns {HTMLCollection<Element>}
     */
    byClass( classNames, element = document ) {
        if ( this.has( classNames ) ) {
            return this.cache[classNames];
        }
        return this.set( classNames, byClass( classNames, element ) );

    }

    assert( key, value ) {
        if ( this.has( key ) ) {
            try {
                if ( is( value ) ) {
                    return this.get( key ) === value;
                }
                return is( this.get( key ) );
            }
            catch ( error ) {
                return catchError( error );
            }
        }
        return false;
    }

    push( ...funcs ) {
        for ( const func of funcs ) {
            if ( isFunction( func ) ) {
                this.actions.push( func );
            }
            else {
                catchError( `func:${ func } is not a function.` );
            }
        }
    }

    async run() {
        try {
            return Promise.all( this.actions.map( Wait.interactive ) );
        }
        catch ( error ) {
            return catchError( error );
        }
    }

}

export const aemi = new Environment();

export default { aemi, Environment };
