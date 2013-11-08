/*!
 * Town Of Jackson site
 * @author Focus43 (http://focus-43.com)
 * @copyright 2013 Town Of Jackson. All Rights Reserved.
 */
$(function(){
    window.tojApp = (function(){

        // cache common selectors
        var _self       = this,
            $document   = $(document),
            $body       = $('body'),
            $settings   = $('#siteSettings'),
            $sidebarLeft = $('#sidebarLeft'),
            $sidebarRight = $('#sidebarRight');


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
        if( !$body.hasClass('edit-mode') ){
            if( $body.hasClass('cms-admin') ){
                sessionStorage.clear();
            }

            $document.on(_self.transitionEnd, '#cL1', function( _transitionEvent ){
                if( _transitionEvent.target === this ){
                    var _bodyWidth = $body.outerWidth();

                    if( _bodyWidth >= 1200 ){
                        if( $sidebarLeft.attr('data-load') ){
                            $.clientCache('leftSidebar', function( _task ){
                                $.get($sidebarLeft.attr('data-load'), function( _htmlResponse ){
                                    _task.resolve(_htmlResponse);
                                }, 'html');
                            }).done(function( _htmlResults ){
                                $sidebarLeft.append( _htmlResults).removeAttr('data-load');
                                $sidebarLeft.trigger('sidebar_left_open');
                            });
                        }
                    }

                    if( _bodyWidth >= 1334 ){
                        $.clientCache('rightSidebar', function( _task ){
                            $.get($sidebarRight.attr('data-load'), function( _htmlResponse ){
                                _task.resolve(_htmlResponse);
                            }, 'html');
                        }).done(function( _htmlResults ){
                            $sidebarRight.append( _htmlResults).removeAttr('data-load');
                            $document.off(_self.transitionEnd, '#cL1');
                        });
                    }
                }
            });
        }else{
            $('.sidebars').removeAttr('data-load');
        }


        // weather data for sidebars
        $document.on('sidebar_left_open', function(){
            $.clientCache('weatherData', function( _task ){
                $.simpleWeather({zipcode: '83001', unit: 'f', success: function(weather){
                    _task.resolve(weather);
                }});
            }, 'json').done(function( weather ){
                $('.panel-body', '#sidebarLeft .weatherWidget').append(function(){
                    return '<img src="'+weather.thumbnail+'" />'+weather.temp+'&deg;'+weather.units.temp+' &nbsp;<span class="badge">'+weather.currently+'</span>';
                });
            });
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


        /**
         * Toggle the font size
         */
        $settings.on('click', '.setFontSize', function(){
            var _value = $(this).attr('data-zoom');
            if( _value === 'default' ){
                $body.removeAttr('data-zoom');
                return;
            }
            $body.attr('data-zoom', _value);
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


        // news page
        $('#btnLoadMore').on('click.pager', function(){
            var $this = $(this),
                _page = +($this.data('paging') || 2);

            // auto-incr the paging data attr even before querying
            $this.data('paging', _page + 1);

            $.get( $this.attr('data-src') + _page, function( _html ){
                if( !_html.length ){
                    $this.replaceWith('<strong class="text-success"><i class="fa fa-check-circle-o"></i> All Posts Loaded!</strong>');
                    $this.off('click.pager');
                    return;
                }

                var $container = $('.list-group', '#postList');
                if( $container.data('masonry') ){
                    var $html = $(_html);
                    $container.masonry().append($html).masonry('appended', $html);
                }else{
                    $container.append(_html);
                }
            }, 'html');
        });


        // masonry grid stuff for news page
        $('[data-view]', '#postList').on('click', function(){
            var $this = $(this),
                $container = $('.list-group', '#postList');

            $this.addClass('active').siblings('button').removeClass('active');

            if( $this.attr('data-view') === 'grid' ){
                $container.addClass('grid');
                $container.masonry({
                    itemSelector: '.list-group-item',
                    columnWidth: '.list-group-item',
                    gutter: 0,
                    transitionDuration: '0.2s'
                });
                return;
            }

            if( $container.data('masonry') ){
                $container.masonry('destroy');
            }
            $container.removeClass('grid');
        });


        // header news & current, set icon class
        //var $newsAndCurrentArea = $('.newsAndCurrent', '#primaryNav');

        $.ajax({
            url: $('#tojAppPaths').attr('data-tools') + '_data/current',
            dataType: 'json',
            cache: false,
            success: function( _resp ){
                var iconColor = (_resp.criticals) ? 'text-danger' : (_resp.warnings) ? 'text-warning' : 'text-success',
                    iconClass = (_resp.criticals) ? 'fa-exclamation-triangle' : (_resp.warnings) ? 'fa-exclamation-circle' : 'fa-check-circle';

                // find both icons (mobile and desktop navigation view) to replace
                $('.status-alert-icon', '#primaryNav').find('i.fa').replaceWith('<i class="fa '+iconColor+' '+iconClass+'" />');

                // create alertGroup dom elements
                var $alertGroup = $('<div class="alertGroup" />');

                // append any criticals
                if( _resp.criticals ){
                    $.each( _resp.criticals, function(idx, obj){
                        $alertGroup.append('<a class="alert alert-danger" href="'+obj.path+'"><i class="fa fa-exclamation-triangle"></i><span> '+obj.name+'</span></a>');
                    });
                }

                // append any warning
                if( _resp.warnings ){
                    $.each( _resp.warnings, function(idx, obj){
                        $alertGroup.append('<a class="alert alert-warning" href="'+obj.path+'"><i class="fa fa-exclamation-circle"></i><span>'+obj.name+'</span></a>');
                    });
                }

                // if theres none of the above, create OK message
                if( ! $('.alert', $alertGroup).length ){
                    $alertGroup.append('<a class="alert alert-success no-icon"><span>No warnings or critical alerts are currently issued.</span></a>');
                }

                // replace in desktop hover menu
                $('h5.updating', '#primaryNav').replaceWith($alertGroup);

                // create the popover for mobile
                $('.status-alert-icon', '#primaryNav .navbar-header').popover({
                    animation: false,
                    html: true,
                    placement: 'bottom',
                    title: 'Current Alerts',
                    content: $alertGroup.clone(),
                    trigger: 'click',
                    container: '#primaryNav'
                });
            }
        });


        // PUBLIC METHODS
        return {

        };

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