		  <?php 
		  // Draft update component

		  // Make a MySQL Connection
          require_once ("/var/www/config/brbl_connect.class.php");
          $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($conn->connect_error) die($conn->connect_error);
           
          //  visiting/home team in this case refers to which team has the series home field advantage
          $querystr= "  
          SELECT s.round,s.al_nl,s.away_team_id,tv.abbrev as visiting_team_abbrev,tv.team_name as visiting_team,
          s.home_team_id,th.abbrev as home_team_abbrev,th.team_name as home_team,
          IF(ISNULL(s.away_win),0,s.away_win) as away_win,IF(ISNULL(s.home_win),0,s.home_win) as home_win 
          FROM series s
          LEFT JOIN team tv ON s.away_team_id=tv.team_id 
          LEFT JOIN team th ON s.home_team_id=th.team_id
          WHERE s.league_year='".$league_year."' AND s.round =  
          (SELECT MAX(round) as round FROM series 
          WHERE league_year='".$league_year."' AND home_win IS NOT NULL AND away_win IS NOT NULL)";
          
          $result = $conn->query($querystr);
          if (!$result) die($conn->error);
          $numofrows = $result->num_rows;
          
          echo "<p><a href=\"year-".$league_year."/post-season/index.php\">BRBL ".$league_year." Post Season</a></p>";
          $league_hold='ZZ';
          echo "<table width=\"80%\">";
          for($i = 0; $i < $numofrows; $i++) {
             $result->data_seek($i);
             $row = $result->fetch_array(MYSQLI_ASSOC); 
             if ($row['al_nl'] != $league_hold) {
                if ($row['al_nl']=='AL') {
                   $league_name='American League';
                }
                else if ($row['al_nl']=='NL') {
                   $league_name='National League';
                }
                else {
                   $league_name='World Series';
                }
                if ($row['round']=='1') {
                   $series_type=' Divisional Series';
                }
                else if ($row['round']=='2') {
                   $series_type=' Championship Series';
                }
                 else {
                   $series_type='';
                }           

                echo "<tr><td align=\"left\" width=\"100%\">";
                echo $league_name.$series_type;
                echo "</td></tr>";
                $league_hold=$row['al_nl'];
             }
             echo "<tr><td align=\"left\" width=\"100%\"><a class=\"style8\" href=\"http://www.brbl-apba.com/teams.php?team=".$row['visiting_team_abbrev']."&view=main&year=".$league_year."\">".$row['visiting_team']."</a>"." "
             .$row['away_win']."</td></tr>";
             echo "<tr><td align=\"left\" width=\"100%\"><a class=\"style8\" href=\"http://www.brbl-apba.com/teams.php?team=".$row['home_team_abbrev']."&view=main&year=".$league_year."\">".$row['home_team']."</a>"." "
             .$row['home_win']."</td></tr>";
             echo "<tr><td><br></td></tr>";

          }                        
          echo "</table>"; 
          $result->close();   
          $conn->close(); 
          ?>
