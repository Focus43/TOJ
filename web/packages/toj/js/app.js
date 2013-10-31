
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


            // lazy-load sidebar content, if visible (auto-triggers on init)
            $document.on(_self.transitionEnd, '#cL1', function( _transitionEvent ){
                if( _transitionEvent.target === this ){
                    var _bodyWidth = $body.outerWidth();

                    if( _bodyWidth >= 1240 ){
                        var $sidebarLeft = $('#sidebarLeft');
                        if( $sidebarLeft.attr('data-load') ){
                            $sidebarLeft.load( $sidebarLeft.attr('data-load'), function(){
                                $sidebarLeft.removeAttr('data-load');
                            });
                        }
                    }

                    if( _bodyWidth >= 1480 ){
                        var $sidebarRight = $('#sidebarRight');
                        if( $sidebarRight.attr('data-load') ){
                            $sidebarRight.load( $sidebarRight.attr('data-load'), function(){
                                $sidebarRight.removeAttr('data-load');
                            });
                            $document.off(_self.transitionEnd, '#cL1');
                        }
                    }
                }
            });


            // auto-trigger the transition event (load sidebar content) on init
            $('#cL1').trigger('transitionend');


            /**
             * Accessibility settings
             */
            $document.on('click', '#openSettings, #closeSettings', {overlay: $settings}, function(_clickEv){
                var _top = _clickEv.data.overlay.data('toggled') === true ? '-100%' : 0;
                $('#siteSettings').animate({top:_top}, 300, 'easeOutExpo').data('toggled', !_clickEv.data.overlay.data('toggled'));
            });


            // toggle font size
            $settings.on('click', '.setFontSize', function(){
                $body.css({zoom: $(this).attr('data-zoom')});
            });


            /**
             * Modal windows
             */
            $document.on('click', '.modalize', function(_clickEvent){
                _clickEvent.preventDefault();
                var $this = $(this),
                    _uri  = $this.attr('href');

                if( _uri.length ){
                    $.get(_uri, {modal:true}, function(_html){
                        var $modal = $(_html);
                        $modal.appendTo($body).modal();
                    }, 'html');
                    return;
                }

                // if we get here, show error message
                alert('Unable to load requested page.');
            });


            /**
             * Popovers and tooltips
             */
            $document.popover({
                animation: false,
                selector: '.showPopover',
                trigger: 'hover',
                placement: function(){
                    return this.$element.attr('data-placement') || 'top';
                },
                container: 'body'
            }).tooltip({
                animation: false,
                selector: '.showTooltip',
                trigger: 'hover focus',
                placement: function(){
                    return this.$element.attr('data-placement') || 'top';
                },
                container: 'body'
            });


            // PUBLIC METHODS
            return {

            }

        }());


        /**
         * jQuery Easing Methods
         */
        jQuery.extend( jQuery.easing, {
            easeInSine: function (x, t, b, c, d) {
                return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
            },
            easeInExpo: function (x, t, b, c, d) {
                return (t===0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
            },
            easeOutExpo: function (x, t, b, c, d) {
                return (t===d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
            }
        });
    });