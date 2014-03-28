/**
 * This is concat'd with application.js, which is included at the bottom of the
 * page *after* jQuery is available.
 */
(function( _modernizr ){
    _modernizr.load([
        {
            test     : _modernizr.mq('only all'),
            nope     : '/packages/toj/bower_components/respond/dest/respond.min.js',
            complete : function(){
                if( typeof(respond) !== 'undefined' ){
                    respond.update();
                }
            }
        },{
            test     : _modernizr.placeholder,
            nope     : '/packages/toj/bower_components/jquery-placeholder/jquery.placeholder.min.js',
            complete : function(){
                $('input,textarea').placeholder();
            }
        },{
            test     : _modernizr.backgroundsize,
            nope     : '/packages/toj/bower_components/jquery-backstretch/jquery.backstretch.min.js',
            complete : function(){
                if( typeof($) !== 'undefined' && $.isFunction($.backstretch) ){
                    $('[data-background]').each(function(idx, element){
                        $(element).backstretch( element.getAttribute('data-background') );
                    });
                }
            }
        }
    ]);
})( Modernizr );