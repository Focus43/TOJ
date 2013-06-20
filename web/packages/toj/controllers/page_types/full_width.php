<?php

    class FullWidthPageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;

        public function on_start(){
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