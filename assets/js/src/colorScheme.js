/** eslint-env module */

import { addClass, hasClass, removeClass } from '../ext/src/dom.js';
import { Cookies } from '../ext/src/navigator.js';
import { getGlobal } from '../ext/src/utils.js';
import { catchError, isset } from './dom.js';
import { aemi, Environment } from './environment.js';


export class ColorScheme {

    static get cookie() {
        return Cookies.get( 'color-scheme' );
    }

    static set cookie( scheme ) {
        Cookies.set( 'color-scheme', scheme );
    }

    static get cookieState() {
        const _cookie = ColorScheme.cookie;
        return isset( _cookie ) ? _cookie : null;
    }

    static isCookieSet() {
        return Cookies.has( 'color-scheme' );
    }

    static deleteCookie() {
        Cookies.delete( 'color-scheme' );
        return Cookies.has( 'color-scheme' ) === false;
    }

    static get autoState() {
        return hasClass( document.body, 'color-scheme-auto' );
    }

    static get classState() {
        if ( hasClass( document.body, 'color-scheme-light' ) ) {
            return 'light';
        }
        if ( hasClass( document.body, 'color-scheme-dark' ) ) {
            return 'dark';
        }
        return null;
    }

    static get userState() {
        if ( aemi instanceof Environment ) {
            return aemi.assert( 'csh-sel' );
        }
        return is( byId( 'color-scheme-selector' ) );
    }

    static get browserState() {
        try {
            const matchMedia = window.matchMedia( '(prefers-color-scheme: light)' );
            return matchMedia.matches !== 'not all' ? matchMedia.matches ? 'light' : 'dark' : false;
        }
        catch ( error ) {
            return catchError( error );
        }
    }

    static get state() {
        const {
            classState,
            userState,
            cookieState,
            browserState
        } = ColorScheme;

        if ( isset( classState ) ) {
            if ( userState ) {
                if ( isset( cookieState ) ) {
                    return cookieState;
                }
            }
            else {
                if ( !ColorScheme.deleteCookie() ) {
                    catchError( 'color-scheme cookie did not have been deleted.' );
                }
            }
            return classState;
        }
        if ( userState ) {
            if ( isset( cookieState ) ) {
                return cookieState;
            }
        }
        else {
            if ( !ColorScheme.deleteCookie() ) {
                catchError( 'color-scheme cookie did not have been deleted.' );
            }
        }
        if ( isset( browserState ) ) {
            return browserState;
        }
        return 'light';
    }

    static get coherenceCondition() {
        return hasClass( document.body, 'color-scheme-light' ) && hasClass( document.body, 'has-post-thumbnail' );
    }

    static get scheme() {
        return aemi.get( 'colorScheme' ).scheme;
    }

    static set scheme( scheme ) {
        aemi.get( 'colorScheme' ).scheme = scheme;
    }

    static getOppositeState( scheme ) {
        return isset( scheme ) ? scheme === 'light' ? 'dark' : 'light' : null;
    }

    static detect() {
        const colorScheme = new ColorScheme();
        getGlobal().colorScheme = colorScheme;
        return colorScheme.scheme;
    }

    static toLightScheme( element ) {
        if ( hasClass( element, 'color-scheme-dark' ) ) {
            removeClass( element, 'color-scheme-dark', true );
            addClass( element, 'color-scheme-light', true );
        }
    }

    static toDarkScheme( element ) {
        if ( hasClass( element, 'color-scheme-light' ) ) {
            removeClass( element, 'color-scheme-light', true );
            addClass( element, 'color-scheme-dark', true );
        }
    }

    static change( scheme, cookie ) {
        const { body } = document;
        switch ( scheme ) {
            case 'dark': {
                removeClass( body, 'color-scheme-light', true );
                addClass( body, 'color-scheme-dark', true );
                break;
            }
            case 'light': {
                removeClass( body, 'color-scheme-dark', true );
                addClass( body, 'color-scheme-light', true );
                break;
            }
            case 'auto': {
                const browserState = ColorScheme.browserState || ColorScheme.classState || 'light';
                const oppositeState = ColorScheme.getOppositeState( browserState );
                removeClass( body, `color-scheme-${ oppositeState }`, true );
                addClass( body, `color-scheme-${ browserState }`, true );
                break;
            }
            default: {
                return catchError( 'scheme is not defined.' );
            }
        }

        if ( aemi.assert( 'colorScheme' ) ) {
            ColorScheme.scheme = scheme;
        }

        if ( cookie ) {
            ColorScheme.cookie = scheme;
        }

        return scheme;
    }

    static init() {
        const support = isset( ColorScheme.browserState );
        const matchMedia = window.matchMedia( '(prefers-color-scheme: light)' );
        if ( support ) {
            matchMedia.addListener( () => {
                const {
                    autoState,
                    classState,
                    userState,
                    cookieState,
                    browserState
                } = ColorScheme;
                if ( userState && isset( cookieState ) && cookieState === 'auto' || !( isset( classState ) && !autoState || userState ) ) {
                    ColorScheme.change( browserState, false );
                }
            } );
        }
        return ColorScheme.change( ColorScheme.state, false );
    }

    static changeHeaderScheme( ) {
        const header = aemi.byId( 'site-header' );
        const bar = aemi.get( 'pro-bar' );
        const isBar = aemi.assert( 'pro-bar' );
        if ( ColorScheme.coherenceCondition ) {
            if ( !isWrapperToggled() ) {
                isOnFirstHeader( header ) ? ColorScheme.toDarkScheme( header ) : ColorScheme.toLightScheme( header );
                if ( isBar ) {
                    isOnFirstHeader( bar ) ? ColorScheme.toDarkScheme( bar ) : ColorScheme.toLightScheme( bar );
                }
            }
            else {
                ColorScheme.toLightScheme( header );
                isBar && ColorScheme.toLightScheme( bar );
            }
        }
    }

    constructor() {
        this.scheme = ColorScheme.init();
    }

}

export default ColorScheme;
