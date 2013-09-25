<?php defined('C5_EXECUTE') or die(_("Access Denied."));

    // @todo: permission check

    // get the event; and determine whether it be an alias or not
    $dateTimeObj = new DateTime($_REQUEST['date'], new DateTimeZone('UTC'));

    $eventObj = SchedulizerEvent::getByID( $_REQUEST['eventID'] );
    $eventObj->setIsAlias($dateTimeObj, $_REQUEST['isAlias']);

    Loader::packageElement('dashboard/events/form_setup', 'schedulizer', array(
        'eventObj' => $eventObj
    ));