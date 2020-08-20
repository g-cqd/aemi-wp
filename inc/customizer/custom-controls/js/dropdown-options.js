jQuery( document ).ready( function() {

	jQuery( '.customize-control-dropdown-options select' ).on(
		'change',
		function() {

			select_value = jQuery( this ).parents( '.customize-control' ).find( 'option:selected' ).map(
				function() {
					return this.value;
				}
			).get().join( ',' );

			jQuery( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( select_value ).trigger( 'change' );
		}
	);

} );