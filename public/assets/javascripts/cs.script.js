
var touch = false,
    clickEv = 'click';

/* slider product*/
function slider_product() {
	"use strict"; 
	
	if ($(".colpro_1_index-collection-product").length) {
		$(".colpro_1_index-collection-product").owlCarousel({
			navigation: true,
			pagination: false,
			autoPlay: false,
			items: 6,
			slideSpeed: 200,
			paginationSpeed: 800,
			rewindSpeed: 1000,
			itemsDesktop: [1199, 5],
			itemsDesktopSmall: [991, 4],
			itemsTablet: [767, 3],
			itemsTabletSmall: [540, 2],
			itemsMobile: [360, 1],
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
		});
	}
	
	if ($("#gallery_main_qs .qs-vertical-slider ").length) {
		$("#gallery_main_qs .qs-vertical-slider").owlCarousel({
          navigation : true,
          pagination: false,
          items: 3,
          slideSpeed : 200,
          paginationSpeed : 800,
          rewindSpeed : 1000,
          itemsDesktop : [1199,3],
          itemsDesktopSmall : [979,2],
          itemsTablet: [768,2],
          itemsTabletSmall: [540,1],
          itemsMobile : [360,1],
          navigationText: ['<i class="fa fa-angle-left" title="Previous" data-toggle="tooltip" data-placement="top"></i>', '<i class="fa fa-angle-right" title="Next" data-toggle="tooltip" data-placement="top"></i>']
        });
	}
	
	if ($(".home1_protab2_item ").length) {
		$(".home1_protab2_item ").owlCarousel({
			navigation: true,
			pagination: false,
			autoPlay: false,
			items: 4,
			slideSpeed: 200,
			paginationSpeed: 800,
			rewindSpeed: 1000,
			itemsDesktop: [1199, 4],
			itemsDesktopSmall: [991, 3],
			itemsTablet: [767, 3],
			itemsTabletSmall: [600, 2],
			itemsMobile: [360, 1],
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
		});
	}
	if ($(".index-galimg-content").length) {
		$(".index-galimg-content").owlCarousel({
			navigation: true,
			pagination: false,
			autoPlay: false,
			items: 2,
			slideSpeed: 200,
			paginationSpeed: 800,
			rewindSpeed: 1000,
			itemsDesktop: [1199, 2],
			itemsDesktopSmall: [991, 2],
			itemsTablet: [767, 2],
			itemsTabletSmall: [540, 2],
			itemsMobile: [360, 2],
			itemsMobile: [292, 2],
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
		});
	}
	
	if ($(".protab1_item").length) {
		$(".protab1_item").owlCarousel({
			navigation: true,
			pagination: false,
			autoPlay: false,
			items: 4,
			slideSpeed: 200,
			paginationSpeed: 800,
			rewindSpeed: 1000,
			itemsDesktop: [1199, 3],
			itemsDesktopSmall: [991, 3],
			itemsTablet: [767, 3],
			itemsTabletSmall: [600, 2],
			itemsMobile: [360, 1],
			navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
		});
	}
		
    /* Slider Related */
    if ($(".related-body .related-content-inner").length) {
        $(".related-body .related-content-inner").owlCarousel({
            navigation: true,
            pagination: false,
            autoPlay: false,
            items: 6,
            slideSpeed: 200,
            paginationSpeed: 800,
            rewindSpeed: 1000,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [991, 3],
            itemsTablet: [767, 3],
            itemsTabletSmall: [540, 2],
            itemsMobile: [360, 1],
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });
    }

    /* Slider Thumb */
    if ($("#product #featuted-image").length) {
        $("#product #featuted-image").owlCarousel({
            navigation: true,
            pagination: false,
            autoPlay: false,
            items: 1,
            slideSpeed: 200,
            paginationSpeed: 800,
            rewindSpeed: 1000,
            itemsDesktop: [1199, 1],
            itemsDesktopSmall: [979, 1],
            itemsTablet: [768, 1],
            itemsTabletSmall: [540, 1],
            itemsMobile: [360, 1],
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });
    }

    /* Slider Relatedpro */
    if ($(".related-products .rp-slider").length) {
        $(".related-products .rp-slider").owlCarousel({
            navigation: true,
            pagination: false,
            autoPlay: false,
            items: 6,
            slideSpeed: 200,
            paginationSpeed: 800,
            rewindSpeed: 1000,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [991, 3],
            itemsTablet: [767, 3],
            itemsTabletSmall: [540, 2],
            itemsMobile: [360, 1],
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });
    }

}

