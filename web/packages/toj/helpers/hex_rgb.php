<?php

    /**
     * Class HexRgbHelper
     * @see http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
     */
    class HexRgbHelper {

        /**
         * Pass in a hex color string, like "#f19adc and get the rgb values back
         * as either a comma-separated string, or an array [r,g,b]
         * @param $hex string hex value
         * @param bool $commaSeparated
         * @return array|string
         */
        public function hex2rgb( $hex, $commaSeparated = false ){
            $hex = str_replace("#", "", $hex);

            if(strlen($hex) == 3) {
                $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            } else {
                $r = hexdec(substr($hex,0,2));
                $g = hexdec(substr($hex,2,2));
                $b = hexdec(substr($hex,4,2));
            }
            $rgb = array($r, $g, $b);

            return $commaSeparated ? implode(',', $rgb) : $rgb;
        }


        /**
         * @param $rgb
         * @param string $includeHash
         * @return string
         */
        function rgb2hex( $rgb, $includeHash = '#' ) {
            $hex = str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
            $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

            return ! empty($includeHash) ? '#' . $hex : $hex;
        }

    }