<?php

ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

class DirectoryUtils{
	
	function getYearDirs($dir = "."){
		$dirs = array();
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if($file != "." && $file != ".." && substr($file, 0, 1) != "." && $file != "index.php"){
					if(is_numeric($file) && strlen($file)==4){
						$dirs[] = $file;
					}
				}
			}
		}
		
		rsort($dirs, SORT_NUMERIC);
		
		return $dirs;
	}
	
	function getDirContents($dir){
	
		$dirs = array();
		$files = array();
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if($file != "." && $file != ".." && substr($file, 0, 1) != "." && $file != "index.php"){
					if(is_dir($dir.'/'.$file)){
						$dirs[] = $file;
					}else{
						$files[] = array('filename'=>$file, 'path'=>$dir.'/'.$file);
					}
					
				}
			}
		}

		return array('files'=>$files, 'dirs'=>$dirs);
	}
	
	function recursiveObjectify($dirs, $path=''){
		$data = array();
		foreach ($dirs as $dir) {
			$contents = $this->getDirContents($path . $dir);

			$dirdata = array('name'=>$dir, 'path'=> $path . $dir,'files'=>$contents['files'], 'dirs'=>array());

			if(count($contents['dirs'])){
				$dirdata['dirs'] = $this->recursiveObjectify($contents['dirs'], $path.$dir.'/');
			}
			$data[] = $dirdata;     
		}

		return $data;
	}
	
	function getList($data, $it=0){
		
		$open_level = 1;
		
		$list_open = ($it <= $open_level) ? '<ul class="directory show level'.$it.'">' : '<ul class="directory hide level'.$it.'">';
		$list_close = '</ul>';
		$folder_img = ($it < $open_level) ? 'folder-horizontal-open.png' : 'folder-horizontal.png';
		
		$out = $list_open;
		
		$it++;
		
		for ($i=0; $i<count($data); $i++) { 
			$out .= '<div class="group">';
			
			if(count($data[$i]['files'])){
				$out .= '<li class="files">';
				$out .= '<a href="'.$data[$i]['path'].'"><img src="/img/icons/images-stack.png" class="dir-type">' . ucwords(implode(' ', explode('-', $data[$i]['name']))) . '</a>';
			}else{
				$out .= '<li class="dirs">';
				$out .= '<img src="/img/icons/'.$folder_img.'" class="toggle">' . ucwords(implode(' ', explode('-', $data[$i]['name'])));
			}	
			
			$out .= '</li>';			
			
			if(count($data[$i]['dirs'])) $out .= $this->getList($data[$i]['dirs'], $it);
			$out .= '</div>';
			
		}
		$out .= $list_close;
		
		return $out;
	}
	
}

$dir_utils = new DirectoryUtils();

$contents = $dir_utils->recursiveObjectify($dir_utils->getYearDirs());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
		<title>Archive</title>
		<link href="/css/style.min.css" rel="stylesheet" type="text/css" media="screen"/>
		
		<style>
			body{
				overflow-x:hidden;
				overflow-y:scroll;
			}		
		</style>
		
	<body>
		<div class="header">
			<div class="headerTitle"><img src="/img/header_etrTitle.gif" width="185" height="41" /></div>
			
		  <div id="projDetails" class="archive"><h1>Archive</h1></div>
		
		</div>
		<div id="container">
			<div class="archive-tree">
<?php echo $dir_utils->getList($contents); ?>
			</div>
		</div>
	</body>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="/js/functions.min.js"></script>
</html>

<script type="text/javascript">
		
			$(function(){
				$('.toggle').bind('click', function(){
					
					var ul = $(this).parent().parent().children('ul');
					
					if(ul.css('display') == 'none'){
						ul.css('display','block');
						$(this).attr({src: '/img/icons/folder-horizontal-open.png'});
					}else{
						ul.css('display','none');
						$(this).attr({src: '/img/icons/folder-horizontal.png'});
					}
					
					
				});
				
			});
		
		</script>
		