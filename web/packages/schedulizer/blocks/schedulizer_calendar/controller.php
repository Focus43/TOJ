<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Schedulizer block controller.
	 */
	class SchedulizerCalendarBlockController extends BlockController {

		protected $btTable 									= 'btSchedulizerCalendar';
		protected $btInterfaceWidth 						= '585';
		protected $btInterfaceHeight						= '440';
		protected $btCacheBlockRecord 						= false;
		protected $btCacheBlockOutput 						= false;
		protected $btCacheBlockOutputOnPost 				= false;
		protected $btCacheBlockOutputForRegisteredUsers 	= false;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;

        protected $blockData;

        /**
         * @return string
         */
        public function getBlockTypeDescription(){
			return t("Display Schedulizer Calendars");
		}


        /**
         * @return string
         */
        public function getBlockTypeName(){
			return t("Schedulizer Calendar");
		}


        public function on_page_view(){
            $this->addHeaderItem(Loader::helper('html')->css('fullcalendar-1.6.1/fullcalendar.css', 'schedulizer'));
            $this->addFooterItem(Loader::helper('html')->javascript('fullcalendar-1.6.1/fullcalendar.min.js', 'schedulizer'));
        }


        /**
         * View action for the block.
         */
        public function view(){
            if( !count((array)$this->blockData()) ){
                $this->set('nextFiveEvents', array());
                return;
            }

            $todayDTO  = new DateTime('now', new DateTimeZone('UTC'));
            $todayDTO->setTime(0, 0, 0);
            $todayDTO->modify('first day of this month');
            $plus30DTO = clone $todayDTO;
            $plus30DTO->modify('+1 Month');

            $calendarIDs = array_keys( (array)$this->blockData() );
            $this->set('nextFiveEvents', EventQueryBuilder::getEventsForRange($todayDTO, $plus30DTO, $calendarIDs, 5));
		}


        /**
         * Edit action.
         */
        public function add(){ $this->edit(); }

        public function edit(){
            $this->set('blockData', $this->blockData());

            $calendarList = $this->calendarListObj()->getAsKeyValueList();
            foreach($this->blockData() AS $calendarID => $rec){
                unset($calendarList[$calendarID]);
            }
            $this->set('calendarList', $calendarList);
        }


        /**
         * @return stdClass
         */
        public function blockData(){
            if( $this->_parsedBlockData === null ){
                $this->_parsedBlockData = (object) Loader::helper('json')->decode( $this->blockData );
            }
            return $this->_parsedBlockData;
        }


        /**
         * @return SchedulizerCalendarList
         */
        protected function calendarListObj(){
            if( $this->_calendarListObj === null ){
                $this->_calendarListObj = new SchedulizerCalendarList;
            }
            return $this->_calendarListObj;
        }
		
		
		/**
		 * Get the full URL to the block tools directory
		 * @return string
		 */
		protected function getBlockToolsURL( $resource = null ){
			if( $this->_btUrl == null ){
				$this->_btUrl = Loader::helper('concrete/urls')->getBlockTypeToolsURL(BlockType::getByHandle('html_five_video'));
			}
			return $resource ? "{$this->_btUrl}/$resource" : $this->_btUrl;
		}
		
		
		/**
		 * Get the string to output as tags in the <video> html tag
		 */
		/*public function getVideoTagAttributes(){
			$controls 	= (bool) $this->showControls ? 'controls' : '';
			$autoplay	= (bool) $this->autoplay ? 'autoplay' : '';
			$loop		= (bool) $this->loopVideo ? 'loop' : '';
			$preload	= (bool) $this->preload ? 'preload="auto"' : 'preload="none"';
			$poster		= ($this->posterImageFileObj(true)) ? 'poster="'.$this->posterImageFileObj()->getURL().'"' : '';
			$width		= ($this->width != '') ? 'width="'.$this->width.'"' : '';
			$height		= ($this->height != '') ? 'height="'.$this->height.'"' : '';
			return trim( t("%s %s %s %s %s %s %s", $controls, $autoplay, $loop, $poster, $width, $height, $preload) );
		}*/
		
		
		public function save( $data ){
            $args['blockData'] = Loader::helper('json')->encode( (object)$_POST['cal'] );
			parent::save( $args );
		}
		
	}