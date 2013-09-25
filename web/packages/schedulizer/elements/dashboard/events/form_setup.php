<?php /** @var $eventObj SchedulizerEvent */

    // @note: if this is a new object, in tools/events/new.php we are setting the startUTC
    // property to the current date on the clicked day @ 9:00 am

    $formHelper         = Loader::helper('form');
    $dateHelper         = Loader::helper('date');
    $timingHelper       = Loader::helper('timing', 'schedulizer');
    $eventColorsHelper  = Loader::helper('event_colors', 'schedulizer');
?>
    <style type="text/css">
        #eventSetupForm .timeChoozers .chzn-container {width:120px !important;}
        #eventSetupForm .timeChoozers .chzn-drop {width:118px !important;}
        #eventSetupForm .timeChoozers .chzn-search input[type="text"] {width:83px !important;margin:-3px 0 2px;}
        #eventSetupForm .timeChoozers .chzn-single {height:26px;}
        #eventSetupForm .timeChoozers .chzn-single span {position:relative;top:2px;}
        #eventSetupForm input[type="radio"] {margin-top:0;}
        #eventSetupForm label.checkbox.no-pad {padding-left:0;}
        #eventSetupForm .control-group .control-label {width:80px;white-space:nowrap;}
        #eventSetupForm .control-group .controls {margin-left:100px;}
        #eventSetupForm .btn-group button input {display:none;}

        <?php if( !($eventObj->getIsRepeating()) ): ?>
        #eventRepeatSettings {display:none;}
        <?php endif; if( $eventObj->getUseCalendarTimezone() ): ?>
        #timezoneSettings {display:none;}
        <?php endif; ?>
        #eventRepeatWeekdays {display:none;}
        #eventRepeatMonthlyMethod {display:none;}
    </style>

    <div id="eventSetupForm" class="ccm-ui">
        <form id="frmNewEvent" data-method="ajax" action="<?php echo View::url('/dashboard/schedulizer/calendars', 'save_event', $eventObj->getEventID()); ?>">
            <?php if(! (bool)$eventObj->getUseCalendarTimezone()): ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="alert alert-block">
                            <p>This event is using timezone <strong><?php echo $eventObj->getTimezoneName(); ?></strong>, which is not the calendar default. In the default calendar timezone (<?php echo $eventObj->calendarObject()->getDefaultTimezone() ?>), this event starts at <strong><?php echo $eventObj->getStartDateTimeObj()->setTimezone(new DateTimeZone($eventObj->calendarObject()->getDefaultTimezone()))->format('n/j/Y h:i a'); ?></strong>.</strong></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if((bool)$eventObj->getIsAlias()): ?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="alert alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Heads Up!</h4>
                            <p>This is a repeating event: choose how this event (and/or others in the series) should be updated.</p>
                            <br />
                            <div class="clearfix" style="padding:0;">
                                <div class="pull-left">
                                    <div class="btn-group">
                                        <button class="btn">Only This Event</button>
                                        <button class="btn">Following Events</button>
                                        <button class="btn">All Events</button>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <a id="hideDayInEventSeries" class="btn error" data-eventid="<?php echo $eventObj->getEventID(); ?>" data-date="<?php echo $eventObj->getStartDateTimeObj()->format('Y-m-d'); ?>">
                                        Hide Day In Event Series
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row-fluid">
                <div class="span12 form-horizontal well">
                    <div class="control-group">
                        <label class="control-label"><strong>Event Title</strong></label>
                        <div class="controls">
                            <?php echo $formHelper->text('event[title]', $eventObj->getTitle(), array('class' => 'input-block-level', 'placeholder' => 'Walk the dog')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><strong>Time</strong></label>
                        <div class="controls timeChoozers">
                            From
                            <?php echo $formHelper->text('event_start_date', $eventObj->getStartDateTimeObj()->format(DATE_APP_GENERIC_MDY), array('class' => 'input-small dp-element', 'placeholder' => 'Start Date')); ?>
                            <?php echo $formHelper->select('event_start_time', $timingHelper::selectableTimeValues(), $eventObj->getStartDateTimeObj()->format('H:i'), array('class' => 'chzn-element')); ?>
                            &nbsp; to &nbsp;
                            <?php echo $formHelper->text('event_end_date', $eventObj->getEndDateTimeObj()->format(DATE_APP_GENERIC_MDY), array('class' => 'input-small dp-element', 'placeholder' => 'End Date')); ?>
                            <?php echo $formHelper->select('event_end_time', $timingHelper::selectableTimeValues(), $eventObj->getEndDateTimeObj()->format('H:i'), array('class' => 'chzn-element')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <label class="checkbox inline"><?php echo $formHelper->checkbox('event[isAllDay]', SchedulizerEvent::ALL_DAY_TRUE, $eventObj->getIsAllDay(), array('data-toggle' => '#event_start_time_chzn, #event_end_time_chzn', 'data-toggle-inverse' => '')); ?> All Day Event</label>
                            <label class="checkbox inline"><?php echo $formHelper->checkbox('event[isRepeating]', SchedulizerEvent::IS_REPEATING_TRUE, $eventObj->getIsRepeating(), array('data-toggle' => '#eventRepeatSettings')); ?> Repeat Settings</label>
                            <label class="checkbox inline"><?php echo $formHelper->checkbox('event[useCalendarTimezone]', SchedulizerEvent::USE_CALENDAR_TIMEZONE_TRUE, $eventObj->getUseCalendarTimezone(), array('data-toggle' => '#timezoneSettings', 'data-toggle-inverse' => '')); ?> Use Calendar Timezone <span class="label"><?php echo $eventObj->calendarObject()->getDefaultTimezone(); ?></span></label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><strong>Event Color</strong></label>
                        <div class="controls">
                            <?php foreach($eventColorsHelper->pairs() AS $key => $colorObj):
                                echo $formHelper->radio('event[colorHex]', $key, $eventObj->getColorHex(), array('data-hex' => $key));
                            endforeach; ?>
                        </div>
                    </div>
                    <div id="timezoneSettings">
                        <div class="control-group">
                            <label class="control-label"><strong>Timezone</strong></label>
                            <div class="controls clearfix" style="padding-bottom:0;">
                                <?php echo $formHelper->select('timezone_name', $dateHelper->getTimezones(), $eventObj->getTimezoneName(), array(
                                    'class' => 'input-block-level chzn-element',
                                    'style' => 'width:520px !important;'
                                )); ?>
                            </div>
                        </div>
                    </div>
                    <div id="eventRepeatSettings">
                        <div class="control-group">
                            <label class="control-label"><strong>Repeats</strong></label>
                            <div class="controls">
                                <?php echo $formHelper->select('event[repeatTypeHandle]', $timingHelper->getRepeatTypeHandles(), $eventObj->getRepeatTypeHandle(), array('class' => 'input-medium')); ?>
                                &nbsp; every &nbsp;
                                <?php echo $formHelper->select('event[repeatEvery]', $timingHelper->repeatEveryOptions(), $eventObj->getRepeatEvery(), array('class' => 'input-mini')); ?>
                                <span id="recurTextLabel" class="help-inline"></span>
                            </div>
                        </div>
                        <!-- weekday repeats -->
                        <div id="eventRepeatWeekdays" class="control-group">
                            <label class="control-label"><strong>Weekdays:</strong></label>
                            <div class="controls">
                                <div class="btn-group" data-toggle="buttons-checkbox">
                                    <button type="button" class="btn">Sun<?php echo $formHelper->checkbox('repeat[weekday_index][]', SchedulizerEventRepeat::WEEKDAY_INDEX_SUN, $eventObj->weeklyRepeatIsChecked(SchedulizerEventRepeat::WEEKDAY_INDEX_SUN)); ?></button>
                                    <button type="button" class="btn">Mon<?php echo $formHelper->checkbox('repeat[weekday_index][]', SchedulizerEventRepeat::WEEKDAY_INDEX_MON, $eventObj->weeklyRepeatIsChecked(SchedulizerEventRepeat::WEEKDAY_INDEX_MON)); ?></button>
                                    <button type="button" class="btn">Tue<?php echo $formHelper->checkbox('repeat[weekday_index][]', SchedulizerEventRepeat::WEEKDAY_INDEX_TUE, $eventObj->weeklyRepeatIsChecked(SchedulizerEventRepeat::WEEKDAY_INDEX_TUE)); ?></button>
                                    <button type="button" class="btn">Wed<?php echo $formHelper->checkbox('repeat[weekday_index][]', SchedulizerEventRepeat::WEEKDAY_INDEX_WED, $eventObj->weeklyRepeatIsChecked(SchedulizerEventRepeat::WEEKDAY_INDEX_WED)); ?></button>
                                    <button type="button" class="btn">Thu<?php echo $formHelper->checkbox('repeat[weekday_index][]', SchedulizerEventRepeat::WEEKDAY_INDEX_THU, $eventObj->weeklyRepeatIsChecked(SchedulizerEventRepeat::WEEKDAY_INDEX_THU)); ?></button>
                                    <button type="button" class="btn">Fri<?php echo $formHelper->checkbox('repeat[weekday_index][]', SchedulizerEventRepeat::WEEKDAY_INDEX_FRI, $eventObj->weeklyRepeatIsChecked(SchedulizerEventRepeat::WEEKDAY_INDEX_FRI)); ?></button>
                                    <button type="button" class="btn">Sat<?php echo $formHelper->checkbox('repeat[weekday_index][]', SchedulizerEventRepeat::WEEKDAY_INDEX_SAT, $eventObj->weeklyRepeatIsChecked(SchedulizerEventRepeat::WEEKDAY_INDEX_SAT)); ?></button>
                                </div>
                            </div>
                        </div>
                        <!-- monthly repeats -->
                        <div id="eventRepeatMonthlyMethod" class="control-group" style="margin-bottom:10px;">
                            <label class="control-label"><strong>On:</strong></label>
                            <div class="controls" style="position:relative;top:-6px;">
                                <label class="checkbox inline no-pad"><?php echo $formHelper->radio('repeat[monthly][method]', SchedulizerEvent::REPEAT_MONTHLY_SPECIFIC_DATE, $eventObj->getRepeatMonthlyMethod()); ?>&nbsp; Day &nbsp;<input id="repeatMonthlySpecificDay" type="number" value="<?php echo $eventObj->getMonthlyRepeatSpecificDay(); ?>" name="repeat[monthly][specific_day]" class="input-mini" value="" min="1" max="31" /></label>
                                <label class="checkbox inline no-pad"><?php echo $formHelper->radio('repeat[monthly][method]', SchedulizerEvent::REPEAT_MONTHLY_WEEK_AND_DAY, $eventObj->getRepeatMonthlyMethod()); ?>&nbsp; <?php echo $formHelper->select('repeat[monthly][week]', $timingHelper->monthlyRepeatableWeekOptions(), $eventObj->getMonthlyRepeatWeek(), array('class' => 'input-small')); ?>
                                    <?php echo $formHelper->select('repeat[monthly][weekday]', $timingHelper->weekdayIndicesList(), $eventObj->getMonthlyRepeatWeekday(), array('class' => 'input-medium')); ?>
                                </label>
                            </div>
                        </div>
                        <div class="control-group" style="margin-bottom:8px;">
                            <label class="control-label"><strong>Ends</strong></label>
                            <div class="controls" style="position:relative;top:-7px;">
                                <label class="checkbox inline no-pad"><?php echo $formHelper->radio('event[repeatIndefinite]', SchedulizerEvent::REPEAT_INDEFINITE_TRUE, $eventObj->getRepeatIndefinite()) ?>&nbsp; Never</label>
                                <label class="checkbox inline no-pad"><?php echo $formHelper->radio('event[repeatIndefinite]', SchedulizerEvent::REPEAT_INDEFINITE_FALSE, $eventObj->getRepeatIndefinite()) ?>&nbsp; On Date: <?php echo $formHelper->text('event_repeat_end', $eventObj->getRepeatEndDateTimeObj(false)->format(DATE_APP_GENERIC_MDY), array('class' => 'input-small dp-element', 'placeholder' => 'End Date')) ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="control-group" style="margin-bottom:0;">
                        <label class="control-label"><strong>Description</strong></label>
                        <div class="controls">
                            <?php Loader::packageElement('editor_config', 'schedulizer', array('theme' => PageTheme::getSiteTheme())); ?>
                            <?php Loader::element('editor_controls'); ?>
                            <?php echo $formHelper->textarea('event[description]', $eventObj->getDescription(), array('class' => 'ccm-advanced-editor')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <button type="submit" class="btn btn-large btn-block btn-success">Save</button>
                </div>
            </div>
            <?php if( is_null($eventObj->getEventID()) ){ echo $formHelper->hidden('event[calendarID]', $eventObj->getCalendarID()); } ?>
            <?php echo $formHelper->hidden('event[isAlias]', $eventObj->getIsAlias()); ?>
        </form>
    </div>

<script type="text/javascript">
    $(function(){
        // datepicker and chosen elements
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
        $('select.chzn-element', '#eventSetupForm').chosen();

        // visibility toggling
        $('[data-toggle]', '#eventSetupForm').on('change', function(){
            var $this  = $(this),
                _state = $this.is(':checked');
            $( $this.attr('data-toggle')).toggle( $this.is('[data-toggle-inverse]') ? !_state : _state );
        });

        // recurring frequency change display text
        $('[name*="repeatTypeHandle"]').on('change', function(){
            var _value = this.value;
            $('#recurTextLabel').text(function(){
                switch(_value){
                    case 'daily': return 'days';
                    case 'weekly': return 'weeks';
                    case 'monthly': return 'months';
                    case 'yearly': return 'years';
                };
            });
            // enable/disable inputs appropriately so no unnecessary data is sent
            $('#eventRepeatWeekdays').toggle( _value === 'weekly').each(function(idx, element){
                var $container = $(element),
                    $inputs    = $(':input', $container);
                if($container.is(':visible')){
                    $inputs.prop('disabled', '');
                }else{
                    $inputs.prop('disabled', 'disabled');
                }
            });
            // enable/disable inputs appropriately so no unnecessary data is sent
            $('#eventRepeatMonthlyMethod').toggle( _value === 'monthly' ).each(function(idx, element){
                var $container = $(element),
                    $inputs    = $(':input', $container);
                if($container.is(':visible')){
                    $inputs.prop('disabled', '');
                }else{
                    $inputs.prop('disabled', 'disabled');
                }
            });
        }).trigger('change'); // fire it so that javascript sets the correct value on_load

        // turn colorHex radio buttons into clickable thumbnails
        $('[name="event[colorHex]"]').each(function(index, element){
            var $wrapper = $('<span class="colorThumbnail" />').css({
                    background: element.getAttribute('data-hex')
                }),
                $element = $(element);
            $wrapper.insertBefore($element);
            $element.appendTo($wrapper);
            if( $element.is(':checked') ){
                $wrapper.addClass('active');
            }
        });

        // bind click event on <span class="colorThumbnail"...
        $('#frmNewEvent').on('click', '.colorThumbnail', function(_event){
            var $this = $(this);
            $this.addClass('active').siblings('.colorThumbnail').removeClass('active');
            $('.colorThumbnail input', '#frmNewEvent').attr('checked', false);
            $('input', $this).attr('checked', true);
        });

        // button "radios"
        $('[data-toggle="buttons-checkbox"]').on('click', 'button', function(){
            var $this   = $(this),
                $chkbox = $('input', this);
            $this.toggleClass('active');
            $chkbox.attr('checked', !($chkbox.attr('checked')));
        });

        // same thing as above, but when loading if its checked do a test
        $('input', '[data-toggle="buttons-checkbox"]').each(function(idx, el){
            var $checkbox = $(el);
            if( $checkbox.is(':checked') ){
                $checkbox.parent('button').addClass('active');
            }
        });

        // custom action Hide Day In Event Series
        $('#hideDayInEventSeries').on('click', function(){
            var $this     = $(this),
                _toolsURI = $('meta[name="schedulizer-tools"]', 'head').attr('content'),
                _data     = {eventID: $this.attr('data-eventid'), date: $this.attr('data-date')};
            $.post(_toolsURI + 'events/nullify_repeat_day', _data, function(resp){

            }, 'json');
        });

        // hide times for start and end dates if isAllDay is set
        <?php if($eventObj->getIsAllDay()): ?>
            $('#event_start_time_chzn, #event_end_time_chzn').toggle(false);
        <?php endif; ?>
    });
</script>