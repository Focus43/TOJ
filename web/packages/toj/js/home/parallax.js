; /*!
 * "Explore Jackson" super sexy parallax.
 * @dependency Greensock animation library
 */
$(function(){

    window.ExploreJackson = (function(){

        var $body    = $('body'),
            $plxView = $('<div id="parallaxView" />');

        function launch(){
            $body.append($plxView).addClass('parallax');
            TweenLite.to($plxView, 1, {opacity:1});
            //TweenLite.to($cL1, 0.3, {top:'100%'});
            //TweenLite.to($navbar, 0.3, {opacity:0});
            //TweenLite.to($bgwrap, 0.3, {left:0,right:0});
        }

        return {
            open: launch,
            next: function(){
                console.log('fine');
            }
        };
    }());

});