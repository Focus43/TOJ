<?php

    /**
     * Run only when package version is incremented to 0.72.
     */
    class UpgradeTask_v0_84 {

        /**
         * Used for removing cruft from Area('Top Area') in all the department
         * pages.
         */
        public static function run(){
            // Purge the 'Top Area' content
            $pageListObj = new PageList();
            $pageListObj->filterByCollectionTypeHandle('department');
            $results = $pageListObj->get(500); // if more than 500 then whatever...

            foreach($results AS $pageObj){
                $areaObj = Area::get($pageObj, 'Top Area');
                $blocks  = $areaObj->getAreaBlocksArray($pageObj);
                foreach($blocks AS $blockObj){
                    $blockObj->delete(true);
                }
            }

            // Transition modal and department pages types to 'Page Content' as the main area
            $db = Loader::db();
            $db->Execute("UPDATE Areas SET arHandle = 'Page Content' WHERE arHandle = 'Left Content';");
            $db->Execute("UPDATE CollectionVersionBlocks SET arHandle = 'Page Content' WHERE arHandle = 'Left Content';");
            $db->Execute("UPDATE Areas SET arHandle = 'Page Content' WHERE arHandle = 'Modal Content';");
            $db->Execute("UPDATE CollectionVersionBlocks SET arHandle = 'Page Content' WHERE arHandle = 'Modal Content';");
        }

    }