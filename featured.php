    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <?php require_once('./search_div.php'); ?>
    
    <!--featured body tructure--> 
    <?php require_once('./featured-body'); ?>
    
    
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
	<script src="js/search.js" type="text/javascript"></script>
    <script type="text/javascript">
		var function_type = -1;
		var page = 1;
		var r_type = "";
		var search_val = "";
		var set_url = "accommodations";
		function get_url(){
			return "./server/featured.inc.php?next_page=" + page;
		}
		function set_urls(fun){
			return "next-prev.php?file=" + fun;
/*			if(fun == "main"){
			}else if(fun == "search"){
				return "next-prev.php?file=search";
				
			}
*/		}
    </script>
	<script src="./js/next-prev.js" type="text/javascript"></script>
	<script src="js/featured.js" type="text/javascript"></script>
    <script type="text/javascript">

    </script>

</body>      
</html>