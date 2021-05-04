/* eslint-env module */

import { attr, hasClass, toggleClass } from '../ext/src/dom.js';
import { isset } from './dom.js';
import { aemi } from './environment.js';

export const isToggled = function isToggled( element ) {
    return hasClass( element, 'toggled' );
};

export const doToggle = function doToggle( element ) {
    return toggleClass( element, 'toggled' );
};

export const isOnFirstHeader = function isOnFirstHeader( element, environment = aemi ) {
    const { bottom } = environment.get( 'first-header' ).getClientRects()[0];
    const { top } = element.getClientRects()[0];
    return bottom > top;
};

export const isWrapperToggled = function isWrapperToggled( environment = aemi ) {
    return environment.assert( 'nav-toggle' ) && isToggled( environment.get( 'nav-toggle' ) ) ||
        environment.assert( 'sea-toggle' ) && isToggled( environment.get( 'sea-toggle' ) );
};

export const addNoOpener = function addNoOpener( link ) {
    if ( link instanceof HTMLAnchorElement ) {
        const relAttr = attr( link, 'rel' ) || '';
        if ( !relAttr.includes( 'noopener' ) ) {
            attr( link, 'rel', isset( relAttr ) ? `${ relAttr } noopener` : 'noopener' );
        }
    }
};

export default { isOnFirstHeader, isWrapperToggled, isToggled, doToggle, addNoOpener };
