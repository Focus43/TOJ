<?php

    Loader::db()->Execute("INSERT INTO SchedulizerEventRepeatNullify (eventID, hideOnDate) VALUES (?,?)", array(
        (int)$_REQUEST['eventID'], $_REQUEST['date']
    ));

    echo Loader::helper('json')->encode( (object) array(
        'code'  => 1,
        'msg'   => 'Ok'
    ));