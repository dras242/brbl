<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Statistics</title>
 <meta name="Description" content="League leaders, club batting and pitching, and historical statistics for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="player stats, league leaders, historical statistics">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
 
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - League Statistics</h1>
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
		  <br>
		  <?php include_once("includes/brbl_logo.php") ?><br><br>		  
		  <?php include_once("includes/world_series_winner.php") ?><br><br>
          <?php include_once("includes/apba_baseball_logo.php") ?><br><br>
          <?php include_once("includes/mlb_logo.php") ?><br><br>
          <img alt="baseball statistics" width="180" height="135" src="http://www.brbl-apba.com/images/statistics_formulas_180x135.jpg">
          <br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
		     <?php 
		     
function top_10_performance($query_year,$limit_number,$stat,$fieldname,$league,$table,$thresh) {
           $orderby = 'DESC';
           if ($stat=='avg') {
              $stat2='sum(h)/sum(ab)';
              $criteria2='sum(ab+bb+sh+sf+hbp)';
              $thresh = $thresh*3.1;
           }
           else if ($stat=='era') {
              $stat2='sum(er)*9/sum(convert_ip(ip))';
              $orderby = 'ASC';
              $criteria2='sum(convert_ip(ip))';
           }
           else if ($stat=='ip') {
              $stat2='convert_ip_base3(ROUND(sum(convert_ip(ip)),1))';
              $criteria2='1000';
           }           
           else {
              $stat2= 'sum('.$stat.')';
              $criteria2='1000';
           }

           $querystr="
           SELECT DISTINCT player_id,first_name,last_name,abbrev,a1.".$stat."
           FROM 
           (select player_id,first_name, last_name, latest_team as abbrev, ".$stat2." as ".$stat."
           FROM ".$table." 
           WHERE draft_year=".$query_year." and league='".$league."' 
           GROUP BY player_id,league
           HAVING ".$criteria2." >= ".$thresh.") a1
           INNER JOIN
           (SELECT ".$stat2." AS ".$stat." from ".$table." 
           WHERE draft_year=".$query_year." and league='".$league."'
           GROUP BY player_id,league 
           HAVING ".$criteria2.">=".$thresh." 
           ORDER BY ".$stat." ".$orderby." 
           LIMIT ".$limit_number.") a2
           ON a1.".$stat."=a2.".$stat."
           ORDER BY ".$stat." ".$orderby."";

           $result = mysql_query($querystr) or die(mysql_error());
           $numofrows = mysql_num_rows($result);
           
           echo "<table><tr><td colspan=\"2\" align=\"center\"><span class=\"style12\">".$fieldname."</span></td></tr>";
           for($i = 0; $i < $numofrows; $i++) {
              $row = mysql_fetch_array($result);
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
              echo "<tr><td valign=\"top\" align=\"right\"><span class=\"style5\">".$stat_format."</span></td><td><a class=\"style8\" href=\"player.php?player=".$row['player_id']."\">".$row['first_name']." ".$row['last_name']."</a> <span class=\"style10\">".$row['abbrev']."</span></td></tr>";
           
           }
           echo "</table>";
}


function getThresh($query_year) {
           # Get Maximum games played to determine minimum criteria
           $querystr="SELECT MAX(cnt) as thresh FROM
           (SELECT COUNT(*) AS cnt,team_id FROM game_team gt
           LEFT JOIN game g ON gt.game_id=g.game_id
           WHERE gt.draft_year=".$query_year." AND g.game_type=1
           GROUP BY team_id) a";
           
           $result = mysql_query($querystr) or die(mysql_error());
           $row = mysql_fetch_array($result);
           
           return $row['thresh'];
}

