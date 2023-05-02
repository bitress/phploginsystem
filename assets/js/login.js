$(function() {

    var notyf = new Notyf({duration: 1000, position: {x: 'right', y: 'top',}});

    $("#login_form").on("submit", function(e){

        e.preventDefault();


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
                password: password,
                token: $("#token").val()
            },
            beforeSend: function(){
                $("#login_button").html('<i class="fa fa-spinner spin"></i> Logging in... &nbsp;');
            },
            success: function(response){
                console.log(response);

               if(response === "true"){
                   window.location = 'index.php';
               } else {
                   notyf.error(response);
               }

                $("#login_button").html('Log in&nbsp;');

            }
        })

        });


    $("#forgotPasswordBtn").on('click',function(e){
        e.preventDefault()

        let email = $("#forgotPasswordEmail").val();

        if(email.trim() === ""){
            notyf.error("Please enter your email");
            return;
        }

        $.ajax({
            url: 'sendData',
            type: "POST",
            data: {
                action: 'sendResetCode',
                email: email
            },
            beforeSend: function(){
                $("#forgotPasswordBtn").html('<i class="fa fa-spinner spin"></i> Resetting Password... &nbsp;');
            }, success: function(response){

                console.log(response);

                $("#forgotPasswordBtn").html('<i class="fa fa-spinner spin"></i> Reset Password&nbsp;');
            }
        })

    });


});