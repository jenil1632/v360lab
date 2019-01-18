let flag1 = false;
let flag2 = false;
let flag3 = false;
let flag4 = false;
$("#name").on("blur", ()=>{
  let name = $("#name").val();
  if(name!="")
  {

    $.post("http://www.bawbaw.co/hosting/v360lab/inc/uservalidate.php", {
      user_name: name
    }, (data, status)=>{
      if(data=='invalid')
      {
        flag1 = true;
        $("#name").addClass("redborder");
        $("#name").next().css("display", "block");
      }
    });
  }
});

$("#name").on("focus", ()=>{
  if(flag1==true)
  {
    $("#name").removeClass("redborder");
    $("#name").next().hide();
    $("#name").next().next().hide();
    flag1 = false;
  }
});

function validatepassword(){
  let password = $("#password").val();
if(password.length>6)
{
return true;
}
else {
  flag2 = true;
  $("#password").addClass("redborder");
  $("#password").next().css("display", "block");
  return false;
}
}

$("#password").on("focus", ()=>{
  if(flag2==true)
  {
    $("#password").removeClass("redborder");
    $("#password").next().hide();
    flag2 = false;
  }
});

function confirmpasswordfunc(){
  let confirmpassword = $("#confirmpassword").val();
  let password = $("#password").val();
if(password===confirmpassword)
return true;
else {
  flag3 = true;
  $("#confirmpassword").addClass("redborder");
  $("#confirmpassword").next().css("display", "block");
  return false;
}
}

$("#confirmpassword").on("focus", ()=>{
  if(flag3==true)
  {
    $("#confirmpassword").removeClass("redborder");
    $("#confirmpassword").next().hide();
    flag3 = false;
  }
});

function validateno()
{
  let no = $("#mobilenumber").val();
  let regexp = /\D/;
  if(no.length!=10 || regexp.test(no))
  {
    flag4 = true;
    $("#mobilenumber").addClass("redborder");
    $("#mobilenumber").next().css("display", "block");
    return false;
  }
  else {
    return true;
  }
}

$("#mobilenumber").on("focus", ()=>{
  if(flag4==true)
  {
    $("#mobilenumber").removeClass("redborder");
    $("#mobilenumber").next().hide();
    flag4 = false;
  }
});

function validateuser_name()
{
  let user_name = $("#name").val();
  if(user_name.includes(' ') || user_name.includes('/') || user_name.includes('\\') || user_name.includes(':') || user_name.includes('*') || user_name.includes('?') || user_name.includes('\"') || user_name.includes('<') || user_name.includes('>') || user_name.includes('|') || user_name.includes('=') || user_name.includes(';') || user_name.includes(','))
  {
    flag1 = true;
    $("#name").addClass("redborder");
    $("#name").next().next().css("display", "block");
    return false;
  }
  else {
    return true;
  }
}

function validateform()
{
   if(validatepassword() && confirmpasswordfunc() && flag1==false && validateno() && $("#honey").val()=="" && validateuser_name())
   {
     return true;
   }
   else {
     return false;
   }
}
