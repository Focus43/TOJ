<?php defined('C5_EXECUTE') or die(_("Access Denied."));

    // @todo: permission check

    // get the calendar obj
    $calendarObj = SchedulizerCalendar::getByID($_REQUEST['calendarID']);

    // parse date w/ DateTime class
    $startUTCDateTimeObj = new DateTime("{$_REQUEST['month']}/{$_REQUEST['day']}/{$_REQUEST['year']} 09:00:00", $calendarObj->getCalendarTimezoneObj());
    $startUTC = $startUTCDateTimeObj->setTimezone(new DateTimeZone('UTC'))->format(SchedulizerPackage::TIMESTAMP_FORMAT);

    Loader::packageElement('dashboard/events/form_setup', 'schedulizer', array(
        'eventObj' => new SchedulizerEvent(array(
            'calendarID'    => $calendarObj->getCalendarID(),
            'startUTC'      => $startUTC,
            'timezoneName'  => $calendarObj->getDefaultTimezone()
        ))
    ));

