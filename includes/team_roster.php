<?php 

function print_pos_block_header($p, $r) {
               echo "<table style=\"width: 100%\"><tr>";
               echo "<td width=\"30%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">".$p." (".$r.")</span></td>";
               if ($r>0) {
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">B</span></td>";
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">T</span></td>";
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">Age</span></td>";
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">Sp</span></td>";
                  echo "<td width=\"5%\" align=\"left\" valign=\"top\">
                  <span class=\"style5\">Pos</span></td>";
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">Def</span></td>";
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">Arm</span></td>";
                  echo "<td width=\"5%\" align=\"left\" valign=\"top\">
                  <span class=\"style5\">GR</span></td>";
                  echo "<td width=\"5%\" align=\"left\" valign=\"top\">
                  <span class=\"style5\">CTL</span></td>";
                  echo "<td width=\"5%\" align=\"right\" valign=\"top\">
                  <span class=\"style5\">PR</span></td>";
                  echo "<td width=\"5%\" align=\"right\" valign=\"top\">
                  <span class=\"style5\">SF</span></td>";
                  echo "<td width=\"5%\" align=\"right\" valign=\"top\">
                  <span class=\"style5\">MRR</span></td>";
                  echo "<td width=\"5%\" align=\"right\" valign=\"top\">
                  <span class=\"style5\">RF</span></td>";
                  echo "<td width=\"5%\" align=\"right\" valign=\"top\">
                  <span class=\"style5\">MBF</span></td>";
                  
               }
               echo "</tr>";                
            }
            
function SQL1($conn,$query_roster, $p, $query_year) {
               if ($p=='C') {
                  $pos_set="('C','C+')";
               }
               elseif ($p=='IF') {
                  $pos_set="('1B','1B+','2B','2B+','SS','SS+','3B','3B+')";
               }
               elseif ($p=='OF') {
                  $pos_set="('OF','OF+')";
               }
               elseif ($p=='P') {
                  $pos_set="('P','P+')";
               }
               elseif ($p=='NC') {
                  $pos_set="('NC')";
               }

               # Roster Query - Left Join of player_year should be last to keep NC players in results
               $mlb_year = $query_year-1;
               $querystr= "        
               SELECT pl.mlb_year,t.team_name,r.player_id,r.team_id, r.protect,
                 CONCAT(p.last_name,', ',p.first_name,' ',p.middle_name) as player,
                 p.bat, p.throw as th, ".$mlb_year."-CAST(p.birthyear AS UNSIGNED) AS age, IF(ISNULL(t.abbrev),'UNF',t.abbrev) AS BRBL, 
                 pl.speed, pl.position, pl.defense, pl.throw AS arm, pl.grade, pl.control,
                 pl.pr,pl.sf,pl.mrr,pl.rf,pl.maxbf
               FROM roster_brbl r
               LEFT JOIN player p ON r.player_id=p.player_id
               LEFT JOIN team t on r.team_id=t.team_id
               LEFT JOIN player_year pl on p.player_id = pl.player_id
               WHERE (pl.mlb_year=$mlb_year OR pl.mlb_year IS NULL) AND t.team_id=getTeamID('".$query_roster."') 
                     AND ((r.date_from<'".$query_year."-11-01' AND r.date_to IS NULL) OR (r.date_from<'".$query_year."-11-01' AND r.date_to >='".$query_year."-10-31')) AND pl.position IN ".$pos_set."
               ORDER BY player";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               print_pos_block_header($p,$numofrows);
               $tot_age=0;
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC); 
                 $player = $row['player'];
                 $player_id = $row['player_id'];
                 $protect = $row['protect'];
                 $bat = $row['bat'];
                 $throw = $row['th'];
                 $age = $row['age'];
                 $tot_age = $tot_age+$age;  
                 $speed = $row['speed'];  
                 $position = $row['position']; 
                 $defense = $row['defense']; 
                 $arm = $row['arm'];                          
                 $grade = $row['grade']; 
                 $control = $row['control']; 
                 $pr = $row['pr']; 
                 $sf = $row['sf']; 
                 $mrr = $row['mrr']; 
                 $rf = $row['rf']; 
                 $maxbf = $row['maxbf'];                                           
                 echo "<tr>";
                 echo "<td width=\"30%\" align=\"left\" valign=\"top\"><a class=\"style3\" href=\"player.php?player=".$player_id."\">".$player."</a>";
                 if ($protect!='T' and $query_year=='2021') {
                    echo "<span class=\"style6\">(np)</span>";
                 }

                 echo "</td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$bat."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$throw."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$age."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$speed."</span></td>";
                 echo "<td width=\"5%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$position."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$defense."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$arm."</span></td>";
                 echo "<td width=\"5%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$grade."</span></td>";
                 echo "<td width=\"5%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$control."</span></td>";
                 echo "<td width=\"5%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$pr."</span></td>";
                 echo "<td width=\"5%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$sf."</span></td>";
                 echo "<td width=\"5%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$mrr."</span></td>";
                 echo "<td width=\"5%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$rf."</span></td>";
                 echo "<td width=\"5%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$maxbf."</span></td>";

                 echo "</tr>";
               } 
               echo "<tr><td></td></tr></table>";
               $result->close();   
               return array($numofrows,$tot_age);
            }
            
            
          
            $total_players=0;
            $total_age=0;
            $positions = array("C","IF","OF","P","NC");
            for ($p=0; $p<count($positions); $p++) {
                $age_data = SQL1($conn,$query_team, $positions[$p], $query_year);
                $total_players=$total_players+$age_data[0];
                $total_age=$total_age+$age_data[1];
                $average_age = ROUND($total_age/$total_players,1);
            }
            echo "<br><br>";
            echo "Total Players: ".$total_players." / Avg Age: ".number_format($average_age,1)."<br><br>";
            echo "<span class=\"style6\">(np)</span> <span class=\"style3\">= Not protected in Free Agent Draft</span><br><br>";
?>
