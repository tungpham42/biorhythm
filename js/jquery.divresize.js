(function($){
    // A collection of elements to which the resize event is bound.
    var elems = $([]),
	// An id with which the polling loop can be canceled.
	timeout_id;
    // Special event definition.
    $.event.special.resize = {
        setup: function() {
            var elem = $(this);
            // Add this element to the internal collection.
            elems = elems.add( elem );
            // Initialize default plugin data on this element.
            elem.data( 'resize', { w: elem.width(), h: elem.height() } );
            // If this is the first element to which the event has been bound,
            // start the polling loop.
            if ( elems.length === 1 ) {
                poll();
            }
        },
        teardown: function() {
            var elem = $(this);
            // Remove this element from the internal collection.
            elems = elems.not( elem );
            // Remove plugin data from this element.
            elem.removeData( 'resize' );
            // If this is the last element to which the event was bound, cancel
            // the polling loop.
            if ( !elems.length ) {
                clearTimeout( timeout_id );
            }
        }
    };
    // As long as a "resize" event is bound, this function will execute
    // repeatedly.
    function poll() {
        // Iterate over all elements in the internal collection.
        elems.each(function(){
            var elem = $(this),
                width = elem.width(),
                height = elem.height(),
                data = elem.data( 'resize' );
            // If element size has changed since the last time, update the element
            // data store and trigger the "resize" event.
            if ( width !== data.w || height !== data.h ) {
                data.w = width;
                data.h = height;
                elem.triggerHandler( 'resize' );
            }
        });
        // Poll, setting timeout_id so the polling loop can be canceled.
        timeout_id = setTimeout( poll, 250 );
    };
})(jQuery);