//Like - Unlike Button

//Dirty? But its working fine...

$(function(){
  $('.box').on('click',function(){
    if ($(this).text()==' Like'){
      $(this).removeClass('entypo-thumbs-up').addClass('entypo-thumbs-down').text(' Unlike');
    }else{
      $(this).removeClass('entypo-thumbs-down').addClass('entypo-thumbs-up').text(' Like');
    }
  });
});