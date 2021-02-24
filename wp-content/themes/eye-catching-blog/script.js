jQuery(document).ready(function(){

    /**
    * Check if slick is initialized or not
    */

    if( !jQuery().slick ) {
        return;
    }

    jQuery('.eye_catching_blog_slider').slick({
        infinite: true,
        slidesToShow: bizberg_object.slidesToShowDesktop,
        autoplaySpeed: bizberg_object.autoplaySpeed * 1000,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        autoplay: true,
        speed: bizberg_object.speed,
        loop:true,
        draggable: bizberg_object.draggable,
        responsive: [{
            breakpoint: 1025,
            settings: {
                slidesToShow: bizberg_object.slidesToShowTablet,
                arrows: true,
                dots: false
            }
        }, {
            breakpoint: 500,
            settings: {
                slidesToShow: bizberg_object.slidesToShowMobile,
            }
        }]
    });
});