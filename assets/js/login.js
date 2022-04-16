$(function() {

    $("#login_form").parsley();

    $("#login_button").on("click", function(e){

        let notyf = new Notyf({duration: 1000, position: {x: 'right', y: 'top',}});

        let username = $("#username").val();
        let password = $("#password").val();

        if(username.trim() === "" && password.trim() === ""){
            notyf.error("All fields are required");
            return;
        }

        if (username.trim() === ""){
            notyf.error("Username is required");
            return;
        }

        if(password.trim() === ""){
            notyf.error("Password is required");
            return;
        }

        password = CryptoJS.SHA512(password).toString();

        $.ajax({
            url: 'sendData',
            type: "POST",
            data: {
                action: 'userLogin',
                username: username,
                password: password
            },
            beforeSend: function(){
                //TODO add before send
            },
            success: function(response){
               if(response === "true"){
                   window.location = 'index.php';
               } else {
                   notyf.error(response);
               }

            }
        })

        });
});