function slider_blog() {
	"use strict"; 
	
    /* Slider Related */
    if ($(".related-article-body .related-content-inner").length) {
        $(".related-article-body .related-content-inner").owlCarousel({
            navigation: true,
            pagination: false,
            autoPlay: false,
            items: 4,
            slideSpeed: 200,
            paginationSpeed: 800,
            rewindSpeed: 1000,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [991, 3],
            itemsTablet: [767, 3],
            itemsTabletSmall: [540, 2],
            itemsMobile: [360, 1],
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });
    }
	
	if ($(".bansli_right .right_content").length) {
		$(".bansli_right .right_content").owlCarousel({
            navigation: true,
            pagination: false,
            autoPlay: false,
            items: 1,
            slideSpeed: 200,
            paginationSpeed: 800,
            rewindSpeed: 1000,
            itemsDesktop: [1199, 1],
            itemsDesktopSmall: [979, 1],
            itemsTablet: [768, 1],
            itemsTabletSmall: [540, 1],
            itemsMobile: [360, 1],
            navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
        });
	}
}

function slideshow() {
	"use strict"; 
	
	$('#home_main-slider').carousel({
		interval: false,
		pause: false
	});
	$("#home_main-slider").swipe({
		swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
			if (direction == 'left') $(this).carousel('next');
			if (direction == 'right') $(this).carousel('prev');
		},
		allowPageScroll: "vertical"
	});
}

function handleBlogGridList() {
	"use strict"; 
	
	if ($('#blog_goList').length) {
	$('#blog_goList').on(clickEv, function(e) {
		$(this).parent().find('li').removeClass('active');
		$(this).addClass('active');
		$('.blog-items .article').removeClass('col-sm-6');
		$('.blog-items .article').addClass("blog_List");
		$('.blog-items .article').removeClass("blog_Grid");
	});
	}
	if ($('#blog_goGrid').length) {
	$('#blog_goGrid').on(clickEv, function(e) {
		$(this).parent().find('li').removeClass('active');
		$(this).addClass('active');
		$('.blog-items .article').addClass('col-sm-6');
		$('.blog-items .article').addClass("blog_Grid");
		$('.blog-items .article').removeClass("blog_List");
	});
	}
}
									
/* Handle dropdown box */
function handleDropdown(){
	"use strict";
	
  if($('.dropdown-toggle').length){
	$('.dropdown-toggle').parent().on({
	  mouseenter: function() {
		if(touch == false && getWidthBrowser() > 767 ){
		  $(this).find('.dropdown-menu').stop(true, true).slideDown(300);
		}
	  }, mouseleave: function() {
		if(touch == false && getWidthBrowser() > 767 ){
		  $(this).find('.dropdown-menu').hide();
	    }
	  }
	});
  }

  $('nav .dropdown-menu').each(function(){
    $(this).find('li').last().addClass('last');
  });


  $('.dropdown').on('click', function() {
    if(touch == false && getWidthBrowser() > 767 ){
      var href = $(this).find('.dropdown-link').attr('href');
      window.location = href;
    }
  });

  $('.cart-link').on('click', function() {
    if(touch == false && getWidthBrowser() > 767 ){
      var href = $(this).find('.dropdown-link').attr('href');
      window.location = href;
    }
  });

}

/* Fucntion get width browser */
function getWidthBrowser() {
	"use strict"; 
	
    var myWidth;

    if (typeof(window.innerWidth) == 'number') {
        //Non-IE 
        myWidth = window.innerWidth;
        //myHeight = window.innerHeight; 
    } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        //IE 6+ in 'standards compliant mode' 
        myWidth = document.documentElement.clientWidth;
        //myHeight = document.documentElement.clientHeight; 
    } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
        //IE 4 compatible 
        myWidth = document.body.clientWidth;
        //myHeight = document.body.clientHeight; 
    }

    return myWidth;
}

