function search_function(){
    $("#search_error").html("");
    let search = $("#search_keyword").val();
    if(search == ""){
        $("#search_error").html("Enter a keyword to search<br>");
        return;
    }else{
        window.location = "./search.php?search=" + search + "&sharing=" + $("#sharing").val();
        //$("#search_form").submit();
    }
}