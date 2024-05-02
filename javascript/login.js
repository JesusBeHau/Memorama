/**
 * Created by Andre on 12/03/2016.
 */


$(function(){
    $("#login").click(function(){

        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        if(username == "" || password== ""){
            verifyUser(null);
            return;
        }

        var data = {
            username: username,
            password: password
        };
        $.ajax({
            url: 'core/php/Login.php',
            data:data,
            type: 'post',
            beforeSend: function () {
                $(loginResponse).html("Procesando, espere por favor...");
            },
            success: function (response) {
                verifyUser(response);
            },
            error:function(){
                alert("Error en el servidor");
            }
        });
    })

    $("#reset-password").click(function() {
        $("#reset-password-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $("#change-password-button").click(function(){
        var username = document.getElementById("userToReset").value;
        var password = document.getElementById("newPassword").value;
        var passwordAgain = document.getElementById("newPasswordAgain").value;

        if(username == "" || password== "" || (password != passwordAgain)){
            console.log("se llama");
            changePassword(null);
            return;
        }

        var data = {
            name: username,
            password: password
        };
        
        $.ajax({
            url: 'core/php/updateUserPassword.php',
            data:data,
            type: 'post',
            beforeSend: function () {
            },
            success: function (response) {
                changePassword(response);
            },
            error:function(){
                alert("Error en el servidor");
            }
        });
    });

    $("#exit-button").click(function(){
        $("#reset-password-modal").modal("hide"); 
    });
});

function verifyUser(response){
    try {
        var userResponse = JSON.parse(response);
        var locationToInsert =  $("#loginResponse");


        if (userResponse !== null) {
            var student = 0;
            var teacher = 1;

            if (userResponse[0].type == student) {
                location.href = "sections/MenuStudent.html";
            } else if (userResponse[0].type == teacher) {
                location.href = "sections/MenuTeacher.html";
            }


        } else {

            insertContentToPage("resources/responseLogin.html", locationToInsert);

        }
    } catch (e){
        console.log(e);
    }
}

function changePassword(response){
    var userResponse = JSON.parse (response);
    var locationToInsert = $("#reset-password-response");
    console.log(userResponse);
    console.log(locationToInsert);
    if(userResponse !== null){
        if(userResponse.status=='success'){
            insertContentToPage("resources/success.html", locationToInsert);
        }else{
            insertContentToPage("resources/error.html", locationToInsert);
        }
    }else{
        insertContentToPage("resources/error.html", locationToInsert);
    }
}