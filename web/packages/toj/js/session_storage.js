/*!
 * Really simple client-side caching of html partials that don't change very often.
 * @author: Jon Hartman
 * @credit: Focus43 (http://focus-43.com)
 */
(function($){

    /**
     * Add hash code prototype to string object.
     * @returns {number}
     */
    String.prototype.hashCode = function(){
        var hash = 0, i, l, char;
        if (this.length === 0){ return hash; }
        for (i = 0, l = this.length; i < l; i++) {
            char  = this.charCodeAt(i);
            hash  = ((hash<<5)-hash)+char;
            hash |= 0; // Convert to 32bit integer
        }
        return hash;
    };


    /**
     * Make a request from local sessionStorage, if available.
     * @param _key
     * @returns {*}
     */
    function getLocal( _key ){
        return (Modernizr.sessionstorage) ? sessionStorage.getItem( _key ) : null;
    }


    /**
     * Set a value in local sessionstorage, if available.
     * @param _key
     * @param data
     * @return bool
     */
    function setLocal( _key, data ){
        if( Modernizr.sessionstorage ){
            sessionStorage.setItem( _key, data );
            return true;
        }
        return false;
    }


    /**
     * Cache the... promise... cache objects. Inception style shit.
     * @type {}
     */
    var promiseCache  = {};


    $.clientCache = function( _key, _sourceFunction, _returnType ){
            // set the data type, if not defined defaults to html
        var dataType = typeof _returnType !== 'undefined' ? _returnType : 'html',
            // make sure the key is in unique hash form
            cacheKey = _key + '_' + ('c@che' + _key).hashCode() + dataType;

        // does the promise exist already? if not, create it
        if( !promiseCache[cacheKey] ){
            // create the deferred object, and return the promise
            promiseCache[cacheKey] = $.Deferred(function( _task ){
                // query local storage
                var _result = getLocal(cacheKey);

                // cache hit? return as the specified data type
                if( _result ){
                    var _data = (dataType === 'json') ? JSON.parse(_result) : _result;
                    console.log('SessionCache hit on: ' + _key);
                    _task.resolve( _data );
                    return;
                }

                // if we get here, register a callback to *set* the cache data on success
                // from the _sourceFunction
                _task.done(function( data ){
                    var _data = (dataType === 'json') ? JSON.stringify(data) : data;
                    setLocal( cacheKey, _data );
                });

                // original source
                _sourceFunction( _task );
            }).promise();
        }

        // return the promise from the cache key
        return promiseCache[ cacheKey ];
    };

})(jQuery);