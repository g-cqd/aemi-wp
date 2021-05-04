/* eslint-env module */

import { addClass, data, ecs, hasClass, removeClass } from './ext/src/dom.js';
import { Wait } from './ext/src/loading.js';
import { smoothScrollTo } from './ext/src/move.js';
import { getGlobal } from './ext/src/utils.js';
import ColorScheme from './src/colorScheme.js';
import { byClass, byId, is, isFunction, isset, requestFrame } from './src/dom.js';
import { aemi, Environment } from './src/environment.js';
import Lightbox from './src/lightbox.js';
import { addNoOpener, doToggle, isToggled } from './src/theme.js';

aemi.set( 'global', getGlobal() );
aemi.set( 'site-header', byId( 'site-header' ) );
aemi.set( 'site-loop', byId( 'site-loop' ) );
aemi.set( 'first-header', byClass( 'post-header' )[0] );
aemi.set( 'nav-toggle', byId( 'navigation-toggle' ) );
aemi.set( 'sea-toggle', byId( 'search-toggle' ) );
aemi.set( 'sea-input', byId( 'search-input-0' ) );
aemi.set( 'pro-bar', byId( 'site-progress-bar' ) );
aemi.set( 'csh-sel', byId( 'color-scheme-selector' ) );
aemi.set( 'csh-light', byId( 'light-scheme-option' ) );
aemi.set( 'csh-dark', byId( 'dark-scheme-option' ) );
aemi.set( 'csh-auto', byId( 'auto-scheme-option' ) );


try {
    if ( isFunction( aemi_color_scheme ) ) {
        aemi.push( aemi_color_scheme );
    }
}
catch ( _ ) {
    aemi.push( () => {
        const scheme = ColorScheme.detect();
        let support = false;
        if ( aemi instanceof Environment ) {
            support = aemi.assert( 'csh-sel' );
        }
        else {
            support = isset( byId( 'color-scheme-selector' ) );
        }
        if ( support ) {
            aemi.get( `csh-${ scheme }` ).checked = true;
            aemi.get( 'csh-sel' ).addEventListener( 'input', async () => {
                if ( aemi.get( 'csh-light' ).checked ) {
                    ColorScheme.change( 'light', true );
                }
                else if ( aemi.get( 'csh-dark' ).checked ) {
                    ColorScheme.change( 'dark', true );
                }
                else if ( aemi.get( 'csh-auto' ).checked ) {
                    ColorScheme.change( 'auto', true );
                }
            } );
        }
    } );
}

try {
    if ( isFunction( aemi_menu ) ) {
        aemi.push( aemi_menu );
    }
}
catch ( _ ) {
    aemi.push( () => {
        for ( const menu of byClass( 'menu' ) ) {
            if ( ![ 'header-menu', 'header-social', 'footer-menu' ].includes( menu.id ) ) {
                for ( const parent of byClass( 'menu-item-has-children', menu ) ) {
                    if ( parent.getElementsByTagName( 'li' ).length > 0 ) {
                        parent.insertBefore(
                            ecs( {
                                class: [ 'toggle' ],
                                _: [ { class: [ 'toggle-element' ] } ]
                            } ),
                            parent.childNodes[1]
                        );
                    }
                }
            }
        }
    } );
}

try {
    if ( isFunction( aemi_loop ) ) {
        aemi.push( aemi_loop );
    }
}
catch ( _ ) {
    aemi.push( () => {
        if ( aemi.assert( 'site-loop' ) ) {
            const loop = aemi.get( 'site-loop' );
            const entries = loop.getElementsByClassName( 'entry' );
            for ( const entry of entries ) {
                const anchor = entry.getElementsByTagName( 'a' )[0];
                if ( is( anchor ) ) {
                    entry.addEventListener( 'click', () => {
                        anchor.click();
                    } );
                    entry.addEventListener( 'mouseenter', () => {
                        addClass( entry, ':hover' );
                    } );
                    entry.addEventListener( 'mouseleave', () => {
                        removeClass( entry, ':hover' );
                    } );
                }
            }
        }
    } );
}

try {
    if ( isFunction( aemi_form_fix ) ) {
        aemi.push( aemi_form_fix );
    }
}
catch ( _ ) {
    aemi.push( () => {
        for ( const form of document.getElementsByClassName( 'comment-form' ) ) {
            form.removeAttribute( 'novalidate' );
        }
    } );
}

