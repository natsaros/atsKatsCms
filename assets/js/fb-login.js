(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    }, true);
}

window.fbAsyncInit = function() {
    FB.init({
        appId      : '451388465220236',
        xfbml      : true,
        version    : 'v2.9',
        status     : true
    });

    checkLoginState();
};

function statusChangeCallback(response) {
    if (response.status === 'connected') {
        $('#newCommentSection').fadeIn();
        $('#fbLoginSection').hide();
        // backendFBLogin(response.authResponse.accessToken);
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
    } else {
        $('#fbLoginSection').fadeIn();
        $('#newCommentSection').hide();
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
    }
}

function backendFBLogin(accessToken) {
    FB.api('/me', function(response) {
        // get accessToken and get user profile
    });

}

function fbLogin(){
    FB.login(function(response) {
        checkLoginState();
    }, {scope: 'email,public_profile'});
}

// function fbLogout(url) {
//     FB.getLoginStatus(function(response) {
//         if (response && response.status === 'connected') {
//             FB.logout(function(response) {
//                 var cookies = document.cookie.split(";");
//                 for (var i = 0; i < cookies.length; i++)
//                 {
//                     if(cookies[i].split("=")[0].indexOf("fblo_") != -1)
//                         document.cookie = $.trim(cookies[i].split("=")[0]) +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
//                 }
//                 window.location.href = url;
//             });
//         }
//     }, true);
// }
