// noinspection JSJQueryEfficiency

$(function() {

    var incoming, is_called = false;

    setInterval(function(){
        fetchSidebarMessage();

        if(is_called){
            initChatBox(incoming);
        }

    }, 3000);

    fetchSidebarMessage();

    $("#_chatbox_").hide();

    $(document).on('click', '.getMess', function (e) {

         incoming = $(this).data("incoming");

        initChatBox(incoming);

    });


    function initChatBox(incoming){

        is_called = true;

        fetchChatBox(incoming);
        setChatHeader(incoming);

        $("#_chatbox_").show();

    }

    function setChatHeader(incoming){

        $.ajax({
            type: 'post',
            url: 'sendData',
            data: {
                action: 'getChatHeader',
                id: incoming
            },
            success: function (res){
                var data = JSON.parse(res);
                $(".user-avatar").attr("src",data.avatar);
                $("#user_name").text(data.name);
                $("#receiver_id").val(data.user_id);

            }
        })




    }

    function fetchSidebarMessage(){

        $.ajax({
            type: 'post',
            url: 'sendData',
            data: {
                action: 'getSidebarMessage',
                id: id
            },
            success: function (res){

              var data = JSON.parse(res);
              console.log(data)
                var output = [];
                for(var i=0; i<data.messages.length; i++) {
                    output += buildSideBarMessage(data.messages[i]);
                   }
                $("#message_sidebar").html(output);
            }
        })
    }



    function fetchChatBox(incoming){


        $.ajax({
            type: 'POST',
            url: 'sendData',
            data: {
                action: 'getAllMessages',
                receiver: id,
                sender: incoming
            },
            success: function (data){

                $("#chatbox").html(data);


            }

        })

    }


    $("#send_message").on("click", function (e){

        let message = $("#message_box").val();
        let receiver = $("#receiver_id").val();

        $.ajax({
            type: 'post',
            url: 'sendData',
            data: {
                action: 'sendMessage',
                message: message,
                receiver: receiver
            },
            success: function (res){

                var data = JSON.parse(res);

                $("#chatbox").append(buildChatElement(data));
                $("#message_box").val('');

            }
        })

    })


    function buildChatElement(res){

        var html =  '';
            html += '<div class="chat-message-right pb-4">';
            html += '<div>';
            html += '<img src="'+ res.avatar +'" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">';
            html += '<div class="text-muted small text-nowrap mt-2">'+ res.timestamp +'</div>';
            html += '</div>';
            html += '<div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">';
            html += '     <div class="font-weight-bold mb-1">You</div>';
            html += res.message;
            html += '     </div>';
            html += '  </div>';

            return $(html);

    }




function buildSideBarMessage(res){

   let    html = '<a id="getMess" data-incoming="'+res.user_id+'" class="getMess list-group-item list-group-item-action border-0">';
                           html += '<div class="badge bg-success float-right"></div>';
                           html += '<div class="d-flex align-items-start">';
                           html += '<img src="'+ res.avatar +'" class="rounded-circle mr-1" alt="" width="40" height="40">';
                           html += '<div class="flex-grow-1 ml-3">';
                           html += res.name;
                           if(res.activity === "0"){
                               html += '  <div class="small"><span class="fas fa-circle chat-offline"></span> Offline</div>';
                           } else {
                               html += '  <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>';
                           }

                           if(res.hasConversation){
                               html += '<p class="text-muted small p-0 m-0">'+ res.message +'</p>'
                           } else {
                               html += '<p class="text-muted small p-0 m-0">'+ res.message +'</p>'
                           }
                           html += '   </div>';
                           html += '</div>';
                           html += '</a>';
                      return html;

   }


});

