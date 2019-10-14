function checkReg() {
    var nameRule=/[a-zA-Z]\s{1,21}/g;
    var usernameRule=/[0-9]{1,10}/g;
    var ageRule=/[0-9]{1,3}/g;
    var addressRule=/[a-zA-Z]\s{1,100}/g;
    var passwordRule=/\w*((\%27)|(\’))((\%6F)|o|(\%4F))((\%72)|r|(\%52)){1,16}/g;
    var emailRule=/^\w+((.\w+)|(-\w+))@[A-Za-z0-9]+((.|-)[A-Za-z0-9]+).[A-Za-z0-9]+$/;
    if(!nameRule.test($("#name").val()) &&
        !usernameRule.test($("#username").val())&&
        !ageRule.test($("#age").val())&&
        !addressRule.test($("#address").val())&&
        !passwordRule.test($("#password").val())&&
        !emailRule.test($("#email").val())&&
        $("#password").val()!=""&&
        $("#email").val()!=""
    ){
        return true;
    }else{
        alert("Please enter the correct format as prompted");
        $("#name").val("");
        $("#username").val("");
        $("#age").val("");
        $("#password").val("");
        $("#address").val("");
        $("#email").val("");
        return false;
    }
}