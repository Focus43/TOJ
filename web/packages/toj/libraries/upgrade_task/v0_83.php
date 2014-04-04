<?php

    /**
     * Run only when package version is incremented to 0.72.
     */
    class UpgradeTask_v0_83 {

        /**
         * Used for removing cruft from Area('Top Area') in all the department
         * pages.
         */
        public static function run(){
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
        }

    }