<?php defined('C5_EXECUTE') or die("Access Denied.");

    class DepartmentPageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true,
                  $postsPerPagination = 8;


        public function view(){
            parent::view();
            $this->set('recentNews', $this->postsPageList()->getPage());
            $this->set('departmentRootPath', BASE_URL . View::url($this->getDepartmentRootPageObj()->getCollectionPath()));
            $this->set('departmentRootID', $this->getDepartmentRootPageObj()->getCollectionID());
        }


        /**
         * Even with full page caching enabled, using this route avoids
         * hitting the cache.
         */
        public function _load_posts( $departmentID, $pagination = 2 ){
            if( ! ((int)$departmentID >= 1) ){
                // @todo: error result
                exit;
            }
            // otherwise, try and load posts
            $pageListObj = $this->postsPageList(Page::getByID($departmentID));
            $results      = $pageListObj->getPage( (int)$pagination );

            foreach($results AS $pageObj){
                Loader::packageElement('partials/department_post', 'toj', array(
                    'pageObj' => $pageObj
                ));
            }
            exit;
        }


        /**
         * Get a page list setup to filter by the 10 most recent news_post
         * pages underneath the top level department page.
         * @param Page $pageObj Optionally inject a $pageObj to act as the root
         * so we don't have to traverse up the entire site tree!
         * @todo: integrate modals?
         * @return PageList
         */
        protected function postsPageList( Page $pageObj = null ){
            $deptRootPage = ($pageObj === null) ? $this->getDepartmentRootPageObj() : $pageObj;
            $pageListObj = new PageList();
            $pageListObj->setItemsPerPage( $this->postsPerPagination );
            $pageListObj->filterByPath($deptRootPage->getCollectionPath());
            $pageListObj->filterByCollectionTypeHandle('department');
            $pageListObj->filter(false, '(ak_department_post = 1)');
            $pageListObj->sortByPublicDateDescending();
            return $pageListObj;
        }


        /**
         * Get the department root page, using the traversal method.
         * @return Page
         */
        protected function getDepartmentRootPageObj(){
            if( $this->_departmentRootPageObj === null ){
                $this->_departmentRootPageObj = Page::getByID($this->getDepartmentRootID());
            }
            return $this->_departmentRootPageObj;
        }


        /**
         * Get the ID of the department root page (aka, traverse the parent tree
         * and find the third node down from the homepage).
         * @return int
         */
        protected function getDepartmentRootID(){
            if( $this->_departmentRootID === null ){
                $ancestryList = $this->pageIDAncestry();
                $this->_departmentRootID = $ancestryList[2];
            }
            return $this->_departmentRootID;
        }


        /**
         * Get an array of the page IDs going all the way back to the
         * homepage. Yes, this is an ugly recursive function using the
         * while loop to navigate up through the tree.
         * @return array
         */
        protected function pageIDAncestry(){
            $currentPageID = Page::getCurrentPage()->getCollectionID();
            $ancestry      = array();

            while( (int)$currentPageID > 0 ){
                array_push($ancestry, $currentPageID);
                $currentPageID = Page::getCollectionParentIDFromChildID($currentPageID);
            }

            return array_reverse($ancestry);
        }
        
    }