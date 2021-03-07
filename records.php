<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Historic Records</title>
 <meta name="Description" content="historical statistics for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="player records, team records, historical statistics">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
 
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Record Book</h1>
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
		     
function top_10_performance($limit_number,$stat,$fieldname,$table,$thresh) {
           $orderby = 'DESC';
           if ($stat=='avg') {
              $stat2='sum(h)/sum(ab)';
              $criteria2='sum(ab+bb+sh+sf+hbp)';
              $thresh = 2000;
           }
           else if ($stat=='era') {
              $stat2='sum(er)*9/sum(convert_ip(ip))';
              $orderby = 'ASC';
              $criteria2='sum(convert_ip(ip))';
              $thresh = 500;

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
           SELECT DISTINCT player_id,first_name,last_name,a1.".$stat."
           FROM 
           (select player_id,first_name, last_name, ".$stat2." as ".$stat."
           FROM ".$table." 
           GROUP BY player_id
           HAVING ".$criteria2." >= ".$thresh.") a1
           INNER JOIN
           (SELECT ".$stat2." AS ".$stat." from ".$table." 
           GROUP BY player_id
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
              echo "<tr><td valign=\"top\" align=\"right\"><span class=\"style5\">".$stat_format."</span></td><td><a class=\"style8\" href=\"player.php?player=".$row['player_id']."\">".$row['first_name']." ".$row['last_name']."</a></td></tr>";
           
           }
           echo "</table>";
}




function career_leaders_hitting() {                  
           
           echo "<table width=\"100%\">";
           echo "<tr><td align=\"center\" width=\"100%\"colspan=\"4\"><span class=\"style7\">Career Batting Leaders: </span></td></tr>";
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'avg','AVG','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'hr','HR','agg_batting_by_player_team',0);
           echo "</td>";  
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'rbi','RBI','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'r','Runs','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";                
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'h','Hits','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'tb','Total bases','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'b2','Doubles','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'b3','Triples','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";               
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'so','Strikeouts','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'bb','Walks','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'g','Games','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'ab','At Bats','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'sb','Stolen Bases','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'gdp','Double Plays','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'ibb','Intentional BB','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'hbp','Hit By Pitch','agg_batting_by_player_team',0);
           echo "</td></tr>";
           echo "<tr><td><br></td></tr>";               
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'sh','Sacrifice Hit','agg_batting_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'sf','Sacrifice Fly','agg_batting_by_player_team',0);
           echo "</td></tr>";

           echo "</table>";
}

function career_leaders_pitching() {           
                      
           echo "<table width=\"100%\">";
           echo "<tr><td align=\"center\" width=\"100%\"colspan=\"4\"><span class=\"style7\">Career Pitching Leaders: </span></td></tr>";
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'era','ERA','agg_pitching_by_player_team',$thresh);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'w','Wins','agg_pitching_by_player_team',0);
           echo "</td>";  
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'l','Loss','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'sv','Save','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";   
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'so','Strikeouts','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'bb','Walks','agg_pitching_by_player_team',0);
           echo "</td>";  
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'g','Games','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'gs','Games Started','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";              
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'cg','Complete Games','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'sho','Shutouts','agg_pitching_by_player_team',0);
           echo "</td>";  
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'qs','Quality Starts','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'ip','Innings Pitched','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";   
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'h','Hits','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'hr','Homeruns','agg_pitching_by_player_team',0);
           echo "</td>";  
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'er','Earned Runs','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'hb','Hit By Pitch','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>";             
           echo "<tr>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'bf','Batters Faced','agg_pitching_by_player_team',0);
           echo "</td>";
           echo "<td width=\"25%\" valign=\"top\">";
           top_10_performance(10,'ibb','Intentional BB','agg_pitching_by_player_team',0);
           echo "</td></tr>";  
           echo "<tr><td><br></td></tr>"; 
            
           echo "</table>";
}
           

function print_header() {
         include("includes/record_categories.php");                         
               
}		     
		     
		     // Make a MySQL Connection
             require_once ("/var/www/config/brbl_connect.class.php");
             $link=mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
             mysql_select_db(DB_NAME) or die(mysql_error());
             // Get request from referring page
             $query_stat = $_REQUEST['stat'];
             print_header();
		     if ($query_stat=='career_batting') {
                career_leaders_hitting();
             }
		     else if ($query_stat=='career_pitching') {
                career_leaders_pitching();
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