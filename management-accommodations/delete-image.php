<?php

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if((isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) &&
            (isset($_REQUEST['image_no']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['image_no'])) &&
            (isset($_REQUEST['image']) && preg_match('/^[a-zA-Z0-9]+\.+(jpg|jpeg|png|gif)+$/', $_REQUEST['image']))){
            $payload = $_REQUEST['payload'];
            $image_no = $_REQUEST['image_no'];
            $image = $_REQUEST['image'];
            
            $sql = "DELETE FROM accommodation_images 
                    WHERE accommo_id = \"$payload\" AND image_id = \"$image_no\"";
            require("../includes/conn.inc.php");
            $db_login = new DB_login_updates();
            $connection = $db_login->connect_db("accommodations");
            if ($connection->query($sql)){
                $sql = "DELETE FROM images WHERE image_id = \"$image_no\"";
                if ($connection->query($sql)){
                    //remove image from folder
                    $name = (isset($_REQUEST['file'])) ? $_REQUEST['file'] : ""; 
                    $filename = "../images/accommodation/" . $name . "/" . $image;
                    if(unlink($filename)){
                        //do nothing, all is good
                    }else{
                        echo "Error deleting image, please reload page and try agein";
                        return;                
                    }
                    echo "Image deleted successfully";
                    return;                
                }else{  
                    echo "Error deleting image, please reload page and try agein";
                    return;                
                }   
            }else{
                echo "Error deleting image, please reload page and try agein";
                return;                
            }
            $connection->close();
        }else{
            echo "Error deleting image, please reload page and try agein";
            return;
        }
        
    }else{
        echo "Unknown request"; 
        return;
    }
?>