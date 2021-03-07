<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Player</title>
 <meta name="Description" content="Player profile and stats for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="player stats, player history">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
 
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Player</h1>
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
		  <br>
		  <?php include_once("includes/brbl_logo.php") ?><br><br>		  
		  <?php include_once("includes/world_series_winner.php") ?><br><br>
          <?php include_once("includes/apba_baseball_logo.php") ?><br><br>
          <?php include_once("includes/mlb_logo.php") ?><br>
          <br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
		     <?php 
             function player_index($conn,$query_index) {
               // Player Index
               $querystr= "
               SELECT p.player_id, p.first_name, p.middle_name, p.last_name,CAST(p.first_year as SIGNED)+1 AS first_year,c.date_to, c.team_id, t.team_name
               FROM player p
               LEFT JOIN
               (SELECT DISTINCT player_id from 
               (SELECT DISTINCT player_id from stats_batting
               UNION 
               SELECT DISTINCT player_id from stats_pitching) a) b 
               ON p.player_id=b.player_id
               LEFT JOIN 
               (SELECT rbi.roster_brbl_id, rbi.player_id, rbi.team_id, rbi.date_to FROM roster_brbl rbi INNER JOIN  
               (SELECT MAX(roster_brbl_id) AS roster_brbl_id FROM roster_brbl GROUP BY player_id) e
               ON rbi.roster_brbl_id=e.roster_brbl_id) c
               ON p.player_id=c.player_id
               LEFT JOIN team t 
               ON c.team_id=t.team_id
               WHERE LEFT(last_name,1)='".$query_index."' 
               ORDER BY last_name, first_name, middle_name";            
               
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               echo "<table width=\"100%\">";
               echo "<tr><td align=\"left\"><span class=\"style10\">Player Index</span></td></tr>";
               echo "<tr><td align=\"left\" colspan=\"3\">";
               $alpha_list=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
               for ($i = 0; $i < count($alpha_list); ++$i) {
                   echo " <a href=\"player.php?index=".$alpha_list[$i]."\">".$alpha_list[$i]."</a> |";
               }
               echo "</td></tr><tr><td>&nbsp;</td></tr>";
               echo "<tr><td align=\"left\">Player</td><td align=\"left\">Team</td><td align=\"left\">First BRBL Year</td></tr>";
               # Player List
               for ($i = 0; $i < $numofrows; $i++) {
                   $result->data_seek($i);
                   $row = $result->fetch_array(MYSQLI_ASSOC);   
                   echo "<tr><td align=\"left\"><a class=\"style3\" href=\"player.php?player=".$row['player_id']."\">".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']."</a></td>";
                   echo "<td align=\"left\">".$row['team_name']."</td>";
                   echo "<td align=\"left\">".$row['first_year']."</td>";
                   echo "</tr>";
               }
               echo "</table>";
               $result->close();

             }           
             
             function player_profile($conn,$query_player, $query_year) {                       
               $mlb_year = $query_year-1;

               // Player Profile - Used Limit clause to get the most recent active year (prevents problem with uncarded players
               $querystr= "        
               SELECT p.player_id,r.team_id, p.last_name,p.first_name, pl.player_year_id,
               p.bat, p.throw, ".$mlb_year."-p.birthyear AS age, t.team_name, t.abbrev,pl.position
               FROM roster_brbl r
               LEFT JOIN player p ON r.player_id=p.player_id
               LEFT JOIN player_year pl ON p.player_id=pl.player_id 
               LEFT JOIN team t on r.team_id=t.team_id
               WHERE p.player_id=".$query_player."  AND r.date_to IS NULL 
               ORDER BY player_year_id DESC
               LIMIT 1";  
               
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);

               $row = $result->fetch_array(MYSQLI_ASSOC);                  
               $position = $row['position'];
               $team_id = $row['team_id'];
               $team_abbrev = $row['abbrev'];
               $team_name = $row['team_name'];
               if (!isset($team_name)) {
                  $team_name="Unsigned";
               }
               echo "<span class=\"style7b\">".$row['first_name']." ".$row['last_name']."</span><br>";
               echo "<a href=\"teams.php?team=".$team_abbrev."&view=main&year=".$query_year."\">".$team_name."</a>&nbsp;&nbsp;&nbsp;(".$position.")&nbsp;&nbsp;&nbsp;<br>";
               echo "Bats: ".$row['bat']."&nbsp;&nbsp;&nbsp;Throws: ".$row['throw']."&nbsp;&nbsp;&nbsp;Age: ".$row['age']."";
               echo "<br><br>";
               $result->close();
               return $position;
 
             }	
             
             function batting_stats($conn,$query_player,$query_year, $period) {
               
               if ($period=='Annual') {
                  echo "<div id=\"batting_annual\" class=\"stat_group\">";
               
                  $querystr= "   
                  (SELECT t.abbrev,s.draft_year, sum(s.g) as g, sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf 
                  FROM stats_batting s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player." AND s.game_type=1 
                  GROUP BY s.draft_year,t.abbrev)
                UNION
                  (SELECT '|Total' AS abbrev, s.draft_year, sum(s.g) as g, sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf 
                  FROM stats_batting s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player." AND s.game_type=1 AND s.draft_year in 
                  (SELECT draft_year FROM
                    (SELECT DISTINCT roster_brbl_id,draft_year from stats_batting WHERE player_id=".$query_player.") A
                  GROUP BY draft_year
                  HAVING count(*)>1) 
                  GROUP BY s.draft_year)
                UNION 
                  (SELECT '' AS abbrev, 'Career' AS draft_year, sum(s.g) as g, sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf 
                  FROM stats_batting s
                  WHERE s.player_id=".$query_player." AND s.game_type=1)                
                  ORDER BY draft_year,abbrev"; 
               }
               elseif ($period=='Week') {
                  echo "<div id=\"batting_week\" class=\"stat_group\">";
               
                  $querystr= "   
                  SELECT t.abbrev,s.week, ".$query_year." AS draft_year, sum(s.g) as g, sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf
                  FROM stats_batting s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player." AND s.draft_year=".$query_year." AND g>0 
                  GROUP BY s.week
                  ORDER BY s.week"; 
               }           
               elseif ($period=='PostSeason') {
                  echo "<div id=\"batting_week\" class=\"stat_group\">";
               
                  $querystr= "   
                  SELECT t.abbrev,s.draft_year, sum(s.g) as g, sum(s.ab) as ab, sum(s.r) as r, sum(s.h) as h, 
                    sum(s.b2) as b2, sum(s.b3) as b3, sum(s.hr) as hr, sum(s.tb) as tb, sum(s.rbi) as rbi, 
                    sum(s.so) as so, sum(s.bb) as bb, sum(s.sb) as sb, sum(s.cs) as cs, sum(s.gdp) as gdp,
                    sum(s.pa) as pa, sum(s.ibb) as ibb, sum(s.hbp) as hbp, sum(s.sh) as sh, sum(s.sf) as sf
                  FROM stats_batting s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player." AND s.game_type=2
                  GROUP BY s.draft_year 
                  ORDER BY draft_year"; 
               }  
                              
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               if ($period=='PostSeason' && $numofrows>0) {
                  $postseason_status=1;
               }
               else {
                  $postseason_status=2;
               }               

               echo "<table width=\"100%\">";
               if ($period=='Annual') {               
                  echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Batting (Annual)</span></td></tr>";
               }
               elseif ($period=='Week') {               
                  echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Batting (Weekly)</span></td></tr>";
               }
               elseif ($period=='PostSeason') {               
                  echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Post Season (Annual)</span></td></tr>";
               }                             
               echo "<tr>";
               if ($period=='Annual' || $period=='PostSeason') {
                  echo "<td width=\"10%\">Year</td>";
               }
               elseif ($period=='Week') {
                  echo "<td width=\"10%\">".$query_year."</td>";
               }
               
               echo "<td width=\"8%\">Team</td>";
               echo "<td align=\"right\" width=\"4%\">G</td>";
               echo "<td align=\"right\" width=\"4%\">AB</td>";
               echo "<td align=\"right\" width=\"4%\">R</td>";
               echo "<td align=\"right\" width=\"4%\">H</td>";
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
               echo "<td align=\"center\" width=\"7%\">AVG</td>";
               echo "<td align=\"center\" width=\"5%\">OBP</td>";
               echo "<td align=\"center\" width=\"5%\">SLG</td>";
               echo "<td align=\"center\" width=\"5%\">OBS</td>";

               echo "</tr>";

               for ($i = 0; $i < $numofrows; $i++) {
                   $result->data_seek($i);
                   $row = $result->fetch_array(MYSQLI_ASSOC);                      
                   $draft_year =$row['draft_year'];
                   $week =$row['week'];
                   $abbrev =$row['abbrev'];
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
                   $obs = ".".str_pad(strval(number_format((($h+$bb+$hbp)/($ab+$bb+$hbp+$sf))+($tb/$ab),3)*1000),3,'0',STR_PAD_LEFT);;
                   
                   if ($week=='W29') {
                      echo "<tr><td>&nbsp;</td></tr><tr><td colspan=\"3\">Post Season</td></tr>";
                   }
                   
                   echo "<tr>";
                   if ($period=='Annual') {  
                      echo "<td width=\"10%\">".$draft_year."</td>";
                   }
                   elseif ($period=='PostSeason') {  
                      echo "<td width=\"10%\">".$draft_year."</td>";
                   }                      
                   elseif ($period=='Week') {      
                      if ($week=='W29') {
                         $week='R1';
                      } 
                      elseif ($week=='W30') {
                         $week='R2';
                      } 
                      elseif ($week=='W31') {
                         $week='R3';
                      }                                   
                      echo "<td width=\"10%\">".$week."</td>";
                   }
                   if ($abbrev=='|Total') {
                      echo "<td width=\"8%\">- Total -</td>";  
                   }
                   else {
                      echo "<td width=\"8%\"><a href=\"teams.php?team=".$abbrev."&view=batting&year=".$draft_year."\">".$abbrev."</a></td>";
                   }
                   echo "<td align=\"right\" width=\"4%\">".$g."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$ab."</td>";
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
                   echo "<td align=\"right\" width=\"4%\">".$gdp."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sh."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sf."</td>";                   
                   echo "<td align=\"center\" width=\"7%\">".$avg."</td>";                   
                   echo "<td align=\"center\" width=\"5%\">".$obp."</td>";
                   echo "<td align=\"center\" width=\"5%\">".$slg."</td>";
                   echo "<td align=\"center\" width=\"5%\">".$obs."</td>";                   
                   echo "</tr>";
               }
               echo "</table>";
               echo "</div>";
               $result->close();	     
		     }
		     
		     
		     function pitching_stats($conn,$query_player,$query_year,$period) {
               if ($period=='Annual') {
                  echo "<div id=\"pitching_annual\" class=\"stat_group\">";
               
                  $querystr= "   
                  (SELECT t.abbrev,s.draft_year, sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, convert_ip_base3(ROUND(sum(convert_ip(s.ip)),1)) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb
                  FROM agg_pitching_by_player_team s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player."
                  GROUP BY s.draft_year,t.abbrev
                  ORDER BY s.draft_year,t.abbrev)
                UNION
                  (SELECT '|Total' AS abbrev, s.draft_year, sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, convert_ip_base3(ROUND(convert_ip(sum(s.ip)),1)) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb                 
                  FROM agg_pitching_by_player_team s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player." AND s.draft_year in 
                  (SELECT draft_year FROM
                    (SELECT DISTINCT roster_brbl_id,draft_year from stats_pitching WHERE player_id=".$query_player.") A
                  GROUP BY draft_year
                  HAVING count(*)>1) 
                  GROUP BY s.draft_year)                
                UNION
                  (SELECT '' AS abbrev, 'Career' AS draft_year, sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, convert_ip_base3(ROUND(sum(convert_ip(s.ip)),1)) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb
                  FROM agg_pitching_by_player_team s
                  WHERE s.player_id=".$query_player.")
                  ORDER BY draft_year,abbrev";                             
               }
               elseif ($period=='Week') {
                  echo "<div id=\"pitching_week\" class=\"stat_group\">";
               
                  $querystr= "   
                  SELECT t.abbrev,s.week, ".$query_year." AS draft_year, sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, sum(s.ip) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb
                  FROM stats_pitching s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player." AND s.draft_year=".$query_year." AND g>0
                  GROUP BY s.week
                  ORDER BY s.week"; 
               }           
               elseif ($period=='PostSeason') {
                  echo "<div id=\"pitching_week\" class=\"stat_group\">";
               
                  $querystr= "   
                  SELECT t.abbrev,s.draft_year, sum(s.w) as w, sum(s.l) as l, sum(s.sv) as sv, sum(s.g) as g, 
                    sum(s.gs) as gs, sum(s.cg) as cg, sum(s.sho) as sho, sum(s.qs) as qs, sum(s.ip) as ip, 
                    sum(s.h) as h, sum(s.r) as r, sum(s.er) as er, sum(s.hr) as hr, sum(s.so) as so, 
                    sum(s.bb) as bb, sum(s.bf) as bf, sum(s.ibb) as ibb, sum(s.hb) as hb
                  FROM stats_pitching s
                  INNER JOIN roster_brbl r ON s.roster_brbl_id=r.roster_brbl_id
                  INNER JOIN player p ON r.player_id=p.player_id
                  INNER JOIN team t ON r.team_id=t.team_id
                  WHERE s.player_id=".$query_player." AND s.game_type=2 
                  GROUP BY s.draft_year
                  ORDER BY draft_year"; 
               } 
                              
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               if ($period=='PostSeason' && $numofrows>0) {
                  $postseason_status=1;
               }
               else {
                  $postseason_status=2;
               } 

               echo "<table width=\"100%\">";
               if ($period=='Annual') {               
                  echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Pitching (Annual)</span></td></tr>";
               }
               elseif ($period=='Week') {               
                  echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Pitching (Weekly)</span></td></tr>";
               }    
               elseif ($period=='PostSeason') {               
                  echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Post Season (Annual)</span></td></tr>";
               }                          
               echo "<tr>";
               if ($period=='Annual' || $period=='PostSeason') {
                  echo "<td width=\"5%\">Year</td>";
               }
               elseif ($period=='Week') {
                  echo "<td width=\"5%\">".$query_year."</td>";
               }
               echo "<td width=\"10%\">Team</td>";
               echo "<td align=\"right\" width=\"4%\">W</td>";
               echo "<td align=\"right\" width=\"4%\">L</td>";
               echo "<td align=\"right\" width=\"4%\">S</td>";
               echo "<td align=\"right\" width=\"4%\">G</td>";
               echo "<td align=\"right\" width=\"4%\">GS</td>";
               echo "<td align=\"right\" width=\"4%\">CG</td>";
               echo "<td align=\"right\" width=\"5%\">SHO</td>";
               echo "<td align=\"right\" width=\"4%\">QS</td>";
               echo "<td align=\"right\" width=\"7%\">IP</td>";
               echo "<td align=\"right\" width=\"4%\">H</td>";
               echo "<td align=\"right\" width=\"4%\">R</td>";
               echo "<td align=\"right\" width=\"4%\">ER</td>";
               echo "<td align=\"right\" width=\"4%\">HR</td>";
               echo "<td align=\"right\" width=\"4%\">SO</td>";
               echo "<td align=\"right\" width=\"4%\">BB</td>";
               echo "<td align=\"right\" width=\"7%\">BF</td>";
               echo "<td align=\"right\" width=\"4%\">IBB</td>";
               echo "<td align=\"right\" width=\"5%\">HBP</td>"; 
               echo "<td align=\"center\" width=\"5%\">ERA</td>"; 
               echo "</tr>";

               for ($i = 0; $i < $numofrows; $i++) {
                   $result->data_seek($i);
                   $row = $result->fetch_array(MYSQLI_ASSOC);   
                   $draft_year =$row['draft_year'];
                   $week =$row['week'];
                   $abbrev =$row['abbrev'];
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
 
                   if ($week=='W29') {
                      echo "<tr><td>&nbsp;</td></tr><tr><td colspan=\"3\">Post Season</td></tr>";
                   }                   
                  
                   echo "<tr>";
                   if ($period=='Annual') {  
                      echo "<td width=\"5%\">".$draft_year."</td>";
                   }
                   elseif ($period=='PostSeason') {  
                      echo "<td width=\"5%\">".$draft_year."</td>";
                   }                   
                   elseif ($period=='Week') {
                      if ($week=='W29') {
                         $week='R1';
                      } 
                      elseif ($week=='W30') {
                         $week='R2';
                      } 
                      elseif ($week=='W31') {
                         $week='R3';
                      }                                                                 
                      echo "<td width=\"5%\">".$week."</td>";
                   }
                   if ($abbrev=='|Total') {
                      echo "<td width=\"8%\">- Total -</td>";  
                   }
                   else {
                      echo "<td width=\"8%\"><a href=\"teams.php?team=".$abbrev."&view=pitching&year=".$draft_year."\">".$abbrev."</a></td>";
                   }
                   echo "<td align=\"right\" width=\"4%\">".$w."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$l."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$sv."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$g."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$gs."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$cg."</td>";
                   echo "<td align=\"right\" width=\"5%\">".$sho."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$qs."</td>";
                   echo "<td align=\"right\" width=\"7%\">".$ip."</td>";                   
                   echo "<td align=\"right\" width=\"4%\">".$h."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$r."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$er."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$hr."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$so."</td>";                   
                   echo "<td align=\"right\" width=\"4%\">".$bb."</td>";
                   echo "<td align=\"right\" width=\"7%\">".$bf."</td>";
                   echo "<td align=\"right\" width=\"4%\">".$ibb."</td>";    
                   echo "<td align=\"right\" width=\"5%\">".$hb."</td>";   
                   echo "<td align=\"center\" width=\"5%\">".$era."</td>";                                                      
                   echo "</tr>";
               }
               echo "</table>";
               echo "</div>";	
               $result->close();	     
		     }

             function player_rating($conn,$query_player,$position) {
               $querystr= " 
               SELECT pl.mlb_year, cast(mlb_year as unsigned)+1 as league_year, pl.speed, pl.position, 
                      pl.defense, pl.throw as arm, pl.grade, pl.control, pl.pr, pl.sf, pl.mrr, pl.rf, pl.maxbf
                 FROM player_year pl
                 WHERE player_id=".$query_player." 
                 ORDER BY mlb_year";
                 
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               echo "<div id=\"rating_history\" class=\"stat_group\">";
               echo "<table width=\"100%\">";
               echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Rating History</span></td></tr>";               
               echo "<tr>";
               echo "<td width=\"10%\">BRBL Year</td>";
               echo "<td width=\"10%\" align=\"center\" valign=\"top\">MLB Year</td>";
               echo "<td width=\"9%\" align=\"center\" valign=\"top\">Speed</td>";
               echo "<td width=\"9%\" align=\"center\" valign=\"top\">POS</td>";
               echo "<td width=\"9%\" align=\"center\" valign=\"top\">Def</td>";
               if (substr($position,0,1) !='P') {    
                  echo "<td width=\"5%\" align=\"center\">Arm</td>";
               }              
               echo "<td width=\"6%\" align=\"center\">Grade</td>";
               if (substr($position,0,1) =='P') {
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">Control</td>";
                  echo "<td width=\"4%\" align=\"center\" valign=\"top\">MRR</td>";
                  echo "<td width=\"4%\" align=\"center\" valign=\"top\">RF</td>";
                  echo "<td width=\"4%\" align=\"center\" valign=\"top\">MaxBF</td>";
               }
               else {
                  echo "<td width=\"6%\" align=\"right\" valign=\"top\">PR</td>";
                  echo "<td width=\"6%\" align=\"right\" valign=\"top\">SF</td>";
               }
               echo "</tr>";
               for ($i = 0; $i < $numofrows; $i++) {
                   $result->data_seek($i);
                   $row = $result->fetch_array(MYSQLI_ASSOC);                      
                   $league_year =$row['league_year'];
                   $mlb_year =$row['mlb_year']; 
                   $speed =$row['speed']; 
                   $position =$row['position']; 
                   $defense =$row['defense']; 
                   $arm =$row['arm']; 
                   $grade =$row['grade']; 
                   $control =$row['control']; 
                   $pr = $row['pr']; 
                   $sf = $row['sf']; 
                   $mrr = $row['mrr']; 
                   $rf = $row['rf']; 
                   $maxbf = $row['maxbf'];                  
                   echo "<tr>";
                   echo "<td width=\"10%\">".$league_year."</td>";
                   echo "<td width=\"10%\" align=\"center\" valign=\"top\">".$mlb_year."</td>";
                   echo "<td width=\"9%\" align=\"center\" valign=\"top\">".$speed."</td>";
                   echo "<td width=\"9%\" align=\"center\" valign=\"top\">".$position."</td>";
                   echo "<td width=\"9%\" align=\"center\" valign=\"top\">".$defense."</td>";
                   //echo "<td width=\"9%\">".$arm."</td>";
                   //echo "<td width=\"9%\">".$grade."</td>";
                   //echo "<td width=\"10%\">".$control."</td>";
                   if (substr($position,0,1) !='P') {                 
                      echo "<td width=\"5%\" align=\"center\" valign=\"top\">".$arm."</span></td>";
                   }
                   echo "<td width=\"6%\" align=\"center\" valign=\"top\">".$grade."</span></td>";
                   if (substr($position,0,1) =='P') {
                      echo "<td width=\"5%\" align=\"center\" valign=\"top\">".$control."</span></td>";
                      echo "<td width=\"4%\" align=\"center\" valign=\"top\">".$mrr."</span></td>";
                      echo "<td width=\"4%\" align=\"center\" valign=\"top\">".$rf."</span></td>";
                      echo "<td width=\"4%\" align=\"center\" valign=\"top\">".$maxbf."</span></td>"; 
                   }  
                   else {
                      echo "<td width=\"6%\" align=\"right\" valign=\"top\">".$pr."</span></td>";
                      echo "<td width=\"6%\" align=\"right\" valign=\"top\">".$sf."</span></td>";
                   }
                   
                   echo "</tr>";
                }
                echo "</table></div>";
                $result->close();
             }
             
             function transactions($conn,$query_player) {
                $querystr= " 
                SELECT transdate, getTeamName(old_team_id) as old_team, 
                  getTeamName(new_team_id) as new_team, transaction_type,
                  draft_year, draft_round, draft_round_pick, description
                FROM transaction_brbl
                WHERE player_id=".$query_player."
                ORDER BY transdate;" ;
                
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;

               echo "<div id=\"transaction_history\" class=\"stat_group\">";
               echo "<table width=\"100%\">";
               echo "<tr><td align=\"left\" colspan=\"5\"><span class=\"style10\">Transaction History</span></td></tr>";               
               if ($numofrows==0) {
                   echo "<tr><td>None</td></tr>";
               }
               else {                         
                   for ($i = 0; $i < $numofrows; $i++) {
                       $result->data_seek($i);
                       $row = $result->fetch_array(MYSQLI_ASSOC);   
                       $transaction_type=$row['transaction_type'];
                       $description=$row['description'];
                       if ($transaction_type==1) {
                          $description="Signed by ".$row['new_team']." ".$row['draft_year']." Free Agent Draft Round #"
                          .$row['draft_round']." Pick #".$row['draft_round_pick']."";
                       }
                       else if ($transaction_type==2) {
                          $description="Signed by ".$row['new_team']." ".$row['draft_year']." Pre-Season Waiver Draft Round #"
                          .$row['draft_round']."";
                       }
                       else if ($transaction_type==3) {
                          $description="Signed by ".$row['new_team']." ".$row['draft_year']." Mid-Season Waiver Draft Round #"
                          .$row['draft_round']."";
                       }
                       else if ($transaction_type==4) {
                          $description="Released by ".$row['old_team']."";
                       }
                       else if ($transaction_type==7) {
                          $description="Automatic Release - protected player that was uncarded for more than 1 year - ".$row['old_team']."";
                       }
                       else if ($transaction_type==8) {
                          $description="Uncarded Release by ".$row['old_team']."";
                       }
                       else if ($transaction_type==9) {
                          $description="Signed by ".$row['new_team']." ".$row['draft_year']." Mid-Season Waiver Signing";
                       }
                       else if ($transaction_type==10) {
                          $description="Team relocated from ".$row['old_team']." to ".$row['new_team']." starting ".$row['draft_year']."";
                       }
                       else if ($transaction_type==11) {
                          $description="Released by ".$row['old_team']." - Mid-Season Waiver Auto-Release";                       }

                       echo "<tr>";
                       echo "<td valign=\"top\" width=\"15%\">".$row['transdate']."</td>";
                       echo "<td width=\"85%\">".$description."</td>";
                       echo "</tr>";
                   }
               }
               echo "</table>";
               $result->close();
             }
		     
		     
		     // Make a MySQL Connection
             require_once ("/var/www/config/brbl_connect.class.php");
             $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
             if ($conn->connect_error) die($conn->connect_error);               
             // Get request from referring page
             $query_player = $_REQUEST['player'];
             $query_index = $_REQUEST['index'];
             $query_year = '2021';
		     
		     if (!$query_player) {   
		       if (!$query_index) {
		          $query_index='A';
               }       
               player_index($conn,$query_index);
             }
             else {
                $position=player_profile($conn,$query_player,$query_year);
                if (substr($position,0,1) =="P") {
                   pitching_stats($conn,$query_player,$query_year,'Annual');
                   pitching_stats($conn,$query_player,$query_year,'PostSeason');
                   pitching_stats($conn,$query_player,$query_year,'Week');
                } 
                else {
                   batting_stats($conn,$query_player,$query_year,'Annual');
                   batting_stats($conn,$query_player,$query_year,'PostSeason');
                   batting_stats($conn,$query_player,$query_year,'Week');
                }
                player_rating($conn,$query_player,$position);
                transactions($conn,$query_player);
             }
             $conn->close();
		     ?>
		     
		  </td>
          <td width="10%"  valign="top" align="center" id="main_column3">
              <?php include("includes/menu.php");  ?>           
          </td>
	  </tr>
  </table>
  <br><br>
  <?php include("includes/footer.php");  ?>
   <br><br>          
</body>
</html>