// handle scroll-to-top button
function handleScrollTop() {
	"use strict"; 
	
    function totop_button(a) {
        var b = $("#scroll-to-top"),
            f = $(".cart-float-right");

        if (a == "on") {
            f.addClass("on fadeInRight ").removeClass("off fadeOutRight");
            b.addClass("on fadeInRight ").removeClass("off fadeOutRight");
        } else {
            f.addClass("off fadeOutRight animated").removeClass("on fadeInRight");
            b.addClass("off fadeOutRight animated").removeClass("on fadeInRight");
        }
    }
    $(window).scroll(function() {
        var b = $(this).scrollTop();
        var c = $(this).height();
        if (b > 0) {
            var d = b + c / 2;
        } else {
            var d = 1;
        }
        if (d < 1e3 && d < c) {
            totop_button("off");
        } else {
            totop_button("on");
        }
    });
    $("#scroll-to-top").on( 'click', function(e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop: 0
        }, 800, 'swing');
    });
}

//newsletter popup
function ModalNewsletter() {
	"use strict"; 
	
	$('#newsletter-popup').modal('toggle');
	$('.nl-wraper-popup').addClass('animated');
	var tnout = 20;
	setTimeout(function() {
		$('#newsletter-popup').modal('hide');
	}, tnout * 1000);
}

function checkcookie() {
	"use strict"; 
	
    $.cookie('mello-cookie', 'deactive', {
        expires: 10
    });
}

/* Handle product quantity */
function handleQuantity() {
	"use strict"; 
	
    if ($('.quantity-wrapper').length) {
        $('.quantity-wrapper').on(clickEv, '.qty-up', function() {
            var $this = $(this);

            var qty = $this.data('src');
            $(qty).val(parseInt($(qty).val()) + 1);
        });
        $('.quantity-wrapper').on(clickEv, '.qty-down', function() {
            var $this = $(this);
            var qty = $this.data('src');

            if (parseInt($(qty).val()) > 1) $(qty).val(parseInt($(qty).val()) - 1);
        });
    }
}

function colorwarches() {
	"use strict"; 
	
    jQuery('.swatch :radio').change(function() {
        var optionIndex = jQuery(this).closest('.swatch').attr('data-option-index');
        var optionValue = jQuery(this).val();
        jQuery(this)
            .closest('form')
            .find('.single-option-selector')
            .eq(optionIndex)
            .val(optionValue)
            .trigger('change');
    });
}

function toggleTagsFilter() {
	"use strict"; 
	
    if (window.innerWidth >= 768) {
        var tagsbutton = document.getElementById('showTagsFilter'),
            tagscontent = document.getElementById('tags-filter-content');
        if (tagsbutton != null) {
            tagsbutton.onclick = function() {
                classie.toggle(this, 'closed');
                classie.toggle(tagscontent, 'tags-closed');
                if (classie.has(this, 'closed')) $('#showTagsFilter').html("Filter <i class='fa fa-angle-down'></i>");
                else $('#showTagsFilter').html("Filter <i class='fa fa-angle-up'></i>");
            };
        }
    }
}


function toggleLeftMenu() {
	"use strict"; 
	
	$('#showLeftPush').on( "click", function() {
		if ($('.mobile-navigation').hasClass('active')) {
			$('.mobile-navigation').removeClass('active');
			$('#showLeftPush').html('<i class="fa fa-bars" aria-hidden="true"></i>');
		} else {
			$('.mobile-navigation').addClass('active');
			$('#showLeftPush').html('<i class="fa fa-times" aria-hidden="true"></i>');
		}
	});
};

/* Function update scroll product thumbs */
function updateScrollThumbsQS() {
	"use strict"; 
	
    if ($('#gallery_main_qs').length) {

        $('#quick-shop-image .fancybox').on(clickEv, function() {
            var _items = [];
            var _index = 0;
            var product_images = $('#gallery_main_qs .image-thumb');
            product_images.each(function(key, val) {
                _items.push({
                    'href': val.href,
                    'title': val.title
                });
                if ($(this).hasClass('active')) {
                    _index = key;
                }
            });
            $.fancybox(_items, {
                closeBtn: true,
                index: _index,
                helpers: {
                    buttons: {}
                }
            });
            return false;
        });

        $('#quick-shop-image').on(clickEv, '.image-thumb', function() {

            var $this = $(this);
            var background = $('.product-image .main-image .main-image-bg');
            var parent = $this.parents('.product-image-wrapper');
            var src_original = $this.attr('data-image-zoom');
            var src_display = $this.attr('data-image');

            background.show();

            parent.find('.image-thumb').removeClass('active');
            $this.addClass('active');

            parent.find('.main-image').find('img').attr('data-zoom-image', src_original);
            parent.find('.main-image').find('img').attr('src', src_display).load(function() {
                background.hide();
            });

            return false;
        });
    }
}

