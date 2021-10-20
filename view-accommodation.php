    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

	<link rel="stylesheet" type="text/css" href="./css/style-accommodation-overview.css">
	<link rel="stylesheet" type="text/css" href="./css/style-accommodation-about.css">
	<link rel="stylesheet" type="text/css" href="./css/style-accommodation-reviews.css">

	<link rel="stylesheet" type="text/css" href="./css/style-apply-accommodation.css">
    <!--heading-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="header_btns" class="sticky-top">
                <span class="header_btns">
                    <a href="#">Overview</a> |
                    <a href="#">Gallery</a> |
                    <a href="#">Direction</a> |
                    <a href="#">About</a> |
                    <a href="#">Reviews</a>
                </span>
                <span class="header_btns">
                    <button onclick="window.location='./featured.php'">Accommodations listing</button>
                </span>
           </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <?php
        $accommodation = (isset($_REQUEST['accommodation']) && $_REQUEST['accommodation'] != "") ? $_REQUEST['accommodation'] : "";
    ?>
    <input type="hidden" id="accommodation" value="<?php echo $accommodation; ?>">
    <!--displayer-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="display_accommodation">
            </div>
        </div>
        <div class="col-sm-1"></div>    
    </div>  


    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="btn_apply">
                <br>
                <button onclick="load_apply_form('123')">Apply</button>
                <button id="visit" onclick="visit_site('123');">
                    <span class="fas fa-forward"></span> Visit site
                </button>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>

    <!--template displayer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="display_template"></div>
        </div>
    </div>

    <!--footer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="the_footer"></div>
        </div>
    </div>
    <!--end footer-->   
    <!--script-->
	<script src="./js/validate_email.js" type="text/javascript"></script>
	<script src="./js/footer.js" type="text/javascript"></script>
	<script src="./js/view-accommodation_main.js" type="text/javascript"></script>
	<script src="./js/view-accommodation_ext.js" type="text/javascript"></script>
	<script src="./js/send-accommodation-application.js" type="text/javascript"></script>

    <script type="text/javascript">
        
        function visit_site(url){
            let con = confirm("You are now leaving our website and you visiting a third party website," + 
                                " Our T&Cs and Policies does not apply there."+
                                "\nSo we encourage you to read and understand that third-party website's T&Cs and Policies"+
                                "\nWe also encourage you to use our website to apply for any of the accommodations, " + 
                                " including this one.\nFor more details, please see our Terms of use at the bottom of the page\n" +
                                "Otherwise confirm to continue to visit the third-party website");
            if(con == true) window.location = './redirect-site.php?content_id=' + url;
        }
        function load_apply_form(url){
            load_template();
            url = './server/apply-accommodation.php?accommodation=' + url;
            let loc = "#display_template";
            send_data(url, displayer, loc);
        }
        function load_template(){
            $("#display_template").css({"display": "block"})
            $("#header_btns").css({"display": "none"})
        }
        function close_apply(){
            $("#display_template").css({"display": "none"})
            $("#header_btns").css({"display": "inline-block"})
        }
        
    </script>

</body>      
</html>