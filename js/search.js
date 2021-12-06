function search_function(){
    $("#search_error").html("");
    let search = $("#search_keyword").val();
    if(search == ""){
        if(window.innerWidth < 500)
            $("#search_error").html("<span style='margin-right: 1%'><br><b style='color: white;'>H</b>Enter a keyword to search</span>");
        else $("#search_error").html("Enter a keyword to search<br>");
        return;
    }else{
        window.location = "./search.php?search=" + search + "&sharing=" + $("#sharing").val();
        //$("#search_form").submit();
    }
}