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


//FONCTION DE CONNEXION

//OUVRIR  L'ONGLET DE CONNEXION 
function openNav(section) {
  if (section==1){
    document.getElementById("login").style.width = "100%";
  }


}

//FERMER L'ONGLET DE CONNEXION
function closeNav(section) {
  if (section==1){
    document.getElementById("login").style.width = "0";
  }
}

