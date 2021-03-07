<?php 

function top_performance($conn,$query_year,$limit_number,$stat,$fieldname,$abbrev,$table) {
           $orderby = 'DESC';
           if ($stat=='avg') {
              $stat2='sum(h)/sum(ab)';
           }
           else if ($stat=='era') {
              $stat2='sum(er)*9/sum(ip)';
              $orderby = 'ASC';
           }
           else {
              $stat2= 'sum('.$stat.')';
           }

           $querystr="
           SELECT p.player_id,p.first_name, p.last_name, ".$stat." FROM 
           (SELECT pool.player_id, pool.".$stat." FROM 
           (SELECT s.player_id,".$stat2." AS ".$stat." 
           FROM ".$table." s
           LEFT JOIN roster_brbl rb ON s.roster_brbl_id=rb.roster_brbl_id
           LEFT JOIN team t ON t.team_id=rb.team_id
           WHERE draft_year='".$query_year."' AND t.team_id=getTeamID('".$abbrev."')
           GROUP BY player_id) pool
           INNER JOIN
           (SELECT DISTINCT ".$stat." FROM
           (SELECT s.player_id,".$stat2." AS ".$stat." 
           FROM ".$table." s
           LEFT JOIN roster_brbl rb ON s.roster_brbl_id=rb.roster_brbl_id
           LEFT JOIN team t ON t.team_id=rb.team_id
           WHERE draft_year='".$query_year."' AND t.team_id=getTeamID('".$abbrev."')
           GROUP BY player_id
           HAVING ".$stat." > 0
           ORDER BY ".$stat." ".$orderby."
           LIMIT ".$limit_number.") top) hrlst
           ON pool.".$stat." = hrlst.".$stat.") pl2
           INNER JOIN player p
           ON pl2.player_id=p.player_id
           ORDER BY ".$stat." ".$orderby."";
           
           $result = $conn->query($querystr);
           if (!$result) die($conn->error);
           $numofrows = $result->num_rows;
           
           echo "<table><tr><td colspan=\"2\" align=\"center\"><span class=\"style12\">".$fieldname."</span></td></tr>";
           for($i = 0; $i < $numofrows; $i++) {
              $result->data_seek($i);
              $row = $result->fetch_array(MYSQLI_ASSOC); 
              if ($stat=='avg') {
                 if ($row[$stat]=='1') {
                    $stat_format='1.000';
                 }
                 else {
                    $stat_format='.'.strval(number_format($row[$stat],3)*1000);
                 }
              }
              else if ($stat=='era') {
                 $stat_format=strval(number_format($row[$stat],2));
              }              
              else {
                 $stat_format=$row[$stat];
              }
              echo "<tr><td valign=\"top\" align=\"right\"><span class=\"style5\">".$stat_format."</span></td><td><a class=\"style3\" href=\"player.php?player=".$row['player_id']."\">".$row['first_name']." ".$row['last_name']."</a></td></tr>";
           
           }
           echo "</table>";
           $result->close();
}

function performance_manager($conn,$query_year,$query_team) {
           echo "<table width=\"100%\"><tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'avg','AVG',$query_team,'agg_batting_by_player_team');
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'hr','HR',$query_team,'agg_batting_by_player_team');
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'rbi','RBI',$query_team,'agg_batting_by_player_team');
           echo "</td>"; 
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'r','Runs',$query_team,'agg_batting_by_player_team');
           echo "</td></tr>"; 
           echo "<tr><td><br></td></tr>";                      
           echo "<tr><td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'h','Hits',$query_team,'agg_batting_by_player_team');   
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'sb','Stolen Bases',$query_team,'agg_batting_by_player_team');   
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'w','Wins',$query_team,'agg_pitching_by_player_team'); 
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";                   
           top_performance($conn,$query_year,3,'so','Strikeouts',$query_team,'agg_pitching_by_player_team');  
           echo "</td></tr>";            
           echo "<tr><td><br></td></tr>";                      
           echo "<tr><td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'era','ERA',$query_team,'agg_pitching_by_player_team');   
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'sv','Saves',$query_team,'agg_pitching_by_player_team');   
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_performance($conn,$query_year,3,'ip','IP',$query_team,'agg_pitching_by_player_team'); 
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";                   
           top_performance($conn,$query_year,3,'g','Appearances',$query_team,'agg_pitching_by_player_team');  
           echo "</td></tr>";   
           echo "</table>";
}

