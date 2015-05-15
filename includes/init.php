<?php

require_once('./googleAPIKey.php');

#Explode the url paths to make variables and remove the directory path we don't want
$viewPath = str_replace($_SERVER['DOCUMENT_ROOT'],'',getcwd());
$imgPath= str_replace($_SERVER['DOCUMENT_ROOT'],'',getcwd());
$request  = str_replace($viewPath,"", $_SERVER['REQUEST_URI']);

#split the path by '/' to turn the directories into values
$params = explode("?", $request);
if(isset($params[1])){
	$params =$params[0];
}

else{
	$params =  $request;
}
$params = explode("/", $params);

$klient_dpl = 'Distiller Tank';


$wtrFile='watermark.png';
$wtrpath="/archive/";

if(isset($_GET['wm'])){
	$wm = $_GET['wm'];
}


function setWMPath(){
	if(isset($wm) && file_exists($wtrpath.$wtrFile)){
		$wtrMrk.=$wtrpath.$wtrFile;
	}
}

$wtrMrk=$wtrpath.$wtrFile;


function setinvalid($msg){
	//echo $msg;
	global $invalDirectory;
	$invalDirectory = true;
}


if(!isset($params[1])){
	setinvalid('no param 1');
	
}
else{
	$wtrpath.=$params[1].'/';
	setWMPath();

}

if(!isset($params[2])){
	setinvalid('no param 2');

}
else{
	$wtrpath.=$params[2].'/';
	setWMPath();
}

if(!isset($params[3])){
	setinvalid('no param 3');
	
}
else{
	$wtrpath.=$params[3].'/';
	setWMPath();
}

if(!isset($params[4])){
	 setinvalid('no param 4');

}
else{
	$wtrpath.=$params[4].'/';
	setWMPath();

}




$yr=$params[1];

if (strlen($yr)==2){
	$yr="archive/20".$yr;
}
$klient=$params[2];
$proj=$params[3];
$projPath=$yr."/".$klient."/".$proj;
$imgDir=$yr."/".$klient."/".$proj."/".$params[4];


$urlVars="";

$proj = str_replace("-"," ", $proj);
$klient = str_replace("-"," ", $klient);

$klient_dpl = $klient;


if(isset($wm)){
	$urlVars.="?wm=1";
}


if(isset($_GET['cn'])){

	$klient_dpl =$_GET['cn'];
	if($urlVars){
		$urlVars.="&cn=".urlencode($klient_dpl);
	}
	else{
		$urlVars="?cn=".urlencode($klient_dpl);
	}
}

if(isset($_GET['bg'])){
	$bgCrl =$_GET['bg'];
	if($urlVars){
		$urlVars.="&bg=".$bgCrl;
	}
	else{
		$urlVars="?bg=".$bgCrl;
	}
}


#set a 2 digit year for use in linking to folders to maintain an invalid directory for htaccess redirect
$projPathSmllYr = str_replace(date('Y')."/",date('y')."/", $projPath);
$projPathSmllYr = str_replace('archive/','', $projPathSmllYr);

#See if a Content View Type is defined
//print_r($params);
//echo('param 5 ='.$params[5]);

$trailingSlash="/".$projPathSmllYr."/".$params[4]."/";


if(isset($params[5]) && $params[5] =='list'){
	$cType= "list";
	$altView ='slideshow';
}
else{
	$cType= "slideshow";
	$altView = 'list';
}
$trailingSlash .= $altView.$urlVars;