//Change Quantity Quick Show
function change_qs_quantity(qs) {
	"use strict"; 
	
    qs_quantity = qs;
}

function showMenuMobile() {
	"use strict"; 
	
    $('.navigation_mobile .arrow').on( 'click', function() {
        if ($(this).attr('class') == 'arrow class_test') {
            $('.navigation_mobile .arrow').removeClass('class_test');
            $('.navigation_mobile').removeClass('active');
            $('.navigation_mobile').find('.menu-mobile-container').hide("slow");
        } else {
            $('.navigation_mobile .arrow').removeClass('class_test');
            $(this).addClass('class_test');
            $('.navigation_mobile').each(function() {
                if ($(this).find('.arrow').attr('class') == 'arrow class_test') {
                    $(this).find('.menu-mobile-container').show("slow");
                    $(this).addClass('active');
                } else {
                    $(this).find('.menu-mobile-container').hide("slow");
                    $(this).removeClass('active');
                }
            });
        }
    });
}

function show_sidebar(){
	"use strict";
	
	$( ".collection-leftsidebar .sidebar-block" ).each(function( index ) {
	  var check_this=this;
	  $(this).find(".show_sidebar_content").on( 'click', function() {
		if($(this).hasClass("fa-caret-down")){
		  $(this).removeClass("fa-caret-down");
		  $(this).addClass("fa-caret-up");
		  $(check_this).find(".sidebar-title").addClass("active");
		  $(check_this).find(".sidebar-content").show( "slow" );
		}
		else{
		  $(this).addClass("fa-caret-down");
		  $(this).removeClass("fa-caret-up");
		  $(check_this).find(".sidebar-title").removeClass("active");
		  $(check_this).find(".sidebar-content").hide("slow");
		}
	  });
	});

	$( ".filter-tag-group .tag-group" ).each(function( index ) {
	  var check_this=this;
	  $(this).find(".show_filter_content").on( 'click', function() {
		if($(this).html()=="+"){
		  $(this).html("-");
		  $(check_this).find(".filter-title").addClass("active");
		  $(check_this).find(".filter-content").css( "display","block" );
		}
		else{
		  $(this).html("+");
		  $(check_this).find(".filter-title").removeClass("active");
		  $(check_this).find(".filter-content").css( "display","none" );
		}
	  });
	});
}

function showLightBox() {
	"use strict"; 
	
    var $lightbox = $('#lightbox');

    $('[data-target="#lightbox"]').on('click', function(event) {
        var $img = $(this).find('img'),
            src = $img.attr('src'),
            alt = $img.attr('alt'),
            css = {
                'maxWidth': $(window).width() - 100,
                'maxHeight': $(window).height() - 100
            };

        $lightbox.find('.close').addClass('hidden');
        $lightbox.find('img').attr('src', src);
        $lightbox.find('img').attr('alt', alt);
        $lightbox.find('img').css(css);
    });

    $lightbox.on('shown.bs.modal', function(e) {
        var $img = $lightbox.find('img');

        $lightbox.find('.modal-dialog').css({
            'width': $img.width()
        });
        $lightbox.find('.close').removeClass('hidden');
    });
}

function clickTitleZoom() {
	"use strict"; 
	
    $(".image-title-zoom").on("click", function(event) {
        var data_zoom = $(this).attr("data-zoom");
        $("#" + data_zoom).click();
    });
}

function show_video_home2() {
	"use strict"; 
	
    $(".video_2_1492745907172").on("click", function() {
		$.fancybox({
			href: this.href,
			type: $(this).data("type")
		}); // fancybox
		return false
	});
}

function showTooltip(){
	"use strict";
	
	$('[data-toggle="tooltip"]').tooltip();
}

$(window).on('ready', function($) {

	slideshow();
	
	show_video_home2();
	
    showLightBox();

    clickTitleZoom();

    show_sidebar();

    slider_product();

    slider_blog();

    handleDropdown();

    handleScrollTop();

    colorwarches();

    showTooltip();

    handleQuantity();

	handleBlogGridList();

    toggleTagsFilter();


    toggleLeftMenu();

    updateScrollThumbsQS();

    showMenuMobile();

});


$(window).on('load', function() {

    ModalNewsletter();
    $.cookie('mello-cookie', 'active', {
        expires: 10
    });

}); 