(function($){

  $(document).ready(function(){

      var sliderClient = $('#slider-client'); 
      
      // Init Clients Slider
      if( sliderClient.length != 0 ){
        sliderClient.owlCarousel({
          items:1,
          loop:true,
          autoplay:true,
          autoplayTimeout:3000,
          autoplayHoverPause:true
        });
      }
      
      // Fix Ajax-Loader Contact Form 7 
      $('#form').find('.ajax-loader').insertAfter('.button');
      
      // Animation
      //  - Button
      var $button = $('.button');
      $button.append('<span class="button-arrow"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>');
      // - All
      var wow = new WOW(
        {
          boxClass:     'cc',      
          animateClass: 'animated',
          offset:       0,         
          mobile:       true,      
          live:         true,      
          scrollContainer: null
        }
      );
      wow.init();  
      
  });

})(jQuery);

