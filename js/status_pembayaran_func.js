$(document).ready(function(){
    var counter = 0 ;
    $('.dropdown-menu').on('click', function(event){
        event.stopPropagation();
    });
    $('.bottom-menu').mouseenter(function(){
        $(this).children().css({'color': 'rgb(3, 172, 14)'});
    });
    $('.bottom-menu').mouseleave(function(){
        $(this).children().css({'color': 'rgba(49, 53, 59, 0.32)'});
    });
    $('.plus').click(function(){
        var obj = $(this).closest('.row .text-right');
        
        var className = obj.find('div:eq(3)').attr('class');
        className = className.substr(6,16);
        var counter = parseInt($('.' + className).text());  
        $('.' + className).html(++counter);
        
        var minColor = obj.find('div:eq(2)').find('svg').attr('fill', 'rgb(3, 172, 14)');
    });
    $('.min').ready(function(){
        $('.min').attr('fill','rgba(49, 53, 59, 0.32)');
    });
    $('.min').click(function(){
        var obj = $(this).closest('.row .text-right');
        
        var className = obj.find('div:eq(3)').attr('class');
        className = className.substr(6,16);
        var counter = parseInt($('.' + className).text());  
        if(counter <= 1){
            $('.min').attr('fill','rgba(49, 53, 59, 0.32)');                    
        }
        else{
            $('.min').attr('fill', 'rgb(3, 172, 14)');
            $('.' + className).html(--counter);
            if(counter <= 1){
                $('.min').attr('fill','rgba(49, 53, 59, 0.32)');     
            }                    
        }				
    });
    $('.choice').click(function(){
        var type = $(this).find('.type').text();
        var price = $(this).find('.price').text();
        var obj = $(this).closest('.dropdown').find('button');

        obj.text(type);
        $(this).closest('.dropdown').dropdown('toggle');
    });
});