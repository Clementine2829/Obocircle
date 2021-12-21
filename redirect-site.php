<?php
    $payload = (isset($_REQUEST['payload'])) ? $_REQUEST['payload'] : "";

    echo '<input type="hidden" id="payload" value="' . $payload . '">';
?>
<p>Redirecting to site, please wait....</p>
<!-- JQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/jquery-3.4.1.js" type="text/javascript"></script>

<script src="js/validate_email.js" type="text/javascript"></script>
<script src="js/footer.js" type="text/javascript"></script>    
<script> 
    (function redir(){
        let url = $('#payload').val();
        url = "./server/redirect-site.inc.php?payload=" + url;
        send_data(url, loader, "");
    }) ();
    function loader(d, l){
        if(d.length > 0){
            let data = JSON.parse(d);
            if(data[0] == "1"){
                window.location = data[1]; //url
            }else if(data[0] == "2"){
                alert("Accommodation does not have a website yet, redirecting to featured list");                
                window.location = "./featured.php";
            }else{
                alert("Internal error occured, redirecting to home page");
            }
        }
    }
</script>