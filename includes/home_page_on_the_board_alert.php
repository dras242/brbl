		  <?php 
		  // Draft update component

		  // Make a MySQL Connection
          require_once ("/var/www/config/brbl_connect.class.php");
          $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($conn->connect_error) die($conn->connect_error);

          // Get On the Board Pick
          $querystr= "           
          SELECT CONCAT(CAST(tb.draft_round AS CHAR(2)),'-',CAST(tb.draft_round_pick AS CHAR(2)),'-',nt.abbrev,': ') as current_pick
          FROM transaction_brbl tb
          LEFT JOIN (SELECT team_id, team_name, abbrev FROM team) nt ON tb.new_team_id=nt.team_id 
          WHERE draft_year='2021' and tb.player_id IS NULL
          ORDER BY tb.draft_round,tb.draft_round_pick";
          
          $result = $conn->query($querystr);
          if (!$result) die($conn->error);
          for($i = 0; $i < 1; $i++) {
             $row = $result->fetch_array(MYSQLI_ASSOC); 
             $on_thb_board = $row['current_pick'];
          }
          $result->close();
          
          $querystr= "  
          SELECT CONCAT(CAST(tb.draft_round AS CHAR(2)),'-',CAST(tb.draft_round_pick AS CHAR(2)),'-',nt.abbrev) as pick,
          CONCAT(p.last_name,', ',p.first_name,' ',p.middle_name,' (',py.position,')') as player
          FROM transaction_brbl tb
          LEFT JOIN player p ON tb.player_id=p.player_id
          LEFT JOIN (SELECT team_id, team_name, abbrev FROM team) nt ON tb.new_team_id=nt.team_id
          LEFT JOIN (SELECT player_id,position FROM player_year WHERE mlb_year='2020') py ON p.player_id=py.player_id
          WHERE draft_year='2021' and tb.player_id IS NOT NULL
          HAVING pick IS NOT NULL
          ORDER BY tb.draft_round desc,tb.draft_round_pick desc";
          
          $result = $conn->query($querystr);
          if (!$result) die($conn->error);
          $numofrows = $result->num_rows;
          if ($numofrows>10) {
             $numofrows=10;
          }     
          echo "<p>";
          echo "Active Pick: ".$on_thb_board."<br><br>";
          for($i = 0; $i < $numofrows; $i++) {
             $result->data_seek($i);
             $row = $result->fetch_array(MYSQLI_ASSOC); 
             $pick = $row['pick'];
             $player = $row['player'];
             echo "".$pick." ".$player."";
             if ($i<$numofrows-1) {
                echo " | ";
             }
          }
          echo "</p>";
          $result->close();
          $conn->close(); 
          ?>
