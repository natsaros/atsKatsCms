(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function checkLoginState(toPostComment) {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response, toPostComment);
    }, true);
}

window.fbAsyncInit = function() {
    FB.init({
        appId      : '451388465220236',
        xfbml      : true,
        version    : 'v2.9',
        status     : true
    });
};

function statusChangeCallback(response, toPostComment) {
    if (response.status === 'connected') {
        // The person is logged both into Facebook and into your app.
        if (!toPostComment){
            $('#loadingImg').fadeIn();
            $('#fbLoginSection').hide();
        }
        backendFBLogin(response.authResponse.accessToken);
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        $('#fbLoginSection').fadeIn();
        $('#loadingImg').hide();
        $('#newCommentSection').hide();
    }
}

function backendFBLogin(accessToken) {
    FB.api('/me', function(response) {
        $.ajax({
            type: "POST",
            url: "/peny/registerFbUser",
            data: {"fbAccessToken" : accessToken},
            success: function() {
                $('#newCommentSection').fadeIn();
                $('#loadingImg').hide();
            }
        });
    });
}

function fbLogin(){
    FB.login(function(response) {
        checkLoginState(false);
    }, {scope: 'email,public_profile'});
}
