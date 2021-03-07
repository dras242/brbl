<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Player and Team Accomplishments</title>
 <meta name="Description" content="Annual player and team accomplishments for the BRBL season including no-hitters and awards.">
 <meta name="Keywords" content="most valuable player, cy young award, no-hitter">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Awards and Accomplishments</h1>
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
          <br>
          <?php include_once("includes/brbl_logo.php") ?><br><br>		  
          <?php include_once("includes/world_series_winner.php") ?><br><br>
          <?php include_once("includes/apba_baseball_logo.php") ?><br><br>         
          <br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
            <?php
            function player_awards($conn,$query_year) {
               $querystr= "        
               SELECT s.award_id, s.league_year, p.player_id,concat(p.first_name,' ',p.last_name) as player,t.abbrev, s.caption, s.honorable_mentions 
               FROM stats_award s
               LEFT JOIN roster_brbl r USING(roster_brbl_id) 
               LEFT JOIN player p USING(player_id)
               LEFT JOIN team t USING(team_id) 
               WHERE s.league_year=".$query_year."";

               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;

               echo "<table style=\"width: 100%\"><tr>";
               echo "<td width=\"10%\" align=\"left\" valign=\"top\">
               <span class=\"style10\">Award</span></td>";               
               echo "<td width=\"20%\" align=\"left\" valign=\"top\">
               <span class=\"style10\">Player</span></td>";
               echo "<td width=\"70%\" align=\"left\" valign=\"top\">
               <span class=\"style10\">Highlights</span></td></tr>";

               
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC); 
                 if ($row['award_id']==1) {
                    $award='MVP AL';
                 }
                 elseif ($row['award_id']==2) {
                    $award='MVP NL';
                 }
                 elseif ($row['award_id']==3) {
                    $award='Cy Young AL';
                 }
                 elseif ($row['award_id']==4) {
                    $award='Cy Young NL';                   
                 }                            
                 elseif ($row['award_id']==5) {
                    $award='Rookie AL';                   
                 }
                 elseif ($row['award_id']==6) {
                    $award='Rookie NL';                   
                 }
                                                   
                 echo "<tr>";
                 echo "<td class=\"imagebuffer1\" width=\"10%\" align=\"left\" valign=\"top\">
                 <span class=\"style3\">".$award."</span></td>";               
                 echo "<td class=\"imagebuffer1\" width=\"20%\" align=\"left\" valign=\"top\">
                 <a  class=\"style3\" href=\"player.php?player=".$row['player_id']."\">".$row['player']."</a> <span  class=\"style3\">(".$row['abbrev'].")</span></td>";
                 echo "<td class=\"imagebuffer1\" width=\"70%\" align=\"left\" valign=\"top\">
                 <span class=\"style3\">".$row['caption']."</span></td>";
                 echo "</tr>";

               
               }
               echo "</tr></table>";   
               $result->close();                           
            }
            
            function table_generation($result, $numofrows, $header) {
               echo "<table>";
               echo "<table style=\"width: 100%\"><tr>";
               echo "<td align=\"left\" valign=\"top\">
               <span class=\"style10\">".$header."</span></td>";               
               echo "<td align=\"left\" valign=\"top\">
               <span class=\"style10\">Pitcher</span></td>";
               echo "<td align=\"left\" valign=\"top\">
               <span class=\"style10\">Team</span></td>";
                echo "<td align=\"left\" valign=\"top\">
               <span class=\"style10\">Opponent</span></td>";
                echo "<td align=\"left\" valign=\"top\">
               <span class=\"style10\">SC</span></td>";
                echo "<td align=\"left\" valign=\"top\">
               <span class=\"style10\">BF</span></td>";
                echo "<td align=\"center\" valign=\"top\">
               <span class=\"style10\">IP</span></td>";
                echo "<td align=\"center\" valign=\"top\">
               <span class=\"style10\">R</span></td>";
                echo "<td align=\"center\" valign=\"top\">
               <span class=\"style10\">ER</span></td>";
                echo "<td align=\"center\" valign=\"top\">
               <span class=\"style10\">H</span></td>";               
                echo "<td align=\"center\" valign=\"top\">
               <span class=\"style10\">SO</span></td>";
                echo "<td align=\"center\" valign=\"top\">
               <span class=\"style10\">BB</span></td>";
                echo "<td align=\"center\" valign=\"top\">
               <span class=\"style10\">HBP</span></td></tr>";
               $post_season_indicator=0;
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC);
                 if ($row['number_pitchers']>1) { 
                    $pitcher='Team ('.$row['number_pitchers'].' pitchers)'; 
                    $link_condition=1;
                 }
                 else {
                    $pitcher=$row['player'];
                    $link_condition=2;
                 }  
                 if ($row['score']==0) { 
                    $score='-'; 
                 }
                 else {
                   $score=$row['score'];
                 } 
                 if ($row['post_season']=='P') { 
                    $post_season='*'; 
                    $post_season_indicator=1;
                 }
                 else {
                    $post_season=''; 
                 }                                                    
                 echo "<tr>";
                 echo "<td align=\"left\" valign=\"top\"><span class=\"style3\">".$row['aim_date'].$post_season."</span></td>";  
                 if ($link_condition==2) {                              
                    echo "<td align=\"left\" valign=\"top\"><a class=\"style3\" href=\"player.php?player=".$row['player_id']."\">".$pitcher."</a></td>"; 
                 }
                 else {
                    echo "<td align=\"left\" valign=\"top\">".$pitcher."</td>"; 
                 }                
                 echo "<td align=\"left\" valign=\"top\"><span class=\"style3\">".$row['team']."</span></td>";
                 echo "<td align=\"left\" valign=\"top\"><span class=\"style3\">".$row['opponent']."</span></td>"; 
                 echo "<td align=\"left\" valign=\"top\"><span class=\"style3\">".$row['score']."</span></td>";
                 echo "<td align=\"left\" valign=\"top\"><span class=\"style3\">".$row['bf']."</span></td>"; 
                 echo "<td align=\"center\" valign=\"top\"><span class=\"style3\">".$row['ip']."</span></td>"; 
                 echo "<td align=\"center\" valign=\"top\"><span class=\"style3\">".$row['runs']."</span></td>"; 
                 echo "<td align=\"center\" valign=\"top\"><span class=\"style3\">".$row['earned_runs']."</span></td>"; 
                 echo "<td align=\"center\" valign=\"top\"><span class=\"style3\">".$row['h']."</span></td>"; 
                 echo "<td align=\"center\" valign=\"top\"><span class=\"style3\">".$row['so']."</span></td>"; 
                 echo "<td align=\"center\" valign=\"top\"><span class=\"style3\">".$row['bb']."</span></td>"; 
                 echo "<td align=\"center\" valign=\"top\"><span class=\"style3\">".$row['hbp']."</span></td>"; 

                 echo "</tr>";
               } 
               echo "<tr><td></td></tr></table>";
               if ($post_season_indicator==1) {     
                  echo "<span class=\"style8\">* Indicates Post Season</span><BR>";  
               }    
            
            }
            
            function no_hitters($conn,$query_year) {
               $querystr= "        
               SELECT s.aim_date, s.post_season, s.player_id,CONCAT(p.first_name,' ',p.last_name) as player,
                      t.team_name as team,op.team_name as opponent,s.score,s.number_pitchers,
                      s.score,s.ip,s.runs,s.earned_runs,s.h,s.bf,s.so,s.bb,s.hbp
               FROM stats_best_score s
               LEFT JOIN player p USING(player_id)
               LEFT JOIN team t ON s.team_id=t.team_id
               LEFT JOIN team op on s.vs_team_id=op.team_id
               WHERE YEAR(s.aim_date)=".$query_year." AND s.type IN ('N','B')  
               ORDER BY aim_date";

               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               table_generation($result,$numofrows,'No Hitters');
               
               $result->close();               
               return array($numofrows);
            }
            
             function best_scores($conn,$query_year) {
               $querystr= "        
               SELECT s.aim_date, s.post_season, s.player_id, CONCAT(p.first_name,' ',p.last_name) as player,
                      t.team_name as team,op.team_name as opponent,s.score,s.number_pitchers,
                      s.score,s.ip,s.runs,s.earned_runs,s.h,s.bf,s.so,s.bb,s.hbp
               FROM stats_best_score s
               LEFT JOIN player p USING(player_id)
               LEFT JOIN team t ON s.team_id=t.team_id
               LEFT JOIN team op on s.vs_team_id=op.team_id
               WHERE YEAR(s.aim_date)=".$query_year." AND s.type IN ('S','B')  
               ORDER BY score DESC, aim_date";

               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               table_generation($result,$numofrows,'Best Scores');
               
               $result->close();               
               return array($numofrows);
            }
           
              function best_stats($conn,$query_year) {
               $querystr= "        
               SELECT rt.record_category_id,rc.entity,rc.span,rc.description,rt.league_year,rt.holder_name,rt.data,rt.annotation
               FROM record_track rt
               LEFT JOIN record_track_categories rc USING(record_category_id)
               WHERE rt.league_year=".$query_year." AND rc.season=1 AND rc.span IN ('game','series','annual')
               ORDER BY record_category_id,holder_name";

               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               echo "<table>";
               echo "<table style=\"width: 100%\">";
               echo "<tr><td align=\"left\" valign=\"top\" colspan=\"2\"><span class=\"style10\">Regular Season Top Stats</td></tr>";
               $zcategory='zzz';
               for($i = 0; $i < $numofrows; $i++) {
                  $result->data_seek($i);
                  $row = $result->fetch_array(MYSQLI_ASSOC);
                  if ($row[description]!=$zcategory) {
                     echo "<tr><td align=\"left\" valign=\"top\">".$row[description].":</td>";
                     $zcategory=$row[description];
                  }
                  else {
                     echo "<tr><td></td>";
                  }
                  echo "<td align=\"center\" valign=\"top\">".$row[data]."</td>";
                  echo "<td align=\"left\" valign=\"top\">".$row[holder_name];
                  if ($row[annotation]!=' ') {
                     echo " (".$row[annotation].")";
                  }
                  echo "</td></tr>"; 
               }
               echo "</table>";  
               
               $result->close();               
               return array($numofrows);
            }
           
            
            // Make a MySQL Connection
            require_once ("/var/www/config/brbl_connect.class.php");
            $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) die($conn->connect_error);  
            // Get request from referring page
            $query_year = $_REQUEST['year'];
            
            echo "<span class=\"bold\">Player Awards and Team Accomplishments: ".$query_year." </span><br><br>";        
            player_awards($conn,$query_year);
            echo "<br><br>";
            no_hitters($conn,$query_year);
            echo "<br><br>";
            best_scores($conn,$query_year);
            echo "<br><br>";
            best_stats($conn,$query_year);
            //$transaction_data = SQL1($conn, $query_year);
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