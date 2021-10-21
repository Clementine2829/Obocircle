$(document).ready(function(){
    load_main_page();
    
    $("#main_page").click(function(){load_main_page();})
})
function load_main_page(){
    let url = "./management-accommodations/main-page.php";
    let loc = "#displayer";
    send_data(url, displayer, loc);
}