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
                //Cache::disableCache();
                //$pageObj->reindex();
                //$pageObj->refreshCache();

                // refresh attribute caches
                //$collectionAKs = CollectionAttributeKey::getList();
                //foreach($collectionAKs AS $akObj){ /** @var CollectionAttributeKey $akObj */
                //    $akObj->updateSearchIndex();
                //}
            }
        }

    }