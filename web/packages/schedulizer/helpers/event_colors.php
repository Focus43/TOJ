<?php

    class EventColorsHelper {

        const GREEN     = '#A3D900',
              BLUE      = '#3a87ad',
              RED       = '#DE4E56',
              PURPLE    = '#BFBFFF',
              YELLOW    = '#FFFF73',
              ORANGE    = '#FFA64D',
              GRAY      = '#cccccc';


        /**
         * Get a list of available colors.
         * @return object
         */
        public function pairs(){
            if( $this->_colorPairs === null ){
                $this->_colorPairs = (object) array(
                    self::GREEN     => (object) array('hex' => '#A3D900', 'textColor' => '#111111'),
                    self::BLUE      => (object) array('hex' => '#3a87ad', 'textColor' => '#ffffff'),
                    self::RED       => (object) array('hex' => '#DE4E56', 'textColor' => '#ffffff'),
                    self::PURPLE    => (object) array('hex' => '#BFBFFF', 'textColor' => '#ffffff'),
                    self::YELLOW    => (object) array('hex' => '#FFFF73', 'textColor' => '#111111'),
                    self::ORANGE    => (object) array('hex' => '#FFA64D', 'textColor' => '#111111'),
                    self::GRAY      => (object) array('hex' => '#cccccc', 'textColor' => '#111111')
                );
            }
            return $this->_colorPairs;
        }


        /**
         * Get the text color as hex value.
         * @param $hex
         * @return string
         */
        public function textColor( $hex ) {
            return $this->pairs()->{$hex}->textColor;
        }

    }