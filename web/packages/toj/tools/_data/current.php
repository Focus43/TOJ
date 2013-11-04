<?php defined('C5_EXECUTE') or die("Access Denied.");

    $alertList = new TojNewsPageList;
    $alertList->filterByWarningsAndAlerts();
    $alertList->filterByStickyUntil();
    $alertList->sortByAlertsCriticalFirst();
    $results = $alertList->get();

    $alertCollection = array();
    foreach($results AS $pageObj){ /** @var Page $pageObj */
        // criticals
        if( (bool) $pageObj->getAttribute('alert_critical') ){
            $alertCollection['criticals'][] = (object) array(
                'id'    => $pageObj->getCollectionID(),
                'path'  => $pageObj->getCollectionPath(),
                'name'  => $pageObj->getCollectionName(),
                'descr' => $pageObj->getCollectionDescription()
            );
        }

        // warnings
        if( (bool) $pageObj->getAttribute('alert_warning') ){
            $alertCollection['warnings'][] = (object) array(
                'id'    => $pageObj->getCollectionID(),
                'path'  => $pageObj->getCollectionPath(),
                'name'  => $pageObj->getCollectionName(),
                'descr' => $pageObj->getCollectionDescription()
            );
        }
    }

    echo Loader::helper('json')->encode( $alertCollection );
    exit;