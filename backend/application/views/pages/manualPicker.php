<html>
    <head>
        <title>view appointment details</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>js/style.css"/>
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css"/>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
       
        <script type="text/javascript">
            $(function() {
                $(".datepicker").datepicker({
                    dateFormat: 'yy-mm-dd'
                });
               
            });
        </script>
        </head>
  
        <body>
         <?php
            echo "<form id='form' name='form' method='post'  action=" . base_url() . "logger/getPeopleAtTimeForm>";
            ?>
            <label id ="pdesc_txt">Start Date:</label>

            <input type="text" class="datepicker" placeholder="Start Date" name="startDate"/>

            <label id ="pdesc_txt">End Date:</label>

            <input type="text" class="datepicker" placeholder="End Date" name="endDate"/>
          
            <input type="submit" name="buttonSubmit" id="submit_btn" value="Submit" onclick="">

            </form>
            </body>
</html>
