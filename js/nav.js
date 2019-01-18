$('#dropdown-arrow, .dropdown-menu').on('click', ()=>{
  $('#mobile-nav').toggle();
});

$(window).on('resize', ()=>{
  if($(window).width()>771)
  {
    $('#mobile-nav').hide();
  }
});
