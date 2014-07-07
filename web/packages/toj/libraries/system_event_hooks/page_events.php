<?php defined('C5_EXECUTE') or die(_("Access Denied."));

    class TojPageEvents {

        /**
         * Might use this to issue updates, currently does nothing.
         * @note The key thing to make this work is setting the constant ENABLE_PROGRESSIVE_PAGE_REINDEX
         * to false in config.php!
         * @todo Issue outgoing events when pages updated.
         */
        public function onPageUpdate( Page $pageObj ){
            if( $pageObj->getCollectionTypeHandle() === 'news_post' ){
                // we don't actually have to do anything in here, the way it works is adjust
                // the constant as noted above
            }
        }


        /**
         * When a new department page is created, bust any other cached department pages.
         * @param Page $pageObj
         */
        public function onPageVersionApprove( Page $pageObj ){
            if( $pageObj->getCollectionTypeHandle() === 'department' ){
                $cacheLib = PageCache::getLibrary();

                $pageListObj = new PageList;
                $pageListObj->filterByCollectionTypeHandle('department');
                $departmentPages = $pageListObj->get(1000); // @todo: might have to increase?

                foreach($departmentPages AS $deptPageObj){
                    $cacheLib->purge($deptPageObj);
                }
            }
        }

    }