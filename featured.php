    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->


    <?php require_once('./search_div.php'); ?>













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
    </script>
</body>      
</html>