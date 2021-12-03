    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->


    <style type="text/css">
        #table_results{
            margin: 5% 6% 0% 6%;
        }
        #table_results .err{
            margin-bottom: 0px;
        }    
        #table_results table,
        #table_results table tr{
            border-collapse: collapse;
            border: none;
            width: 100%;
        }    
        #table_results table col:nth-child(1){
            width: 3%;
        }
        #table_results table col:nth-child(2){
            width: 25%;
        }
        /*#table_results table col:nth-child(3){
            width: 35%;
        }
        #table_results table col:nth-child(4){
            width: 20%;
        }*/
        #table_results table col:nth-child(5){
            width: auto;
        }
        #table_results table tr{
            border-bottom: 1px solid #1b9ce3;
            margin-bottom: 1%;
        }    
        #table_results table tr th:nth-child(1),
        #table_results table tr td:nth-child(1){
            text-align: center;
        }    
        #table_results table tr td{
            padding: 1% 0%;   
        }

        #actions{
            padding-top: 3%;
        }
        #actions p{
            margin-top: 2%;
            margin-bottom: 0px;
        }    
        #accommodation_name,
        #action,
        #submit_results{
            width: 20%;
            border: 2px solid #1b9ce3;
            padding: 2px 5px;
            margin-right: 4px;
            outline: none;
        }
        #action{
            width: 10%;
        }
        #submit_results{
            width: 7%;
            color: white;
            background-color: #1b9ce3;
        }
        #submit_results:hover{
            background-color: white;
            color: #1b9ce3;
        }
        
        #footer1, 
        #footer2{display: none;}
        #footer3{margin-bottom: 0px;}
        #footer4{margin-top: 0px;}
    </style>
    <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
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
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Momo's Place</td>
                        <td>22 End Street, Doornfontein, Johannesburg, 2001</td>
                        <td><span style="color: red">Rejected</span></td>
                        <td>16 Jun 2020</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>West Liffe Residence</td>
                        <td>16 Thabo's Street, Pretoria, 5547</td>
                        <td><span style="color: blue">Pending <i>Your</i> approval/rejection</span></td>
                        <td>02 May 2021</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>West Liffe Residence</td>
                        <td>101 Smith Street, Hillbrow, Johannesburg, 2001</td>
                        <td><span style="color: green"><i>You</i> Accepted offer</span></td>
                        <td>16 Dec 2021</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>West Liffe Residence</td>
                        <td>101 Smith Street, Hillbrow, Johannesburg, 2001</td>
                        <td><span style="color: red"><i>You</i> Rejected offer</span></td>
                        <td>16 Dec 2021</td>
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
</body>      
</html>