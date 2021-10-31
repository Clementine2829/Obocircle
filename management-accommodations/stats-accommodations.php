<style type="text/css">
    .display_a_info{
        margin: 1%;
    }
    .display_a_info,
    .chart{
        width: 100%;
        float: left;
        padding-right: 30%;
    }
    .chart{
        padding-right: 5%;
    }
    .display_a_info table, 
    .display_a_info table tr {
        border-collapse: collapse;
        background-color: lightgray;
        width: 100%;
    }
    .display_a_info table tr th {
        background-color: gray;
    }
    .display_a_info table tr {
        border-top: 1px solid gray;
        padding: 4px 0px;
    }    
    .display_a_info table col:nth-child(1) {
        width: 5%;
    }
    .display_a_info table col:nth-child(2) {
        width: 45%;
    }
    .display_a_info table col:nth-child(3),
    .display_a_info table col:nth-child(4),
    .display_a_info table col:nth-child(5) {
        width: 15%;
    }
    .display_a_info table col:nth-child(6) {
        width: 20%;
    }
    .display_a_info table col:nth-child(7) {
        width: 30%;
    }
    .display_a_info table tr th,
    .display_a_info table tr td{
        padding: 2px 3px;
  5 }
  7 .display_a_info table tr td:nth-child(1),
    .display_a_info table tr td:nth-child(3),
    .display_a_info table tr td:nth-child(4),
    .display_a_info table tr td:nth-child(5),
    .display_a_info table tr td:nth-child(7){
        text-align: center;
    }    
    .display_a_info table .span_action span{
        color: gray; 
        margin-right: 2%;
        cursor: pointer;
    }
    .display_a_info table .span_action span:nth-child(1){
        color: red; 
    }


</style>
<div class="display_a_info">
    <table>
        <colgroup>
            <col span="1">
            <col span="1">
            <col span="1">
            <col span="1">
        </colgroup>
        <tbody>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Pending</th>
                <th>Declined</th>
                <th>Approved</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>1</td>
                <td>West Gate Residence</td>
                <td>5</td>
                <td>19</td>
                <td>48</td>
                <td><span style="color: blue">Active</span></td>
                <td class="span_action">
                    <span class="fas fa-eye-slash"></span>
                    <span class="fas fa-trash"></span>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Lithulie Residence</td>
                <td>0</td>
                <td>22</td>
                <td>13</td>
                <td><span style="color: gray">Hidden</span></td>
                <td class="span_action">
                    <span class="fas fa-eye"></span>
                    <span class="fas fa-trash"></span>
                </td>
            </tr>
            <tr>
                <td>1</td>
                <td>Living @ Rissik</td>
                <td>18</td>
                <td>3</td>
                <td>11</td>
                <td><span style="color: blue">Active</span></td>
                <td class="span_action">
                    <span class="fas fa-eye-slash"></span>
                    <span class="fas fa-trash"></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="chart">
    <?php
        $dataPoints = array( 
            array("label"=>"West Gate Residence", "y"=>75),
            array("label"=>"Lithuli Residence", "y"=>255),
            array("label"=>"Living @ Rissik", "y"=>150)
        ) 
    ?>
    <script type="text/javascript">
        $(document).ready(function(){    
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Number of applications for each accommodation"
                },
                subtitles: [{
                    text: "For this current year (2022)"
                }],
                data: [{
                    type: "pie",
                    yValueFormatString: "#,##0\" Applications\"",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        });
    </script>
    <div id="chartContainer"></div>
</div>