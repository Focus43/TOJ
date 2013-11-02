<?php

    class TojNewsPageList extends PageList {

        public function __construct(){
            $this->filterByCollectionTypeHandle('news_post');
        }

        public function filterByWarningsAndAlerts(){
            $this->filter(false, '(ak_alert_warning = 1 OR ak_alert_critical = 1)');
        }


        public function filterByStickyUntil( $time = 'now', $dir = '>=' ){
            $dateTimeObj = new DateTime($time, new DateTimeZone('UTC'));
            $dateTimeObj->setTimezone( new DateTimeZone('America/Denver') );
            $this->filterByAttribute('sticky_until', $dateTimeObj->format('Y-m-d H:i:s'), $dir);
        }


        public function sortByAlertsCriticalFirst(){
            $this->sortByMultiple('ak_alert_critical desc', 'cvDatePublic desc');
        }

    }