<?php

    class AgendasController extends TojPageController {

        const TOWN_COUNCIL_PATH      = '/agendas/town-council',
              PLANNING_ZONING_PATH   = '/agendas/pzcba';

        protected $includeThemeAssets = true,
                  $itemsPerPage       = 20;

        public function on_start(){
            parent::on_start();
            $this->set('backgroundImage', $this->getPageBackgroundImageURL());

            // single page css
            $this->addHeaderItem( $this->getHelper('html')->css('compiled/singlepage-current.css', 'toj') );
        }


        public function view(){
            // on just the initial page load, clone the PageListObj so we don't override filters
            $tcPageListObj = clone $this->pageListObj();
            $pzPageListObj = clone $this->pageListObj();

            $tcPageListObj->filterByParentID( Page::getByPath(self::TOWN_COUNCIL_PATH)->getCollectionID() );
            $this->set('townCouncilAgendas', $tcPageListObj->getPage() );

            $pzPageListObj->filterByParentID( Page::getByPath(self::PLANNING_ZONING_PATH)->getCollectionID() );
            $this->set('planningZoningAgendas', $pzPageListObj->getPage() );
        }


        /**
         * Called via ajax: current/load_more. Anytime this is called it should
         * start at page 2.
         */
        public function load_more( $page = 2 ){
            $handle = ($_REQUEST['list'] === 'tc') ? self::TOWN_COUNCIL_PATH : self::PLANNING_ZONING_PATH;
            $this->pageListObj()->filterByParentID( Page::getByPath($handle)->getCollectionID() );

            $results = $this->pageListObj()->getPage( (int) $page );

            foreach($results AS $pageObj){
                Loader::packageElement('partials/agenda_list_item', 'toj', array(
                    'pageObj' => $pageObj
                ));
            }
            exit;
        }


        private function pageListObj(){
            if( $this->_agendasPageList === null ){
                $this->_agendasPageList = new PageList();
                $this->_agendasPageList->setItemsPerPage( $this->itemsPerPage );
                $this->_agendasPageList->sortByPublicDateDescending();
            }
            return $this->_agendasPageList;
        }

    }