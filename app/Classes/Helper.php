<?php 

namespace App\Classes;

defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
    
    /*
    *   Get a Folder size in bytes
    */
    public function folderSize ($dir){
        $size = 0;
        foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
            $size += is_file($each) ? filesize($each) : $this->folderSize($each);
        }
        return $size;
    }

    /*
    *   Format bytes to kilobytes, megabytes, gigabytes
    */
    public function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('', 'kb', 'mb', 'gb', 'tb');   

        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }

    
    /*
    *   Format bytes to kilobytes, megabytes, gigabytes
    */
    public static function calc($size, $digits=2){
        $unit= array('','K','M','G','T','P');
        $base= 1024;
        $i = floor(log($size,$base));
        $n = count($unit);
        if($i >= $n){
            $i=$n-1;
        }
        return round($size/pow($base,$i),$digits).' '.$unit[$i] . 'B';
    }
    
    
    // 
    public static function is_mobile($mobile) {
        return strlen($mobile) == 11 && preg_match("/^1[3-9]\d{9}$/", $mobile);
    }
    
    
    function downloads($filename,$dir='./'){
        $filepath = $dir.$filename;
        if (!file_exists($filepath)){
            header("Content-type: text/html; charset=utf-8");
            echo "File not found!";
            exit;
        } else {
            $file = fopen($filepath,"r");
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Accept-Length: ".filesize($filepath));
            Header("Content-Disposition: attachment; filename=".$filename);
            echo fread($file, filesize($filepath));
            fclose($file);
        }
    }
    
    
    /*
    *  Check Email is Valid
    */
    public function valid_email($email){
        
        // Check if is it a real email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        
        // check if is not from banned list
        $file = INC_ROOT.'/app/Libraries/domains.json';
        
        // Check if File Exists
        if(file_exists($file)){
            $bannedEmails = json_decode(file_get_contents());
            if (in_array(strtolower(explode('@', $email)[1]), $bannedEmails)) {
                return false;
            }
        }
        return true;
    }
    
    
    /*
    *  Get User IP
    *  this function is tested & it works perfectly
    */
    public function get_ip_address(){ 
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
    
    
    /*
    *    Clean the Inputs
    */
    public function clean($data) {
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
    
    
    /*
    *    Check if a variable is only numbers and letters
    */
    public function is_alphanumeric ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    /*
    *    Check if is a string is small
    */
    public function is_small ($input){
        if(strlen($input)< 3) {
            return false;
        } else {
            return true;
        }
    }   
    
    /*
    *   check a url if it is gravatar
    */
    public function is_gravatar($url){
        if ( false!==stripos($url, 'gravatar') ) {
            return true;
        }
        return false;
    } 
    
    /*
    *    check if a string is an email
    */
    public function is_Email($input){
       if(!filter_var($input, FILTER_VALIDATE_EMAIL)) {
            return true; 
        }else {
            return false;
        }
    }  
    
    
    /*
    *   is unique
    */
    public function is_Unique ($field,$table,$value) {
        $result = $this->container->db->table($table)->where($field, $value)->value($field);
        if($result) {
            return false;
        } else {
            return true;
        }
    }
    
    
    /*
    *   Get time of now  year-month-day Hour:minutes:seconds
    *   Return time
    */
    public function get_Time_Now(){
        $now = new \DateTime();
        return $now->format('Y-m-d H:i:s');
    }
    
    /*
    *   example : contact us page --to--> contact-us-page
    *   remove all whitespace and replace with -
    *   Return srting 
    */
    public function string_To_Uri($string){
      return  preg_replace('/\s+/', '-', $string);
    }
    
    
    /*
    *    Count the words of a string
    */
    public function count_words($word){
        return str_word_count($word);
    }
    
    
    public function is_slug ($input){
        if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._-]+$/', $input)) {
            return true; 
        }else {
            return false;
        }
    }
    
    
    /*
    *   Deleting all files ( and the hidden files also) from a folder   
    */
    public function delete_folders_files($path){
        $path = rtrim($path, '/').'/{,.}*';
        $files = glob($path, GLOB_BRACE); // get all file names
        foreach($files as $file){ // iterate files
          if(is_file($file))
            unlink($file); // delete file
        }
    }
    
    
    /*
    *     Get the current page url
    */
    public function get_page_url(){
      return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
      );
    }
    
    
  /*
    *   Function to Get Snippet from a string , 
    *   @str = the text you want to get snippet from
    *   @$wordCount = the number of words 
    *   usage example get_snippet($text,15,' [...] ');
    */
    public function get_snippet( $str, $wordCount = 10 , $car = ' ' ) {
        $text = implode( 
        '', 
            array_slice( 
              preg_split(
                '/([\s,\.;\?\!]+)/', 
                $str, 
                $wordCount*2+1, 
                PREG_SPLIT_DELIM_CAPTURE
              ),
              0,
              $wordCount*2-1
            )
        );
        
        return $text.$car;
    }
    
    /*
    *    Check if a string is empty
    */ 
    public function is_empty($string){
        if(empty($string)){
            return true;
        }else {
            return false;
        }
    }
    
