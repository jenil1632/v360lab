$('#add').on('click', ()=>{
  let url = location.search;
  let user_name = url.substring(11);
  window.location = "http://www.bawbaw.co/hosting/v360lab/editproduct.php?user_name=" + user_name;
});

$('#delete').on('click', ()=>{
  let url = location.search;
  let user_name = url.substring(11);
  if(delarray.length==0 && delswitch == false)
  {
  alert('Select products to delete and click the bin button');
  delswitch = true;
  $('.productwrapper').children().addClass('disablecontent');
  }
  else if (delarray.length==0 && delswitch == true) {
    delswitch = false;
    alert('Delete mode is switched off.');
  }
  else {
    let json = JSON.stringify({"arr": delarray});
    $.get('http://www.bawbaw.co/hosting/v360lab/inc/deleteproduct.php?user_name='+user_name+'&arr='+json, ()=>{
      $('.productwrapper').children().removeClass('disablecontent');
      window.location = `http://www.bawbaw.co/hosting/v360lab/album.php?user_name=${user_name}`;
      delswitch = false;
      alert('deleted '+delarray.length+' products');
      delarray =[];
    });
  }
});

let delarray = [];
let delswitch = false;


  $('.productwrapper').on('click', (e)=>{
    if(delswitch==true)
    {
      let product_name = $(e.target).children().eq(1).html();
      if(checkName(product_name))
      {
        $(e.target).css({"background": "#9F0000", "opacity": "0.8"});
      }
      else {
        $(e.target).css({"background": "none", "opacity": "1"});
      }
    }
  });

  function checkName(name)
  {
    for(let i=0; i<delarray.length;i++)
    {
      if(delarray[i]==name)
      {
        delarray.splice(i, 1);
        return false;
      }
    }
    delarray.push(name);
    return true;
  }

  $('.link').on('click', ()=>{
    var cc = $('#cclink').attr('href');
    var dummy = document.createElement('input');
    document.body.appendChild(dummy);
    dummy.value = cc;
    dummy.select();
    document.execCommand('copy');
    dummy.remove();
    alert('Link copied to clipboard');
  });
