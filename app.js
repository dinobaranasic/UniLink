
var forma = document.getElementsByClassName("form-class");
var regSignIntTitle=document.getElementsByClassName("signin-reg");
var btnSi=document.getElementsByName("signInBtn")
// const tl=new TimelineMax({repeat:-1});

$(document).ready(function() {
    console.log($('.form-class'));
    console.log($('.signin-reg')); 
    $(regSignIntTitle).slideDown(400);
    $(forma).fadeIn(400);
    $(btnSi).slideDown(400);
});