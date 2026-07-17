/**
 * Booking form submit, AJAX and optional Razorpay checkout.
 */
( function () {
	'use strict';

	if ( 'undefined' === typeof epbBooking ) {
		return;
	}

	document.querySelectorAll( '.epb-booking-form' ).forEach( function ( form ) {
		var msg = form.querySelector( '.epb-form-msg' );
		var button = form.querySelector( 'button[type="submit"]' );

		function showMessage( type, text ) {
			msg.hidden = false;
			msg.className = 'epb-form-msg ' + type;
			msg.textContent = text;
			msg.scrollIntoView( { behavior: 'smooth', block: 'nearest' } );
		}

		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();

			if ( ! form.reportValidity() ) {
				return;
			}

			button.disabled = true;
			showMessage( 'success', epbBooking.i18n.submitting );

			var data = new FormData( form );
			data.append( 'action', 'epb_create_booking' );
			data.append( 'nonce', epbBooking.nonce );

			fetch( epbBooking.ajaxUrl, { method: 'POST', body: data } )
				.then( function ( res ) { return res.json(); } )
				.then( function ( res ) {
					if ( ! res.success ) {
						throw new Error( res.data && res.data.message ? res.data.message : epbBooking.i18n.error );
					}

					if ( 'razorpay' === res.data.payment && window.Razorpay ) {
						openRazorpay( res.data );
						return;
					}

					form.reset();
					showMessage( 'success', epbBooking.i18n.success );
					button.disabled = false;
				} )
				.catch( function ( err ) {
					showMessage( 'error', err.message || epbBooking.i18n.error );
					button.disabled = false;
				} );
		} );

		function openRazorpay( payload ) {
			var rzp = new window.Razorpay( {
				key: epbBooking.razorpayKey,
				order_id: payload.order.id,
				amount: payload.order.amount,
				currency: payload.order.currency,
				name: epbBooking.brandName,
				description: 'Puja booking',
				prefill: {
					name: payload.customer.name,
					email: payload.customer.email,
					contact: payload.customer.phone
				},
				theme: { color: epbBooking.brandColor },
				handler: function ( response ) {
					var verify = new FormData();
					verify.append( 'action', 'epb_verify_payment' );
					verify.append( 'nonce', epbBooking.nonce );
					verify.append( 'booking_id', payload.booking_id );
					verify.append( 'razorpay_order_id', response.razorpay_order_id );
					verify.append( 'razorpay_payment_id', response.razorpay_payment_id );
					verify.append( 'razorpay_signature', response.razorpay_signature );

					fetch( epbBooking.ajaxUrl, { method: 'POST', body: verify } )
						.then( function ( res ) { return res.json(); } )
						.then( function ( res ) {
							if ( res.success ) {
								form.reset();
								showMessage( 'success', epbBooking.i18n.paid );
							} else {
								showMessage( 'error', res.data.message || epbBooking.i18n.error );
							}
							button.disabled = false;
						} );
				},
				modal: {
					ondismiss: function () {
						showMessage( 'success', epbBooking.i18n.success );
						button.disabled = false;
					}
				}
			} );
			rzp.open();
		}
	} );
} )();
