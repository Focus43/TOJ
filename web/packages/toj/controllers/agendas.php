<?php

    class AgendasController extends TojPageController {

        protected $includeThemeAssets = true,
                  $itemsPerPage       = 20;

        public function on_start(){
            parent::on_start();
            $this->set('backgroundImage', $this->getPageBackgroundImageURL());
        }


        public function view(){
            $this->set('optionList', array('_all_' => 'All Meeting Agendas') + $this->agendaTypesList());
            $this->set('agendaList', $this->pageListObj()->getPage());
        }


        /**
         * Called via ajax to load more pages. Paging is handled via javascript and passed
         * to the method as the $page argument.
         * @return void
         */
        public function load_more( $page = null ){
            // if $page not set, return nothing
            if( $page === null ){ exit; }

            // if an agenda type is passed, filter the requests
            if( $_REQUEST['agendaType'] != '_all_' ){
                $this->pageListObj()->filterByAttribute('agenda_type', $_REQUEST['agendaType'], '=');
            }

            // render the results
            $results = $this->pageListObj()->getPage( (int) $page );
            foreach($results AS $pageObj){
                Loader::packageElement('partials/agenda_list_item', 'toj', array(
                    'pageObj' => $pageObj
                ));
            }
            exit;
        }


        /**
         * Use the agenda_type page attribute to get the available agenda types (returns an array
         * with key => value as assigned in the dashboard).
         * @return array
         */
        protected function agendaTypesList(){
            $agendaTypeAk = CollectionAttributeKey::getByHandle('agenda_type');
            if( $agendaTypeAk instanceof AttributeKey ){
                $agendaTypeController = $agendaTypeAk->getController();
                if( $agendaTypeController instanceof SelectableAttributeTypeController ){
                    return $agendaTypeController->selectElementFormattedOptions();
                }
            }
            return array();
        }


        /**
         * @return PageList
         */
        private function pageListObj(){
            if( $this->_agendasPageList === null ){
                $this->_agendasPageList = new PageList();
                $this->_agendasPageList->filterByCollectionTypeHandle('agenda');
                $this->_agendasPageList->setItemsPerPage( $this->itemsPerPage );
                $this->_agendasPageList->sortByPublicDateDescending();
            }
            return $this->_agendasPageList;
        }

    }