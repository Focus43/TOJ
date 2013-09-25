<?php defined('C5_EXECUTE') or die(_("Access Denied."));

    // load event color helper
    $eventColorsHelper = Loader::helper('event_colors', 'schedulizer');

    // calendar view start date (converted to UTC)
    $start = new DateTime("@{$_REQUEST['start']}", new DateTimeZone('UTC'));
    $start->setTime('0','0','0');

    // calendar view end date (converted to UTC)
    $end = new DateTime("@{$_REQUEST['end']}", new DateTimeZone('UTC'));
    $end->setTime('0','0','0');

    // get the events for every day in the range
    $results = EventQueryBuilder::getEventsForRange($start, $end, array($_REQUEST['calendarID']));

    $eventsList = array();
    foreach($results AS $eventObj){ /** @var $eventObj SchedulizerEvent */
        $eventsList[] = (object) array(
            'id'        => $eventObj->getEventID(),
            'title'     => $eventObj->getTitle(),
            'start'     => $eventObj->getStartDateTimeObj()->format('Y-m-d H:i:s'), //$eventObj->isAlias ? $eventObj->getStartDateTimeObj()->setDate($eventObj->aliasDate->format('Y'),$eventObj->aliasDate->format('m'),$eventObj->aliasDate->format('d'))->format('Y-m-d H:i:s') : $eventObj->getStartDateTimeObj()->format('Y-m-d H:i:s'),
            'end'       => $eventObj->getEndDateTimeObj()->format('Y-m-d H:i:s'), //$eventObj->isAlias ? $eventObj->getEndDateTimeObj()->setDate($eventObj->aliasDate->format('Y'),$eventObj->aliasDate->format('m'),$eventObj->aliasDate->format('d'))->format('Y-m-d H:i:s') : $eventObj->getEndDateTimeObj()->format('Y-m-d H:i:s'),
            'allDay'    => (bool) $eventObj->getIsAllDay() ? true : false,
            'color'     => $eventObj->getColorHex(),
            'textColor' => $eventColorsHelper->textColor($eventObj->getColorHex()),
            'isAlias'   => (int) $eventObj->getIsAlias()
        );
    }

    // render JSON
    echo Loader::helper('json')->encode($eventsList);
    exit;