function team_header($conn,$query_year,$query_team) {
           // GM, Manager, Current Record
           $querystr="
           SELECT gm.first_name, gm.last_name, m.manager_name,m.filename,l.win,l.loss
           FROM team t
           INNER JOIN gm_division_teams gt ON t.team_id=gt.team_id 
           INNER JOIN GM gm ON gt.gm_id= gm.gm_id 
           INNER JOIN manager m ON gm.manager_id=m.manager_id 
           LEFT JOIN (SELECT team_id,total_win as win,total_loss as loss 
                      FROM standings WHERE league_year=".$query_year." AND team_id=getTeamID('".$query_team."')) l                
           ON t.team_id=l.team_id
           WHERE t.abbrev='".$query_team."' AND gt.end_date IS NULL";

           $result = $conn->query($querystr);
           if (!$result) die($conn->error);

           $row = $result->fetch_array(MYSQLI_ASSOC); 
         
           echo "<table width=\"100%\"><tr>";
           echo "<td width=\"10%\"><img class=\"imagebuffer1\" alt=\"Team Logo ".$query_team."\" width=\"150\" height=\"100\" src=\"images/team-logos/".strtolower($query_team)."_150x100.gif\">
               </td>"; 
           echo "<td width=\"90%\" align=\"left\">";      
           echo "GM: ".$row['first_name']." ".$row['last_name']."<br>";               
           echo "Manager: <a href=\"http://www.brbl-apba.com/docs/managers/".$row['filename']."\">".$row['manager_name']."</a><br>";
           echo "Current Record: ".$row['win']."-".$row['loss'];
           echo "</td></tr></table>";
           $result->close();                                   
}
            
