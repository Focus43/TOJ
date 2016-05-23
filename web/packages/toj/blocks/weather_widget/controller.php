<?php defined('C5_EXECUTE') or die("Access Denied.");
	
	
	/**
	 * Button Link block
	 */
	class WeatherWidgetBlockController extends BlockController {

		protected $btTable 									= 'btWeatherWidget';
		protected $btInterfaceWidth 						= '250';
		protected $btInterfaceHeight						= '200';
		protected $btCacheBlockRecord 						= true;
		protected $btCacheBlockOutput 						= true;
		protected $btCacheBlockOutputOnPost 				= true;
		protected $btCacheBlockOutputForRegisteredUsers 	= true;
		protected $btCacheBlockOutputLifetime 				= CACHE_LIFETIME;
		
        // database fields
        public $zipCode;
        
        
		public function getBlockTypeDescription(){
			return t("Add a weather widget based on zip code.");
		}
		
		
		public function getBlockTypeName(){
			return t("Weather Widget");
		}
        
        
        public function add(){}
        
        
        public function edit(){}
		
        
		public function view(){
		    $this->set('zipCode', $this->zipCode);
            $this->set('containerClass', "widget-{$this->bID}");
            $this->set('toolsURL', $this->getBlockToolsURL('jquery.simpleweather.min.js'));
		}


        /**
         * Get the full URL to the block tools directory.
         * @return string
         */
        protected function getBlockToolsURL( $resource = null ){
            if( $this->_btUrl == null ){
                $this->_btUrl = Loader::helper('concrete/urls')->getBlockTypeAssetsURL(BlockType::getByHandle('weather_widget')) . '/assets';
            }
            return $resource ? "{$this->_btUrl}/$resource" : $this->_btUrl;
        }

		
		public function save( $data ){
			parent::save( $data );
		}
		
	}