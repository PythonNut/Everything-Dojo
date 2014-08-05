// JavaScript Document
$(document).ready(function(){
	for(i=2;i<=4;i++){
		$("#manage-"+i).hide();
	}
	$("#header-1").click(function(){
		$("#manage-1").slideToggle(350, function(){
        if($(this).is(':visible')){
            $('#header-1').css('background-image','url(../../images/up-arrow.png)');
        } else {
            $('#header-1').css('background-image','url(../../images/down-arrow.png)');
        }
    });
	});
	$("#header-2").click(function(){
		$("#manage-2").slideToggle(350, function(){
        if($(this).is(':visible')){
            $('#header-2').css('background-image','url(../../images/up-arrow.png)');
        } else {
            $('#header-2').css('background-image','url(../../images/down-arrow.png)');
        }
    });
	});
	$("#header-3").click(function(){
		$("#manage-3").slideToggle(350, function(){
        if($(this).is(':visible')){
            $('#header-3').css('background-image','url(../../images/up-arrow.png)');
        } else {
            $('#header-3').css('background-image','url(../../images/down-arrow.png)');
        }
    });
	});
	$("#header-4").click(function(){
		$("#manage-4").slideToggle(350, function(){
        if($(this).is(':visible')){
            $('#header-4').css('background-image','url(../../images/up-arrow.png)');
        } else {
            $('#header-4').css('background-image','url(../../images/down-arrow.png)');
        }
    });
	});
});