function preloadImages(array) {
  $('#loading').show();
    if (!preloadImages.list) {
        preloadImages.list = [];
    }
    var list = preloadImages.list;
    for (var i = 0; i < array.length; i++) {
        var img = new Image();
        img.onload = function() {
            var index = list.indexOf(this);
            if (index !== -1) {
                // remove image from the array once it's loaded
                // for memory consumption reasons
                list.splice(index, 1);
            }
        }
        list.push(img);
        img.src = array[i];
    }
    $('#loading').hide();
}

preloadImages(["img/ring_1.jpg", "img/ring_2.jpg", "img/ring_3.jpg", "img/ring_4.jpg", "img/ring_5.jpg", "img/ring_6.jpg", "img/ring_7.jpg", "img/ring_8.jpg", "img/ring_9.jpg", "img/ring_10.jpg", "img/ring_11.jpg", "img/ring_12.jpg", "img/ring_13.jpg", "img/ring_14.jpg", "img/ring_15.jpg", "img/ring_16.jpg", "img/ring_17.jpg",  "img/ring_18.jpg", "img/ring_19.jpg", "img/ring_20.jpg", "img/ring_21.jpg", "img/ring_22.jpg", "img/ring_23.jpg", "img/ring_24.jpg", "img/ring_25.jpg", "img/ring_26.jpg", "img/ring_27.jpg", "img/ring_28.jpg", "img/ring_29.jpg", "img/ring_30.jpg", "img/ring_31.jpg", "img/ring_32.jpg", "img/ring_33.jpg", "img/ring_34.jpg", "img/ring_35.jpg", "img/ring_36.jpg"]);

var count = 1;
var lastX;
var move;
var rotateImage = false;



//Turn images clockwise
function leftMove()
{
  if(count==36)
  {
    count = 0;
  }
count++;
let source = 'img/ring_' + count + '.jpg';
$('#image360').attr('src', source);
}

//turn images anti-clockwise
function rightMove()
{
  if(count==1)
  {
    count = 37;
  }
count--;
let source = 'img/ring_' + count + '.jpg';
$('#image360').attr('src', source);
}

// event handlers on clicking buttons
$('#leftButton').on('click', ()=>{
  if(rotateImage==true)
  {stopRotate();}
  leftMove()});
$('#rightButton').on('click', ()=>{
  if(rotateImage==true)
  {stopRotate()};
  rightMove()});

//rotation on dragging the image
$('img').on('dragstart', function(event) { event.preventDefault();});
var mouseDown = false;
var prevX;
$('#image360').mousedown(function(e){
  if(rotateImage==true)
  {stopRotate();}
  prevX = e.clientX;
  mouseDown = true;
}).mousemove(function(e){
  if(mouseDown) {
    if(e.clientX-prevX<-6) { leftMove();}
    if(e.clientX-prevX>6) { rightMove();}
    prevX = e.clientX;
  }
}).mouseup(function(){
  mouseDown = false;
}).mouseleave(function(){
  $('#image360').mouseup();
});

//rotation on swiping
$('#image360').on('touchstart', (event)=>{
  if(rotateImage==true)
  {stopRotate()};
  event.preventDefault();
});
$('#image360').bind('touchmove', function (e){
     var currentX = e.originalEvent.touches[0].clientX;
     if(currentX-lastX<-6){
        leftMove();
     }else if(currentX-lastX>6){
        rightMove();
     }
     lastX = currentX;
});

//play buuton
$('#play').on('click', ()=>{
  if(rotateImage==true)
  {
    stopRotate();
  }
  else {
    rotateImage = true;
      move = setInterval(leftMove, 120);
  }
});

//stop rotation
function stopRotate()
{
  rotateImage = false;
  clearInterval(move);
}


//fullscreen images
$('#fullscreen').on('click', ()=>{
    $('#close').show();
  if(navigator.userAgent.match(/(iPad)|(iPhone)|(iPod)/i))
  {
      window.open('http://www.bawbaw.co/hosting/v360lab/fullimg.php?user_name='+user_name+'&product_name='+product_name+'&photonumber='+photonumber+'&imagefiletype='+imagefiletype);
      $('#close').hide();
  }
  if (window.matchMedia("(orientation: portrait)").matches) {
     var i = document.getElementById("image-container");
     if (i.requestFullscreen) {
     	i.requestFullscreen();
     }
     else if(i.webkitRequestFullscreen){
       i.webkitRequestFullscreen();
     }
     else if (i.mozRequestFullScreen) {
     i.mozRequestFullScreen();
    } else if (i.msRequestFullscreen) {
     i.msRequestFullscreen();
    }
      window.screen.orientation.lock('landscape').then(null, function(error) {
        exitFullscreen();
           }
  );
  }
var i = document.getElementById("image-container");
if (i.requestFullscreen) {
	i.requestFullscreen();
  changeCss();
} else if (i.webkitRequestFullscreen) {
	i.webkitRequestFullscreen();
  changeCss();
} else if (i.mozRequestFullScreen) {
	i.mozRequestFullScreen();
  changeCss();
} else if (i.msRequestFullscreen) {
	i.msRequestFullscreen();
  changeCss();
}
});

//close fullscreen
document.addEventListener('fullscreenchange', ()=>{
  if(!document.webkitIsFullScreen && !document.fullscreenElement && !document.mozFullScreen && !document.msFullscreenElement)
  {
    $('#close').hide();
    $('#image360').removeClass('full43');
  }
});
document.addEventListener('webkitfullscreenchange', ()=>{
  if(!document.webkitIsFullScreen && !document.fullscreenElement && !document.mozFullScreen && !document.msFullscreenElement)
  {
    $('#close').hide();
    $('#image360').removeClass('full43');
  }
});
document.addEventListener('mozfullscreenchange', ()=>{
  if(!document.webkitIsFullScreen && !document.fullscreenElement && !document.mozFullScreen && !document.msFullscreenElement)
  {
    $('#close').hide();
    $('#image360').removeClass('full43');
  }
});
document.addEventListener('MSFullscreenchange', ()=>{
  if(!document.webkitIsFullScreen && !document.fullscreenElement && !document.mozFullScreen && !document.msFullscreenElement)
  {
    $('#close').hide();
    $('#image360').removeClass('full43');
  }
});
$('#close').on('click', ()=>{
  $('#close').hide();
  exitFullscreen();
});

function exitFullscreen() {
               if(document.exitFullscreen) {
                  document.exitFullscreen();
                  $('#image360').removeClass('full43');
               } else if(document.mozCancelFullScreen) {
                  document.mozCancelFullScreen();
                  $('#image360').removeClass('full43');
               } else if(document.webkitExitFullscreen) {
                  document.webkitExitFullscreen();
                  $('#image360').removeClass('full43');
               } else if (document.msExitFullscreen) {
                  document.msExitFullscreen();
                  $('#image360').removeClass('full43');
               }
            }
  function changeCss(ratio){
          $('#image360').addClass('full43');
    }
