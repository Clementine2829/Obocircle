    <!--header-->
    <?php require_once('./header.php'); $_SESSION['redir'] = "view-my-applications.php"; ?>
    <!--end header-->
    <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <?php
            $_SESSION['redir'] = "./view-my-applications.php";
            if(!isset($_SESSION['s_id'])){
                echo "<br><br><br>";
                require_once './offline.html';
                return;
            }
        ?>  
        <link rel="stylesheet" type="text/css" href="./css/style-view-my-accommodation-applications.css">
        <div id="table_results"></div>    
    </div>
    <div class="col-sm-1"></div>
    </div>
    <!--footer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="the_footer"></div>
        </div>
    </div>
    <!--end footer-->   
    <!--script-->
	<script src="js/validate_email.js" type="text/javascript"></script>
	<script src="js/footer.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            let url = "./server/view-my-applications.inc.php";
            send_data(url, displayer, "#table_results")
        });
        function delete_application(payload){
            let con = confirm("Are you sure you want to delete this applications? You cannot recover it once deleted");
            if(con == true){
                let url = "./server/manage-application.php?application=" + payload + "&action=delete";
                send_data(url, delete_application_helper, "");
            }
        }
        function delete_application_helper(data, loc){
            alert(data);
            window.location.reload();
        }
        function send_application_response(){
            let accommodation = $("#accommodation_name").val();
            let action = $("#action").val();
            if(accommodation == "" || action == ""){
                $("err_submit_msg").html("Please select both accommodation name and action to take before submit<br>");
                return;
            }else{
                $("err_submit_msg").html("");
            }
            let url = "./server/manage-application.php?accommodation=" + accommodation + "&action=" + action;
            send_data(url, delete_application_helper, "");
        }
        function synch_applications(){
            let accommodation = $("#accommodation_name").val();
            let url = "./server/manage-application.php?accommodation=" + accommodation + "&action=synch-applications";
            send_data(url, synch_apps, "");
        }
        function synch_apps(d, l){
            console.log(d);
            if(d == "found"){
                alert("Applicatoins were found and page will reload to sychronize them");
                window.location.reload();
            }else if(d == "Not found"){
                alert("No applicatoins were found linked to your applications, to help you make things simpler, please make sure you are using the same email you used on signup page, or update your email to the one you used to apply");
            }
        }
    </script>
</body>      
</html>