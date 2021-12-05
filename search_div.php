<?php

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $sharing = (isset($_GET['sharing'])) ? $_GET['sharing'] : "";
    $search = (isset($_GET['location']) && $_GET['location'] != "") ? $_GET['location'] : $search;     
    $sql = "";
?>  
<!--main-->
<link rel="stylesheet" type="text/css" href="./css/style-index-search.css">
<style rel="sytlesheet" type="text/css">        
    #main_container{
        margin-top: 2%;
    }        
</style> 
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <div id="main_container">
            <h3>Accommodations all over South Africa. All in one place.</h3>
            <form action="search.php" method="get" id="search_form">
                <label>I am looking for accommodation at: </label><br>
                <span id="search_error" class="err"></span>
                <br>
                <div class="search_keyword">
                    <span class="fas fa-map-marker-alt"></span>
                    <input type="text" id="search_keyword" name="search" value="<?php echo $search; ?>" placeholder="E.g. Johannesburg" >
                </div>
                <div class="user">
                    <span class="fas fa-users"></span>
                    <select id="sharing" name="sharing">
                        <?php
                        echo '<option value="any" ' . (($sharing == "any") ? "selected": "") . '>Any Sharing</option>';
                        echo '<option value="double" ' . (($sharing == "double") ? "selected": "") . '>Double Sharing</option>';
                        echo '<option value="single" ' . (($sharing == "single") ? "selected": "") . '>Single Room</option>';
                        echo '<option value="multi" ' . (($sharing == "multi") ? "selected": "") . '>Multi-Sharing</option>';
                        ?>
                    </select>
                </div>
                <div class="search">
                    <button type="button" onclick="search_function()">
                        <span class="fas fa-search"></span>
                        SEARCH
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm-1"></div>
</div>