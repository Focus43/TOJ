<?php

    class HomePageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;
        
        public function on_start(){
			parent::on_start();
            $this->set('backgroundImage', $this->getPageBackgroundImageURL());
            $this->addFooterItem( $this->getHelper('html')->css('compiled/parallax.css', self::PACKAGE_HANDLE) );
            $this->addFooterItem( $this->jsAsync($this->getHelper('html')->javascript('compiled/parallax.js', self::PACKAGE_HANDLE)) );
        }
        
    }