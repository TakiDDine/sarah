<?php



    function CleanInput(){
      
    }

    /*
    *    Create a Random String
    
    function str_random($length = 20) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /*
    *    Debug
    */
    function st($string,$a = 0){
        if($string){
            echo '<pre>';
            print_r($string);
            echo '</pre>';
        }
        if($a == 1 ){
             exit;
        }
        return ' ';
    }
    
    
    /*
    *   remove http://, www and slash from URL
    *   example : http://www.google.com/exampleUri  --> google.com 
    */
    function urlToDomain ($input){
        
        // in case scheme relative URI is passed, e.g., //www.google.com/
        $input = trim($input, '/');

        // If scheme not included, prepend it
        if (!preg_match('#^http(s)?://#', $input)) {
            $input = 'http://' . $input;
        }

        $urlParts = parse_url($input);

        // remove www
        $domain = preg_replace('/^www\./', '', $urlParts['host']);

        return $domain;
    }
    
    
    
    
    
    
    
    /*
    *    Get the full Url of the current Page
    */
    function Get_Full_Url(){
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;

    }
    
    function meta_redirect($sec,$page){
        echo '<meta http-equiv="refresh" content="'.$sec.'; URL='.$page.'"/>';
    }
    
    
    
    
    
   
    
    
    /**
     * Mulit-byte Unserialize (http://stackoverflow.com/questions/2853454/php-unserialize-fails-with-non-encoded-characters)
     *
     * UTF-8 will screw up a serialized string
     *
     * @access private
     * @param string
     * @return string
     */
    function mb_unserialize($string) {
        $string = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $string);
        return unserialize($string);
    }

    function is_alphanumeric ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    

    function clean($data) {
        // Strip HTML Tags
        $clear = strip_tags($data);
        // Clean up things like &amp;
        $clear = html_entity_decode($clear);
        // Strip out any url-encoded stuff
        $clear = urldecode($clear);
        // Replace Multiple spaces with single space
        $clear = preg_replace('/ +/', ' ', $clear);
        // Trim the string of leading/trailing space
        $clear = trim($clear);
        return $clear;
    }



    

/*                                                                              */
/*   ********************************* YOUTUBE **********************************/ 
/*                                                                              */

        /*
        *     get youtube Video ID From the URL
        */
        function getYoutubeIdFromUrl($url) {
            $parts = parse_url($url);
            if(isset($parts['query'])){
                parse_str($parts['query'], $qs);
                if(isset($qs['v'])){
                    return $qs['v'];
                }else if(isset($qs['vi'])){
                    return $qs['vi'];
                }
            }
            if(isset($parts['path'])){
                $path = explode('/', trim($parts['path'], '/'));
                return $path[count($path)-1];
            }
            return false;
        }


        /*
        *       Iframe youtube video
        */
        function iframeVideo($url){  
            $videoID = getYoutubeIdFromUrl($url);
            echo '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src=" https://www.youtube.com/embed/'.$videoID .'" allowfullscreen></iframe></div>' ;
        }



function makeNiceTime($intTime)
{
     $curTime = time();
    
    $intTime = strtotime($intTime);
    
     $strTime = '';
     if ( ($curTime-$intTime) <  (60)) //(24*60*60))
     {
        $strTime = sprintf("%d ثواني مضت", $curTime-$intTime);
     }
     else if ( ($curTime-$intTime) <  (60*60)) //(24*60*60))
     {
        $strTime = sprintf("%d دقائق مضت", ($curTime-$intTime) / 60 );
     }
     else if ( ($curTime-$intTime) <  (60*60*24)) //(24*60*60))
     {
        $strTime = sprintf("%d ساعات مضت", ($curTime-$intTime) / (60*60) );
     }
     else if ( ($curTime-$intTime) <  (60*60*24*7)) //(24*60*60))
     {
        $strTime = sprintf("%d أيام مضت", ($curTime-$intTime) / (60*60*24) );
     }
    

     else
     {  
         

//         // sample: "12.22 am Sat 21-Jul 2012"
        $strTime = date("j-M Y", $intTime);
     }
     return $strTime;
}



define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
define( 'MONTH_IN_SECONDS',  30 * DAY_IN_SECONDS    );
define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );


function human_time_diff( $from, $to = '' ) {
    if ( empty( $to ) ) {
        $to = time();
    }
 
    $diff = (int) abs( $to - strtotime($from) );
 
    if ( $diff < HOUR_IN_SECONDS ) {
        $mins = round( $diff / MINUTE_IN_SECONDS );
        if ( $mins <= 1 )
            $mins = 1;
        /* translators: Time difference between two dates, in minutes (min=minute). 1: Number of minutes */
        $since = sprintf( 'قبل %s دقائق', $mins );
    } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
        $hours = round( $diff / HOUR_IN_SECONDS );
        if ( $hours <= 1 )
            $hours = 1;
        /* translators: Time difference between two dates, in hours. 1: Number of hours */
        $since = sprintf( 'قبل %s ساعات', $hours );
    } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
        $days = round( $diff / DAY_IN_SECONDS );
        if ( $days <= 1 )
            $days = 1;
        /* translators: Time difference between two dates, in days. 1: Number of days */
        $since = sprintf( 'قبل %s أيام ', $days );
    } elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
        $weeks = round( $diff / WEEK_IN_SECONDS );
        if ( $weeks <= 1 )
            $weeks = 1;
        /* translators: Time difference between two dates, in weeks. 1: Number of weeks */
        $since = sprintf( 'قبل %s أسابيع', $weeks );
    } elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
        $months = round( $diff / MONTH_IN_SECONDS );
        if ( $months <= 1 )
            $months = 1;
        /* translators: Time difference between two dates, in months. 1: Number of months */
        $since = sprintf( 'قبل %s شهور', $months );
    } elseif ( $diff >= YEAR_IN_SECONDS ) {
        $years = round( $diff / YEAR_IN_SECONDS );
        if ( $years <= 1 )
            $years = 1;
        /* translators: Time difference between two dates, in years. 1: Number of years */
        $since = sprintf( 'قبل %s سنوات ', $years );
    }
 
    /**
     * Filters the human readable difference between two timestamps.
     *
     * @since 4.0.0
     *
     * @param string $since The difference in human readable text.
     * @param int    $diff  The difference in seconds.
     * @param int    $from  Unix timestamp from which the difference begins.
     * @param int    $to    Unix timestamp to end the time difference.
     */
    return $since;
}


















//function makeNiceTime($intTime)
//{
//     $curTime = time();
//     $strTime = '';
//     if ( ($curTime-$intTime) <  (60)) //(24*60*60))
//     {
//        $strTime = sprintf("%d seconds ago", $curTime-$intTime);
//     }
//     else if ( ($curTime-$intTime) <  (60*60)) //(24*60*60))
//     {
//        $strTime = sprintf("%d minutes ago", ($curTime-$intTime) / 60 );
//     }
//     else if ( ($curTime-$intTime) <  (60*60*24)) //(24*60*60))
//     {
//        $strTime = sprintf("%d hours ago", ($curTime-$intTime) / (60*60) );
//     }
//     else if ( ($curTime-$intTime) <  (60*60*24*7)) //(24*60*60))
//     {
//        $strTime = sprintf("%d days ago", ($curTime-$intTime) / (60*60*24) );
//     }
//     else
//     {  // sample: "12.22 am Sat 21-Jul 2012"
//        $strTime = date("g.i a D j-M Y", $intTime);
//     }
//     return $strTime;
//}


