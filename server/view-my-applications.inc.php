<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]+$/', $_SESSION['s_id'])){
            $user = $_SESSION['s_id'];
            ?>
                <h4 style="text-align: center; margin-bottom: 3%">View your accommodation applications</h4>
                <p class="err" id="err_msg"></p>
            <?php
                
            $sql = "SELECT new_applicants.accommodation, new_applicants.reg_date, new_applicants.a_status 
                    FROM (application 
                        INNER JOIN new_applicants ON application.app_id = new_applicants.id)
                    WHERE application.id = \"$user\" 
                        AND (new_applicants.a_status = \"0\" OR  new_applicants.a_status = \"1\" OR new_applicants.a_status = \"1\" OR  
                            new_applicants.a_status = \"2\" OR  new_applicants.a_status = \"3\")  
                    LIMIT 20";
            //echo $sql;
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();
            $results = $sql_results->results_applicaations($sql);
            $applications = array();
            $select_options = $message = "";
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()){
                    $temp_applications = array("id"=>$row['accommodation'],
                                               "name"=>"",
                                               "address"=>"",
                                               "status"=>$row['a_status'],
                                               "date"=>date("d M Y", strtotime(substr($row['reg_date'], 0, 10))));
                    array_push($applications, $temp_applications);
                }
                if(sizeof($applications) > 0){
                    ?>
                    <small style='color: gray'><i>Please view in your emails for details about your accommodation application statuses</i></small>
                    <table>
                        <colgroup>
                            <col span="1">
                            <col span="1">
                            <col span="1">
                            <col span="1">
                            <col span="1">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Date <br>approved/<br>rejected</th>
                                <th></th>
                            </tr>
                            <?php
                            $counter = 1;
                            foreach($applications as $application => $value){
                                $accommodation = $applications[$application]['id'];
                                $sql = "SELECT accommodations.name, address.main_address
                                        FROM ( accommodations
                                            INNER JOIN address ON accommodations.id = address.accommo_id)
                                        WHERE accommodations.id = \"$accommodation\" LIMIT 1";
                                //echo $sql;
                                $results = $sql_results->results_accommodations($sql);
                                if ($results->num_rows > 0) {
                                    $row = $results->fetch_assoc();
                                    $applications[$application]['name'] = $row['name'];
                                    $applications[$application]['address'] = $row['main_address'];
                                }
                                if($applications[$application]['address'] != ""){
                                    $temp_address = explode(",", str_replace("<br>", ",", $applications[$application]['address']));
                                    $a_address = "";
                                    for($i = 0; $i < 4; $i++){
                                        if($temp_address[$i] != "") $a_address .= $temp_address[$i] . ", ";
                                        else continue;
                                    }
                                    $applications[$application]['address'] = substr($a_address, 0, (strlen($a_address) - 2));
                                }
                                ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $applications[$application]['name']; ?></td>
                                    <td><?php echo $applications[$application]['address']; ?></td>
                                    <td>
                                        <?php
                                            if($applications[$application]['status'] == 0){
                                                echo '<span style="color: orange">Peding</span>';
                                            }else if($applications[$application]['status'] == 1){
                                                echo '<span style="color: green"><i>You</i> Accepted offer</span>';
                                            }else if($applications[$application]['status'] == 2){
                                                echo '<span style="color: red">Rejected</span>';
                                            }else if($applications[$application]['status'] == 3){
                                                echo '<span style="color: blue">Pending <i>Your</i> approval/rejection</span>';
                                                $select_options .= '<option value="' . $applications[$application]['id'] . '">' .   
                                                                            $applications[$application]['name'] . '</option>';
                                                if($message == ""){
                                                    $message = '<span style="color: blue">Congradulations, one of your applicatoins have been approved. Please select to approve or reject the offer</span>';
                                                }
                                            }else if($applications[$application]['status'] == 4){
                                                echo '<span style="color: red"><i>You</i> Rejected offer</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $applications[$application]['date']; ?></td>
                                    <!-- 22 Apr 2021 -->
                                    <td>
                                        <span class="fas fa-trash" style='color: red' 
                                                onclick="delete_application('<?php echo $applications[$application]['id']; ?>')">
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                $counter++;
                            }
                        ?>
                        </tbody>
                    </table>
                    <span id="temp_message" style="display: none"><?php echo $message; ?></span>
                    <?php 
                    
                    if($select_options != ""){
                        ?>
                        <div id="actions">
                            <p>Select the accommodation you got approved and action to take</p>
                            <small style="color: red">
                                Please note that once you accept/decline an offer, you cannot change that until it's been reviewed by the maanager.
                            </small><br>
                            <span id="err_submit_msg"></span>
                            <select id="accommodation_name">
                                <?php echo $select_options; ?>
                            </select>
                            <select id="action">
                                <option value="approve">Approve</option>
                                <option value="reject">Reject</option>
                            </select>
                            <button id="submit_results">Submit</button>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                $("#err_msg").html($("#temp_message").html());  
                            });
                        </script>
                        <?php
                    }
                }
            }else{
                $message = "<h5>No applications found<h5>
                        <p>You can click <a href='./featured.php'>here</a> to browse for accommodations to apply for one</p>";
                return;
            }
        }else{
            echo "<br><br><br>";
            require_once './offline.html';
            return;
        }
    }else{
        echo "Invalid request";
        return;
    }
?>