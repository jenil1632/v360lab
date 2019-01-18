let toggle = false;

  $('.active').on("click", ()=>{
    if($(window).width()<=771)
    {
    event.stopPropagation();
    if(toggle==false)
    {
    $('li.active').siblings().removeClass("passive");
    $('#sub_dropdown').toggle();
    $('#sub_dropup').toggle();
    toggle = true;
  }
  else{
    $('li.active').siblings().addClass("passive");
    $('#sub_dropdown').toggle();
    $('#sub_dropup').toggle();
    toggle = false;
  }
}
  });

  $(document).on('click', ()=>{
    if($(window).width()<=771)
    {
    if(toggle==true)
    {
      $('li.active').siblings().addClass("passive");
      $('#sub_dropdown').toggle();
      $('#sub_dropup').toggle();
      toggle = false;
    }
  }
  });


if($(window).width()>771)
{
  $('#sub_dropdown').hide();
  $('#sub_dropup').hide();
  toggle = false;
}

jQuery(window).resize(function () {
    var screen = $(window)
    if (screen.width() > 771) {
        $('#sub_dropdown').hide();
        $('#sub_dropup').hide();
        toggle = false;
    }
    else{
      $('#sub_dropdown').show();
      $('#sub_dropup').hide();
    }
});
