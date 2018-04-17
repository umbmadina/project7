function sendRequest(data, callback) {
    $.ajax({
        method: "POST",
        url: 'core/request.php',
        data: data
    }).done(function(data) {
        callback(data);
    });
}

$(function(){

    $('.register-submit').click(function() {
        console.log($('#username').val() + " " + $('#password'). val());
        sendRequest(
            {
                'register': true,
                'username': $('#username').val(),
                'password': $('#password'). val(),
            },
            function (data) {
                console.log(data)
                if ( data ) {
                    alert("Registered");
                    location.replace('/calendar/login.html');
                } else {
                    alert ("something went wrong!");
                }
            }
        );
    });

    $('.signin-submit').click(function() {
        sendRequest(
            {
                'sign-in': true,
                'username': $('#username').val(),
                'password': $('#password'). val(),
            },
            function (data) {
                console.log(data)
                if ( data == 1 ) {
                    alert("Signed In");
                    location.replace('/calendar/calendar.html');
                } else {
                    alert ("Something went wrong!");
                }
            }
        );
    });
});