<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Transactions</title>
 <meta name="Description" content="Transactions and trades for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="brbl transactions, brbl trades">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Trades</h1>
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
          <br>
		  <?php include_once("includes/brbl_logo.php") ?><br><br>		  
		  <?php include_once("includes/world_series_winner.php") ?><br><br>
          <?php include_once("includes/apba_baseball_logo.php") ?>
          <br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
            <?php
            function print_header($query_year) {
               echo "Trades: ";
               $webpage='trades';
               include("includes/year-selector.php");
               echo " <br><br>";
               echo "<table style=\"width: 100%\"><tr>";
               echo "<td width=\"20%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Date</span></td>";               
               echo "<td width=\"80%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Transaction</span></td>";
               echo "</tr>";                
            }
            
            function SQL1($conn,$query_year) {
               
               # Draft Query 
               $querystr= "        
               SELECT DATE_FORMAT(transdate, '%M %d, %Y') AS trade_date, transdate, description 
               FROM trade_summary
               WHERE draft_year=$query_year 
               ORDER BY transdate DESC";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC); 
                 $trade_date = $row['trade_date'];                 
                 $description = $row['description'];                                                          
                 echo "<tr>";
                 echo "<td width=\"20%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$trade_date."</span></td>";                 
                 echo "<td width=\"80%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$description."</span></td>";
                 echo "</tr>";
               } 
               echo "<tr><td></td></tr></table>";
               $result->close();               
               return array($numofrows);
            }
            
            
            // Make a MySQL Connection
            require_once ("/var/www/config/brbl_connect.class.php");
            $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) die($conn->connect_error);  
            // Get request from referring page
            $query_year = $_REQUEST['year'];
                      
            print_header($query_year);
            
            $transaction_data = SQL1($conn, $query_year);
            echo "<br>";
            $conn->close();      
           
           ?> 

           
		  </td>
          <td width="10%"  valign="top" align="center" id="main_column3">
              <?php include("includes/menu.php");  ?>
          </td>

	  </tr>
  </table>
    <?php include("includes/footer.php");  ?>                 
</body>
</html>