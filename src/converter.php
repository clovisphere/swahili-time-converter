<?php

/**
 * European-Swahili Time converter.
 */
class Converter {
    // swahili equivalent to 'night', 'morning', and 'afternoon/ during the day'
    private $part_of_the_day = array('Usiku', 'Asubuhi', 'Mschana');
    // the below values are used for calculation purposes
    // to distinguish between the different part of the day in Swahili.
    private $lower = 6;
    private $upper = 18;
    
    /**
     * class constructor
     */
    public function __construct() {
        // TODO - nothing 
    }
    
    /**
     * Converts given (european) time to swahili equivalent. 
     * @param $time
     * @return string -- empty string if conversion failed.
     */
    public function convert($time) {
        $str = '';
        
        if (is_valid_time($time)) {
            $temp = explode(':', $time);
            $seconds = '';
            if (count($temp) > 2) { $second = ':' .$temp[2];} // if there was any second passed
            // the magic happens here
            $result = to_swahili($temp[0]);
            // build the swahili equivalent.
            $str = $result[0] .':' .$temp[1] .$second .", {$result[1]}";
        }
        return $str;
    }
    
    /**
     * Transforms the given $hour to its swahili equivalent + add the part of the day
     * @param $hour
     * @return array
     */
    private function to_swahili($hour) {
        $result = array();
        
        if ($hour >= 19 && $hour <= 24) {
            array_push(
                $result, 
                ($hour - $upper), 
                $part_of_the_day[0]
            );
        }else {
            $temp = (($hour - $lowe) < 1)?($hour + $lower):($hour - $lower);
            array_push($result, $temp);
            // get part of the day
            if ($hour < 19 && $hour >= 12) {
                array_push($result, $part_of_the_day[2]);
            }else if ($hour < 12 && $hour >= 5) {
                array_push($result, $part_of_the_day[1]);
            }else {
                array_push($result, $part_of_the_day[0]);
            }
        }
        return $result;
    }
    
    /**
     * Checks if the given time is valid - 24-HOUR FORMAT.
     * @param $time
     * @return bolean
     */
    private function is_valid_time($time) {
        // regex expression pattern for time in a 24-Hour format.
        $pattern = '#^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$#';
        return preg_match($pattern, $time);
    }
}

## -- TO BE REMOVED -- ##
# (only used for test purposes) #
$european_time = '12:00:00';
$obj = new Converter();
echo "Time - '{$european_time}' - is said/read: '" .$obj->convert($european_time) ."' in Swahili\n";
