<?php 

            
function team_batting_stats($conn,$query_roster, $query_year, $season_type) {
            
               $mlb_year = $query_year-1;
               
               # Player Batting Statistics
               $querystr= "        
               SELECT p.player_id,concat(p.first_name,' ',p.last_name) AS player,t.abbrev,s.draft_year, sum(s.g) as g, 
                    sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf,
                    sum(s.h)/sum(s.ab) as avg 
               FROM stats_batting s
               INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
               INNER JOIN player p ON r.player_id=p.player_id
               INNER JOIN team t ON r.team_id=t.team_id
               WHERE t.team_id=getTeamID('".$query_roster."') AND s.draft_year='".$query_year."' AND s.game_type='".$season_type."' 
			   GROUP BY p.player_id, concat(p.first_name,' ',p.last_name)
               ORDER BY avg desc";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               if ($numofrows>0) {
                  # Team Total Batting
                  $querystr= "        
                  SELECT sum(s.g) as g, sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf,
                    sum(s.h)/sum(s.ab) as avg 
                  FROM stats_batting s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE t.team_id=getTeamID('".$query_roster."') AND s.draft_year='".$query_year."'  AND s.game_type='".$season_type."'";          
   
                  $ttl_result = $conn->query($querystr);
                  if (!$ttl_result) die($conn->error);
             
                  echo "<div class=\"stat_group\">";
                  echo "<table width=\"100%\">";
                  if ($season_type==1) {
                     echo "<tr><td><span class=\"bold\">-- Regular Season --</span></td></tr>";
                  }
                  elseif ($season_type==2) {
                     echo "<tr><td><span class=\"bold\">-- Post Season --</span></td></tr>";
                  }
                  echo "<tr>";
                  echo "<td class=\"bold\" align=\"left\" width=\"25%\">Player</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">G</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"5%\">AB</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">R</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">H</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">2B</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">3B</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">HR</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">RBI</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">BB</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">SO</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">SB</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">CS</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"5%\">GDP</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"4%\">SH</td>";
                  echo "<td class=\"bold\" align=\"right\" width=\"5%\">SF</td>";
                  echo "<td class=\"bold\" align=\"center\" width=\"7%\">AVG</td>";
                  echo "<td class=\"bold\" align=\"center\" width=\"5%\">OBP</td>";
                  echo "<td class=\"bold\" align=\"center\" width=\"5%\">SLG</td>";
                  echo "<td class=\"bold\" align=\"center\" width=\"5%\">OBS</td>";
                  echo "</tr>";
                                          
                  # Player Totals
                  for ($i = 0; $i < $numofrows; $i++) {
                   $result->data_seek($i);
                   $row = $result->fetch_array(MYSQLI_ASSOC);                   
                   $player = $row['player'];
                   $player_id = $row['player_id'];
                   $g =$row['g'];
                   $ab =$row['ab'];
                   $r =$row['r'];
                   $h =$row['h'];
                   $b2 =$row['b2'];
                   $b3 =$row['b3'];
                   $hr =$row['hr'];
                   $tb = $row['tb'];
                   $rbi =$row['rbi'];
                   $bb =$row['bb'];
                   $so =$row['so'];
                   $sb =$row['sb'];
                   $cs =$row['cs'];
                   $gdp =$row['gdp'];
                   $ibb =$row['ibb'];
                   $hbp =$row['hbp'];
                   $sh =$row['sh'];
                   $sf =$row['sf'];
                   $avg = ".".str_pad(strval(number_format($h/$ab,3)*1000),3,'0',STR_PAD_LEFT);
                   $obp = ".".str_pad(strval(number_format(($h+$bb+$hbp)/($ab+$bb+$hbp+$sf),3)*1000),3,'0',STR_PAD_LEFT);
                   $slg = ".".str_pad(strval(number_format($tb/$ab,3)*1000),3,'0',STR_PAD_LEFT);
                   $obs = ".".str_pad(strval(number_format((($h+$bb+$hbp)/($ab+$bb+$hbp+$sf))+($tb/$ab),3)*1000),3,'0',STR_PAD_LEFT);              
             
                   echo "<tr class=\"spaceUnder\">";
                   echo "<td align=\"left\" width=\"25%\"><a class=\"style8\" href=\"player.php?player=".$player_id."\">".$player."</a></td>";
                   echo "<td align=\"right\" width=\"4%\">".$g."</td>";
                   echo "<td align=\"right\" width=\"5%\">".$ab."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$r."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$h."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$b2."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$b3."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$hr."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$rbi."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$bb."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$so."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sb."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$cs."</td>";
                   echo "<td align=\"right\" width=\"5%\">".$gdp."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sh."</td>";
                   echo "<td align=\"right\" width=\"5%\">".$sf."</td>";                   
                   echo "<td align=\"center\" width=\"7%\">".$avg."</td>";                   
                   echo "<td align=\"center\" width=\"5%\">".$obp."</td>";
                   echo "<td align=\"center\" width=\"5%\">".$slg."</td>";
                   echo "<td align=\"center\" width=\"5%\">".$obs."</td>";                   
                   echo "</tr>";
                  }
               
                  # Team Grand Totals
                  $row = $ttl_result->fetch_array(MYSQLI_ASSOC);               
                  $ab =$row['ab'];
                  $r =$row['r'];
                  $h =$row['h'];
                  $b2 =$row['b2'];
                  $b3 =$row['b3'];
                  $hr =$row['hr'];
                  $tb = $row['tb'];
                  $rbi =$row['rbi'];
                  $bb =$row['bb'];
                  $so =$row['so'];
                  $sb =$row['sb'];
                  $cs =$row['cs'];
                  $gdp =$row['gdp'];
                  $ibb =$row['ibb'];
                  $hbp =$row['hbp'];
                  $sh =$row['sh'];
                  $sf =$row['sf'];
                  $avg = ".".strval(number_format($h/$ab,3)*1000);
                  $obp = ".".strval(number_format(($h+$bb+$hbp)/($ab+$bb+$hbp+$sf),3)*1000);
                  $slg = ".".strval(number_format($tb/$ab,3)*1000);
                  $obs = ".".strval(number_format((($h+$bb+$hbp)/($ab+$bb+$hbp+$sf))+($tb/$ab),3)*1000);
               
                  echo "<tr class=\"spaceUnder\">";
                  echo "<td align=\"left\" width=\"25%\">-Total-</td>";
                  echo "<td align=\"right\" width=\"4%\">-</td>";
                  echo "<td align=\"right\" width=\"5%\">".$ab."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$r."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$h."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$b2."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$b3."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$hr."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$rbi."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$bb."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$so."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$sb."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$cs."</td>";
                  echo "<td align=\"right\" width=\"5%\">".$gdp."</td>";
                  echo "<td align=\"right\" width=\"4%\">".$sh."</td>";
                  echo "<td align=\"right\" width=\"5%\">".$sf."</td>";                   
                  echo "<td align=\"center\" width=\"7%\">".$avg."</td>";                   
                  echo "<td align=\"center\" width=\"5%\">".$obp."</td>";
                  echo "<td align=\"center\" width=\"5%\">".$slg."</td>";
                  echo "<td align=\"center\" width=\"5%\">".$obs."</td>";                   
                  echo "</tr>";
              
                  echo "</table>";
                  echo "</div>";	
                  $result->close();
                  $ttl_result->close();  
               }   
}

team_batting_stats($conn,$query_team, $query_year, 1);
team_batting_stats($conn,$query_team, $query_year, 2);
echo "<br><br>";
?>
