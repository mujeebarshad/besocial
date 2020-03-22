$(".nav li").on("click", function() {
      $(".nav li").removeClass("active");
      $(this).addClass("active");
    });

  $(function() {
    $( ".bt" ).click(function() {
        
      $( ".bt, .lk" ).toggleClass( "press", 1000 );
      $('.bt').css('color','red');    
    });
  });
