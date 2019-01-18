let error = false;
if(location.search!="")
{
  error = true;
  let page = location.search.substring(6);
  if(page=="error")
  {
    $("#error").show();
  }
}

$(document).on("click", ()=>{
  if(error==true)
  {
    error = false;
    $("#error").hide();
    window.location = window.location.pathname;
  }
});
