
    /**
     * Town Of Jackson site
     * @author Focus43 (http://focus-43.com)
     * @copyright 2013 Town Of Jackson. All Rights Reserved.
     */
    $(function(){
        window.tojApp = (function(){

            // cache common selectors
            var _self       = this,
                $document   = $(document),
                $window     = $(window),
                $body       = $('body'),
                $settings   = $('#siteSettings');


            // css transitions
            this.transitionEnd  = 'transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd';


            // lazy-load sidebar content, if visible (auto-triggers on init)
            $document.on(_self.transitionEnd, '#cL1', function( _transitionEvent ){
                if( _transitionEvent.target === this ){
                    var _bodyWidth = $body.outerWidth();

                    if( _bodyWidth >= 1240 ){
                        var $sidebarLeft = $('#sidebarLeft');
                        if( $sidebarLeft.attr('data-load') ){
                            $sidebarLeft.load( $sidebarLeft.attr('data-load')).removeAttr('data-load');
                        }
                    }

                    if( _bodyWidth >= 1480 ){
                        var $sidebarRight = $('#sidebarRight');
                        if( $sidebarRight.attr('data-load') ){
                            $sidebarRight.load( $sidebarRight.attr('data-load')).removeAttr('data-load');
                            $document.off(_self.transitionEnd, '#cL1');
                        }
                    }
                }
            });


            // auto-trigger the transition event (load sidebar content) on init
            $('#cL1').trigger('transitionend');


            // lazy-load large background images (anything w/ data-background attr)
            if( typeof Modernizr !== 'undefined' ){
                var $backgroundElements = $('[data-background]');
                if( Modernizr.backgroundsize && $backgroundElements.length ){
                    $backgroundElements.each(function(idx, element){
                        $(element).css({backgroundImage: 'url('+element.getAttribute('data-background')+')'})
                            .removeAttr('data-background');
                    });
                }
            }


            // PUBLIC METHODS
            return {

            }

        }());
    });