function annual_leaders_hitting($query_year) {           
           
           $thresh = getThresh($query_year);
           
           echo "<table width=\"100%\">";
           echo "<tr><td align=\"center\" width=\"100%\"colspan=\"4\"><span class=\"style7\">Batting Leaders: ".$query_year."</span></td></tr>";
           echo "<tr><td align=\"center\" width=\"50%\"colspan=\"2\"><span class=\"style7\">American League</span></td>
           <td align=\"center\" width=\"50%\"colspan=\"2\"><span class=\"style7\">National League</span></td></tr>";
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'avg','AVG','AL','agg_batting_by_player_team',$thresh);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'hr','HR','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'avg','AVG','NL','agg_batting_by_player_team',$thresh);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'hr','HR','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'rbi','RBI','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'r','Runs','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'rbi','RBI','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'r','Runs','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";                
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'h','Hits','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'tb','Total Bases','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'h','Hits','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'tb','Total bases','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'b2','Doubles','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'b3','Triples','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'b2','Doubles','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'b3','Triples','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'so','Strikeouts','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'bb','Walks','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'so','Strikeouts','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'bb','Walks','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'g','Games','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ab','At Bats','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'g','Games','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ab','At Bats','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sb','Stolen Bases','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'gdp','Double Plays','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sb','Stolen Bases','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'gdp','Double Plays','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ibb','Intentional BB','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'hbp','Hit By Pitch','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ibb','Intentional BB','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'hbp','Hit By Pitch','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sh','Sacrifice Hit','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sf','Sacrifice Fly','AL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sh','Sacrifice Hit','NL','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sf','Sacrifice Fly','NL','agg_batting_by_player_team',0);
           echo "</td></tr>";

           echo "</table>";
}

function annual_leaders_pitching($query_year) {           
           
           $thresh = getThresh($query_year);
           
           echo "<table width=\"100%\">";
           echo "<tr><td align=\"center\" width=\"100%\"colspan=\"4\"><span class=\"style7\">Pitching Leaders: ".$query_year."</span></td></tr>";
           echo "<tr><td align=\"center\" width=\"50%\"colspan=\"2\"><span class=\"style7\">American League</span></td>
           <td align=\"center\" width=\"50%\"colspan=\"2\"><span class=\"style7\">National League</span></td></tr>";
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'era','ERA','AL','agg_pitching_by_player_team',$thresh);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'w','Wins','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'era','ERA','NL','agg_pitching_by_player_team',$thresh);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,10,'w','Wins','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'l','Loss','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sv','Saves','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'l','Loss','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sv','Save','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";   
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'so','Strikeouts','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'bb','Walks','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'so','Strikeouts','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'bb','Walks','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";                            
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'g','Games','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'gs','Games Started','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'g','Games','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'gs','Games Started','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";              
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'cg','Complete Games','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sho','Shutouts','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'cg','Complete Games','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'sho','Shutouts','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";                  
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'qs','Quality Starts','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ip','Innings Pitched','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'qs','Quality Starts','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ip','Innings Pitched','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";   
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'h','Hits','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'hr','Homeruns','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'h','Hits','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'hr','Homeruns','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";   
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'er','Earned Runs','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'hb','Hit By Pitch','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'er','Earned Runs','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'hb','Hit By Pitch','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";             
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'bf','Batters Faced','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ibb','Intentional BB','AL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'bf','Batters Faced','NL','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance($query_year,3,'ibb','Intentional BB','NL','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>"; 
            
           echo "</table>";
}



