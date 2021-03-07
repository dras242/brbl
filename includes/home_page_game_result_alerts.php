		  <?php 
		  // Draft update component

		  // Make a MySQL Connection
          require_once ("/var/www/config/brbl_connect.class.php");
          $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($conn->connect_error) die($conn->connect_error);
           
          // Get On the Board Pick
          $querystr= "           
          SELECT al_nl,w_id,away_team, home_team,sum(if(a_runs>h_runs,1,0)) AS a_wins,sum(if(h_runs>a_runs,1,0)) AS h_wins
          FROM (SELECT g.game_id, g.al_nl,g.w_id,a_team.abbrev AS away_team, h_team.abbrev AS home_team, 
          if(isnull(a_score.runs),0,a_score.runs) AS a_runs, if(isnull(h_score.runs),0,h_score.runs) AS h_runs
          FROM game g 
          LEFT JOIN game_team AS a_score ON g.game_id=a_score.game_id and g.team_id_away=a_score.team_id
          LEFT JOIN game_team AS h_score ON g.game_id=h_score.game_id and g.team_id_home=h_score.team_id
          LEFT JOIN team AS a_team ON g.team_id_away=a_team.team_id
          LEFT JOIN team AS h_team ON g.team_id_home=h_team.team_id
          WHERE league_year='".$league_year."' AND w_id=
          (SELECT max(w_id) FROM game WHERE processed>'2005-01-01' AND league_year='".$league_year."')) g_results
          GROUP BY al_nl,away_team, home_team";
          
          $result = $conn->query($querystr);
          if (!$result) die($conn->error);
          $numofrows = $result->num_rows;
          
          echo "<br>";
          $status=1;
          $nline=1;
          echo "<table width=\"80%\"><tr><td align=\"left\" width=\"100%\" colspan=\"4\">";
          for($i = 0; $i < $numofrows; $i++) {
             $result->data_seek($i);
             $row = $result->fetch_array(MYSQLI_ASSOC); 
             $w_id = $row['w_id'];
             if ($status==1) {
                echo "Week ".$w_id." Results";
                $status=2;
                echo "</td></tr><tr><td width=\"25%\">";
             }
             $al_nl = $row['al_nl'];
             $away_team = $row['away_team'];
             $home_team = $row['home_team'];
             $a_wins = $row['a_wins'];
             $h_wins = $row['h_wins'];                                       
             if ($nline==4) {
                echo "</td><td width=\"25%\">";
                $nline=1;
             }
             echo "<span class=\"style2\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$away_team."&view=games&year=".$league_year."\">".$away_team."</a> ".$a_wins."</span><br>";
             echo "<span class=\"style2\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$home_team."&view=games&year=".$league_year."\">".$home_team."</a> ".$h_wins."</span><br><br>";
             $nline+=1;             
          }
          echo "</td></tr></table>";
          $result->close();   
          $conn->close(); 
          ?>
