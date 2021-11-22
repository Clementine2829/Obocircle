
<?php
	if($accommodations) {
		$main_counter = 0;
        foreach ($accommodations as $accommodation => $value) {
            $accommo_id = $accommodations[$accommodation]["id"];
            $sql = "SELECT images.image
                    FROM (images
                        INNER JOIN accommodation_images ON images.image_id = accommodation_images.image_id)
                    WHERE accommodation_images.accommo_id = \"$accommo_id\" LIMIT 15";
            
            $results = $sql_results->results_accommodations($sql);
            $images = "";
            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {
                    if(true){
                        $temp_image = "./images/accommodation/" . $accommodations[$accommodation]["name"] . "/" . $row['image'];
                        $images .= ($images != "") ? "," . $temp_image : $temp_image; 
                    }else continue;
                }
            }else continue; //if no images, do not show
            
            $accommodations[$accommodation]["images"] = explode(",", $images);
            //print_r($accommodations);
            ?>
            <div class="accommodation">
                <div class="images">
                    <!--<div id="accommodation1" class="carousel slide" data-ride="carousel" data-interval="false">//auto-slide off-->
                    <div id="<?php echo 'accommodation' . ($main_counter + 1); ?> " class="carousel slide" data-ride="carousel">
                      <!-- Indicators -->
                      <ul class="carousel-indicators">
                            <?php
                                for($i = 0; $i < sizeof($accommodations[$accommodation]["images"]); $i++){
                                    if($i == 0) echo '<li data-target="#accommodation1" data-slide-to="' . $i . '" class="active"></li>';
                                    else echo '<li data-target="#accommodation1" data-slide-to="' . $i . '"></li>';
                                }
                            ?>
                      </ul>

                      <!-- The slideshow -->
                      <div class="carousel-inner" style="width: 100%; height: 100%;">
                            <?php
                                for($i = 0; $i < sizeof($accommodations[$accommodation]["images"]); $i++){
                                    if($i == 0) echo '<div class="carousel-item active">';
                                    else echo '<div class="carousel-item">';
                                    echo '<img src="' . $accommodations[$accommodation]["images"][$i] . '" 
                                                alt="' . $accommodations[$accommodation]["name"] . '" width="100%" height="100%">
                                    </div>';
                                }
                            ?>
                      </div>

                      <!-- Left and right controls -->
                      <a class="carousel-control-prev" href="#accommodation<?php echo $main_counter; ?>" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                      </a>
                      <a class="carousel-control-next" href="#accommodation1<?php echo $main_counter; ?>" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                      </a>
                    </div>
                </div>
                <div class="map">
                    <div id="google_map_div"></div>
                </div>
                <div class="details">
                    <h4><?php echo $accommodations[$accommodation]["name"]; ?></h4>
                    <span class="stars">
                        <span class="fas fa-star checked"></span>
                        <span class="fas fa-star checked"></span>
                        <span class="fas fa-star checked"></span>
                        <span class="fas fa-star"></span>
                        <span class="fas fa-star"></span>
                    </span><br>
                    <?php 
                        $ratings = $accommodations[$accommodation]["ratings"];
                        if($ratings > 0){
                            echo '<p class="ratings" style="padding: 1% 3%;
                                          margin-right: 2%;
                                          border-radius: 10px;
                                          background-color: blue;
                                          text-align: center;
                                          color: white;
                                          display: inline;">
                                    ' . $ratings . ' </p>';
                            $reviews = $accommodations[$accommodation]["reviews"];
                            $reviews = (reviews == 1) ? " 1 Review" : ' ' . $reviews . " Reviews";
                            echo '<small>' . $reviews . '</small>';
                        }else{
                            echo '<p class="rating" style=" padding: 1% 3%;
                                          border-radius: 10px;
                                          margin-right: 2%;
                                          background-color: lightgray;
                                          text-align: center;
                                          color: white;
                                          display: inline;">
                                    / </p>';
                            echo '<small> 0 Reviews</small>';
                        }
            
                        $nsfas = $accommodations[$accommodation]["nsfas"];
                        if($nsfas == 1)
                            echo '<p class="nsfas"><span>NSFAS Accredited</span></p>';                            
                        else echo '<p class="nsfas"><span style="background-color: pink"><del>NSFAS Accredited</del></span></p>';
                    
                        $location = "Location N/A";
                        $temp_loc = (preg_match("/(<br>)/", $location)) ? explode("<br>", $location) : explode(",", $location);
                        if(isset($temp[2])) $location = $temp_loc[2];
                    ?>
                    <p class="location"><span class="fas fa-map-marker-alt"></span> <strong><?php echo $location; ?></strong></p>
                </div>
                <div class="view_deal">
                    <button onclick="view_accommodation('<?php echo $accommodations[$accommodation]["id"]; ?>')" class="view_deal_btn">
                        VIEW DEAL 
                         <span class="fas fa-angle-right"></span>
                    </button>
                    <div>
                        <?php
                            if($accommodations[$accommodation]['rooms']['double_available'] == 1){
                                ?>
                                    <span class="fas fa-user-friends"></span> 
                                    <span> Double Sharing</span><br>
                                    <span class="price">
                                        R<?php echo $accommodations[$accommodation]['rooms']['double_sharing_amount']; ?>
                                    </span>
                                <?php
                            }else if($accommodations[$accommodation['rooms']['multi_available']] != 1){
                                //default display even though it is not available     
                                ?>
                                    <span class="fas fa-user"></span> 
                                    <span> Double Sharing</span><br>
                                    <span class="price">
                                        R<?php echo $accommodations[$accommodation]['rooms']['single_sharing_amount']; ?>
                                    </span>
                                <?php
                            }else if($accommodations[$accommodation['rooms']['multi_available']] == 1){
                                ?>
                                    <span class="fas fa-users"></span> 
                                    <span> Double Sharing</span><br>
                                    <span class="price">
                                        R<?php echo $accommodations[$accommodation['rooms']['single_sharing_amount']]; ?>
                                    </span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        } 
        $main_counter++;
    }
?>
