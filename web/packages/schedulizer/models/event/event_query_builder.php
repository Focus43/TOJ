<?php

    class EventQueryBuilder {

        private $calendarIDs;

        /**
         * Constructor (can only be called from internally).
         * @param array $calendarIDs
         */
        protected function __construct( array $calendarIDs ){
            $this->calendarIDs = $calendarIDs;
        }


        /**
         * Pass in a start DateTime object, and a later end DateTime object to automatically
         * loop through the days to find events that members of the passed calendarIDs.
         * @param DateTime $startDTO
         * @param DateTime $endDTO
         * @param array $calendarIDs
         * @param int $limit If greater than zero, return once the number of results = $limit
         * @return array
         */
        public static function getEventsForRange(DateTime $startDTO, DateTime $endDTO, array $calendarIDs, $limit = 0){
            $self = new self($calendarIDs);

            // loop from start to end and prepare list to return
            $eventsList = array();
            while( $startDTO < $endDTO ){
                $eventsList = array_merge($eventsList, $self->fetch($startDTO));
                if( ($limit >= 1) && (count($eventsList) >= (int)$limit) ){
                    return array_slice($eventsList, 0, $limit);
                }
                $startDTO->modify('+1 Day');
            }

            return $eventsList;
        }


        /**
         * Get events for a specific day, thats are members of one or more calendarIDs.
         * @param DateTime $dateObj
         * @param array $calendarIDs
         * @return array
         */
        public static function getEventsForDay(DateTime $dateObj, array $calendarIDs){
            $self = new self($calendarIDs);
            return $self->fetch( $dateObj );
        }


        /**
         * Get a list of events for the day, and append necessary stuff to indicate
         * if its the original record or an alias (a repeating event).
         * @param DateTime $dateObj
         * @return array
         */
        private function fetch( DateTime $dateObj ){
            $results = Loader::db()->GetArray( $this->_query($dateObj) );
            // get all the events for the day
            $eventsList = array();
            foreach($results AS $data){
                $eventObj           = SchedulizerEvent::getByID( $data['eventID'] );
                $eventObj->setIsAlias( $dateObj, $data['isAlias'] );
                $eventsList[]       = $eventObj;
            }
            return $eventsList;
        }


        /**
         * Construct the burly-ass query.
         * @param DateTime $dateObj
         * @return string
         *
         * @todo: What if an event (repeating or single) spans 2 days, and we're searching for
         * events that occur on the second day?
         *
         * See http://stackoverflow.com/questions/2157282/generate-days-from-date-range for
         * possibility on how to include single-query date range results.
         */
        private function _query( DateTime $dateObj ){
            $calendarIDs = join(',', $this->calendarIDs);
            $date        = $dateObj->format('Y-m-d');

            return "SELECT evrepeat.eventID, (CASE WHEN (DATE('{$date}') != DATE(CONVERT_TZ(ev.startUTC, '+00:00', ev.timezoneOffset))) IS TRUE THEN 1 ELSE 0 END) AS isAlias
                FROM SchedulizerEvent ev
                RIGHT JOIN SchedulizerEventRepeat evrepeat ON evrepeat.eventID = ev.id
                WHERE ((DATE(CONVERT_TZ(startUTC, '+00:00', ev.timezoneOffset)) <= DATE('{$date}')) AND (ev.calendarID IN ({$calendarIDs})))
                AND (ev.repeatIndefinite = 1 OR (DATE('{$date}') <= ev.repeatEndUTC AND ev.repeatIndefinite = 0))
                AND ev.id NOT IN (SELECT evnullify.eventID FROM SchedulizerEventRepeatNullify evnullify WHERE DATE('{$date}') = DATE(evnullify.hideOnDate))
                AND (
                    # DAILY ONLY
                    ((DATEDIFF('{$date}', CONVERT_TZ(startUTC, '+00:00', ev.timezoneOffset)) % ev.repeatEvery) = 0 AND ev.repeatTypeHandle = 'daily')
                    # WEEKLY, ON DAY x; OPTIONALLY EVERY y WEEKS
                    OR
                    (((evrepeat.repeatWeekday = DAYOFWEEK('{$date}')) AND (CEIL(DATEDIFF('{$date}', CONVERT_TZ(startUTC, '+00:00', ev.timezoneOffset))/7) % ev.repeatEvery = 0)) AND (evrepeat.repeatWeek IS NULL) AND (ev.repeatTypeHandle = 'weekly'))
                    # MONTHLY ON SPECIFIC DAY OF THE MONTH
                    OR
                    ((evrepeat.repeatDay = DAYOFMONTH('{$date}')) AND ((MONTH('{$date}') - MONTH(CONVERT_TZ(startUTC, '+00:00', ev.timezoneOffset))) % ev.repeatEvery = 0) AND (ev.repeatTypeHandle = 'monthly'))
                    # MONTHLY ON ABSTRACT (eg. SECOND FRIDAY, see: http://oreilly.com/catalog/sqlhks/chapter/ch04.pdf)
                    OR
                    ( ((DATE_ADD(DATE_SUB(LAST_DAY('{$date}'), INTERVAL DAY(LAST_DAY('{$date}')) -1 DAY), INTERVAL (((evrepeat.repeatWeekday+7)-DAYOFWEEK(DATE_SUB(LAST_DAY('{$date}'), INTERVAL DAY(LAST_DAY('{$date}')) -1 DAY))) % 7) + ((evrepeat.repeatWeek*7)-7) DAY)) = '{$date}') AND ((MONTH('{$date}') - MONTH(CONVERT_TZ(startUTC, '+00:00', ev.timezoneOffset))) % ev.repeatEvery = 0) AND (ev.repeatTypeHandle = 'monthly'))
                    # YEARLY (ONLY SUPPORTS ONE DATE ON EVERY YEAR)
                    OR
                    ( (YEAR('{$date}')-YEAR(CONVERT_TZ(startUTC, '+00:00', ev.timezoneOffset))) % ev.repeatEvery = 0 AND ev.repeatTypeHandle = 'yearly' ))
                UNION SELECT ev2.id AS eventID, 0 AS isAlias FROM SchedulizerEvent ev2
                WHERE ((DATE(CONVERT_TZ(ev2.startUTC, '+00:00', ev2.timezoneOffset)) = DATE('{$date}')) AND (ev2.calendarID IN ({$calendarIDs}))) AND ev2.isRepeating = 0;";
        }
    }