function schedule($conn,$query_year,$query_team) {

               # Team Schedule and Results
               $querystr= "        
               SELECT w_id, pre, team, sum(win) as win, sum(loss) as loss 
               FROM
               (SELECT w_id,g_inv.game_id,away_home,if(away_home='A','@',' ') as pre, t.abbrev as team,
               if(gt.win_loss='W',1,0) AS win, if(gt.win_loss='L',1,0) AS loss
               FROM 
               (SELECT g.w_id, g.game_id, 
               if(g.team_id_away=getTeamID('".$query_team."'),'A','H') as away_home,
               if(g.team_id_away=getTeamID('".$query_team."'),g.team_id_home,g.team_id_away) as opponent
               FROM game g
               WHERE g.league_year='".$query_year."' AND g.game_type='1' AND (team_id_away=getTeamID('".$query_team."') OR team_id_home=getTeamID('".$query_team."'))) g_inv
               LEFT JOIN team t ON g_inv.opponent=t.team_id
               LEFT JOIN game_team gt ON g_inv.game_id=gt.game_id AND gt.team_id=getTeamID('".$query_team."')) results
               GROUP BY w_id, team
               ORDER BY w_id";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               echo "<table>";
               echo "<tr><td colspan=\"4\"><span class=\"style12\">Series By Week ".$query_year."</span></td></tr><tr>";
               $ncounter=1;
               $i=1;
               $j=0;
               while ($i<=4) {
                 $result->data_seek($j);
                 $row = $result->fetch_array(MYSQLI_ASSOC); 
                 $w_id = $row['w_id'];
                 $pre  = $row['pre'];
                 $team = $row['team'];
                 $win = $row['win'];    
                 $loss = $row['loss'];             
                 if ($ncounter==1) {
                    echo "<td width=\"10%\" valign=\"top\"><table width=\"100%\">";
                 }
                 $z1="W".$w_id." ".$pre."<a href=\"http://www.brbl-apba.com/teams.php?team=".$team."&view=main&year=".$query_year."\">".$team."</a>";
                 echo "<tr><td class=\"nowrap\" align=\"left\" valign=\"top\"><span class=\"style6\">".$z1."</span></td>";
                 echo "<td class=\"nowrap\" align=\"left\" valign=\"top\"><span class=\"style6\">".$win."-".$loss."</span></td></tr>";

                 $ncounter++;
                 $j++;
                 if ($ncounter==8) {
                    echo "</table></td><td width=\"10%\"></td>";
                    $ncounter=1;
                    $i++;
                 }     
               }
               echo "</tr></table>";
               
               $result->close();
}
function season_results($conn,$query_team) {
               $querystr= "        
               SELECT s.league_year, s.total_win AS win, s.total_loss AS loss, 
               if(ISNULL(s.total_win/(s.total_win+s.total_loss)),.000,s.total_win/(s.total_win+s.total_loss)) AS pct, 
               s.gb, s.place, s.home_win AS win_home, s.home_loss AS lose_home, s.away_win AS win_away, s.away_loss AS lose_away, 
               s.run1_win AS r_win, s.run1_loss AS r_loss, s.xinn_win AS x_win, s.xinn_loss AS x_loss, 
               s.east_win, s.east_loss, s.central_win, s.central_loss, s.west_win, s.west_loss, s.post_season_results, s.series_id  
               FROM standings s
               LEFT JOIN team t USING (team_id)
               WHERE t.abbrev='".$query_team."'  
               ORDER by s.league_year DESC";        
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;

               echo "<div id=\"team_annual_results\" class=\"stat_group\">";
               echo "<table width=\"100%\">";
               echo "<tr>";
               echo "<td nowrap align=\"left\" class=\"bold\">Year</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">W-L</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">PCT</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">GB</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">Place</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">Home</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">Away</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">1-Run</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">X-Inn</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">East</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">Central</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">West</td>";
               echo "<td nowrap align=\"center\" class=\"bold\">Post Season</td>";
               echo "</tr>";

               # Team Records for each year
               for ($i = 0; $i < $numofrows; $i++) {
                   $result->data_seek($i);
                   $row = $result->fetch_array(MYSQLI_ASSOC);                   
                   $league_year = $row['league_year'];
                   $win = $row['win'];
                   $loss =$row['loss'];
                   $pct=explode(".", number_format($row['pct'],3));
                   $pct=".".$pct[1];
                   $gb=($row['gb']==0.0 ? '-' : $row['gb']);
                   $place =$row['place'];
                   $win_home =$row['win_home'];
                   $loss_home =$row['lose_home'];
                   $win_away =$row['win_away'];
                   $loss_away =$row['lose_away'];
                   $r_win =$row['r_win'];
                   $r_loss =$row['r_loss'];
                   $x_win =$row['x_win'];
                   $x_loss =$row['x_loss'];
                   $east_win =$row['east_win'];
                   $east_loss =$row['east_loss'];
                   $central_win =$row['central_win'];
                   $central_loss =$row['central_loss'];
                   $west_win =$row['west_win'];
                   $west_loss =$row['west_loss'];    
                   $post_season_results =$row['post_season_results'];       
                   $series_id =$row['series_id'];
                   
                   echo "<tr class=\"spaceUnder\">";
                   echo "<td nowrap align=\"left\">".$league_year."</td>";
                   echo "<td nowrap align=\"center\">".$win."-".$loss."</td>";
                   echo "<td nowrap align=\"center\">".$pct."</td>";
                   echo "<td nowrap align=\"center\">".$gb."</td>";
                   echo "<td nowrap align=\"center\">".$place."</td>";
                   echo "<td nowrap align=\"center\">".$win_home."-".$loss_home."</td>";
                   echo "<td nowrap align=\"center\">".$win_away."-".$loss_away."</td>";
                   echo "<td nowrap align=\"center\">".$r_win."-".$r_loss."</td>";
                   echo "<td nowrap align=\"center\">".$x_win."-".$x_loss."</td>";
                   echo "<td nowrap align=\"center\">".$east_win."-".$east_loss."</td>";
                   echo "<td nowrap align=\"center\">".$central_win."-".$central_loss."</td>";            
                   echo "<td nowrap align=\"center\">".$west_win."-".$west_loss."</td>";
                   if ($series_id) {
                      echo "<td nowrap align=\"center\"><a href=\"http://www.brbl-apba.com/year-".$league_year."/post-season/series_".$series_id.".php\">".$post_season_results."</a></td>";   
                   }
                   else {
                      echo "<td nowrap align=\"center\">".$post_season_results."</td>";
                   }              
                   echo "<td nowrap align=\"center\">&nbsp;</td>";
                   echo "</tr>";
               }
               echo "</table>";
               echo "</div>";	
               $result->close();
}

function SQL_manager($conn,$query_year,$query_team) {
   //echo "<table><tr>";
   //echo "<td width=\"100%\" valign=\"top\">"; 
   team_header($conn,$query_year,$query_team);
   echo "<br>";
   schedule($conn,$query_year,$query_team);
   echo "<br>";
   performance_manager($conn,$query_year,$query_team);
   echo "<br>";  
   season_results($conn,$query_team);
   //echo "</td>";
   //echo "</tr></table>";
}

SQL_manager($conn,$query_year,$query_team);            
echo "<br><br>";
?>
