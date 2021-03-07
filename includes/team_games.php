<?php 

function print_block_header($p, $r) {
               echo "<table style=\"width: 100%\">";              
            }
            
function SQL1($conn,$query_team, $query_year) {

                # Team Games
               $mlb_year = $query_year-1;
               $querystr= "        
               SELECT g.game_id,g.aim_date,g.w_id,g.league_year,g.al_nl,g.extra,
               thome.abbrev AS home_team, taway.abbrev AS away_team,
               ht.runs as h_runs,ht.hits as h_hits,ht.errors as h_errors,ht.score as h_score,
               awt.runs as a_runs,awt.hits as a_hits,awt.errors as a_errors,awt.score as a_score, 
               GetPlayerInitial(ht.starting_pitcher_id) AS h_starting_pitcher, 
               GetPlayerInitial(ht.decision_pitcher_id) AS h_decision_pitcher, 
               GetPlayerInitial(ht.game_save_id) AS h_save_pitcher, 
               GetPlayerInitial(awt.starting_pitcher_id) AS a_starting_pitcher, 
               GetPlayerInitial(awt.decision_pitcher_id) AS a_decision_pitcher, 
               GetPlayerInitial(awt.game_save_id) AS a_save_pitcher
               FROM game g
               LEFT JOIN game_team ht ON g.game_id=ht.game_id AND g.team_id_home = ht.team_id
               LEFT JOIN team thome ON g.team_id_home = thome.team_id
               LEFT JOIN game_team awt ON  g.game_id=awt.game_id AND g.team_id_away = awt.team_id
               LEFT JOIN team taway ON g.team_id_away = taway.team_id               
               WHERE g.league_year='".$query_year."' AND (taway.abbrev='".$query_team."' or  thome.abbrev='".$query_team."')
               ORDER BY g.aim_date";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               print_block_header();
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC); 
                 $w_id = 'W'.$row['w_id'];
                 $game_id = $row['game_id'];
                 $aim_date = $row['aim_date'];    
                 $extra = $row['extra'];
                 $extra_innings='';
                 if (intval($extra) >='10') {
                    $extra_innings = ' - '.$extra.' INNINGS';
                 }                                    
                 $away_team = $row['away_team'];
                 $home_team = $row['home_team'];
                 $away_runs = $row['a_runs'];
                 $home_runs = $row['h_runs'];  
                 $away_hits = $row['a_hits'];
                 $home_hits = $row['h_hits']; 
                 $away_errors = $row['a_errors'];
                 $home_errors = $row['h_errors'];
                 $away_score =  $row['a_score'];
                 $home_score =  $row['h_score'];
                 $away_starter = $row['a_starting_pitcher']; 
                 $home_starter = $row['h_starting_pitcher'];
                 $save = ''; 
                 if ($away_runs>$home_runs) {
                    $winner = $row['a_decision_pitcher'];
                    $loser = $row['h_decision_pitcher'];
                    if ($row['a_save_pitcher']) {
                       $save = $row['a_save_pitcher'];
                    }
                 }
                 else {
                    $winner = $row['h_decision_pitcher'];
                    $loser = $row['a_decision_pitcher'];
                    if ($row['h_save_pitcher']) {
                       $save = $row['h_save_pitcher'];
                    }                    
                 }
             
                 echo "<tr><td>";
                 echo "<span class=\"style1\">".$w_id." - AIM Date: ".$aim_date."</span><span class=\"style9\">".$extra_innings."</span>";
                 echo "<table style=\"width: 60%\">";
                 echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style9\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$away_team."&view=games&year=".$query_year."\">".$away_team."</a></span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$away_runs."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$away_hits."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$away_errors."</span></td>";
                 echo "<td width=\"35%\" align=\"left\" valign=\"top\"><span class=\"style9\">".$away_starter." ".$away_score."</span></td>";
                 echo "</tr>";
                 echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style9\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$home_team."&view=games&year=".$query_year."\">".$home_team."</a></span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$home_runs."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$home_hits."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$home_errors."</span></td>";
                 echo "<td width=\"35%\" align=\"left\" valign=\"top\"><span class=\"style9\">".$home_starter." ".$home_score."</span></td>";
                 echo "</tr>";        
                 if ($away_runs != $home_runs) {
                    echo "<tr><td width=\"100%\" align=\"left\" colspan=\"5\">";
                    echo "<span class=\"style9\"> W: ".$winner."&nbsp;&nbsp;&nbsp; L: ".$loser."&nbsp;&nbsp;&nbsp; S: ".$save."</span>";
                    echo "</td></tr>";
                 }
                 echo "<tr><td></td></tr></table>";
                 echo "</td></tr>";
               } 
               echo "<tr><td></td></tr></table>";
               $result->close();
            }
            
                     
SQL1($conn,$query_team, $query_year);
echo "<br><br>";
?>
