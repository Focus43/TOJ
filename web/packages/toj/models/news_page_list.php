<?php

    class TojNewsPageList extends PageList {

        /**
         * On instantiation, automatically set a filter to restrict it to news posts only.
         */
        public function __construct(){
            $this->filterByCollectionTypeHandle('news_post');
        }


        /**
         * Filter by alerts only (warnings or criticals)
         * @return void
         */
        public function filterByWarningsAndAlerts(){
            $this->filter(false, '(ak_alert_warning = 1 OR ak_alert_critical = 1)');
        }


        /**
         * Just news posts (not alerts)
         * @return void
         */
        public function filterByNewsPostsOnly(){
            $this->filter(false, '(ak_alert_warning != 1 AND ak_alert_critical != 1)');
        }


        /**
         * @param string $time Time string (Defaults to "now")
         * @param string $dir Sort direction
         */
        public function filterByStickyUntil( $time = 'now', $dir = '>=' ){
            $dateTimeObj = new DateTime($time, new DateTimeZone('UTC'));
            $dateTimeObj->setTimezone( new DateTimeZone('America/Denver') );
            //echo $dateTimeObj->format('Y-m-d H:i:s');exit;
            $this->filterByAttribute('sticky_until', $dateTimeObj->format('Y-m-d H:i:s'), $dir);
        }


        /**
         * Order the results so critical alerts are first
         */
        public function sortByAlertsCriticalFirst(){
            $this->sortByMultiple('ak_alert_critical desc', 'cvDatePublic desc');
        }

    }