<?php defined('C5_EXECUTE') or die("Access Denied.");

    class HomePageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;

        /**
         * If using the view() public function, make sure to call the parent::view().
         */
        public function view(){
            parent::view();
            $this->addFooterItem( $this->getHelper('html')->css('compiled/parallax.css', self::PACKAGE_HANDLE) );
            $this->addFooterItem( $this->jsAsync($this->getHelper('html')->javascript('home-parallax.js', self::PACKAGE_HANDLE)) );
        }
        
    }