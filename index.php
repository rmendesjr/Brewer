<?php

if(isset($_GET['page']) && $_GET['page'] == 'archive'){
	require_once('includes/archive.php');
}

else{
	require_once('includes/viewer.php');
}
