<?php
session_start();
function flasherror($message){
    return '<div class="alert alert-danger errorbox" >'.$message.'</div>';
}
function flashsuccess($message){
    return '<div class="alert alert-success errorbox" >'.$message.'</div>';
}



if(!isset($_POST['validate'])) {

$host           =     $_POST['database_host'];
$name           =     $_POST['database_name'];
$username       =     $_POST['database_username'];
$pwd            =     $_POST['database_pwd'];

try{
    $dbh = new pdo("mysql:host=$host;dbname=$name",
                    $username,
                    $pwd,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
   
    
    $_SESSION['db_info'] = $_POST;
    
    
    
    echo "startstep2";
    exit;
}
catch(PDOException $ex){
    echo flasherror('المعلومات خاطئة ، المرجوا ادخال المعلومات الصحيحة');
    exit;
}


}


if(isset($_POST['validate'])) {

    
$host           =     $_SESSION['db_info']['database_host'];
$name           =     $_SESSION['db_info']['database_name'];
$username       =     $_SESSION['db_info']['database_username'];
$pwd            =     $_SESSION['db_info']['database_pwd'];

$pdo = new pdo("mysql:host=$host;dbname=$name",
$username,
$pwd,
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    
function importSqlFile($pdo, $sqlFile, $tablePrefix = null, $InFilePath = null)
{
	try {
		

        
        
		// Enable LOAD LOCAL INFILE
		$pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE, true);
		
		$errorDetect = false;
		
		// Temporary variable, used to store current query
		$tmpLine = '';
		
		// Read in entire file
		$lines = file($sqlFile);
		
		// Loop through each line
		foreach ($lines as $line) {
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || trim($line) == '') {
				continue;
			}
			
			// Read & replace prefix
			$line = str_replace(['<<prefix>>', '<<InFilePath>>'], [$tablePrefix, $InFilePath], $line);
			
			// Add this line to the current segment
			$tmpLine .= $line;
			
			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';') {
				try {
					// Perform the Query
					$pdo->exec($tmpLine);
				} catch (\PDOException $e) {
					echo "<br><pre>Error performing Query: '<strong>" . $tmpLine . "</strong>': " . $e->getMessage() . "</pre>\n";
					$errorDetect = true;
				}
				
				// Reset temp variable to empty
				$tmpLine = '';
			}
		}
		
		// Check if error is detected
		if ($errorDetect) {
			return false;
		}
		
	} catch (\Exception $e) {
		echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
		return false;
	}
	
	return true;
}
    
    
    
// Import the SQL file
$res = importSqlFile($pdo, 'db.sql');
if ($res === false) {
	die('ERROR');
}else {
    echo "startstep4";
}
 
    
    
}
    
 
    
