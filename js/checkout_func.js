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

        // var string = '<b style="font-size:15px;">Kurir Pilihan</b>'+
        //             ' <div style="font-size:14.5px;"><span style="color:rgba(49, 53, 59, 0.32);">Anter Aja'+ 
        //             '(Rp. 19000) </span> &nbsp&nbsp<span> <b style="color:rgb(3, 172, 14); cursor:pointer;">Ubah</b> </span></div>';
        
        // $('.optionCourier').html(string);   
        
    });
   
    // $('svg').on('click','.trigger',function(){//kalau mau klik tag html yang dinamis pakek method on saja 
    //     if(counter % 2 == 0){
    //         var string = '<svg width="18px" height="18px" viewBox="0 0 16 16" class="bi bi-caret-down-fill trigger my-1" fill="currentColor" style="cursor:pointer;" data-toggle="collapse" data-target="#collapseExample" xmlns="http://www.w3.org/2000/svg">'+
    //                 '<path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>';
    //     }
    //     else{
    //         var string = '<svg width="18px" height="18px" viewBox="0 0 16 16" class="bi bi-caret-up-fill trigger my-1" fill="currentColor" style="cursor:pointer;" data-toggle="collapse" data-target="#collapseExample" xmlns="http://www.w3.org/2000/svg">'+
    //                 '<path d="M7.247 4.86l-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/></svg>';
    
    //     }
    
    //     $(this).closest('.row').find('svg').html(string);   			
    //     counter++;
    // });
    // $('.trigger').click(function(){
    //     var string = '<svg width="18px" height="18px" viewBox="0 0 16 16" class="bi bi-caret-up-fill trigger my-1" fill="currentColor" style="cursor:pointer;" data-toggle="collapse" data-target="#collapseExample" xmlns="http://www.w3.org/2000/svg">'+
    //                 '<path d="M7.247 4.86l-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/></svg>';
    
    //     $(this).closest('.row').find('svg').html(string);   
    
    // });
    // $('.remove').click(function(){
    //     var obj = $(this).closest('.root');
    //     obj.remove();
    // });

});