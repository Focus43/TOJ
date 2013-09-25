<?php /** @var $calendarObj SchedulizerCalendar */
    $formHelper = Loader::helper('form');
    $dateHelper = Loader::helper('date');
?>

<div id="schedulizerWrap">

    <ul class="nav nav-tabs">
        <li class="<?php if($activeTab == 'properties'){ echo 'active'; } ?>"><a href="#tabGroup1" data-toggle="tab">Properties</a></li>
        <li class="<?php if($activeTab == 'events'){ echo 'active'; } ?>"><a href="#tabGroup2" data-toggle="tab">Events</a></li>
        <li class="<?php if($activeTab == 'permissions'){ echo 'active'; } ?>"><a href="#tabGroup3" data-toggle="tab">Permissions</a></li>
    </ul>

    <div class="tab-content" style="overflow:visible;">
        <!-- pane 1 -->
        <div id="tabGroup1" class="tab-pane<?php if($activeTab == 'properties'){ echo ' active'; } ?>">
            <form method="post" action="<?php echo $this->action('save_calendar', $calendarObj->getCalendarID()); ?>">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <label>Calendar Title</label>
                            <div class="controls controls-row">
                                <?php echo $formHelper->text('calendar[title]', $calendarObj->getTitle(), array(
                                    'class' => 'input-block-level',
                                    'placeholder' => 'My Snazzy Calendar')) ;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <label>Default Timezone <span class="label">Note: Individual Events Can Override</span></label>
                            <div class="controls controls-row">
                                <?php echo $formHelper->select('calendar_timezone', $dateHelper->getTimezones(), $calendarObj->getDefaultTimezone(), array(
                                    'class' => 'input-block-level'
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <button class="btn btn-success btn-block btn-large" type="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- pane 2 -->
        <div id="tabGroup2" class="tab-pane<?php if($activeTab == 'events'){ echo ' active'; } ?>">
            <div id="schedulizerCalendar" style="width:100%;" data-calendar-id="<?php echo $calendarObj->getCalendarID(); ?>">
                <!-- rendered via js -->
            </div>
        </div>

        <!-- pane 3 -->
        <div id="tabGroup3" class="tab-pane<?php if($activeTab == 'permissions'){ echo ' active'; } ?>">
            permissions
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $('#calendar_timezone').chosen();
    });
</script>