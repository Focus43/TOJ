/*! Elderly browsers... */
;(function( _modernizr ){
    _modernizr.load([
        {
            test: Modernizr.mq('only all'),
            nope: '/packages/toj/js/standalones/shims/respond.min.js',
            complete: function(){
                if( typeof(respond) !== 'undefined' ){
                    respond.update();
                }
            }
        },{
            test: Modernizr.placeholder,
            nope: '/packages/toj/js/standalones/shims/placeholder.min.js',
            complete: function(){
                if( typeof(Placeholders) != 'undefined' ){
                    // @todo: switched to https://github.com/mathiasbynens/jquery-placeholder
                    // initialize differently
                    Placeholders.init();
                }
            }
        }
    ]);
})( Modernizr );