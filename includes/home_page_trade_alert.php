		  <?php 
		  // trade alerts

		  // Make a MySQL Connection
          require_once ("/var/www/config/brbl_connect.class.php");
          $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($conn->connect_error) die($conn->connect_error);
           
          //  visiting/home team in this case refers to which team has the series home field advantage
          $querystr= "  
          SELECT description 
          FROM trade_summary 
          ORDER BY trade_id DESC 
          LIMIT 3";
          
          $result = $conn->query($querystr);
          if (!$result) die($conn->error);
          $numofrows = $result->num_rows;
          
          echo "<table width=\"80%\">";
          for($i = 0; $i < $numofrows; $i++) {
             $result->data_seek($i);
             $row = $result->fetch_array(MYSQLI_ASSOC); 
             echo "<tr><td align=\"left\" width=\"100%\">".$row['description']."</td></tr>";
             echo "<tr><td><br></td></tr>";

          }                        
          echo "</table>"; 
          $result->close();   
          $conn->close(); 
          ?>
