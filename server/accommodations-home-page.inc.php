<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : "";
        if($action == "featured"){
            $sql = "SELECT accommodations.id, accommodations.name, 
                            address.main_address, images.image
                    FROM (((accommodations
                        INNER JOIN address ON accommodations.id = address.accommo_id)
                        INNER JOIN accommodation_images ON accommodations.id = accommodation_images.accommo_id)
                        INNER JOIN images ON accommodation_images.image_id = images.image_id)
                    WHERE accommodations.display = \"1\" 
                    GROUP BY accommodations.id LIMIT 5";
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();
            $results = $sql_results->results_accommodations($sql);
            $accommodations = [];
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()){
                    $temp_accommodation = array("id"=> $row['id'],
                                                "name"=> $row['name'],
                                                "address"=> "",
                                                "stars"=> 0,
                                                "reviews"=> 0,
                                                "image"=> $row['name'] . "/" . $row['image']);
                    $temp_address = explode(",", str_replace("<br>", ',', $row['main_address']));                    
                    if(isset($temp_address[2]) && $temp_address[2] != "") $temp_accommodation["address"] = $temp_address[2];
                    else if(isset($temp_address[1]) && $temp_address[1] != "") $temp_accommodation["address"] = $temp_address[1];
                    else if(isset($temp_address[0]) && $temp_address[0] != "") $temp_accommodation["address"] = $temp_address[0];
                    
                    $temp_accommodation['name'] = (strlen($temp_accommodation['name']) > 30) ? ((substr($temp_accommodation['name'], 0, 25)) . "..") : $temp_accommodation['name']; 
                    array_push($accommodations, $temp_accommodation);
                }
            }  
            echo  '<div class="featured_accommodations">';
            foreach($accommodations as $accommodation => $value){ 
                $temp_accommodation = $accommodations[$accommodation]['id'];
                $sql = "SELECT stars_values, rate_counter
                        FROM star_and_scale_rating 
                        WHERE accommo_id = \"$temp_accommodation\" LIMIT 1";
                $results = $sql_results->results_accommodations($sql);
                $sum_stars = $counter = 0;
                if($results->num_rows > 0){
                    $row = $results->fetch_assoc();
                    $stars = explode(",", $row['stars_values']);
                    $counter = $row['rate_counter'];
                    for($i = 0; $i < (sizeof($stars) - 1);$i++){
                        $sum_stars = $sum_stars + $stars[$i];
                    }
                    $sum_stars = ($sum_stars > 0) ? number_format(($sum_stars / $counter)) : $sum_stars;
                    if($sum_stars > 5) $sum_stars = number_format(0.0);
                    $accommodations[$accommodation]['stars'] = $sum_stars; 
                    $accommodations[$accommodation]['reviews'] = $counter; 
                }
                ?>
                    <div class="accommodation">
                        <div class="image">
                            <a href="view-accommodation.php?accommodation=<?php echo $accommodations[$accommodation]['id']; ?>" target="_blank">
                                <img src="./images/accommodation/<?php echo $accommodations[$accommodation]['image']; ?>" 
                                     alt="<?php echo $accommodations[$accommodation]['name']; ?>" style="width: 100%; height: 100%; ">
                            </a> 
                        </div>
                        <div class="accommodation_detaails">
                            <p>
                                <?php 
                                    echo "<strong>" . $accommodations[$accommodation]['name'] . "</strong><br>";
                                    echo $accommodations[$accommodation]['address'] . '<br>';
                                    $stars = $accommodations[$accommodation]["stars"];
                                    for($j = 1; $j < 6; $j++){
                                        echo '<span class="fas fa-star ' . (($stars >= $j) ? "checked" : "") . '"></span>';
                                    }
                                    $reviews = $accommodations[$accommodation]["reviews"];
                                    $reviews = ($reviews == 1) ? " 1 Review" : ' ' . $reviews . " Reviews";
                                    echo '<small style="color: gray; "><i>' . $reviews . '</i></small>';
                                ?>
                            </p>
                        </div>
                    </div>
                <?php
            }
            echo '</div>';
        }else if($action == "location"){
            $sql = "SELECT accommodations.id, accommodations.name, 
                            address.main_address, images.image
                    FROM (((accommodations
                        INNER JOIN address ON accommodations.id = address.accommo_id)
                        INNER JOIN accommodation_images ON accommodations.id = accommodation_images.accommo_id)
                        INNER JOIN images ON accommodation_images.image_id = images.image_id)
                    WHERE accommodations.display = \"1\" 
                    GROUP BY accommodations.id LIMIT 5";
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();
            $results = $sql_results->results_accommodations($sql);
            $accommodations = [];
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()){
                    $temp_accommodation = array("id"=> $row['id'],
                                                "name"=> $row['name'],
                                                "image"=> $row['name'] . "/" . $row['image']);
                    $temp_accommodation['name'] = (strlen($temp_accommodation['name']) > 30) ? ((substr($temp_accommodation['name'], 0, 25)) . "..") : $temp_accommodation['name']; 
                    array_push($accommodations, $temp_accommodation);
                }
            }
            echo '<div class="accommodations_by_location">';
            foreach($accommodations as $accommodation => $value){                
                ?>
                <div class="accommodation">
                    <div class="image">
                        <a href="view-accommodation.php?accommodation=<?php echo $accommodations[$accommodation]['id']; ?>" target="_blank">
                            <img src="./images/accommodation/<?php echo $accommodations[$accommodation]['image']; ?>" 
                                 alt="<?php echo $accommodations[$accommodation]['name']; ?>" style="width: 100%; height: 100%; ">
                            <div class="accommodation_name"><?php echo $accommodations[$accommodation]['name']; ?></div>
                        </a> 
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        }else if($action == "accommodations"){
             $sql = "SELECT address.main_address
                    FROM (accommodations
                        INNER JOIN address ON accommodations.id = address.accommo_id)
                    WHERE (address.main_address LIKE \"%polokwane%\" OR address.main_address LIKE \"%plk%\" OR 
                            address.main_address LIKE \"%pretoria%\" OR address.main_address LIKE \"%pta%\" OR  
                            address.main_address LIKE \"%johannesburg%\" OR address.main_address LIKE \"%jhb%\" OR  
                            address.main_address LIKE \"%durban%\" OR address.main_address LIKE \"%fadn%\" OR  
                            address.main_address LIKE \"%capetown%\" OR address.main_address LIKE \"%cape town%\" OR
                            address.main_address LIKE \"%cpt%\") 
                            AND accommodations.display = \"1\" 
                    GROUP BY accommodations.id LIMIT 500";
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();
            $results = $sql_results->results_accommodations($sql);
            $accommodations = array("polokwane"=>0,
                                    "johannesburg"=>0,
                                    "pretoria"=>0,
                                    "durban"=>0,
                                    "capetown"=>0);
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()){
                    if(preg_match('/polokwane|plk/i', $row['main_address'])) $accommodations['polokwane']++;
                    else if(preg_match('/johannesburg|jhb/i', $row['main_address'])) $accommodations['johannesburg']++;
                    else if(preg_match('/pretoria|pta/i', $row['main_address'])) $accommodations['pretoria']++;
                    else if(preg_match('/durban|fadn/i', $row['main_address'])) $accommodations['durban']++;
                    else if(preg_match('/capetown|cpt|cape town/i', $row['main_address'])) $accommodations['capetown']++;       
            
                }
            }
            if($accommodations['polokwane'] == 1) $accommodations['polokwane'] = $accommodations['polokwane'] . " Property"; 
            else $accommodations['polokwane'] = $accommodations['polokwane'] . " Properties";
            
            if($accommodations['johannesburg'] == 1) $accommodations['johannesburg'] = $accommodations['johannesburg'] . " Property"; 
            else $accommodations['johannesburg'] = $accommodations['johannesburg'] . " Properties";
            
            if($accommodations['pretoria'] == 1) $accommodations['pretoria'] = $accommodations['pretoria'] . " Property"; 
            else $accommodations['pretoria'] = $accommodations['pretoria'] . " Properties";
            
            if($accommodations['durban'] == 1) $accommodations['durban'] = $accommodations['durban'] . " Property"; 
            else $accommodations['durban'] = $accommodations['durban'] . " Properties";
            
            if($accommodations['capetown'] == 1) $accommodations['capetown'] = $accommodations['capetown'] . " Property"; 
            else $accommodations['capetown'] = $accommodations['capetown'] . " Properties";
            
            echo json_encode($accommodations);
        }else if($action == "heading"){
            ?>
                <small style="float: right; font-style: italic;">
                    Enable location for better accuracy in finding accommodations
                    <span data-toggle="tooltip" data-placement="left" title class="fas fas fa-info-circle" 
                        data-original-title="Click on the lock on the URL bar to grant-access"></span>
                </small><br>
                <p><strong>ACCOMMODATIONS @ JOHANNESBURG</strong> <a href="./featured.php?location=Johannesburg" class="view_more">...VIEW MORE</a></p>
            <?php  
        }else{
            echo "Invalid request";
            return;
        }
    }else{
        echo "Invalid request";
        return;
    }
?>