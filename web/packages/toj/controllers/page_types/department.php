<?php defined('C5_EXECUTE') or die("Access Denied.");

    class DepartmentPageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;


        public function view(){
            parent::view();
            $this->set('recentNews', $this->newsPageList()->get(10));
        }


        /**
         * Get a page list setup to filter by the 10 most recent news_post
         * pages underneath the top level department page.
         * @return PageList
         */
        protected function newsPageList(){
            $ancestryList   = $this->pageIDAncestry();
            $departmentRootPageObj = Page::getByID($ancestryList[2]);

            $pageListObj    = new PageList();
            $pageListObj->filterByPath($departmentRootPageObj->getCollectionPath());
            $pageListObj->filterByCollectionTypeHandle('department');
            $pageListObj->filter(false, '(ak_department_post = 1)');
            return $pageListObj;
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