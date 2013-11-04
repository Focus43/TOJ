<?php

    class TojPageEvents {

        /**
         * Might use this to issue updates, currently does nothing.
         * @todo Issue outgoing events when pages updated.
         */
        public function onPageUpdate( Page $pageObj ){
            if( $pageObj->getCollectionTypeHandle() === 'news_post' ){
                //$pageObj->reindex();
            }
        }

    }