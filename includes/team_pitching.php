<?php 

            
function team_pitching_stats($conn,$query_roster, $query_year, $season_type) {
            
               $mlb_year = $query_year-1;
               
               # Player Pitching Statistics
               if ($season_type==1) {
                  $querystr= "        
                  SELECT p.player_id,concat(p.first_name,' ',p.last_name) AS player,t.abbrev,s.draft_year, 
                    sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, convert_ip_base3(ROUND(sum(convert_ip(s.ip)),1)) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb,
                    sum(s.er)*9/sum(convert_ip(s.ip)) as era 
                  FROM agg_pitching_by_player_team s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE t.team_id=getTeamID('".$query_roster."') AND s.draft_year='".$query_year."'
			      GROUP BY p.player_id, concat(p.first_name,' ',p.last_name)
                  ORDER BY era";   
               }
               elseif ($season_type==2) {
                  $querystr= "        
                  SELECT p.player_id,concat(p.first_name,' ',p.last_name) AS player,t.abbrev,s.draft_year, 
                    sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, convert_ip_base3(ROUND(sum(convert_ip(s.ip)),1)) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb,
                    sum(s.er)*9/sum(convert_ip(s.ip)) as era 
                  FROM stats_pitching s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE t.team_id=getTeamID('".$query_roster."') AND s.draft_year='".$query_year."' AND s.game_type=".$season_type."
                  GROUP BY p.player_id, concat(p.first_name,' ',p.last_name)
                  ORDER BY era";   
               
               }       
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               # Team Total Pitching
               if ($season_type==1) {
                  $querystr= "        
                  SELECT sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, ROUND(sum(convert_ip(s.ip))) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb,
                    sum(s.er)*9/sum(convert_ip(s.ip)) as era 
                  FROM agg_pitching_by_player_team s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE t.team_id=getTeamID('".$query_roster."') AND s.draft_year='".$query_year."'";      
               }
               elseif ($season_type==2) {    
                  $querystr= "        
                  SELECT sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, ROUND(sum(convert_ip(s.ip))) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb,
                    sum(s.er)*9/sum(convert_ip(s.ip)) as era 
                  FROM stats_pitching s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE t.team_id=getTeamID('".$query_roster."') AND s.draft_year='".$query_year."' AND s.game_type=".$season_type."";   
               }   
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
               echo "<td class=\"bold\" align=\"right\" width=\"3%\">W</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"3%\">L</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"3%\">S</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"3%\">G</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"3%\">GS</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">CG</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"5%\">SHO</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">QS</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"6%\">IP</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">H</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">R</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">ER</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">HR</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">SO</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">BB</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"5%\">BF</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">IBB</td>";
               echo "<td class=\"bold\" align=\"right\" width=\"4%\">HBP</td>"; 
               echo "<td class=\"bold\" align=\"center\" width=\"6%\">ERA</td>";               echo "</tr>";
                                          
               # Player Totals
               for ($i = 0; $i < $numofrows; $i++) {
                   $result->data_seek($i);
                   $row = $result->fetch_array(MYSQLI_ASSOC); 
                   $player = $row['player'];
                   $player_id = $row['player_id'];
                   $w =$row['w'];
                   $l =$row['l'];
                   $sv =$row['sv'];
                   $g =$row['g'];
                   $gs =$row['gs'];
                   $cg =$row['cg'];
                   $sho =$row['sho'];
                   $qs = $row['qs'];
                   $ip = $row['ip'];                   
                   $h =$row['h'];
                   $r =$row['r'];
                   $er =$row['er'];
                   $hr =$row['hr'];
                   $so =$row['so'];
                   $bb =$row['bb'];
                   $bf =$row['bf'];
                   $ibb =$row['ibb'];
                   $hb =$row['hb'];
                   $era = strval(number_format($er*9/$ip,2));
             
             
                   echo "<tr class=\"spaceUnder\">";
                   echo "<td align=\"left\" width=\"25%\"><a class=\"style8\" href=\"player.php?player=".$player_id."\">".$player."</a></td>";
                   echo "<td align=\"right\" width=\"3%\">".$w."</td>";
                   echo "<td align=\"right\" width=\"3%\">".$l."</td>";
                   echo "<td align=\"right\" width=\"3%\">".$sv."</td>";
                   echo "<td align=\"right\" width=\"3%\">".$g."</td>";
                   echo "<td align=\"right\" width=\"3%\">".$gs."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$cg."</td>";
                   echo "<td align=\"right\" width=\"5%\">".$sho."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$qs."</td>";
                   echo "<td align=\"right\" width=\"6%\">".$ip."</td>";                   
                   echo "<td align=\"right\" width=\"4%\">".$h."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$r."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$er."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$hr."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$so."</td>";                   
                   echo "<td align=\"right\" width=\"4%\">".$bb."</td>";
                   echo "<td align=\"right\" width=\"5%\">".$bf."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$ibb."</td>";    
                   echo "<td align=\"right\" width=\"4%\">".$hb."</td>";   
                   echo "<td align=\"center\" width=\"6%\">".$era."</td>";                 
                   echo "</tr>";
               }
               
               # Team Grand Totals
               $row = $ttl_result->fetch_array(MYSQLI_ASSOC); 
               $w =$row['w'];
               $l =$row['l'];
               $sv =$row['sv'];
               $g =$row['g'];
               $gs =$row['gs'];
               $cg =$row['cg'];
               $sho =$row['sho'];
               $qs = $row['qs'];
               $ip = $row['ip'];                   
               $h =$row['h'];
               $r =$row['r'];
               $er =$row['er'];
               $hr =$row['hr'];
               $so =$row['so'];
               $bb =$row['bb'];
               $bf =$row['bf'];
               $ibb =$row['ibb'];
               $hb =$row['hb'];
               $era = strval(number_format($er*9/$ip,2));
               
               echo "<tr class=\"spaceUnder\">";
               echo "<td align=\"left\" width=\"25%\">-Total-</td>";
               echo "<td align=\"right\" width=\"3%\">".$w."</td>";
               echo "<td align=\"right\" width=\"3%\">".$l."</td>";
               echo "<td align=\"right\" width=\"3%\">".$sv."</td>";
               echo "<td align=\"right\" width=\"3%\">".$g."</td>";
               echo "<td align=\"right\" width=\"3%\">".$gs."</td>";
               echo "<td align=\"right\" width=\"4%\">".$cg."</td>";
               echo "<td align=\"right\" width=\"5%\">".$sho."</td>";
               echo "<td align=\"right\" width=\"4%\">".$qs."</td>";
               echo "<td align=\"right\" width=\"6%\">".$ip."</td>";                   
               echo "<td align=\"right\" width=\"4%\">".$h."</td>";
               echo "<td align=\"right\" width=\"4%\">".$r."</td>";
               echo "<td align=\"right\" width=\"4%\">".$er."</td>";
               echo "<td align=\"right\" width=\"4%\">".$hr."</td>";
               echo "<td align=\"right\" width=\"4%\">".$so."</td>";                   
               echo "<td align=\"right\" width=\"4%\">".$bb."</td>";
               echo "<td align=\"right\" width=\"5%\">".$bf."</td>";
               echo "<td align=\"right\" width=\"4%\">".$ibb."</td>";    
               echo "<td align=\"right\" width=\"4%\">".$hb."</td>";   
               echo "<td align=\"center\" width=\"6%\">".$era."</td>";                   
               echo "</tr>";
              

               echo "</table>";
               echo "</div>";	
               $result->close(); 
               $ttl_result->close();      
}
           
team_pitching_stats($conn,$query_team, $query_year, 1);
team_pitching_stats($conn,$query_team, $query_year, 2);
echo "<br><br>";
?>
