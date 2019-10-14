function checkSearch() {
    var searchRule=/[a-zA-Z\u4e00-\u9fa5 ]/g;
    if(!searchRule.test($("search").val())){
        return true;
    }else{
        return false;
    }
}