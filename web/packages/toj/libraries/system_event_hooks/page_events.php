<?php

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

    }