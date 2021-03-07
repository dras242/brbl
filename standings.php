<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Team Standings</title>
 <meta name="Description" content="Team standings for the APBA Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="brbl standings, brbl baseball standings">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Standings</h1>
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
          <br>
		  <?php include_once("includes/brbl_logo.php") ?><br><br>		  
		  <?php include_once("includes/world_series_winner.php") ?><br><br>
          <?php include_once("includes/apba_baseball_logo.php") ?>
          <br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
            <?php
            
            function SQL1($conn,$query_year) {
               $querystr= "        
               SELECT d.division_id,d.division_name as division, t.team_name as team, t.abbrev, s.total_win AS win, s.total_loss AS loss, 
               if(ISNULL(s.total_win/(s.total_win+s.total_loss)),.000,s.total_win/(s.total_win+s.total_loss)) AS pct, 
               s.gb, s.place, s.home_win AS win_home, s.home_loss AS lose_home, s.away_win AS win_away, s.away_loss AS lose_away, 
               s.run1_win AS r_win, s.run1_loss AS r_loss, s.xinn_win AS x_win, s.xinn_loss AS x_loss, 
               s.east_win, s.east_loss, s.central_win, s.central_loss, s.west_win, s.west_loss  
               FROM standings s
               LEFT JOIN team t ON s.team_id=t.team_id
               LEFT JOIN division d ON d.division_id = t.division_id
               WHERE s.league_year=".$query_year." 
               ORDER by division_id, pct desc, abbrev";        
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
		       
		       echo "<table style=\"width: 100%\">";
				  
               $division_hold="zzz";
               for ($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC);                 
                 $division=$row['division'];
                 if ($division!=$division_hold) {
                    echo "<tr class=\"spacer\"></tr><tr class=\"division_block\">";
                    echo "<td width=\"15%\" align=\"left\" valign=\"top\"><span class=\"style7a\">".$division."</span></td>";
                    echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style7a\">W</span></td>";
                    echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style7a\">L</span></td>";
                    echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style7a\">PCT</span></td>";
                    echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style7a\">GB</span></td>";
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style7a\">Home</span></td>";
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style7a\">Away</span></td>";
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style7a\">1-Run</span></td>";
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style7a\">X-Inn</span></td>";
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style7a\">East</span></td>";  
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style7a\">Cen</span></td>";
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style7a\">West</span></td>";                                
                    echo "</tr>";
                    $division_hold=$division;
                 }
                 $team=$row['team'];
                 $abbrev=$row['abbrev'];
                 $win=$row['win'];
                 $loss=$row['loss'];
                 $win_home=$row['win_home'];
                 $lose_home=$row['lose_home'];
                 $win_away=$row['win_away'];
                 $lose_away=$row['lose_away'];
                 $r_win=$row['r_win'];
                 $r_loss=$row['r_loss'];
                 $x_win=$row['x_win'];
                 $x_loss=$row['x_loss'];                                   
                 $east_win=$row['east_win'];
                 $east_loss=$row['east_loss']; 
                 $central_win=$row['central_win'];
                 $central_loss=$row['central_loss']; 
                 $west_win=$row['west_win'];
                 $west_loss=$row['west_loss']; 
                 $pct=explode(".", number_format($row['pct'],3));
                 $pct=".".$pct[1];
                 $gb = ($row['gb']==0.0 ? '-' : $row['gb']);             
                 echo "<tr>";
                 echo "<td width=\"15%\" align=\"left\"  valign=\"top\"><a class=\"style8\" href=\"http://www.brbl-apba.com/teams.php?team=".$abbrev."&view=main&year=".$query_year."\">".$team."</a></td>";
                 echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$win."</span></td>";
                 echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$loss."</span></td>";
                 echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$pct."</span></td>"; 
                 echo "<td width=\"4%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$gb."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$win_home."-".$lose_home."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$win_away."-".$lose_away."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$r_win."-".$r_loss."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$x_win."-".$x_loss."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$east_win."-".$east_loss."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$central_win."-".$central_loss."</span></td>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style8\">".$west_win."-".$west_loss."</span></td>";

                echo "</tr>";
               }
               echo "</table>";
               $result->close();

                
            }
            
            function print_header($query_year) {
               echo "<span class=\"style2\">League Standings: ".$query_year." </span><br><br>";                                
               
            }
            
            // Make a MySQL Connection
            require_once ("/var/www/config/brbl_connect.class.php");
            $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) die($conn->connect_error);   
            // Get request from referring page
            $query_year = $_REQUEST['year'];
                      
            print_header($query_year);
            
            SQL1($conn,$query_year);

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