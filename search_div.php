<?php

    $search = $sharing = "";
    if(isset($_GET['search'])) $search = $_GET['search'];
    if(isset($_GET['sharing'])) $sharing = $_GET['sharing'];
    $search = (isset($_GET['location']) && $_GET['location'] != "") ? $_GET['location'] : "";     
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
                        if($sharing == "any"){
                            echo '<option value="any" selected>Any Sharing</option>';                                
                        }else{   
                            echo '<option value="any">Any Sharing</option>';                                
                        }
                        if($sharing == "double"){
                            echo '<option value="double" selected>Double Sharing</option>';
                        }else{
                            echo '<option value="double">Double Sharing</option>';
                        }
                        if($sharing == "single"){
                            echo '<option value="single" selected>Single Sharing</option>';
                        }else{
                            echo '<option value="single">Single Sharing</option>';
                        }
                        if($sharing == "multi"){
                            echo '<option value="multi" selected>Multi-Sharing</option>';
                        }else{
                            echo '<option value="multi">Multi-Sharing</option>';
                        }
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