function league_batting($query_year,$league) {

               if ($league=='AL') {
                  $div_id_list=array(1,2,3);
                  $league_name="American League";
               }
               else {
                  $div_id_list=array(4,5,6);
                  $league_name="National League";
               }
               
               # Team Total Batting
               $querystr= "        
               SELECT t.team_name, t.abbrev,g.g,sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf,
                    sum(s.h)/sum(s.ab) as avg
               FROM stats_batting s
               INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
               INNER JOIN player p ON r.player_id=p.player_id
               INNER JOIN team t ON r.team_id=t.team_id
			   INNER JOIN (SELECT COUNT(gt.team_id) AS g, gt.team_id FROM game_team gt INNER JOIN game gm USING (game_id) WHERE gt.draft_year='".$query_year."' AND gm.game_type=1 GROUP BY team_id) g
               ON g.team_id=t.team_id               
               WHERE t.division_id in (".implode(',',$div_id_list).") AND s.draft_year='".$query_year."' AND s.game_type=1  
               GROUP BY team_name,abbrev,g
               ORDER BY avg DESC";          
   
               $result = mysql_query($querystr) or die(mysql_error());
               $numofrows = mysql_num_rows($result);
             
               echo "<div class=\"stat_group\">";
               echo "Year: ".$query_year."<br><br>";
               echo "<table width=\"100%\">";
               echo "<tr>";
               echo "<td align=\"left\" width=\"17%\">".$league_name."</td>";
               echo "<td align=\"right\" width=\"4%\">G</td>";
               echo "<td align=\"right\" width=\"6%\">AB</td>";
               echo "<td align=\"right\" width=\"4%\">R</td>";
               echo "<td align=\"right\" width=\"5%\">H</td>";
               echo "<td align=\"right\" width=\"4%\">2B</td>";
               echo "<td align=\"right\" width=\"4%\">3B</td>";
               echo "<td align=\"right\" width=\"4%\">HR</td>";
               echo "<td align=\"right\" width=\"4%\">RBI</td>";
               echo "<td align=\"right\" width=\"4%\">BB</td>";
               echo "<td align=\"right\" width=\"4%\">SO</td>";
               echo "<td align=\"right\" width=\"4%\">SB</td>";
               echo "<td align=\"right\" width=\"4%\">CS</td>";
               echo "<td align=\"right\" width=\"4%\">GDP</td>";
               echo "<td align=\"right\" width=\"4%\">SH</td>";
               echo "<td align=\"right\" width=\"4%\">SF</td>";
               echo "<td align=\"center\" width=\"5%\">AVG</td>";
               echo "<td align=\"center\" width=\"5%\">OBP</td>";
               echo "<td align=\"center\" width=\"5%\">SLG</td>";
               echo "<td align=\"center\" width=\"5%\">OBS</td>";
               echo "</tr>";
               
               # Team Totals
               for ($i = 0; $i < $numofrows; $i++) {
                   $row = mysql_fetch_array($result);
                   $team = $row['team_name'];
                   $abbrev = $row['abbrev'];                   
                   $team_id = $row['team_id'];
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
                   $avg = ".".strval(number_format($h/$ab,3)*1000);
                   $obp = ".".strval(number_format(($h+$bb+$hbp)/($ab+$bb+$hbp+$sf),3)*1000);
                   $slg = ".".strval(number_format($tb/$ab,3)*1000);
                   $obs = ".".strval(number_format((($h+$bb+$hbp)/($ab+$bb+$hbp+$sf))+($tb/$ab),3)*1000);

                   echo "<tr class=\"spaceUnder\">";
                   echo "<td align=\"left\" width=\"17%\"><a class=\"style8\" href=\"teams.php?team=".$abbrev."&view=batting&year=".$query_year."\">".$team."</a></td>";
                   echo "<td align=\"right\" width=\"4%\">".$g."</td>";
                   echo "<td align=\"right\" width=\"6%\">".$ab."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$r."</td>";
                   echo "<td align=\"right\" width=\"5%\">".$h."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$b2."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$b3."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$hr."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$rbi."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$bb."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$so."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sb."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$cs."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$gdp."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sh."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sf."</td>";                   
                   echo "<td align=\"center\" width=\"5%\">".$avg."</td>";                   
                   echo "<td align=\"center\" width=\"5%\">".$obp."</td>";
                   echo "<td align=\"center\" width=\"5%\">".$slg."</td>";
                   echo "<td align=\"center\" width=\"5%\">".$obs."</td>";                   
                   echo "</tr>";

               }
               
               # League Total Batting
               $querystr= "        
               SELECT sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf,
                    sum(s.h)/sum(s.ab) as avg
               FROM stats_batting s
               INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
               INNER JOIN player p ON r.player_id=p.player_id
               INNER JOIN team t ON r.team_id=t.team_id
			   INNER JOIN (SELECT COUNT(gt.team_id) AS g, gt.team_id FROM game_team gt INNER JOIN game gm USING (game_id) WHERE gt.draft_year='".$query_year."' AND gm.game_type=1 GROUP BY team_id) g
               ON g.team_id=t.team_id               
               WHERE t.division_id in (".implode(',',$div_id_list).") AND s.draft_year='".$query_year."' AND s.game_type=1 
               ORDER BY avg DESC";          
   
               $result = mysql_query($querystr) or die(mysql_error());
               $numofrows = mysql_num_rows($result);
              
               $row = mysql_fetch_array($result);
               $team = '- League Total -';
               $g ='-';
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
               echo "<td align=\"left\" width=\"17%\">".$team."</td>";
               echo "<td align=\"right\" width=\"4%\">".$g."</td>";
               echo "<td align=\"right\" width=\"6%\">".$ab."</td>";
               echo "<td align=\"right\" width=\"4%\">".$r."</td>";
               echo "<td align=\"right\" width=\"5%\">".$h."</td>";
               echo "<td align=\"right\" width=\"4%\">".$b2."</td>";
               echo "<td align=\"right\" width=\"4%\">".$b3."</td>";
               echo "<td align=\"right\" width=\"4%\">".$hr."</td>";
               echo "<td align=\"right\" width=\"4%\">".$rbi."</td>";
               echo "<td align=\"right\" width=\"4%\">".$bb."</td>";
               echo "<td align=\"right\" width=\"4%\">".$so."</td>";
               echo "<td align=\"right\" width=\"4%\">".$sb."</td>";
               echo "<td align=\"right\" width=\"4%\">".$cs."</td>";
               echo "<td align=\"right\" width=\"4%\">".$gdp."</td>";
               echo "<td align=\"right\" width=\"4%\">".$sh."</td>";
               echo "<td align=\"right\" width=\"4%\">".$sf."</td>";                   
               echo "<td align=\"center\" width=\"5%\">".$avg."</td>";                   
               echo "<td align=\"center\" width=\"5%\">".$obp."</td>";
               echo "<td align=\"center\" width=\"5%\">".$slg."</td>";
               echo "<td align=\"center\" width=\"5%\">".$obs."</td>";                   
               echo "</tr>";
               
               echo "</table></div>";

}

