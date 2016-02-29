<html>
          <?php
          // print_r($chart_data);
				     //      foreach ($chart_data as $data) {
							  // print("[\"".$data->name."\",new Date(".$data->userLoginTime."),new Date(".$data->userLogoutTime.")],\n");
						   //        }
          ?>  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
                  google.charts.load('43', {
                      'packages': ['timeline']
                  });
                  google.charts.setOnLoadCallback(drawChart);

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
                      dataTable.addRows([
                          // ['Washington', new Date(1789, 3, 30), new Date(1797, 2, 4)],
                          // ['Washington', new Date(1800, 3, 30), new Date(1810, 2, 4)],
                          // ['Adams', new Date(1797, 2, 4), new Date(1801, 2, 4)],
                          // ['Jefferson', new Date(1801, 2, 4), new Date(1809, 2, 4)]
	                      <?php
				          foreach ($chart_data as $data) {
							  print("[\"".$data->name."\",new Date(".$data->userLoginTime."*1000),new Date(".$data->userLogoutTime."*1000)],\n");
						          }
						?>
                      ]);
                      chart.draw(dataTable);
                  }
    </script>
  </head>
  <body>
    <div id="timeline" style="width: 900px; height: 500px;"></div>
  </body>
</html>
