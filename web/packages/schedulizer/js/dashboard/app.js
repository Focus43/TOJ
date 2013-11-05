
    var SchedulizerDashboard;

    $(function(){

        SchedulizerDashboard = (function(){

            var $document = $(document),
                _toolsURI = $('meta[name="schedulizer-tools"]', 'head').attr('content');


            /**
             * Close the top-most dialog window
             * @param int _afterMilliseconds Close the window after...
             * @param function _callback Callback function once window closes
             */
            function closeTopDialog( _afterMilliseconds, _callback ){
                setTimeout(function(){
                    $.fn.dialog.closeTop();

                    // if a callback is passed...
                    if( $.isFunction(_callback) ){
                        _callback.call();
                    }
                }, _afterMilliseconds || 0);
            }


            /**
             * Ajaxify form handler
             */
            if( $.fn.ajaxifyForm ){
                $('form[data-method="ajax"]').ajaxifyForm();
                // on complete callback
                $(document).on('ajaxify_complete', 'form[data-method="ajax"]', function(ev, resp){
                    $('.ui-dialog-content').scrollTop(0);
                    if(resp.code === 1){
                        closeTopDialog(1000, function(){
                            $('#schedulizerCalendar').fullCalendar('refetchEvents');
                        });
                    }
                });
            }


            /**
             * Tab functionality (mimics twitter bootstrap's thats missing in C5)
             */
            $document.on('click', 'a[data-toggle="tab"]', function(_clickEvent){
                _clickEvent.preventDefault();
                var $this = $(this);
                $this.parent('li').addClass('active').siblings('li').removeClass('active');
                $( $this.attr('href') ).addClass('active').siblings('.tab-pane').removeClass('active');
                // emit custom on_show event
                $this.trigger('tab.show');

                // init functions, if applicable
                if( $this.attr('data-init') ){
                    switch( $this.attr('data-init') ){
                        case 'properties':
                            $('#calendar_timezone').chosen();
                            break;
                    }
                }
            });


            /**
             * Listen for on_show from the custom tab click handler (emits tab.show event),
             * and init the calendar. This runs *once* only, hence the .one() method.
             */
            function initCalendar(){
                var $calendar   = $('#schedulizerCalendar'),
                    _calendarID = +($calendar.attr('data-calendar-id'));

                $calendar.fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: true,
                    defaultView: 'month',

                    // load event data
                    events: _toolsURI + 'dashboard/events/feed?' + $.param({
                        calendarID: _calendarID
                    }),

                    // open a dialog and create a new event on the specific day
                    dayClick: function(date, allDay, jsEvent, view){
                        var _data = $.param({
                            calendarID: _calendarID,
                            year: date.getUTCFullYear(),
                            month: date.getUTCMonth() + 1,
                            day: date.getUTCDate(),
                            hour: date.getUTCHours(),
                            min: date.getUTCMinutes(),
                            allDay: allDay
                        });

                        // launch the dialog and pass appropriate data
                        $.fn.dialog.open({
                            width:650,
                            height:525,
                            title: 'New Event: ' + date.toLocaleDateString(),
                            href: _toolsURI + 'dashboard/events/new?' + _data
                        });
                    },

                    // open a dialog to edit an existing event
                    eventClick: function(calEvent, jsEvent, view){
                        $.fn.dialog.open({
                            width:650,
                            height:525,
                            title: 'Editing Event: ' + calEvent.title,
                            href: _toolsURI + 'dashboard/events/edit?' + $.param({
                                eventID: calEvent.id,
                                isAlias: calEvent.isAlias,
                                eventCalendarStart: calEvent.start.toISOString()
                            })
                        });
                    },

                    eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc){
                        // if its a repeating event, show warning
                        if( event.isRepeating === 1 ){
                            if( event.repeatMethod !== 'daily' ){
                                ccmAlert.hud('Events that repeat ' + event.repeatMethod + ' cannot be dragged/dropped.', 2000, 'error');
                                revertFunc.call();
                                return;
                            }
                            if( ! confirm('This is a repeating event and will affect all other events in the series. Proceed?') ){
                                revertFunc.call();
                                return;
                            }
                        }

                        // append day and minute deltas to the event object
                        event.dayDelta    = dayDelta;
                        event.minuteDelta = minuteDelta;

                        // then send the whole shebang
                        $.post( _toolsURI + 'dashboard/events/calendar_handler_drop', event, function( _respData ){
                            if( _respData.code === 1 ){
                                ccmAlert.hud(_respData.msg, 2000, 'success');
                            }else{
                                ccmAlert.hud('Error occurred adjusting the event length', 2000, 'error');
                            }
                        }, 'json');
                    },

                    eventResize: function(event, dayDelta, minuteDelta, revertFunc){
                        // if its a repeating event, show warning
                        if( event.isRepeating === 1 ){
                            if( ! confirm('This is a repeating event and will affect all other events in the series. Proceed?') ){
                                revertFunc.call();
                                return;
                            }
                        }

                        // append day and minute deltas to the event object
                        event.dayDelta    = dayDelta;
                        event.minuteDelta = minuteDelta;

                        // then send the whole shebang
                        $.post( _toolsURI + 'dashboard/events/calendar_handler_resize', event, function( _respData ){
                            if( _respData.code === 1 ){
                                ccmAlert.hud(_respData.msg, 2000, 'success');
                            }else{
                                ccmAlert.hud('Error occurred adjusting the event length', 2000, 'error');
                            }
                        }, 'json');
                    }
                });
            };


            /**
             * When a parent element is wrapping a child checkbox or radio button,
             * this will ensure correct toggling.
             */
            $document.on('click', '[data-toggle-input]', function(){
                var $this  = $(this),
                    $input = $('input', this);

                // checkbox
                if( $this.attr('data-toggle-input') === 'checkbox' ){
                    $this.toggleClass('active');
                    $input.attr('checked', !($input.attr('checked')));
                    return;
                }

                // radio button
                $this.addClass('active');
                $input.attr('checked', true);
                var $siblings = $this.siblings('[data-toggle-input]').removeClass('active');
                $('input', $siblings).attr('checked', false);
            });


            /**
             * When a checkbox should toggle the visibility of some other stuff.
             */
            $document.on('change', '[data-viz-checked], [data-viz-unchecked]', function(){
                var $this        = $(this),
                    _state       = $this.is(':checked'),
                    $attrChecked = $this.attr('data-viz-checked');

                // if toggle to visible when checked
                if( $attrChecked ){ $( $attrChecked ).toggle(_state); return; }

                // otherwise toggle to visible when unchecked
                $( $this.attr('data-viz-unchecked')).toggle(!_state);
            });


            /**
             * Initialize the calendar, if the container exists in the DOM
             */
            if( $('#schedulizerCalendar').length ){
                initCalendar();
            }


            /** Public methods; @return Object */
            return {
                // expose toolsURI property
                toolsURI: _toolsURI,

                initCalendar: initCalendar,

                // proxy directly to the internal closeTopModal method
                closeTopDialog: closeTopDialog,

                // called after a new/editable event management window is loaded
                initEventWindow: function( _settings ){
                    // datepickers
                    $('input.dp-element', '#eventSetupForm').datepicker({
                        onClose: function(){
                            if( $(this).is('#event_start_date') ){
                                var minDate = $('#event_start_date').datepicker('getDate');
                                $('#event_end_date').datepicker('option', 'minDate', minDate);
                                $('#event_repeat_end').datepicker('option', 'minDate', minDate);
                                $('#repeatMonthlySpecificDay').val( minDate.getDate() );
                            }
                        }
                    });

                    // jqChosen
                    $('select.chzn-element', '#eventSetupForm').chosen();

                    // recurring frequency change display text
                    $('[name*="repeatTypeHandle"]').on('change', function(){
                        var _value = this.value;

                        // set the text label
                        $('#recurTextLabel').text(function(){
                            switch(_value){
                                case 'daily': return 'days';
                                case 'weekly': return 'weeks';
                                case 'monthly': return 'months';
                                case 'yearly': return 'years';
                            };
                        });

                        // toggle visibility of extra repeat options (daily/monthly only),
                        // and if a container is *not* visible, disable its' inputs
                        $('.repeat-options', '#eventSetupForm').each(function(_idx, _container){
                            var $container = $(_container),
                                $inputs    = $(':input', _container);
                            $container.toggle( _value === $container.attr('data-show-on') );
                            $inputs.prop('disabled', !$container.is(':visible'));
                        });

                    }).trigger('change'); // fire it so that javascript sets the correct value on_load

                    // if its an all day event, hide the jqChosen time selections
                    if( _settings.isAllDay ){
                        $('#event_start_time_chzn, #event_end_time_chzn').toggle(false);
                    }
                }
            }
        })();

    });