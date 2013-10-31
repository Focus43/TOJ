<?php

    /**
     * Reads the CSS (or SCSS) file and extracts all the available icon classes names to
     * an array.
     */
    class FontAwesomeIconNamesHelper {

        protected $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';


        /**
         * @param $fileName
         * @return array
         */
        public function getFromFile( $fileName ){
            $cssFileText = Loader::helper('file')->getContents( $fileName );

            // regex (sets variable $matches with the values)
            preg_match_all($this->pattern, $cssFileText, $matches, PREG_SET_ORDER);

            $icons = array();

            foreach($matches AS $match){
                $icons[$match[1]] = $match[1];
            }

            return $icons;
        }

    }