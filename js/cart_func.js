$(document).ready(function(){
    $('.dropdown-menu').on('click', function(event){
        event.stopPropagation();
    });
    $('.bottom-menu').mouseenter(function(){
        $(this).children().css({'color': 'rgb(3, 172, 14)'});
    });
    $('.bottom-menu').mouseleave(function(){
        $(this).children().css({'color': 'rgba(49, 53, 59, 0.32)'});
    });
});