//Anonymous function to wrap around your function to avoid conflict
(function($){
 
    //Attach this new method to jQuery
    $.fn.extend({
         
        //The function - pass the options variable to the function
        jsliderelatedposts: function(options) {
 
            //Set the default values, use comma to separate the settings
            var defaults = {
				 speed: 1000,  
				 scrolltrigger: 0.75,
				 smartwidth: true
            }
                 
            var options =  $.extend(defaults, options);
 
            return this.each(function() {
			
                var o = options;
				var animatesliderdiv = $(this);
				var jslide_width = animatesliderdiv.width();
				
				//IE fixes (div width issues)
				if ( $.browser.msie ) {
				
					if (o.smartwidth) {
						//smart width
						jslide_width = jslide_width * 0.58; //0.53 //0.422
					}
					else {
						//full width
						jslide_width = $(window).width();
					}
					
					animatesliderdiv.css({position: "absolute", width: jslide_width, right: "-"+jslide_width});
					animatesliderdiv.addClass('fixie');
					
				} else {
				
					if (!o.smartwidth) {
					
						//full width for browsers other than IE
						jslide_width = $(window).width();
						
					}
					
					animatesliderdiv.css({position: "fixed", width: jslide_width, right: "-"+jslide_width});
					
				}
				
				var webpage = $("body");
				var webpage_height = webpage.height();
				//show the window after % of the web page is scrolled.
				var trigger_height = webpage_height * o.scrolltrigger;

				//function to catch the user scroll
				var is_animating = false;
				var is_visible = false;
				
				$(window).scroll(function(){
				
					//dont stop the animation in action
					if (!is_animating) {
					
						if (!is_visible) {
						
							//reaching the bottom of page trigger
							if ($(window).scrollTop() > (webpage_height-trigger_height)) {
							
								showjsrp_related();
								
							}
							
						}else {
						
							//reaching top of page trigger
							if ($(window).scrollTop() < (webpage_height-trigger_height)) {
							
								hidejsrp_related();
								
							}	
						}
					}
				}); 
				
				function ishorizonalscrollpresent() {
				
					if (document.documentElement.scrollWidth === document.documentElement.clientWidth) {
					
						//There is no hoz scrollbar
						return false;
						
					} else {
					
						return false;
						
					}
					
				}
				
				function showjsrp_related() {
				
					is_animating = true;
					animatesliderdiv.show(); //show the window
					
					// if hoz scroll is not present, hide x scroll 
					if (ishorizonalscrollpresent() == false) { $('body').addClass('hidexscroll'); }
					
					animatesliderdiv.animate({
						right: '+='+jslide_width,
						opacity: 1
					}, o.speed, function() {
						// Animation complete.
						is_animating = false;
						is_visible = true;
					});
				}
				
				function hidejsrp_related() {
				
					$('body').addClass('hidexscroll'); // hide x scroll
					is_animating = true;
					
					animatesliderdiv.animate({
						right: '-='+jslide_width,
						opacity: 0
					}, o.speed, function() {
						// Animation complete.
						animatesliderdiv.hide();
						is_animating = false;
						is_visible = false;
					});
					
				}
				
				$("#jsrp_related-close").click(function(){
					hidejsrp_related();
				});

            });
        }
    });
     
})(jQuery);
