    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

	<link rel="stylesheet" type="text/css" href="./css/style-accommodation-overview.css">
    <!--heading-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="header_btns" class="sticky-top">
                <span class="header_btns">
                    <a href="#">Overview</a> |
                    <a href="#">Gallery</a> |
                    <a href="#">Direction</a> |
                    <a href="#">About</a> |
                    <a href="#">Reviews</a>
                </span>
                <span class="header_btns">
                    <button onclick="window.location='./featured.php'">Accommodations listing</button>
                </span>
           </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
<!-- About-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">

        </div>
        <div class="col-sm-1"></div>
    </div>


<!-- Overview
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="accommodation">
                <div id="overview_container">
                    <div class="sub_container">
                        <div class="image">
                            <img src="./images/accommodation/African House/res1.jpg" alt="Africa House" style="width: 100%; height: 100%;">
                            <div onclick="images()">
                                <span class="fas fa-images"></span> More Images
                            </div>
                        </div>
                        <div class="info">
                            <h4>African House</h4>
                            <span class="stars">
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                            </span><br>
                            <p class="ratings" style="padding: 3px 12px;
                                                      margin-right: 2%;
                                                      border-radius: 10px;
                                                      background-color: blue;
                                                      text-align: center;
                                                      color: white;
                                                      display: inline;">
                                6.9 </p>
                            <small>12 Reviews</small>
                            <p class="nsfas"><span><del>NSFAS Accredited</del></span></p>
                            <p class="address">
                                <strong>
                                    23 Main road<br>
                                    Braam<br>
                                    Johannesburg 2525
                                    <span data-toggle="tooltip" data-placement="left" title class="fas fas fa-info-circle" 
                                        data-original-title="To get GPS direction, click on the 'Direction' button at the top"></span>
                                </strong>
                            </p>
                        </div>
                        <div class="price">
                            <div>
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
                                            <th>Room Type</th>
                                            <th>Cash</th>
                                            <th>Bursary</th>
                                            <th>Status</th>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-user"></span> Single Room</td>
                                            <td>R4,350.25</td>
                                            <td>R3,990.00</td>
                                            <td><span style="color: red">Full</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-user-friends"></span> Double Shaing</td>
                                            <td>R3,510.99</td>
                                            <td>R3,990.50</td>
                                            <td><span style="color: blue">Available</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-users"></span> Multi-Sharing</td>
                                            <td>R0.00</td>
                                            <td>R0.00</td>
                                            <td><span style="color: orange">N/A</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="sub_container">
                        <div class="features">
                            <h5>Features</h5>
                            <p>
                                <span>| <span class="fas fa-bed"></span> 1/2/3+ person rooms </span> 
                                <span>| Own/Inroom kitchen </span> 
                                <span>| <span class="fas fa-bath"></span> Commune Sharing bathroom </span> 
                                <span>| Security 24/7 </span>
                                <span>| CCTV </span>
                                <span>| <span class="fas fa-fingerprint"></span> Biometric Access Control </span> 
                                <span>| Fully Furnished </span> 
                                <span>| <span class="fas fa-chess"></span> Sports fields </span> 
                                <span>| <span class="fas fa-child"></span> Recreational/ Entertainment Area </span> 
                                <span>| <span class="fa fa-wifi"></span> Uncapped WiFi </span> 
                                <span>| <span class="fas fa-dumbbell"></span> Free indoor gym </span> 
                                <span><a href="#" onclick="about()">...more</a></span>
                            </p>
                        </div>
                        <div class="about_us">
                            <h5>About us</h5>
                            <p>
                                If you looking for luxurious accommodations that offer the best services of all times i am talking about this accommodations, starting from transporta... <a href="#" onclick="about()">more</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="btn_apply">
                <br>
                <button>Apply</button>
                <button><span class="fas fa-forward"></span> Visit site</button>
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

        
    </script>
</body>      
</html>