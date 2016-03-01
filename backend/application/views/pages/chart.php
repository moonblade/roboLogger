<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    var CompleteData = [
        <?php
		foreach ($chart_data as $data) {
				print("{name:\"".$data->name."\",start:new Date(".$data->userLoginTime."*1000),end:new Date(".$data->userLogoutTime."*1000)},\n");
				}
		?>
    ]

    var users= [
    		<?php
    		foreach($users as $user)
    		{
    			print("{macId:\"".$user->macId."\",name:\"".$user->name."\"},\n");
    		}
		?>
	]
	function getName(macId) {
		for (user in users)
		{
			user=users[user]
			if(user.macId==macId)
				return user.name
		}
		return "null"
	}
    dataForTable = CompleteData
    function changeName(macId) {
    	document.getElementById('nameSpace').value=getName(macId);
    }

    function changeTime(hours) {
        var fromDate = new Date()
        fromDate.setHours(fromDate.getHours() - hours);
        dataForTable = CompleteData.filter(function(row) {
            return row.end > fromDate;
        });
        // for(var i=0;i<dataForTable.length;++i)
        // {
        // 	if(dataForTable[i].start<fromDate)
        // 		dataForTable[i].start=fromDate
        // }
        drawChart()
    }
    google.charts.load('43', {
        'packages': ['timeline']
    });

    google.charts.setOnLoadCallback(firstDraw);
function firstDraw() {
	changeTime(24)
	drawChart()
}
    function drawChart() {
        var container = document.getElementById('timeline');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({
            type: 'string',
            id: 'Name'
        });
        dataTable.addColumn({
            type: 'datetime',
            id: 'Start'
        });
        dataTable.addColumn({
            type: 'datetime',
            id: 'End'
        });
        for (i = 0; i < dataForTable.length; ++i) {
            tableRow = dataForTable[i]
            dataTable.addRow([
                tableRow.name, tableRow.start, tableRow.end
            ]);

        }
        chart.draw(dataTable);
    }
    </script>
</head>

<body onLoad="changeName(users[0].macId)">
    <div id="body" style="width: 100%; height: 100%;">
        <div id="selectors" style="width: 100%; height: 5%;">
            <div id="macChanger" style="float:left">
            	 <form style="float:left" action="changeName">
	            	<select name="macId" id="macSelector" style="float:left" onLoad="changeName(this.value)" onChange="changeName(this.value)">
			    		<?php
			    		foreach($users as $user)
			    		{
			    			print("<option value=\"".$user->macId."\">".$user->macId." (".$user->name.")</option>\n");
			    		}
						?>
	            	</select>
				  <input id="nameSpace" style="float:left" type="text" name="name">
				  <input style="float:left" type="submit" value="Change Name">
				</form> 
            </div>
            <div id="timeChanger" style="float:right">
                <select onChange="changeTime(this.value)">
                    <!-- <option value=""></option> -->
                    <option value="1">Last hour</option>
                    <option value="2">Last 2 hours</option>
                    <option value="4">Last 4 hours</option>
                    <option value="8">Last 8 hours</option>
                    <option value="12">Last 12 hours</option>
                    <option value="24" selected>Last 24 hours</option>
                    <option value="48">Last 2 Days</option>
                    <option value="96">Last 4 Days</option>
                    <option value="168">Last Week</option>
                    <option value="336">Last 2 Weeks</option>
                    <option value="730">Last Month</option>
                </select>
            </div>
        </div>
        <div id="timeline" style="width: 100%; height: 95%;"></div>
    </div>
</body>

</html>
