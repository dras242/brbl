<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Game Scores and Results</title>
 <meta name="Description" content="Game history, scores, and summary for the APBA Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="brbl games, brbl score">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Game Results</h1>
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
          <br>
		  <?php include_once("includes/brbl_logo.php") ?><br><br>		  
		  <?php include_once("includes/world_series_winner.php") ?><br><br>
          <?php include_once("includes/apba_baseball_logo.php") ?><br><br>
          <img alt="homerun zone" width="180" height="196" src="http://www.brbl-apba.com/images/homerun_zone_180x196.jpg">
          
          <br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
            <?php

            
            function get_current_week($conn, $query_year) {
               //find the most current week
               $querystr= "        
               SELECT MAX(g.w_id) as week 
               FROM game_team gt LEFT JOIN game g ON gt.game_id=g.game_id
               WHERE g.game_type=1 and g.league_year='".$query_year."'";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
              
               $row = $result->fetch_array(MYSQLI_ASSOC); 
               if ($row['week']>1) {
                  return $row['week']; 
               }
               else {
                  return 1;
               }
               $result->close();
                                                                                                       
            }
            
            function print_header($query_year, $query_week) {
               echo "<h2>Game Schedule/Scores</h2>";
               echo "<span class=\"style1\">
               <a href=\"game-scores.php?year=".$query_year."&amp;week=1\">W1</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=2\">W2</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=3\">W3</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=4\">W4</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=5\">W5</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=6\">W6</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=7\">W7</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=8\">W8</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=9\">W9</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=10\">W10</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=11\">W11</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=12\">W12</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=13\">W13</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=14\">W14</a><br> 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=15\">W15</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=16\">W16</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=17\">W17</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=18\">W18</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=19\">W19</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=20\">W20</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=21\">W21</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=22\">W22</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=23\">W23</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=24\">W24</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=25\">W25</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=26\">W26</a> |                           
               <a href=\"game-scores.php?year=".$query_year."&amp;week=27\">W27</a> | 
               <a href=\"game-scores.php?year=".$query_year."&amp;week=28\">W28</a>                                          
               </span><br><br>";
               
               echo "League Year: ".$query_year."&nbsp;&nbsp;&nbsp;Week: ".$query_week."<br>";
               echo "<br><br>";
            }
            
            function SQL1($conn, $query_year, $query_week) {
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
               WHERE g.league_year='".$query_year."' AND g.w_id=".$query_week." AND g.al_nl='NL'
               ORDER BY thome.abbrev, g.aim_date
               ";           
                  
               $result_nl = $conn->query($querystr);
               if (!$result_nl) die($conn->error);
               $numofrows = $result_nl->num_rows;
               
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
               WHERE g.league_year='".$query_year."' AND g.w_id=".$query_week." AND g.al_nl='AL'
               ORDER BY thome.abbrev, g.aim_date
               ";        
   
               $result_al = $conn->query($querystr);
               if (!$result_al) die($conn->error);
               $numofrows = $result_al->num_rows;
       
               echo "<table style=\"width: 100%\"><tr>";
               echo "<td width=\"50%\" align=\"left\" valign=\"top\"><span class=\"style7\">American League</span></td>";
               echo "<td width=\"50%\" align=\"left\" valign=\"top\"><span class=\"style7\">National League</span></td>";
               echo "</tr>";
               echo "<tr><td></td></tr>";
               for($i = 0; $i < $numofrows; $i++) {
                 echo "<tr>";
                 echo "<td width=\"50%\" align=\"left\" valign=\"top\">";
                 $result_al->data_seek($i);
                 $row_al = $result_al->fetch_array(MYSQLI_ASSOC); 
                 $al_game_id = $row_al['game_id'];
                 $al_aim_date = $row_al['aim_date'];       
                 $al_extra = $row_al['extra'];
                 $al_extra_innings='';
                 if (intval($al_extra) >='10') {
                    $al_extra_innings = ' - '.$al_extra.' INNINGS';
                 }              
                 $al_away_team = $row_al['away_team'];
                 $al_home_team = $row_al['home_team'];
                 $al_away_runs = $row_al['a_runs'];
                 $al_home_runs = $row_al['h_runs'];  
                 $al_away_hits = $row_al['a_hits'];
                 $al_home_hits = $row_al['h_hits']; 
                 $al_away_errors = $row_al['a_errors'];
                 $al_home_errors = $row_al['h_errors']; 
                 $al_away_score = $row_al['a_score'];
                 $al_home_score = $row_al['h_score'];                  
                 $al_away_starter = $row_al['a_starting_pitcher']; 
                 $al_home_starter = $row_al['h_starting_pitcher'];
                 $al_save = ''; 
                 if ($al_away_runs>$al_home_runs) {
                    $al_winner = $row_al['a_decision_pitcher'];
                    $al_loser = $row_al['h_decision_pitcher'];
                    if ($row_al['a_save_pitcher']) {
                       $al_save = $row_al['a_save_pitcher'];
                    }
                 }
                 else {
                    $al_winner = $row_al['h_decision_pitcher'];
                    $al_loser = $row_al['a_decision_pitcher'];
                    if ($row_al['h_save_pitcher']) {
                       $al_save = $row_al['h_save_pitcher'];
                    }                    
                 }
              
                 echo "<span class=\"style1\">AIM Date: ".$al_aim_date."</span><span class=\"style9\">".$al_extra_innings."</span>";
                 echo "<table style=\"width: 100%\">";
                 echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style9\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$al_away_team."&view=games&year=".$query_year."\">".$al_away_team."</a></span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$al_away_runs."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$al_away_hits."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$al_away_errors."</span></td>";
                 echo "<td width=\"35%\" align=\"left\" valign=\"top\"><span class=\"style9\">".$al_away_starter." ".$al_away_score."</span></td>";
                 echo "</tr>";
                 echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style9\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$al_home_team."&view=games&year=".$query_year."\">".$al_home_team."</a></span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$al_home_runs."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$al_home_hits."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$al_home_errors."</span></td>";
                 echo "<td width=\"35%\" align=\"left\" valign=\"top\"><span class=\"style9\">".$al_home_starter." ".$al_home_score."</span></td>";
                 echo "</tr>";        
                 if ($al_away_runs != $al_home_runs) {
                    echo "<tr><td width=\"100%\" align=\"left\" colspan=\"5\">";
                    echo "<span class=\"style9\"> W: ".$al_winner."&nbsp;&nbsp;&nbsp; L: ".$al_loser."&nbsp;&nbsp;&nbsp; S: ".$al_save."</span>";
                    echo "</td></tr>";
                 }
                         
                 echo "</table>"; 
                 
                 echo "<td width=\"50%\" align=\"left\" valign=\"top\">";
                 $result_nl->data_seek($i);
                 $row_nl = $result_nl->fetch_array(MYSQLI_ASSOC); 
                 $nl_game_id = $row_nl['game_id'];
                 $nl_aim_date = $row_nl['aim_date'];  
                 $nl_extra = $row_nl['extra'];
                 $nl_extra_innings='';
                 if (intval($nl_extra) >='10') {
                    $nl_extra_innings = ' - '.$nl_extra.' INNINGS';
                 }                                               
                 $nl_away_team = $row_nl['away_team'];
                 $nl_home_team = $row_nl['home_team'];
                 $nl_away_runs = $row_nl['a_runs'];
                 $nl_home_runs = $row_nl['h_runs'];  
                 $nl_away_hits = $row_nl['a_hits'];
                 $nl_home_hits = $row_nl['h_hits']; 
                 $nl_away_errors = $row_nl['a_errors'];
                 $nl_home_errors = $row_nl['h_errors']; 
                 $nl_away_score = $row_nl['a_score'];
                 $nl_home_score = $row_nl['h_score'];                    
                 $nl_away_starter = $row_nl['a_starting_pitcher']; 
                 $nl_home_starter = $row_nl['h_starting_pitcher'];
                 $nl_save = '';    
                 if ($nl_away_runs>$nl_home_runs) {
                    $nl_winner = $row_nl['a_decision_pitcher'];
                    $nl_loser = $row_nl['h_decision_pitcher'];
                    if ($row_nl['a_save_pitcher']) {
                       $nl_save = $row_nl['a_save_pitcher'];
                    }
                 }
                 else {
                    $nl_winner = $row_nl['h_decision_pitcher'];
                    $nl_loser = $row_nl['a_decision_pitcher'];
                    if ($row_nl['h_save_pitcher']) {
                       $nl_save = $row_nl['h_save_pitcher'];
                    }                    
                 }
                                                                            
                 echo "<span class=\"style1\">AIM Date: ".$nl_aim_date."</span><span class=\"style9\">".$nl_extra_innings."</span>";
                 echo "<table style=\"width: 100%\">";
                 echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style9\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$nl_away_team."&view=games&year=".$query_year."\">".$nl_away_team."</a></span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$nl_away_runs."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$nl_away_hits."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$nl_away_errors."</span></td>";
                 echo "<td width=\"35%\" align=\"left\" valign=\"top\"><span class=\"style9\">".$nl_away_starter." ".$nl_away_score."</span></td>";
                 echo "</tr>";
                 echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style9\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$nl_home_team."&view=games&year=".$query_year."\">".$nl_home_team."</a></span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$nl_home_runs."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$nl_home_hits."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style9\">".$nl_home_errors."</span></td>";
                 echo "<td width=\"35%\" align=\"left\" valign=\"top\"><span class=\"style9\">".$nl_home_starter." ".$nl_home_score."</span></td>";
                 echo "</tr>";  
                 if ($nl_away_runs != $nl_home_runs) {
                    echo "<tr><td width=\"100%\" align=\"left\" colspan=\"5\">";
                    echo "<span class=\"style9\"> W: ".$nl_winner."&nbsp;&nbsp;&nbsp; L: ".$nl_loser."&nbsp;&nbsp;&nbsp; S: ".$nl_save."</span>";
                    echo "</td></tr>";
                 }
              
                 echo "</table>";        

                 echo "</td>";
                 
                 echo "</tr>";  
                 echo "<tr><td></td></tr>";                                           
               }
               echo "</table>";
               $result_al->close();
               $result_nl->close();
            }

            
            // Make a MySQL Connection
            require_once ("/var/www/config/brbl_connect.class.php");
            $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) die($conn->connect_error); 
            // Get request from referring page
            $query_year = $_REQUEST['year'];
            $query_week = $_REQUEST['week'];
            
            // If $week is not included in the string, the default is to determine and use the most current week//
            if (!$query_week) {          
               $query_week = get_current_week($conn,$query_year);
            }
            
            print_header($query_year,$query_week);
            
            SQL1($conn,$query_year,$query_week);
            
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