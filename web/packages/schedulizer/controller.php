<?php defined('C5_EXECUTE') or die(_("Access Denied."));
	
	class SchedulizerPackage extends Package {

        const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

	    protected $pkgHandle 			= 'schedulizer';
	    protected $appVersionRequired 	= '5.6.1';
	    protected $pkgVersion 			= '0.15';


        /**
         * @return string
         */
        public function getPackageName(){
	        return t('Schedulizer');
	    }


        /**
         * @return string
         */
        public function getPackageDescription() {
	        return t('Schedulizer');
	    }


        /**
         * On_start hook; provide constants for run + autoload classes.
         */
        public function on_start(){
	        define('SCHEDULIZER_TOOLS_URL', BASE_URL . REL_DIR_FILES_TOOLS_PACKAGES . '/' . $this->pkgHandle . '/');
			
			Loader::registerAutoload(array(
                'SchedulizerController'     => array('library', 'schedulizer_controller', $this->pkgHandle),
				'SchedulizerBaseModel'      => array('library', 'base_model', $this->pkgHandle),
                'SchedulizerCalendar'       => array('model', 'calendar/calendar', $this->pkgHandle),
                'SchedulizerCalendarList'   => array('model', 'calendar/calendar_list', $this->pkgHandle),
                'SchedulizerCalendarColumnSet' => array('model', 'calendar/column_set', $this->pkgHandle),
                'SchedulizerCalendarDefaultColumnSet' => array('model', 'calendar/default_column_set', $this->pkgHandle),
                'SchedulizerEvent'          => array('model', 'event/event', $this->pkgHandle),
                'SchedulizerEventRepeat'    => array('model', 'event/event_repeat', $this->pkgHandle),
                'SchedulizerEventList'      => array('model', 'event/event_list', $this->pkgHandle),
                'EventQueryBuilder'         => array('model', 'event/event_query_builder', $this->pkgHandle)
			));
	    }


        /**
         * Uninstall the Schedulizer package.
         * @return void
         */
        public function uninstall() {
	        parent::uninstall();
			
			try {
				// delete mysql tables
				$db = Loader::db();
				$db->Execute("DROP TABLE SchedulizerCalendar");
                $db->Execute("DROP TABLE SchedulizerEvent");
                $db->Execute("DROP TABLE SchedulizerEventRepeat");
			}catch(Exception $e){
				// fail gracefully
			}
	    }


        /**
         * Run before install or upgrade to ensure dependencies and version minimums are ok.
         */

        private function checkDependencies(){
            if( !( (float) phpversion() >= 5.2 ) ){
                throw new Exception('Schedulizer requires PHP version 5.2 or greater.');
            }
        }


        /**
         * @return void
         */
        public function upgrade(){
            $this->checkDependencies();
			parent::upgrade();
			$this->installAndUpdate();
	    }


        /**
         * @todo Dependency check to make sure DateTime classes are available.
         * @return void
         */
        public function install() {
            $this->checkDependencies();
	    	$this->_packageObj = parent::install(); 
			$this->installAndUpdate();
	    }


        /**
         * @return void
         */
        private function installAndUpdate(){
			$this->setupBlocks()
                 ->setupSinglePages();
		}


        /**
         * @return SchedulizerPackage
         */
        private function setupBlocks(){
            // Ace Code Editor
            if(!is_object(BlockType::getByHandle('schedulizer_calendar'))) {
                BlockType::installBlockTypeFromPackage('schedulizer_calendar', $this->packageObject());
            }

            return $this;
        }
		
		
		/**
		 * Install necessary single pages.
         * @return SchedulizerPackage
		 */
		private function setupSinglePages(){
			SinglePage::add('/dashboard/schedulizer', $this->packageObject());

            // calendars
			$calendar = SinglePage::add('/dashboard/schedulizer/calendars', $this->packageObject());
            if( $calendar instanceof Page ){
                $calendar->setAttribute('icon_dashboard', 'icon-calendar');
            }

            // calendars/search (no icon for subpage)
            SinglePage::add('/dashboard/schedulizer/calendars/search', $this->packageObject());
			
			return $this;
		}


		/**
		 * Get the package object; if it hasn't been instantiated yet, load it.
		 * @return SchedulizerPackage
		 */
		private function packageObject(){
			if( $this->_packageObj == null ){
				$this->_packageObj = Package::getByHandle( $this->pkgHandle );
			}
			return $this->_packageObj;
		}
	    
	}
