$(document).ready(function(){
    load_main_page();
    
    $("#main_page").click(function(){load_main_page();})
    $("#upload_images").click(function(){load_upload_images();})
    $("#add_features").click(function(){load_add_features();})
    $("#applications").click(function(){load_view_applications();})
    
    
    $("#add_new_manager").click(function(){add_new_manager();})
    
    
})
function load_main_page(){
    let url = "./management-accommodations/main-page.php";
    let loc = "#displayer";
    send_data(url, displayer, loc);
}
function load_upload_images(){
    let url = "./management-accommodations/upload-images.php";
    let loc = "#displayer";
    send_data(url, displayer, loc);
}
function load_add_features(){
    let url = "./management-accommodations/add-features.php";
    let loc = "#displayer";
    send_data(url, displayer, loc);
}
function load_view_applications(){
    let url = "./management-accommodations/view-applications.php";
    let loc = "#displayer";
    send_data(url, displayer, loc);
}


function add_new_manager(){
    let url = "./management-accommodations/add-manager.php";
    let loc = "#displayer";
    send_data(url, displayer, loc);
}