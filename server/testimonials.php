<?php session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $sql = "SELECT * FROM testimonials WHERE display = \"1\" LIMIT 5";
        require("../includes/conn.inc.php");
        $sql_results = new SQL_results();
        $results = $sql_results->results_accommodations($sql);
        $testimonials = [];
        if ($results->num_rows > 0) {
            while($row = $results->fetch_assoc()){
                $temp_testimonial = array("id"=>$row['user_id'], 
                                         "name"=>"", 
                                         "testimonial"=>$row['testimonial'], 
                                         "name_and_organization"=>"  @ " . $row['organization'] . "--", 
                                         "image"=>"avata.png");
                array_push($testimonials, $temp_testimonial);
            }
        }
        if(sizeof($testimonials) > 0){
            echo '<div class="carousel-inner" style="border-right:4px solid lightblue; border-radius:5px; padding-right:5px;" >';
            $first = true;
            foreach($testimonials as $testimonial => $value){
                $user_id = $testimonials[$testimonial]['id'];
                $sql = "SELECT first_name FROM users WHERE id = \"$user_id\" LIMIT 1";
                $results = $sql_results->results_profile($sql);
                if ($results->num_rows > 0) {
                    $row = $results->fetch_assoc();
                    $testimonials[$testimonial]['name'] = "--" . $row['first_name'];
                    $testimonials[$testimonial]['name_and_organization'] = $testimonials[$testimonial]['name'] . $testimonials[$testimonial]['name_and_organization'];
                }
                $sql = "SELECT image FROM display_picture WHERE user_id = \"$user_id\" LIMIT 1";
                $results = $sql_results->results_profile($sql);
                if ($results->num_rows > 0) {
                    $row = $results->fetch_assoc();
                    $testimonials[$testimonial]['image'] = substr($user_id, 5, 15) . "/" . $row['image'];   
                }
                ?>
                <div class="carousel-item <?php echo (($first) ? "active" : ""); ?>">
                    <p>
                        <i><?php echo $testimonials[$testimonial]['testimonial']; ?></i>
                        <br>
                        <strong><i><?php echo $testimonials[$testimonial]['name_and_organization']; ?></i></strong>
                    </p>
                    <div class="image">
                        <img src="./images/users/<?php echo $testimonials[$testimonial]['image']; ?>" 
                                alt="<?php echo $testimonials[$testimonial]['name']; ?>" 
                                style="width: 100%; height:  100%;">
                    </div>
                </div>					
                <?php
                $first = false;
            }
            echo '</div>';
        }
    }else{
        echo "Invalid request";
        return;
    }
?>