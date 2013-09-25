<?php

    class SchedulizerEventList extends DatabaseItemList {

        protected $autoSortColumns  = array('createdUTC', 'modifiedUTC', 'title', 'startUTC', 'endUTC'),
                  $itemsPerPage     = 10,
                  $attributeClass   = 'SchedulizerEventAttributeKey',
                  $attributeFilters = array();


        /**
         * Magic method for filtering by attribute keys.
         * @param string $nm Filter method name to parse
         * @param mixed $a Value
         * @return void
         */
        public function __call($nm, $a) {
            if (substr($nm, 0, 8) == 'filterBy') {
                $txt = Loader::helper('text');
                $attrib = $txt->uncamelcase(substr($nm, 8));
                if (count($a) == 2) {
                    $this->filterByAttribute($attrib, $a[0], $a[1]);
                } else {
                    $this->filterByAttribute($attrib, $a[0]);
                }
            }
        }


        /**
         * Apply a plain-text keyword search to specific column values.
         * @param string $keywords Plain text keywords.
         * @return void
         */
        public function filterByKeywords($keywords) {
            $db = Loader::db();
            $this->searchKeywords = $db->quote($keywords);
            $qkeywords = $db->quote('%' . $keywords . '%');
            $keys = SchedulizerEventAttributeKey::getSearchableIndexedList();
            $attribsStr = '';
            foreach ($keys as $ak) {
                $cnt = $ak->getController();
                $attribsStr.=' OR ' . $cnt->searchKeywords($keywords);
            }
            $this->filter(false, "(event.title LIKE $qkeywords OR $qkeywords {$attribsStr})");
        }


        /**
         * Filter results by specific calendarID.
         * @param $calendarID
         * @return void
         */
        public function filterByCalendarID( $calendarID ){
            $this->filter('event.calendarID', (int) $calendarID, '=');
        }


        /*public function filterByStartUTCTimestamp( $timestamp ){
            $this->filter('event.startUTC', $timestamp, '>=');
        }


        public function filterByEndUTCTimestamp( $timestamp ){
            $this->filter('event.endUTC', $timestamp, '<=');
        }


        public function filterByStartBetweenUTCTimestamps( $startUTC, $endUTC ){
            $this->filter(false, "(event.startUTC between '{$startUTC}' and '{$endUTC}')");
        }*/


        /**
         * Run the built up query.
         * @param int $itemsToGet
         * @param int $offset
         * @return array SchedulizerEvent
         */
        public function get( $itemsToGet = 100, $offset = 0 ){
            $events = array();
            $this->createQuery();
            $r = parent::get($itemsToGet, $offset);
            foreach($r AS $row){
                $events[] = SchedulizerEvent::getByID( $row['id'] );
            }
            return $events;
        }


        /**
         * Get the total number of results.
         * @return int
         */
        public function getTotal(){
            $this->createQuery();
            return parent::getTotal();
        }


        /**
         * Setup the query string internally for the database class.
         * @return void
         */
        protected function createQuery(){
            if( !$this->queryCreated ){
                $this->setBaseQuery();
                //$this->setupAttributeFilters("LEFT JOIN LithPropertySearchIndexAttributes lpattrsearch ON (lpattrsearch.propertyID = lp.id)");
                $this->queryCreated = true;
            }
        }


        /**
         * Set the base query string up.
         * @return void
         */
        public function setBaseQuery(){
            $this->setQuery("SELECT event.id FROM SchedulizerEvent event");
        }

    }