// CHECK BROWSER
if (!(window.location.pathname == '/browser-support')) {
  using_ms_browser = navigator.appName == 'Microsoft Internet Explorer' || (navigator.appName == "Netscape" && navigator.appVersion.indexOf('Edge') > -1) || (navigator.appName == "Netscape" && navigator.appVersion.indexOf('Trident') > -1);

  if (using_ms_browser == true){
      window.location.replace("/browser-support");
  }
}


//FADE-IN PAGINA
jQuery(document).ready(function() {
  $('body').addClass("load");
  setTimeout(function() {
    //ANIMATIE INLOGGEN-INSTELLEN FORM
    if ($(window).width() > 700) {
      $('.inloggen-content').css("top" , "calc(50% - 222px)");
    }
  }, 1000);
});


//MAILADRES VOORBEELD | REGISTREREN
$.fn.bindTo = function(element) {
  $(this).keyup(function() {
    element.text($(this).val());
  });
};

$(document).ready(function() {
  $("#username").bindTo($("#output"));
});


//SHOW CONTENT IN BLOCK HOME
$('.sub-content-block').click(function(){
  $('.sub-content-block').removeClass("active");
  $(this).toggleClass("active");
  // e.preventDefault();
});


//BODY OVERLAY
$('.inleveren-annuleren').click(function(){
  $('.body-overlay').css("opacity" , "0");
  $('.body-overlay').css("visibility" , "hidden");
  $('.inleveren-block').css("top" , "-100%");
  $('.inleveren-block').css("visibility" , "hidden");
})
$('.body-overlay').click(function(){
  $('.body-overlay').css("opacity" , "0");
  $('.body-overlay').css("visibility" , "hidden");
  $('.inleveren-block').css("top" , "-100%");
  $('.inleveren-block').css("visibility" , "hidden");
  $('.opdrachten-leerling-block').css("top" , "-100%");
  $('.opdrachten-leerling-block').css("visibility" , "hidden");
})
$('.body-overlay-taak').click(function(){
  $('.body-overlay-taak').css("opacity" , "0");
  $('.body-overlay-taak').css("visibility" , "hidden");
  $('.taak-aanmaken-block').css("top" , "-100%");
  $('.taak-aanmaken-block').css("visibility" , "hidden");
  $(".nieuwe-taak").css("opacity" , "1");
  $(".nieuwe-taak").css("visibility" , "visible");
})

//BODY OVERLAY MELDING
$('.melding-weghalen').click(function(){
  $('.body-overlay').css("opacity" , "0");
  $('.body-overlay').css("visibility" , "hidden");
  $('.body-overlay-taak').css("opacity" , "0");
  $('.body-overlay-taak').css("visibility" , "hidden");
  $('.taak-aanmaken-block').css("top" , "-100%");
  $('.taak-aanmaken-block').css("visibility" , "hidden");
  $('.opdrachten-leerling-block').css("top" , "-100%");
  $('.opdrachten-leerling-block').css("visibility" , "hidden");
  $(".nieuwe-taak").css("opacity" , "1");
  $(".nieuwe-taak").css("visibility" , "visible");
})
$('.melding-weghalen').click(function(){
  $('.body-overlay-melding').css("opacity" , "0");
  $('.body-overlay-melding').css("visibility" , "hidden");
  $('.inleveren-melding').css("top" , "-100%");
  $('.inleveren-melding').css("visibility" , "hidden");
})
$('.body-overlay-melding').click(function(){
  $('.body-overlay-melding').css("opacity" , "0");
  $('.body-overlay-melding').css("visibility" , "hidden");
  $('.inleveren-melding').css("top" , "-100%");
  $('.inleveren-melding').css("visibility" , "hidden");
})
//BODY OVERLAY TAAK AANMAKEN
$(".nieuwe-taak").click(function(){
  $(".nieuwe-taak").css("opacity" , "0");
  $(".nieuwe-taak").css("visibility" , "hidden");
  $(".body-overlay-taak").css("opacity" , "1");
  $(".body-overlay-taak").css("visibility" , "visible");
  $(".taak-aanmaken-block").css("top" , "calc(50% - 240px)");
  $(".taak-aanmaken-block").css("visibility" , "visible");
});

