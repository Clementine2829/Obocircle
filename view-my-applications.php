    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <?php
            $_SESSION['redir'] = "./view-my-applications.php";
            if(!isset($_SESSION['s_id'])){
                echo "<br><br><br>";
                require_once './offline.html';
                return;
            }
        ?>  
        <link rel="stylesheet" type="text/css" href="./css/style-view-my-accommodation-applications.css">
        <div id="table_results">
            <h4 style="text-align: center; margin-bottom: 3%">View your accommodation applications</h4>
            <p class="err">
                <span style="color: blue">
                    Congradulations, one of your applicatoins have been approved. Please select to approve or reject the offer
                </span>
            </p>
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
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>West Liffe Residence</td>
                        <td>101 Smith Street, Hillbrow, Johannesburg, 2001</td>
                        <td><span style="color: orange">Peding</span></td>
                        <td>22 Apr 2021</td>
                        <td><span class="fas fa-trash" style='color: red' onclick="delete_application('123')"></span></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Momo's Place</td>
                        <td>22 End Street, Doornfontein, Johannesburg, 2001</td>
                        <td><span style="color: red">Rejected</span></td>
                        <td>16 Jun 2020</td>
                        <td><span class="fas fa-trash" style='color: red' onclick="delete_application('123')"></span></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>West Liffe Residence</td>
                        <td>16 Thabo's Street, Pretoria, 5547</td>
                        <td><span style="color: blue">Pending <i>Your</i> approval/rejection</span></td>
                        <td>02 May 2021</td>
                        <td><span class="fas fa-trash" style='color: red' onclick="delete_application('123')"></span></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>West Liffe Residence</td>
                        <td>101 Smith Street, Hillbrow, Johannesburg, 2001</td>
                        <td><span style="color: green"><i>You</i> Accepted offer</span></td>
                        <td>16 Dec 2021</td>
                        <td><span class="fas fa-trash" style='color: red' onclick="delete_application('123')"></span></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>West Liffe Residence</td>
                        <td>101 Smith Street, Hillbrow, Johannesburg, 2001</td>
                        <td><span style="color: red"><i>You</i> Rejected offer</span></td>
                        <td>16 Dec 2021</td>
                        <td><span class="fas fa-trash" style='color: red' onclick="delete_application('123')"></span></td>
                    </tr>
                </tbody>
            </table>
            <div id="actions">
                <p>Select the accommodation you got approved and action to take</p>
                <small style="color: red">
                    Please note that once you accept/decline an offer, you cannot change that until it's been reviewed by the maanager.
                </small><br>
                <select id="accommodation_name">
                    <option value="15Ksh2544S">West life residence</option>
                    <option value="15224WsfDfLS">Momo's Place</option>
                </select>
                <select id="action">
                    <option value="approve">Approve</option>
                    <option value="reject">Reject</option>
                </select>
                <button id="submit_results">Submit</button>
            </div>
        </div>    
    </div>
    <div class="col-sm-1"></div>
    </div>
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
    <script type="text/javascript">
        function delete_application(payload){
            let con = confirm("Are you sure you want to delete this applications? You cannot recover it once deleted");
            if(con == true){
                let url = "./server/delete-application.php?application=" + payload;
                send_data(url, delete_application_helper, "");
            }
        }
        function delete_application_helper(data, loc){
            alert(data);
        }
    </script>
</body>      
</html>