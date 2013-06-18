<?php

    class HomePageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;
        
        public function on_start(){
            $this->addFooterItem( $this->getHelper('html')->css('home/parallax.css', self::PACKAGE_HANDLE) );
            $this->addFooterItem( $this->jsAsync($this->getHelper('html')->javascript('home/parallax.js', self::PACKAGE_HANDLE)) );
        	$this->set('backgroundImage', $this->getPageBackgroundImageURL());
			parent::on_start();
        }
		
		
		protected function getPageBackgroundImageURL(){
			$fileObj = $this->getCollectionObject()->getAttribute('page_background');
			if( $fileObj instanceof File ){
				return $fileObj->getRecentVersion()->getRelativePath();
			}
		}
        
    }