#Check to make sure a client project is specified
if(!$params[3]){
 $invalDirectory=true;
}
#function to create array from files of selected directory
function hasComps($directory = NULL, $imgPath = NULL) {

    if(file_exists($directory) && $dir = opendir($directory)) {
		$tmp = array();
	    while($file = readdir($dir)){
	        if ($file != '.' && $file != '..' &&  $file != 'watermark.png' && $file != '.DS_Store'){
	            // add the filename, to be sure not to
	            // overwrite a array key
	     //ECHO $file;
				$ctime = filectime($directory."/" . $file) . ',' . $file;

				#check to see if the file is a .zip file or not			
				$zipFile = strtolower($file) ;
				$zipFile = explode("[/\\.]", $zipFile) ;
				$n = count($zipFile)-1;
				$zipFile = $zipFile[$n];
				#define the path and file name to the zip file
				
				$fileCheck= explode('.',$file);

				if($zipFile=="zip"){
					global $downloadZip;
					$downloadZip=$directory."/".$file;
				}
				#add file to array for viewing
				else{
					if(isset($fileCheck[0]) && $fileCheck[0] !== ''){
						$tmp[$ctime] =$directory."/".$file;
					}
				}
			}
    	}
	    closedir($dir);
		
		//get names of all the files
		asort($tmp);
		global $imgName;
		$imgName =array();
		$i=1;


	foreach ($tmp as $afile){
/*
		$content = file_get_contents($afile);
		$xmp_data_start = strpos($content, '<x:xmpmeta');
		$xmp_data_end   = strpos($content, '</x:xmpmeta>');
		$xmp_length     = $xmp_data_end - $xmp_data_start;
		$xmp_data       = substr($content, $xmp_data_start, $xmp_length + 12);
		//$xmp            = simplexml_load_string($xmp_data);
		$xmp           =new simpleXMLElement($xmp_data);
		//$xmp  = simplexml_load_string($xmp_data);
		//echo $xmp->description;
	//	echo $xmp_data->description;

*/

		$afile = explode(($directory."/"),$afile);

		//$fileName=explode("[/\\.]",$afile[1]);
		$fileName=explode(".",$afile[1]);
		$fileName=$fileName[0];
		$fileName=str_replace("-"," ", $fileName);
		$fileName=str_replace("_"," ", $fileName);
		$fileName=ucwords($fileName);
		$imgName[$i]= $fileName;
		$i++;
	}
	return $tmp;
	}
	else{
		setinvalid('directory not set');
	}
}


#function to create array from project folders of selected directory
function hasFolders($projPath = NULL, $imgPath = NULL,$projPathSmllYr) {
 if(file_exists($projPath) && $pjcts = opendir($projPath)) {
	$flds = array();
    while($file2 = readdir($pjcts)){
        if ($file2 != '.' and $file2 != '..'){
            // add the filename, to be sure not to
            // overwrite a array key
			$ctime2 = filectime($projPath."/" . $file2) . ',' . $file2;
		  $flds[$ctime2] =$imgPath."/". $projPathSmllYr.'/'.$file2."";
        }	
    }
    closedir($pjcts);
    asort($flds);
    return $flds;
	}
	else{
		setinvalid('directory not set');
	}
}
  	if(!isset($invalDirectory)){
	# setup
	$imgId	= "lgImage"; 	// id tag for images
	$getImg = hasComps($imgDir,$imgPath); // gather images
	$getFolders = hasFolders($projPath,$imgPath,$projPathSmllYr);
	$numImgs = count($getImg); // count images
	}
	




class GoogleUrlApi {
	
	// Constructor
	function GoogleURLAPI($key,$apiURL = 'https://www.googleapis.com/urlshortener/v1/url') {
		// Keep the API Url
		$this->apiURL = $apiURL.'?key='.$key;
		//echo($this->apiURL);

	}
	
	// Shorten a URL
	function shorten($url) {
		// Send information along
		//print_r($this);
		$response = $this->send($url);
		// Return the result
		return isset($response['id']) ? $response['id'] : false;
	}
	
	// Expand a URL
	function expand($url) {
		// Send information along
		$response = $this->send($url,false);
		// Return the result
		return isset($response['longUrl']) ? $response['longUrl'] : false;
	}
	
	// Send information to Google
	function send($url,$shorten = true) {
		// Create cURL
		$ch = curl_init();
		// If we're shortening a URL...
		if($shorten) {
			curl_setopt($ch,CURLOPT_URL,$this->apiURL);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode(array("longUrl"=>$url)));
			curl_setopt($ch,CURLOPT_HTTPHEADER,array("Content-Type: application/json"));
		}
		else {
			curl_setopt($ch,CURLOPT_URL,$this->apiURL.'&shortUrl='.$url);
		}
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		// Execute the post
		$result = curl_exec($ch);
		// Close the connection
		curl_close($ch);
		// Return the result
		return json_decode($result,true);
	}		
}
if($GoogleAPIKey){
	
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$shorten =$protocol.$_SERVER['HTTP_HOST'].$trailingSlash;
	$getGURL = new GoogleURLAPI($GoogleAPIKey);

	$shorterurl= $getGURL->shorten($shorten);
}
?>