//INLEVEREN-BLOCK-FILENAME
// $('#inleveren-uploaden').change(function() {
//   var i = $(this).prev('label').clone();
//   var file = $('#inleveren-uploaden')[0].files[0].name;
//   $(this).prev('label').text(file);
// });

//UPLOADEN-BLOCK-FILENAME
$('#uploaden-toevoegen').change(function() {
  var i = $(this).prev('label').clone();
  var file = $('#uploaden-toevoegen')[0].files[0].name;
  $(this).prev('label').text(file);
});

//SHOW UITGEBREIDE DETAILS TAKEN
$('.opdrachten-leerling-block-taken').click(function(){
  $('.opdrachten-leerling-block-taken').removeClass("active");
  $(this).toggleClass("active");
  // e.preventDefault();
});



// GEEN # ONCLICK
$(".sub-content-block-inleveren").click(function(e){
   e.preventDefault();
});
$(".sub-content-block-link").click(function(e){
   e.preventDefault();
});


// INSTELLINGEN THEMA KLEUR
$('#thema_donker').click(function(){
  $('.account-content').css("background-color" , "#272727");
  $('.account-content').css("color" , "#fff");
  $('.thema_kleur').css("background-color" , "#2d2d2d");
  $('.thema_kleur').css("color" , "#fff");
  $('.checkmark').css("background-color" , "#272727");
  $('.thema_kleur:hover input ~ .checkmark').css("background-color" , "#e62686");
  $('.thema_kleur input:checked ~ .checkmark').css("background-color" , "#e62686");
  $('.divider').css("border-color" , "#2d2d2d");
})
$('#thema_licht').click(function(){
  $('.account-content').css("background-color" , "#fff");
  $('.account-content').css("color" , "#000");
  $('.thema_kleur').css("background-color" , "#e6e6e6");
  $('.thema_kleur').css("color" , "#000");
  $('.checkmark').css("background-color" , "#fff");
  $('.thema_kleur:hover input ~ .checkmark').css("background-color" , "#e62686");
  $('.thema_kleur input:checked ~ .checkmark').css("background-color" , "#e62686");
  $('.divider').css("border-color" , "#e6e6e6");
})

// $('.melding-weghalen').click(function() {
//     location.reload();
// });

//INSTELLINGEN INFO JAARTALLEN
// var instellingenInfo = document.getElementById("instellingen-copyright");
// var huidigJaar = new Date();
// instellingenInfo.innerHTML = '<p>© 2017 - ' + huidigJaar.getFullYear() + ' RBR Development<br><a href="https://ma-web.nl/" target="_blank">Mediacollege Amsterdam</a><p>';





//FOOTER JAARTAL
var mijnDiv = document.getElementById("copyright");
var datum = new Date();
mijnDiv.innerHTML = 'Copyright &#169 ' + datum.getFullYear() + ' | <a href="https://www.ma-web.nl/" target="_blank">Mediacollege</a> | <a href="./over">Over Ons</a>';

//
// //PASSWORD HERHALEN | AANMAKEN
// var password = document.getElementById("password"),
//     confirm_password = document.getElementById("password-herhalen");
//
// function validatePassword(){
//  if (password.value != confirm_password.value) {
//    confirm_password.setCustomValidity("Wachtwoorden komen niet overeen");
//  } else {
//    confirm_password.setCustomValidity(' ');
//  }
// }
//
// password.onchange = validatePassword;
// confirm_password.onkeyup = validatePassword;


//DISPLAY DATUM HOME
var date = new Date(),
    year = date.getFullYear(),
    month = date.getMonth(),
    day = date.getDay(),
    months = ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"],
    days = ["Zondag", "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag"],
    date = date.getDate();

document.getElementById('datum').innerHTML = days[day] + " " + date + " " + months[month] + " " + year;
