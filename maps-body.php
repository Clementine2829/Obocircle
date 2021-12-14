<?php
$google_maps = [];
foreach($accommodations as $accommodation => $value){
    if(isset($accommodations[$accommodation]["coordinates"])){ 
         $accommo_id = $accommodations[$accommodation]["id"];
        $sql = "SELECT images.image
                FROM (images
                    INNER JOIN accommodation_images ON images.image_id = accommodation_images.image_id)
                WHERE accommodation_images.accommo_id = \"$accommo_id\" LIMIT 1";

        $results = $sql_results->results_accommodations($sql);
        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
             $accommodations[$accommodation]["image"] = $accommodations[$accommodation]["name"] . "/" . $row['image'];
        }
        
        $div_container = '<div class="accommodations">
                            <div class="accommodation">
                                <div class="image">
                                    <img src="./images/accommodation/' . $accommodations[$accommodation]['image'] . '" alt="" style="width: 100%; height: 100%;">
                                </div>
                                <div class="details">
                                <h4>' . $accommodations[$accommodation]['name'] . '</h4>
                                <span class="stars">';
                                    $stars = $accommodations[$accommodation]["stars"];
                                    for($j = 1; $j < 6; $j++){
                                        $div_container .= '<span class="fas fa-star ' . (($stars >= $j) ? "checked" : "") . '"></span>';
                                    }
             $div_container .= '</span>';
                                $nsfas = $accommodations[$accommodation]["nsfas"];
                                if($nsfas == 1)
                                     $div_container .= '<p class="nsfas"><span>NSFAS Accredited</span></p>';                            
                                else  
                                    $div_container .= '<p class="nsfas"><span style="background-color: pink"><del>NSFAS Accredited</del></span></p>';
                                $location = ($accommodations[$accommodation]["location"]) ? $accommodations[$accommodation]["location"] : "Location N/A";
                                $temp_loc = (preg_match("/(<br>)/", $location)) ? explode("<br>", $location) : explode(",", $location);
                                    $location = (isset($temp_loc[2])) ? $temp_loc[2] : "";
            $div_container .= '<p class="location">
                                    <span class="fas fa-map-marker-alt"></span>
                                    <strong>' . $location . '</strong>
                                </p>
                                <button onclick="view_accommodation(\'' . $accommodations[$accommodation]["id"] . '\')" class="view_deal_btn">
                                    VIEW DEAL
                                    <span class="fas fa-angle-right"></span>
                                </button>
                                </div>
                            </div>
                        </div>';
        $temp_coordinates = explode(",", $accommodations[$accommodation]["coordinates"]);
        $lat = (isset($temp_coordinates[0])) ? $temp_coordinates[0]: 0;
        $lng = (isset($temp_coordinates[1])) ? $temp_coordinates[1]: 0;
        $temp_coordates = array(array('lat'=>$lat, 'lng'=>$lng), $div_container);
        array_push($google_maps, $temp_coordates);
    }else continue;    
}
echo json_encode($google_maps);

?>