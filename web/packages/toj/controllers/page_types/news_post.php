<?php

    class NewsPostPageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;

        public function on_start(){
            $this->set('backgroundImage', $this->getPageBackgroundImageURL());
            parent::on_start();

            $this->set('titleClass', $this->titleClass());
        }


        private function titleClass(){
            $pageObj = $this->getCollectionObject();
            return (bool) $pageObj->getAttribute('alert_critical') ? 'text-danger' : ($pageObj->getAttribute('alert_warning') ? 'alert-warning' : '');
        }
        
    }