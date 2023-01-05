$(function () {

    $("#install_btn").on("click", function (e){

        e.preventDefault();

        alert($("#wizard_form").serialize())

    })

    
});