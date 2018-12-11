<?php


use \App\Classes\Helper;



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
    
    

    $text = "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.";


    $helper = new helper();
//st($helper->getMemory(),1);

//   unset($_SESSION['lang']);
//   st($_SESSION,1);

    
    
//    st($_SESSION,1);
    
    
   
    
    
    


   





function makeNiceTime($intTime) {
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
        $strTime = date("j-M Y", $intTime);
     }
     return $strTime;
}






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





















