<html>
          <?php
          // print_r($chart_data)
          ?>  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['line','bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Number of students'],
          <?php
          foreach($chart_data as $data)
          {
            echo "[".$data['time'].",".$data['count']."]".",";
          }
          ?>
        ]);

        var options = {
          chart: {
            title: 'Log',
            subtitle: 'Number of students logged',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Line(document.getElementById('barchart_material'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="barchart_material" style="width: 900px; height: 500px;"></div>
  </body>
</html>
