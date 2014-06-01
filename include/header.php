<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Everything Dojo - AoPS Blog Resource</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('div#index-database').hover(
        function () {
           $(this).css({"background-color":"#a91c9e"});
		   $(this).css({"cursor":"pointer"});
        }, 
        function () {
        	$(this).css({"background-color":"#cc3ac1"});
    	}
	);
	$('div#index-themizer').hover(
        function () {
           $(this).css({"background-color":"#3cab1e"});
		   $(this).css({"cursor":"pointer"});
        }, 
        function () {
        	$(this).css({"background-color":"#51b835"});
    	}
	);
	$('div#index-tryit').hover(
        function () {
           $(this).css({"background-color":"#ce6417"});
		   $(this).css({"cursor":"pointer"});
        }, 
        function () {
        	$(this).css({"background-color":"#ff6c00"});
    	}
	);
	$('div#index-discuss').hover(
        function () {
           $(this).css({"background-color":"#448ae9"});
		   $(this).css({"cursor":"pointer"});
        }, 
        function () {
        	$(this).css({"background-color":"#509aff"});
    	}
	);			
});
</script>
</head>