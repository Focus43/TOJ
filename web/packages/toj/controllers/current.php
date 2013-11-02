<?php

    class CurrentController extends TojPageController {

        protected $includeThemeAssets   = true,
                  $newsPostItemsPerPage = 5;

        public function on_start(){
            parent::on_start();
            $this->set('backgroundImage', $this->getPageBackgroundImageURL());

            // include the masonry gallery script from the masonry_grid package
            $this->addFooterItem( $this->getHelper('html')->javascript('masonry.pkgd.min.js', 'toj') );
        }


        public function view(){
            $alertsList = $this->alertsPageList()->get();

            $this->set('criticals', array_filter($alertsList, function( $pageObj ){
                return (bool) $pageObj->getAttribute('alert_critical');
            }));

            $this->set('warnings', array_filter($alertsList, function( $pageObj ){
                return (bool) $pageObj->getAttribute('alert_warning');
            }));

            $this->set('newsPages', $this->newsPageList()->getPage());
        }


        /**
         * Called via ajax: current/load_more. Anytime this is called it should
         * start at page 2.
         */
        public function load_more( $page = 2 ){
            $results = $this->newsPageList()->getPage( (int) $page );

            foreach($results AS $pageObj){
                Loader::packageElement('partials/news_item', 'toj', array(
                    'pageObj' => $pageObj
                ));
            }
            exit;
        }


        private function newsPageList(){
            if( $this->_newsPageList === null ){
                $this->_newsPageList = new TojNewsPageList;
                $this->_newsPageList->setItemsPerPage($this->newsPostItemsPerPage);
                $this->_newsPageList->sortByPublicDateDescending();
            }
            return $this->_newsPageList;
        }


        private function alertsPageList(){
            if( $this->_alertsPageList === null ){
                $this->_alertsPageList = new TojNewsPageList;
                $this->_alertsPageList->filterByWarningsAndAlerts();
                $this->_alertsPageList->filterByStickyUntil(); // now is default
            }
            return $this->_alertsPageList;
        }

    }