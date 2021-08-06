$(function(){
    $.ajax({
        url: "get_DataSellerHome.php",
        method: "GET",
        success: function(result) {
            $('#pesananBaru').text(result.varNewOrder);
            $('#siapDikirim').text(result.varReadyOrder);
            $('#komplainPesanan').text(result.varComplain);
            $('#diskusiBaru').text(result.varDiskusi);
            $('#ulasanBaru').text(result.varUlasan);
        },
        error: function(result) {

        }
    });
});