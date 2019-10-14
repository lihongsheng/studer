function checkLoginForm() {
    var usernameRule=/[0-9]{1,10}/g;
    var passwordRule=/[0-9]{1,10}\w*((\%27)|(\’))((\%6F)|o|(\%4F))((\%72)|r|(\%52)){1,16}/g;
    console.log($("#username").val());
    console.log($('#password').val());

    if (!$("#username").val()) {
        alert("Please do not attack this website");
        return false;
    }
    if (!($('#password').val())) {
        alert("Please do not attack this website");
        return false;
    }
    return true;

}