/* return Operating System */
    public function get_os(){
    if ( isset( $_SERVER ) ) {
        $agent = $_SERVER['HTTP_USER_AGENT'];
    }
    else {
        global $HTTP_SERVER_VARS;
        if ( isset( $HTTP_SERVER_VARS ) ) {
            $agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
        }
        else {
            global $HTTP_USER_AGENT;
            $agent = $HTTP_USER_AGENT;
        }
    }
    $ros[] = array('Windows XP', 'Windows XP');
    $ros[] = array('Windows NT 5.1|Windows NT5.1)', 'Windows XP');
    $ros[] = array('Windows 2000', 'Windows 2000');
    $ros[] = array('Windows NT 5.0', 'Windows 2000');
    $ros[] = array('Windows NT 4.0|WinNT4.0', 'Windows NT');
    $ros[] = array('Windows NT 5.2', 'Windows Server 2003');
    $ros[] = array('Windows NT 6.0', 'Windows Vista');
    $ros[] = array('Windows NT 7.0', 'Windows 7');
    $ros[] = array('Windows CE', 'Windows CE');
    $ros[] = array('(media center pc).([0-9]{1,2}\.[0-9]{1,2})', 'Windows Media Center');
    $ros[] = array('(win)([0-9]{1,2}\.[0-9x]{1,2})', 'Windows');
    $ros[] = array('(win)([0-9]{2})', 'Windows');
    $ros[] = array('(windows)([0-9x]{2})', 'Windows');
    // Doesn't seem like these are necessary...not totally sure though..
    //$ros[] = array('(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'Windows NT');
    //$ros[] = array('(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})', 'Windows NT'); // fix by bg
    $ros[] = array('Windows ME', 'Windows ME');
    $ros[] = array('Win 9x 4.90', 'Windows ME');
    $ros[] = array('Windows 98|Win98', 'Windows 98');
    $ros[] = array('Windows 95', 'Windows 95');
    $ros[] = array('(windows)([0-9]{1,2}\.[0-9]{1,2})', 'Windows');
    $ros[] = array('win32', 'Windows');
    $ros[] = array('(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})', 'Java');
    $ros[] = array('(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}', 'Solaris');
    $ros[] = array('dos x86', 'DOS');
    $ros[] = array('unix', 'Unix');
    $ros[] = array('Mac OS X', 'Mac OS X');
    $ros[] = array('Mac_PowerPC', 'Macintosh PowerPC');
    $ros[] = array('(mac|Macintosh)', 'Mac OS');
    $ros[] = array('(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'SunOS');
    $ros[] = array('(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'BeOS');
    $ros[] = array('(risc os)([0-9]{1,2}\.[0-9]{1,2})', 'RISC OS');
    $ros[] = array('os/2', 'OS/2');
    $ros[] = array('freebsd', 'FreeBSD');
    $ros[] = array('openbsd', 'OpenBSD');
    $ros[] = array('netbsd', 'NetBSD');
    $ros[] = array('irix', 'IRIX');
    $ros[] = array('plan9', 'Plan9');
    $ros[] = array('osf', 'OSF');
    $ros[] = array('aix', 'AIX');
    $ros[] = array('GNU Hurd', 'GNU Hurd');
    $ros[] = array('(fedora)', 'Linux - Fedora');
    $ros[] = array('(kubuntu)', 'Linux - Kubuntu');
    $ros[] = array('(ubuntu)', 'Linux - Ubuntu');
    $ros[] = array('(debian)', 'Linux - Debian');
    $ros[] = array('(CentOS)', 'Linux - CentOS');
    $ros[] = array('(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - Mandriva');
    $ros[] = array('(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - SUSE');
    $ros[] = array('(Dropline)', 'Linux - Slackware (Dropline GNOME)');
    $ros[] = array('(ASPLinux)', 'Linux - ASPLinux');
    $ros[] = array('(Red Hat)', 'Linux - Red Hat');
    // Loads of Linux machines will be detected as unix.
    // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
    //$ros[] = array('X11', 'Unix');
    $ros[] = array('(linux)', 'Linux');
    $ros[] = array('(amigaos)([0-9]{1,2}\.[0-9]{1,2})', 'AmigaOS');
    $ros[] = array('amiga-aweb', 'AmigaOS');
    $ros[] = array('amiga', 'Amiga');
    $ros[] = array('AvantGo', 'PalmOS');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}', 'Linux');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}', 'Linux');
    //$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})', 'Linux');
    $ros[] = array('[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})', 'Linux');
    $ros[] = array('(webtv)/([0-9]{1,2}\.[0-9]{1,2})', 'WebTV');
    $ros[] = array('Dreamcast', 'Dreamcast OS');
    $ros[] = array('GetRight', 'Windows');
    $ros[] = array('go!zilla', 'Windows');
    $ros[] = array('gozilla', 'Windows');
    $ros[] = array('gulliver', 'Windows');
    $ros[] = array('ia archiver', 'Windows');
    $ros[] = array('NetPositive', 'Windows');
    $ros[] = array('mass downloader', 'Windows');
    $ros[] = array('microsoft', 'Windows');
    $ros[] = array('offline explorer', 'Windows');
    $ros[] = array('teleport', 'Windows');
    $ros[] = array('web downloader', 'Windows');
    $ros[] = array('webcapture', 'Windows');
    $ros[] = array('webcollage', 'Windows');
    $ros[] = array('webcopier', 'Windows');
    $ros[] = array('webstripper', 'Windows');
    $ros[] = array('webzip', 'Windows');
    $ros[] = array('wget', 'Windows');
    $ros[] = array('Java', 'Unknown');
    $ros[] = array('flashget', 'Windows');
    // delete next line if the script show not the right OS
    //$ros[] = array('(PHP)/([0-9]{1,2}.[0-9]{1,2})', 'PHP');
    $ros[] = array('MS FrontPage', 'Windows');
    $ros[] = array('(msproxy)/([0-9]{1,2}.[0-9]{1,2})', 'Windows');
    $ros[] = array('(msie)([0-9]{1,2}.[0-9]{1,2})', 'Windows');
    $ros[] = array('libwww-perl', 'Unix');
    $ros[] = array('UP.Browser', 'Windows CE');
    $ros[] = array('NetAnts', 'Windows');
    $file = count ( $ros );
    $os = '';
    for ( $n=0 ; $n<$file ; $n++ ){
        if ( preg_match('/'.$ros[$n][0].'/i' , $agent, $name)){
            $os = @$ros[$n][1].' '.@$name[2];
            break;
        }
    }
    return trim ( $os );
}
    
    
    
    
  
    
    
    
    
    
    
    
    
    
    
    
    
}