<? require_once 'includes/init.php' ?>
<!DOCTYPE HTML>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if IE 10]>         <html class="no-js lt-ie11"> <![endif]-->

<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META NAME=robots CONTENT="noindex,nofollow">
<title><?PHP echo(ucwords($klient_dpl)) ?></title>
<link href="/css/styles.min.css" rel="stylesheet" type="text/css">
<meta name="viewport" content="width=device-width,  initial-scale=1">

<body class="hover <?= $cType ?>" <? if(isset($_GET['bg'])): echo 'style="background-color:#'.$_GET['bg'].'";'; endif; ?>>
<div id="infoBox" style="display: none">
<?php 
	echo('<!-- '.$yr."/".$urlDir2."/".$urlDir3. '-->');
	$pagePath='/archive/index.php/'.$yr."/".$urlDir2."/".$urlDir3;
	$curl = curl_init();
	// curl_setopt ($curl, CURLOPT_URL, $pagePath);
	curl_exec ($curl);
	curl_close ($curl);
?>
</div>
<?  if(isset($invalDirectory) && (!isset($urlDir3) || !$urlDir3)): ?>
<h2 class="errorPath"><?= $invalDirectory ?></h1>
<? else: ?>
<div class="header">
<div class="header-info">

	<div class="headerTitle">
		<?php 
		$txtcnt = strlen($klient_dpl);
		$cls='';
		switch ($txtcnt) {
			case $txtcnt>30:
		        $cls= "xlrg";
		        break;
		    case $txtcnt>20:
		        $cls="lg";
		        break;
		    case $txtcnt> 10:
		        $cls= "med";
		        break;

		 
		}

		echo '<span class="'.$cls.'">'.$klient_dpl.'</span>';
		?>
	</div>
	<div id="projDetails">
			<div class="project">
			<div class="info"></div>
<?php if(($urlDir3)): ?>
	<div class="selectbox">
		<select name="Projects" onChange="location = this.options[this.selectedIndex].value;">
	<option value="" >Select Files</option>
<?php $i=1; foreach($getFolders as $fldr): ?>
<?php 
$fldrRoot = explode('archive',$fldr);
$folderName=explode("/",$fldr);?>
	<option value="<?=$fldr?>/<?=$trailingSlash?>" <?php if(isset($urlDir4) && $folderName[sizeof($folderName)-1]==$urlDir4): echo 'selected="selected"'; endif; ?>>
<?PHP
	$folderName = ucwords(str_replace("-"," ",$folderName[sizeof($folderName)-1]));
	echo($folderName);
?>
	</option>
	<?php $i++; endforeach; ?>
	</select>
	</div>
</div>
<? else: ?>
<?php endif; ?>
<? if($cType != 'list'): ?>
	<div class="imgDescr"> </div>
<? endif; ?>
	</div>

</div>
	<div class='header-options'>
	<?php if(isset($getImg) && (sizeof($getImg)>1)&&(isset($urlDir4)) && $cType != 'list'): ?>
		<div class="pagination">
		<div class="navButton next"><a id="btnNext" href="#next"  title="Next Photo">&#x276f;</a></div>
		<div class="navButton prev" ><a id="btnPrev" href="#prev" title="Previous Photo">&#x276e;</a></div>
		<div id="pageDisplay">Page 2 of 10</div>
		</div>
	<?php endif; ?>
		<div class="viewNav">
		View as
	<?php if($cType == 'list'): ?>
		<div class="btnSlideshow"><a href="<?php echo $trailingSlash?>" title="View as Slideshow">Slideshow</a></div>
	<?php else: ?>
		<div class="btnList"><a href="<?php echo $trailingSlash?>"  title="View as List">List</a></div>
	<? /*  <div class="btnPrint"><a href="javascript:window.print();" title="Print">&nbsp;</a></div> */?>
	<?php endif; ?> 
	<?php if(isset($downloadZip)): ?>
		<div class="btnDownload" ><a href="/<?php echo($downloadZip); ?>" title="Download Files">&nbsp;</a></div>
	<?php endif; ?> 
	<!-- <div class="btnInfo"><a href="javascript:toggle();" title="Archive Info">&nbsp;</a></div> -->
		</div>
	</div>
	</div>

<?php 
/* ===================================================================================
						Display Items in folder as a list 
=================================================================================== */
if($cType == 'list'): ?>
	<div id="container">
		<?php $i=1; foreach($getImg as $img): ?>

		<span>
			<? if(isset($wm)): ?><div class="watermark" style="background:url('<?= $wtrMrk ?>')" /></div><? endIf; ?>
			<img src="/<?=$img?>"  style="max-width: <?php $imgInfo=getimagesize($img); echo($imgInfo[0]); ?>px" />
		<h2><?=$imgName[$i]?></h2>
	</span><br />
	<?php $i++; endforeach; ?>


 <?php else: 
/* ===================================================================================
						Display Items in folder as a Slideshow
=================================================================================== */
 ?>
	 <div id="container">
		<?php if(!isset($urlDir4) || !$urlDir4): ?>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<h2 class="errorPath"><?= $invalDirectory ?></h2>
		<?php else: ?>
		<div id="<?php echo $imgId?>" >
				<? if(isset($wm)): ?><div class="watermark" style="background:url('<?= $wtrMrk ?>')" /></div><? endIf; ?>
			<img src="#"  />
		</div>

		<?php endif; ?>
		<?php endif; ?>
		<!-- End "Comps" Div -->
		</div>
	</div>
<?php endif;
/* ===================================================================================
										End Content
=================================================================================== */
?>
<a href="http://theelixirhaus.com/projects/brewer" class="footer credit" target="_blank">Powered by Brewer</a>
<? if(isset($shorterurl)):?><a href="<?= $shorterurl ?>" class="footer shortUrl">Short Url: <?= $shorterurl ?></a><? endIf;?>
</body>
<script>
	imgId = "<?= $imgId ?>";
	cType= "<?= $cType ?>";
	proj ="<?php echo ucwords($proj); ?>";
	var NumberOfImages = <?php echo $numImgs?>; 
	var img = new Array(NumberOfImages); 
	var imgCount = new Array(NumberOfImages); 
	var imgDescr = new Array(NumberOfImages);
	var imgWidth = new Array(NumberOfImages);
	var imgHeight = new Array(NumberOfImages);
	var imgPXWidth = 0;
	var imgNumber = 0;  

	<?php $i=0; 
	if(isset($getImg)){
		foreach ($getImg as $image): ?>
	img[<?php echo $i?>] = "/<?php echo $image?>";
	imgCount[<?php echo $i?>] = "<?php echo $i+1?>";
	imgDescr[<?php echo $i?>] = "<?php echo ($imgName[($i+1)]); ?>";
	imgWidth[<?php echo $i?>]="<?php $imgInfo=getimagesize($image); echo($imgInfo[0]); ?>"
	imgHeight[<?php echo $i?>]="<?php $imgInfo=getimagesize($image); echo($imgInfo[1]); ?>"

		
	<?php $i++; endforeach; }?>

</script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="/js/functions.min.js"></script>
</html>
