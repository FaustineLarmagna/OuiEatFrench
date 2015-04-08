$(document).ready(function (){
    $("#howitworks").click(function (){
        //$(this).animate(function(){
            $('html, body').animate({
                scrollTop: $("#howit").offset().top
            }, 1000);
        //});
    });

    $("#howitworks2").click(function (){
        //$(this).animate(function(){
            $('html, body').animate({
                scrollTop: $("#howit2").offset().top
            }, 1000);
        //});
    });

    $("#join-us").click(function (){
        //$(this).animate(function(){
            $('html, body').animate({
                scrollTop: $("#forms").offset().top
            }, 1000);
        //});
    });

    $("#qui-sommes-nous").click(function (){
        //$(this).animate(function(){
            $('html, body').animate({
                scrollTop: $("#team").offset().top
            }, 1000);
        //});
    });

    (function($){
	    var jump=function(e)
	    {
	       if (e){
	           e.preventDefault();
	           var target = $(this).attr("href");
	       }else{
	           var target = location.hash;
	       }

	       $('html,body').animate(
	       {
	           scrollTop: $(target).offset().top
	       },1000,function()
	       {
	           location.hash = target;
	       });

	    }

	    $('html, body').hide()

	    $(document).ready(function()
	    {
	        $('a[href^=#]').bind("click", jump);

	        if (location.hash){
	            setTimeout(function(){
	                $('html, body').scrollTop(0).show()
	                jump()
	            }, 0);
	        }else{
	          $('html, body').show()
	        }
	    });
	  
	})(jQuery)

	$(function () 
	{
	    var div = $('#headerwrap #slider');
	    var backgrounds = [
	      'url(assets2/img/murephoto2.jpg)', 
	      'url(assets2/img/coccinelle.jpg)',
	      'url(assets2/img/abricot.jpg)',
	      'url(assets2/img/fleur.jpg)'];
	    var current = 0;

	    function nextBackground() {
	    	div.fadeOut(100, function(){
	    		div.css(
	            'background',
	        backgrounds[current = ++current % backgrounds.length]);
	    		div.css('background-size','cover');
				div.css('background-position', 'center center');
	    		div.fadeIn(1000);
	    	});
	        

	        setTimeout(nextBackground, 7000);
	    }
	    setTimeout(nextBackground, 7000);
	    div.css('background', backgrounds[0]);
	    div.css('background-size','cover');
		div.css('background-position', 'center center');
	});
    
});