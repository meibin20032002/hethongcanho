jQuery(document).ready(function ($) {
    //scroll sticky menu
    fixedMenu();    
    $(window).resize(function() {
		fixedMenu();
	});
    function fixedMenu(){
        var fixed = $( ".fixed" ).outerHeight();
        $("#header").css("height", fixed);
        
        if (window.matchMedia("screen and (max-width: 992px)").matches) {
			$(".fixed").hide();
            $(".desktop").show();
		}else{
            $(".fixed").show();
            $(".desktop").hide();
		}
    }
});
