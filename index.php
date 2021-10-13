    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    
    <!--main-->
    <style rel="stylesheet" type="text/css">
        #main_container{
            margin-top: 6%;
        }
        #main_container h3, 
        #main_container label,
        #search_error{
            margin-left: 2%;
        }
        #main_container .search_keyword,
        #main_container .user,
        #main_container .date,
        #main_container .search{
            display: inline;
            padding: 2% 2%;
            border: 1px solid blue;
            border-radius: 50px;
            margin: 2% 1%; 
        }
        #main_container .search{
            background-color: blue;
        }
        #main_container .search_keyword input{
            width: 32%;
            padding: 1%;
            border: none;
            outline: none;
        }
        #main_container .user select{
            width: 15%;
            padding: 1%;
            border: none;
            outline: none;
        }
        #main_container .date input{
            width: 15%;
            padding: 1%;
            border: none;
            outline: none;
        }
        #main_container .search button{
            width: auto;
            padding: 1%;
            border: none;
            outline: none;
            background-color: blue;
            color: white;
        }
        .err{color: red}
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
                        <input type="text" id="search_keyword" name="search" placeholder="E.g. Johannesburg" >
                    </div>
                    <div class="user">
                        <span class="fas fa-user"></span>
                        <select id="sharing" name="sharing">
                            <option value="any" selected>Any Sharing</option>
                            <option value="double">Double Sharing</option>
                            <option value="single">Single Sharing</option>
                            <option value="multi">Multi-Sharing</option>
                        </select>
                    </div>
                    <div class="date">
                        <input type="date" id="move_in_date" name="move_in_date" >
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
    <!--end main-->

    <!--footer-->
    
    <!--end footer-->   
    
    <!--script-->
    <script type="text/javascript">
        function search_function(){
            $("#search_error").html("");
            let search = $("#search_keyword").val();
            if(search == ""){
                $("#search_error").html("Enter a keyword to search<br>");
                return;
            }else{
                window.location = "./search.php?search=" + search + "&sharing=" + $("#sharing").val() + "&move_in_date=" + $("#move_in_date").val();
                //$("#search_form").submit();
            }
        }
    </script>
</body>      
</html>