function league_pitching($query_year,$league) {

               if ($league=='AL') {
                  $div_id_list=array(1,2,3);
                  $league_name="American League";
               }
               else {
                  $div_id_list=array(4,5,6);
                  $league_name="National League";
               }
               
               # Team Total Pitching
               $querystr= "        
               SELECT t.team_name, t.abbrev,sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, convert_ip_base3(round(sum(convert_ip(s.ip)),1)) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb,
                    sum(s.er)*9/sum(convert_ip(s.ip)) as era 
               FROM agg_pitching_by_player_team s
               INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
               INNER JOIN player p ON r.player_id=p.player_id
               INNER JOIN team t ON r.team_id=t.team_id
			   INNER JOIN (SELECT COUNT(gt.team_id) AS g, gt.team_id FROM game_team gt INNER JOIN game gm USING (game_id) WHERE gt.draft_year='".$query_year."' AND gm.game_type=1 GROUP BY team_id) g
               ON g.team_id=t.team_id               
               WHERE t.division_id in (".implode(',',$div_id_list).") AND s.draft_year='".$query_year."'
               GROUP BY team_name,abbrev
               ORDER BY era";          
   
               $result = mysql_query($querystr) or die(mysql_error());
               $numofrows = mysql_num_rows($result);
               
               echo "<div class=\"stat_group\">";
               echo "Year: ".$query_year."<br><br>";
               echo "<table width=\"100%\">";
               echo "<tr>";
               echo "<td align=\"left\" width=\"21%\">".$league_name."</td>";
               echo "<td align=\"right\" width=\"3%\">W</td>";
               echo "<td align=\"right\" width=\"3%\">L</td>";
               echo "<td align=\"right\" width=\"3%\">S</td>";
               echo "<td align=\"right\" width=\"3%\">G</td>";
               echo "<td align=\"right\" width=\"3%\">GS</td>";
               echo "<td align=\"right\" width=\"4%\">CG</td>";
               echo "<td align=\"right\" width=\"5%\">SHO</td>";
               echo "<td align=\"right\" width=\"4%\">QS</td>";
               echo "<td align=\"right\" width=\"6%\">IP</td>";
               echo "<td align=\"right\" width=\"4%\">H</td>";
               echo "<td align=\"right\" width=\"4%\">R</td>";
               echo "<td align=\"right\" width=\"4%\">ER</td>";
               echo "<td align=\"right\" width=\"4%\">HR</td>";
               echo "<td align=\"right\" width=\"4%\">SO</td>";
               echo "<td align=\"right\" width=\"4%\">BB</td>";
               echo "<td align=\"right\" width=\"5%\">BF</td>";
               echo "<td align=\"right\" width=\"5%\">IBB</td>";
               echo "<td align=\"right\" width=\"5%\">HBP</td>"; 
               echo "<td align=\"center\" width=\"6%\">ERA</td>";                  echo "</tr>";
               
               # Team Totals
               for ($i = 0; $i < $numofrows; $i++) {
                   $row = mysql_fetch_array($result);
                   $team = $row['team_name'];
                   $abbrev = $row['abbrev'];                   
                   $team_id = $row['team_id'];
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
                   echo "<td align=\"left\" width=\"21%\"><a class=\"style8\" href=\"teams.php?team=".$abbrev."&view=pitching&year=".$query_year."\">".$team."</a></td>";
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
                   echo "<td align=\"right\" width=\"5%\">".$ibb."</td>";    
                   echo "<td align=\"right\" width=\"5%\">".$hb."</td>";   
                   echo "<td align=\"center\" width=\"6%\">".$era."</td>";                  
                   echo "</tr>";

               }
               
               # League Total Pitching
               $querystr= "        
               SELECT sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, round(sum(convert_ip(s.ip))) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb,
                    sum(s.er)*9/sum(convert_ip(s.ip)) as era               
               FROM agg_pitching_by_player_team s
               INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
               INNER JOIN player p ON r.player_id=p.player_id
               INNER JOIN team t ON r.team_id=t.team_id
			   INNER JOIN (SELECT COUNT(gt.team_id) AS g, gt.team_id FROM game_team gt INNER JOIN game gm USING (game_id) WHERE gt.draft_year='".$query_year."' AND gm.game_type=1 GROUP BY team_id) g
               ON g.team_id=t.team_id               
               WHERE t.division_id in (".implode(',',$div_id_list).") AND s.draft_year='".$query_year."' 
               ";          
   
               $result = mysql_query($querystr) or die(mysql_error());
               $numofrows = mysql_num_rows($result);
              
               $row = mysql_fetch_array($result);
               $team = '- League Total -';
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
               echo "<td align=\"left\" width=\"17%\">".$team."</td>";
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
               echo "<td align=\"right\" width=\"5%\">".$ibb."</td>";    
               echo "<td align=\"right\" width=\"5%\">".$hb."</td>";   
               echo "<td align=\"center\" width=\"6%\">".$era."</td>";                    
               echo "</tr>";
               
               echo "</table></div>";

}


