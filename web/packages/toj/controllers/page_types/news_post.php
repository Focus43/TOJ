<?php defined('C5_EXECUTE') or die("Access Denied.");

    class NewsPostPageTypeController extends TojPageController {
        
        protected $includeThemeAssets = true;

        public function on_start(){
            $this->set('backgroundImage', $this->getPageBackgroundImageURL());
            parent::on_start();

            // should title be normal, warning, or danger colored?
            $this->set('titleClass', $this->titleClass());

            // author name + avatar
            $authorUserInfoObj = UserInfo::getByID( $this->getCollectionObject()->getCollectionUserID() );
            if( $authorUserInfoObj instanceof UserInfo ){
                $this->set('avatarPath', $this->authorAvatarImgPath( $authorUserInfoObj ));
                $this->set('authorName', $this->authorName( $authorUserInfoObj ));
            }
        }


        /**
         * If the title color (<h1> tag) of the new post should be a different color because its
         * an alert of some sort, pass the string from here.
         * @return string
         */
        private function titleClass(){
            $pageObj = $this->getCollectionObject();
            return (bool) $pageObj->getAttribute('alert_critical') ? 'text-danger' : ($pageObj->getAttribute('alert_warning') ? 'alert-warning' : '');
        }


        /**
         * Return the image path to the user avatar
         * @param UserInfo $userInfoObj
         * @return string
         */
        private function authorAvatarImgPath( UserInfo $userInfoObj ){
            $avatarPath  = $this->getHelper('concrete/avatar')->getImagePath( $userInfoObj, false );
            return $avatarPath;
        }


        /**
         * @param UserInfo $userInfoObj
         * @return string
         */
        private function authorName( UserInfo $userInfoObj ){
            return $userInfoObj->getAttribute('first_name') . ' ' . $userInfoObj->getAttribute('last_name');
        }
        
    }