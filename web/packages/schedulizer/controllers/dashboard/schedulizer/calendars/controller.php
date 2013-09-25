<?php

    class DashboardSchedulizerCalendarsController extends SchedulizerController {

        public function on_start(){
            parent::on_start();
            // css (header)
            $this->addHeaderItem($this->getHelper('html')->css('dashboard/app.css', self::PACKAGE_HANDLE));
            $this->addHeaderItem($this->getHelper('html')->css('fullcalendar-1.6.1/fullcalendar.css', self::PACKAGE_HANDLE));

            // js (footer)
            $this->addFooterItem($this->getHelper('html')->javascript('fullcalendar-1.6.1/fullcalendar.min.js', self::PACKAGE_HANDLE));
            $this->addFooterItem($this->getHelper('html')->javascript('ajaxify.form.js', self::PACKAGE_HANDLE));
            $this->addFooterItem($this->getHelper('html')->javascript('dashboard/app.js', self::PACKAGE_HANDLE));
        }

        /**
         * C5 view action.
         * @return void
         */
        public function view(){
            $this->redirect('/dashboard/schedulizer/calendars/search');
        }


        /**
         * Create a new calendar record and redirect to /edit/$id.
         * @return void
         */
        public function add(){
            $calendarObj = new SchedulizerCalendar(array(
                'ownerID' => $this->userObj()->getUserID()
            ));
            $calendarObj->save();
            $this->redirect('/dashboard/schedulizer/calendars/edit', $calendarObj->getCalendarID());
        }


        /**
         * Passes an existing (*if* it exists) calendar object to the view.
         * @param int $id
         * @param string $activeTab The tab to activate on page render
         * @return void
         */
        public function edit( $id, $activeTab = 'properties' ){
            $calendarObj = SchedulizerCalendar::getByID($id);

            // if it exists, render the edit form
            if( $calendarObj->getCalendarID() >= 1 ){
                $this->set('calendarObj', $calendarObj);
                $this->set('activeTab', $activeTab);
                return;
            }

            // otherwise, redirect to /search and flash error message
            $this->flash('Calendar Not Found', self::FLASH_TYPE_ERROR);
            $this->redirect('/dashboard/schedulizer/calendars/search');
        }


        /**
         * Callable URL to save a calender.
         * @return void
         */
        public function save_calendar( $id = null ){
            try {
                $calendarObj = SchedulizerCalendar::getByID($id);
                // cache this so the save call can use it when updating event default timezones
                $calendarObj->formerTimezone = $calendarObj->getDefaultTimezone();
                // manually add to $_POST, b/c jquery .chosen can't handle arrays
                $_POST['calendar']['defaultTimezone'] = $_POST['calendar_timezone'];
                $calendarObj->setPropertiesFromArray($_POST['calendar']);
                $calendarObj->save();
                $this->flash('Calendar Saved!', self::FLASH_TYPE_OK);
                $this->redirect('/dashboard/schedulizer/calendars/edit', $calendarObj->getCalendarID());
            }catch(ADODB_Exception $e){
                $this->flash("Unable to save: {$e->msg}", self::FLASH_TYPE_ERROR);
                $this->redirect('/dashboard/schedulizer/calendars/edit', $calendarObj->getCalendarID());
            }catch(Exception $e){
                $this->flash("Unable to save: {$e->getMessage()}", self::FLASH_TYPE_ERROR);
                $this->redirect('/dashboard/schedulizer/calendars/edit', $calendarObj->getCalendarID());
            }
        }


        /**
         * @todo If its an all day event, don't account for the start and end *times*?
         * @todo Save repeatMonthlyMethod
         * @todo Validations
         * @todo If a repeating event starts on a different day, adjust the start of the event to that day
         * @param null $id
         */
        public function save_event( $id = null ){
            if( (bool)$_REQUEST['event']['isAlias'] ){
                print_r($_REQUEST);exit;
            }

            try {
                // append values to $_POST array
                $_POST['event']['isRepeating']          = isset($_POST['event']['isRepeating']) ? SchedulizerEvent::IS_REPEATING_TRUE : SchedulizerEvent::IS_REPEATING_FALSE;
                $_POST['event']['isAllDay']             = isset($_POST['event']['isAllDay']) ? SchedulizerEvent::ALL_DAY_TRUE : SchedulizerEvent::ALL_DAY_FALSE;
                $_POST['event']['repeatMonthlyMethod']  = isset($_POST['repeat']['monthly']['method']) ? (int)$_POST['repeat']['monthly']['method'] : SchedulizerEvent::REPEAT_MONTHLY_SPECIFIC_DATE;

                // get the event object (or return an empty one we can populate then save)
                $eventObj = SchedulizerEvent::getByID( $id );
                $eventObj->setPropertiesFromArray($_POST['event']);

                // if its a new event (no owner ID is set yet), assign a new one
                if( ! ($eventObj->getOwnerID() >= 1) ){
                    $eventObj->setPropertiesFromArray(array(
                        'ownerID' => $this->userObj()->getUserID()
                    ));
                }

                // timezone stuff
                $eventObj->setPropertiesFromArray(array(
                    'useCalendarTimezone'   => isset($_POST['event']['useCalendarTimezone']) ? SchedulizerEvent::USE_CALENDAR_TIMEZONE_TRUE : SchedulizerEvent::USE_CALENDAR_TIMEZONE_FALSE,
                    'timezoneName'          => isset($_POST['event']['useCalendarTimezone']) ? $eventObj->calendarObject()->getDefaultTimezone() : $_POST['timezone_name']
                ));

                $dateTimeNowTzLocal = new DateTime('now', $eventObj->getEventTimezoneObj());
                $data['timezoneOffset'] = $dateTimeNowTzLocal->format('P');

                // time properties (uses $eventObj->getEventTimezoneObj as the base timezone, which
                // gets converted to UTC)
                $startUTC                     = new DateTime("{$_POST['event_start_date']} {$_POST['event_start_time']}", $eventObj->getEventTimezoneObj());
                $data['startUTC']             = $startUTC->setTimezone(new DateTimeZone('UTC'))->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                $endUTC                       = new DateTime("{$_POST['event_end_date']} {$_POST['event_end_time']}", $eventObj->getEventTimezoneObj());
                $data['endUTC']               = $endUTC->setTimezone(new DateTimeZone('UTC'))->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                $recurringEndUTC              = new DateTime($_POST['event_repeat_end'], $eventObj->getEventTimezoneObj());
                $data['repeatEndUTC']         = $recurringEndUTC->setTimezone(new DateTimeZone('UTC'))->setTime(0,0,0)->format(SchedulizerPackage::TIMESTAMP_FORMAT);

                // ADJUST THE START DATE IF ITS A REPEATING EVENT AND THE FIRST REPEATED DATE IS LATER
                if( $_REQUEST['event']['isRepeating'] ){
                    $startEndIntrvl = $startUTC->diff($endUTC);

                    // if repeating weekly, and the start date doesn't match the first day that should repeat
                    if($_REQUEST['event']['repeatTypeHandle'] === SchedulizerEvent::REPEAT_TYPE_HANDLE_WEEKLY){
                        $repeatableDays = (array) $_REQUEST['repeat']['weekday_index'];
                        if( !empty($repeatableDays) ){
                            $startDate          = new DateTime("{$_POST['event_start_date']} {$_POST['event_start_time']}", $eventObj->getEventTimezoneObj());
                            $startDateDayIndex  = $startDate->format('w') + 1;
                            $lowestDayIndex     = min( $repeatableDays );

                            if( !in_array($startDateDayIndex, $repeatableDays) ){
                                $weekdayIndicesList = Loader::helper('timing', 'schedulizer')->weekdayIndicesList();
                                $startDate->modify('next ' . $weekdayIndicesList[$lowestDayIndex]);
                                $startTime = explode(':', $_REQUEST['event_start_time']);
                                $startDate->setTime($startTime[0], $startTime[1]);
                                $startDate->setTimezone(new DateTimeZone('UTC'));
                                $data['startUTC'] = $startDate->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                                $data['endUTC']   = $startDate->add($startEndIntrvl)->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                            }
                        }
                    }

                    /**
                     * Auto-adjust the start date for monthly repeats (ie. user clicked the 5th, but wants a date to
                     * repeat every 11th, so adjust the start date to the 11th automatically). Or if its the "first tuesday"
                     * of every month, set the start date to that.
                     */
                    if($_REQUEST['event']['repeatTypeHandle'] === SchedulizerEvent::REPEAT_TYPE_HANDLE_MONTHLY){
                        $startDate = new DateTime("{$_POST['event_start_date']} {$_POST['event_start_time']}", $eventObj->getEventTimezoneObj());

                        // "repeat every month on the 11th"
                        if( (int)$_REQUEST['repeat']['monthly']['method'] === SchedulizerEvent::REPEAT_MONTHLY_SPECIFIC_DATE ){
                            if( (int)$startDate->format('j') !== (int)$_REQUEST['repeat']['monthly']['specific_day'] ){
                                $startDate->setDate($startDate->format('Y'), $startDate->format('m'), ((int)$_REQUEST['repeat']['monthly']['specific_day']));
                                $startDate->setTimezone(new DateTimezone('UTC'));
                                $data['startUTC'] = $startDate->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                                $data['endUTC']   = $startDate->add($startEndIntrvl)->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                            }
                        }

                        // "repeat every 2nd tuesday"
                        if( (int)$_REQUEST['repeat']['monthly']['method'] === SchedulizerEvent::REPEAT_MONTHLY_WEEK_AND_DAY ){
                            // 1 -> "first", 2 -> "second", etc
                            $intToOrdinalPairs = $this->getHelper('timing', 'schedulizer')->monthlyRepeatableWeekOptions();
                            $ordinal = $intToOrdinalPairs[ (int)$_REQUEST['repeat']['monthly']['week'] ];

                            // weekday string (1 -> "sunday", 2 -> "monday", etc)
                            $intToWeekdayPairs = $this->getHelper('timing', 'schedulizer')->weekdayIndicesList();
                            $weekday = $intToWeekdayPairs[ (int)$_REQUEST['repeat']['monthly']['weekday'] ];

                            // create date time object from relative string
                            $monthName = $startDate->format('F');
                            $dateTimeFromStr = new DateTime("{$ordinal} {$weekday} of {$monthName}");

                            $startDate->setDate($dateTimeFromStr->format('Y'), $dateTimeFromStr->format('m'), $dateTimeFromStr->format('d'));
                            $startDate->setTimezone(new DateTimezone('UTC'));
                            $data['startUTC'] = $startDate->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                            $data['endUTC']   = $startDate->add($startEndIntrvl)->format(SchedulizerPackage::TIMESTAMP_FORMAT);
                        }
                    }
                }

                // set properties again
                $eventObj->setPropertiesFromArray($data);

                // *now* persist the object in its current state to the database
                $eventObj->save();

                // repeat settings
                SchedulizerEventRepeat::purgeExisting($eventObj->getEventID());
                if( (bool)$_POST['event']['isRepeating'] ){
                    SchedulizerEventRepeat::save($eventObj, (array) $_REQUEST['repeat']);
                }

                // respond
                $this->formResponder(true, 'Event saved.', array(
                    'eventID'   => $eventObj->getEventID(),
                    'title'     => $eventObj->getTitle()
                ));
            }catch(Exception $e){
                $this->formResponder(false, $e->getMessage());
            }
        }
    }