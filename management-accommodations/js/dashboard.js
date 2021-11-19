$(document).ready(function(){
    document.getElementsByClassName('col-md-1')[0].remove();
    document.getElementsByClassName('col-md-1')[0].remove();
    document.getElementsByClassName('col-sm-4')[0].className = "col-sm-5";
    document.getElementsByClassName('col-sm-6')[0].className = "col-sm-7";
    
    load_main_page();
    
    $("#main_page").click(function(){load_main_page();})
    $("#main_page").click(function(){load_main_page();})
    $("#upload_images").click(function(){load_upload_images();})
    $("#add_features").click(function(){load_add_features();})
    $("#applications").click(function(){load_view_applications();})
    
    
    $("#add_new_manager").click(function(){add_new_manager();})
    
    
    $("#stats_applications").click(function(){statistics_applications();})
    $("#stats_accommodation").click(function(){statistics_accommodation();})
    
    
})
function new_accommodation(){
    special_displayer("select-accommodation.php");
/*    let url = "./management-accommodations/upload-images.php?payload=" + $("#payload").val();
    let loc = "#displayer";
    send_data(url, displayer, loc);*/
}
function load_main_page(){
    special_displayer("main-page.php");
}
function load_upload_images(){
    special_displayer("upload-images.php");
}
function load_add_features(){
    special_displayer("add-features.php");
}
function load_view_applications(){
    special_displayer("view-applications.php");
}

function add_new_manager(){
    special_displayer("add-manager.php");
}
function statistics_applications(){
    special_displayer("stats-applications.php");
}
function statistics_accommodation(){
    special_displayer("stats-accommodations.php");
}
function special_displayer(url){
    url = "./management-accommodations/" + url + "?payload=" + $("#payload").val();
    let loc = "#displayer";
    send_data(url, displayer, loc);
}