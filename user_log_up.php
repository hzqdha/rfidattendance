<?php  
session_start();
?>
<div class="table-responsive" style="max-height: 500px;"> 
  <table class="table">
    <thead class="table-primary">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Card UID</th>
        <th>DEPARTMENT</th>
        <th>Class</th>
        <th>Room</th>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
      </tr>
    </thead>
    <tbody class="table-secondary">
      <?php

        //Connect to database
        require'connectDB.php';
        $searchQuery = " ";
        $Start_date = " ";
        $End_date = " ";
        $Start_time = " ";
        $End_time = " ";
        $Card_sel = " ";

        if (isset($_POST['log_date'])) {
          //Start date filter
          if ($_POST['date_sel_start'] != 0) {
              $Start_date = $_POST['date_sel_start'];
              $_SESSION['searchQuery'] = "users_logs.checkindate='".$Start_date."'";
          }
          else{
              $Start_date = date("Y-m-d");
              $_SESSION['searchQuery'] = "users_logs.checkindate='".date("Y-m-d")."'";
          }
          //End date filter
          if ($_POST['date_sel_end'] != 0) {
              $End_date = $_POST['date_sel_end'];
              $_SESSION['searchQuery'] = "users_logs.checkindate BETWEEN '".$Start_date."' AND '".$End_date."'";
          }
          //Time-In filter
          if ($_POST['time_sel'] == "Time_in") {
            //Start time filter
            if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
                $Start_time = $_POST['time_sel_start'];
                $_SESSION['searchQuery'] .= " AND users_logs.timein='".$Start_time."'";
            }
            elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
                $Start_time = $_POST['time_sel_start'];
            }
            //End time filter
            if ($_POST['time_sel_end'] != 0) {
                $End_time = $_POST['time_sel_end'];
                $_SESSION['searchQuery'] .= " AND users_logs.timein BETWEEN '".$Start_time."' AND '".$End_time."'";
            }
          }
          //Time-out filter
          if ($_POST['time_sel'] == "Time_out") {
            //Start time filter
            if ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] == 0) {
                $Start_time = $_POST['time_sel_start'];
                $_SESSION['searchQuery'] .= " AND users_logs.timeout='".$Start_time."'";
            }
            elseif ($_POST['time_sel_start'] != 0 && $_POST['time_sel_end'] != 0) {
                $Start_time = $_POST['time_sel_start'];
            }
            //End time filter
            if ($_POST['time_sel_end'] != 0) {
                $End_time = $_POST['time_sel_end'];
                $_SESSION['searchQuery'] .= " AND users_logs.timeout BETWEEN '".$Start_time."' AND '".$End_time."'";
            }
          }
          //Card filter
          if ($_POST['card_sel'] != 0) {
              $Card_sel = $_POST['card_sel'];
              $_SESSION['searchQuery'] .= " AND users_logs.card_uid='".$Card_sel."'";
          }
          //Department filter
          if ($_POST['device_dep'] != 0) {
              $device_dep = $_POST['device_dep'];
              $_SESSION['searchQuery'] .= " AND users_logs.device_dep='".$device_dep."'";
          }
        }
        
        if ($_POST['select_date'] == 1) {
            $Start_date = date("Y-m-d");
            $_SESSION['searchQuery'] = "users_logs.checkindate='".$Start_date."'";
        }

        // $sql = "SELECT * FROM users_logs WHERE checkindate=? AND pic_date BETWEEN ? AND ? ORDER BY id ASC";
        $sql = "SELECT `users_logs`.`id`, `users_logs`.`username`, `users_logs`.`card_uid`, `users`.`device_dep`, `users`.`class`, `users`.`no_room`, `users_logs`.`checkindate`, `users_logs`.`timein`, `users_logs`.`timeout` FROM users_logs INNER JOIN users ON users_logs.username = users.username WHERE ".$_SESSION['searchQuery']." ORDER BY id DESC";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        }
        else{
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
            if (mysqli_num_rows($resultl) > 0){
                while ($row = mysqli_fetch_assoc($resultl)){
        ?>
                  <TR>
                      <TD><?php echo $row['id'];?></TD>
                      <TD><?php echo $row['username'];?></TD>
                      <TD><?php echo $row['card_uid'];?></TD>
                      <TD><?php echo $row['device_dep'];?></TD>
                      <TD><?php echo $row['class'];?></TD>
                      <TD><?php echo $row['no_room'];?></TD>
                      <TD><?php echo $row['checkindate'];?></TD>
                      <TD><?php echo $row['timeout'];?></TD>
                      <TD><?php echo $row['timein'];?></TD>
                  </TR>
      <?php
                }
            }
        }
        // echo $sql;
      ?>
    </tbody>
  </table>
</div>