try {
    if ( isFunction( aemi_toggle ) ) {
        aemi.push( aemi_toggle );
    }
}
catch ( _ ) {
    aemi.push( () => {
        for ( const toggler of byClass( 'toggle' ) ) {
            toggler.addEventListener( 'click', () => {
                const id = data( toggler, 'target' );
                if ( isset( id ) ) {
                    doToggle( byId( id ) );
                }
                doToggle( toggler );
            } );
        }
    } );
}
try {
    if ( isFunction( aemi_galleries ) ) {
        aemi.push( aemi_galleries );
    }
}
catch ( _ ) {
    aemi.push( () => new Lightbox( { env: aemi } ).prepare( {
        wrapperSelectors: [
            '.gallery',
            '.blocks-gallery-grid',
            '.wp-block-gallery',
            '.justified-gallery'
        ],
        itemSelectors: [
            '.gallery-item',
            '.blocks-gallery-item',
            '.jg-entry'
        ],
        captionSelectors: [
            'figcaption',
            '.gallery-caption'
        ]
    } ) );
}
try {
    if ( isFunction( aemi_view_handler ) ) {
        aemi.push( aemi_view_handler );
    }
}
catch ( _ ) {
    aemi.push( () => {
        const classScrolled = 'page-scrolled';
        const classHidden = 'header-hidden';
        const aemi_header_auto_hide = autoHide => requestFrame( startTime => {
            const currentState = {
                startTime,
                height: document.body.clientHeight,
                position: window.scrollY
            };
            setTimeout(
                ( observable, currentState ) => requestFrame(
                    ( currentTime, observable, currentState ) => {
                        const { startTime, height, position } = currentState;
                        const currentPosition = window.scrollY;
                        const menuToggler = aemi.get( 'nav-toggle' );
                        const searchToggler = aemi.get( 'sea-toggle' );
                        if ( position > 0 ) {
                            addClass( observable, classScrolled );
                        }
                        else {
                            removeClass( observable, classScrolled );
                        }
                        if (
                            autoHide &&
                                ( !menuToggler || !isToggled( menuToggler ) ) &&
                                ( !searchToggler || !isToggled( searchToggler ) )
                        ) {
                            const elapsedTime = currentTime - startTime;
                            if ( elapsedTime > 100 ) {
                                const elapsedDistance =
                                        currentPosition - position;
                                const $11 = Math.round( 1000 * elapsedDistance / elapsedTime );
                                if ( !hasClass( observable, classHidden ) ) {
                                    if ( $11 > 0 && position > 0 && position + window.innerHeight < height ) {
                                        addClass( observable, classHidden );
                                    }
                                }
                                else if (
                                    $11 < 0 && position > 0 && position + window.innerHeight < height ||
                                        position <= 0 || position + window.innerHeight >= height ) {
                                    removeClass( observable, classHidden );
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
        } );
        const aemi_progress_bar = () => requestFrame( () => {
            const totalHeight = document.body.clientHeight - window.innerHeight;
            const progress = window.scrollY / totalHeight;
            aemi.get( 'pro-bar' ).style.width = `${ 100 * ( progress > 1 ? 1 : progress )
            }vw`;
        } );
        const features = [
            {
                test: [ aemi.assert( 'pro-bar' ) ],
                func: aemi_progress_bar,
                args: []
            },
            {
                test: [],
                func: aemi_header_auto_hide,
                args: [ hasClass( document.body, 'header-auto-hide' ) ]
            },
            {
                test: [ true ],
                func: ColorScheme.changeHeaderScheme,
                args: []
            }
        ];

        features.forEach( ( { test, func, args } ) => {
            if ( test.every( t => t === true ) ) {
                for ( const type of [ 'scroll', 'resize' ] ) {
                    window.addEventListener(
                        type,
                        () => func( ...args ),
                        { passive: true }
                    );
                }
            }
        } );
    } );
}

try {
    if ( isFunction( aemi_mutation_observer ) ) {
        aemi.push( aemi_mutation_observer );
    }
}
catch ( _ ) {
    aemi.push( () => {

        const toggleFilter = [ aemi.get( 'nav-toggle' ), aemi.get( 'sea-toggle' ) ];

        /**
         *
         * @param {MutationRecord[]} mutationRecords
         */
        const togglerHandler = function togglerHandler( mutationRecords ) {
            for ( const { target } of mutationRecords ) {
                const alts = toggleFilter.filter( e => e !== target );
                if ( isToggled( target ) ) {
                    for ( const alt of alts.filter( e => isToggled( e ) ) ) {
                        doToggle( aemi.byId( data( alt, 'target' ) ) );
                        doToggle( alt );
                    }
                }
                if ( target === aemi.get( 'sea-toggle' ) && aemi.assert( 'sea-input' ) ) {
                    Wait.promiseDelay( () => {
                        aemi.get( 'sea-input' ).focus();
                    }, 200 );
                }
                ColorScheme.changeHeaderScheme();
            }
        };

        const togglerObserver = new MutationObserver( togglerHandler );

        togglerObserver.observe( aemi.get( 'nav-toggle' ), {
            attributes: true,
            attributeFilter: [ 'class' ]
        } );

        togglerObserver.observe( aemi.get( 'sea-toggle' ), {
            attributes: true,
            attributeFilter: [ 'class' ]
        } );

        /**
         *
         * @param {MutationRecord[]} mutationRecords
         */
        const schemeMutationHandler = function schemeMutationHandler( mutationRecords ) {
            for ( let i = 0, { length } = mutationRecords; i < length; i += 1 ) {
                if ( ColorScheme.coherenceCondition ) {
                    ColorScheme.changeHeaderScheme();
                }
                else if ( hasClass( document.body, 'has-post-thumbnail' ) ) {
                    ColorScheme.toDarkScheme( aemi.get( 'site-header' ) );
                    aemi.assert( 'pro-bar' ) && ColorScheme.toDarkScheme( aemi.get( 'pro-bar' ) );
                }
            }
        };

        const colorSchemeObserver = new MutationObserver( schemeMutationHandler );

        colorSchemeObserver.observe( document.body, {
            attributes: true,
            attributeFilter: [ 'class' ]
        } );
    } );
}

try {
    if ( isFunction( aemi_link_tweaking ) ) {
        aemi.push( aemi_link_tweaking );
    }
}
catch ( _ ) {
    aemi.push( () => {
        for ( const link of document.getElementsByTagName( 'a' ) ) {
            let url;
            let hash;
            let scrollable;
            let external;
            try {
                url = new URL( link.href );
                ( { hash } = url );
                external = window.location.origin !== url.origin;
                scrollable =
                    !external &&
                    window.location.pathname === url.pathname &&
                    isset( hash );
            }
            catch ( _error ) {
                if ( link.href.indexOf( '#' ) >= 0 ) {
                    hash = link.href.split( '?' )[0];
                    scrollable = isset( hash );
                }
            }
            if ( external ) {
                addNoOpener( link );
            }
            if ( scrollable ) {
                link.addEventListener( 'click', () => {
                    smoothScrollTo( hash );
                } );
            }
        }
    } );
}

aemi.run();
