$(function() {

    setInterval(function(){
        fetchSidebarMessage();
    }, 3000);



    function fetchSidebarMessage(){

        $.ajax({
            type: 'post',
            url: 'sendData',
            data: {
                action: 'getSidebarMessage',
                id: id
            },
            success: function (res){

            // let data = JSON.parse(res);

            // console.log(data.username);

                $("#message_sidebar").html(res);
                // console.log(res);
            }
        })
    }





});

