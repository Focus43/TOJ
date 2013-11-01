
    /**
     * Simple and kinda crude way to cache html partials on a page instead of pinging
     * over a network every time. Uses sessionStorage to cache partials.
     */
    (function($){

        /**
         * Add hash code prototype to string object.
         * @returns {number}
         */
        String.prototype.hashCode = function(){
            var hash = 0, i, char;
            if (this.length == 0) return hash;
            for (i = 0, l = this.length; i < l; i++) {
                char  = this.charCodeAt(i);
                hash  = ((hash<<5)-hash)+char;
                hash |= 0; // Convert to 32bit integer
            }
            return hash;
        };


        $.fn.htmlCacheLoader = function( uri ){

            var $element    = this,
                _keyPrepend = 'html_partial';

            function getCached( uri ){
                return sessionStorage.getItem( _keyPrepend + uri.hashCode() );
            }

            function setCache( uri, html ){
                sessionStorage.setItem( _keyPrepend + uri.hashCode(), html );
            }

            return $.Deferred(function( _task ){
                var _cacheHit = getCached(uri);
                if( _cacheHit ){
                    console.log('sessionStorage cache hit: ', uri);
                    $element.append( _cacheHit );
                    _task.resolve();
                    return;
                }

                $element.load( uri, function( _html ){
                    console.log('sesstionStorage cache miss: ', uri);
                    setCache(uri, _html);
                    _task.resolve();
                });
            });

        }

    })(jQuery);