function league_batting_manager($query_year) {
           league_batting($query_year,'AL');
           league_batting($query_year,'NL');
}

function league_pitching_manager($query_year) {
           league_pitching($query_year,'AL');
           league_pitching($query_year,'NL');
}

           

function print_header($query_year) {
           echo "<span class=\"style5\"><a href=\"stats.php?year=".$query_year."&stat=annual_batting\">Batting Leaders</a> | 
           <a href=\"stats.php?year=".$query_year."&stat=annual_pitching\">Pitching Leaders</a> |
           <a href=\"stats.php?year=".$query_year."&stat=league_batting\">Team Batting</a> | 
           <a href=\"stats.php?year=".$query_year."&stat=league_pitching\">Team Pitching</a></span>";
           echo "<br><br>";                            
               
}		     
		     
		     // Make a MySQL Connection
             require_once ("/var/www/config/brbl_connect.class.php");
             $link=mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
             mysql_select_db(DB_NAME) or die(mysql_error());
             // Get request from referring page
             $query_year = $_REQUEST['year'];
             $query_stat = $_REQUEST['stat'];
             print_header($query_year);
		     if ($query_stat=='annual_batting') {
                annual_leaders_hitting($query_year);
             }
		     else if ($query_stat=='annual_pitching') {
                annual_leaders_pitching($query_year);
             }
		     else if ($query_stat=='league_batting') {
                league_batting_manager($query_year);
             }
		     else if ($query_stat=='league_pitching') {
                league_pitching_manager($query_year);
             }

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