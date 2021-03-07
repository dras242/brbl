<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Annual Free Agency Draft</title>
 <meta name="Description" content="Free Agency Draft Schedule for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="brbl draft schedule, brbl draft order">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Draft Schedule</h1>
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
          <br>
          <?php
          // Make a MySQL Connection
          require_once ("/var/www/config/brbl_connect.class.php");
          $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          if ($conn->connect_error) die($conn->connect_error);   
          // Get request from referring page
          $query_year = $_REQUEST['year'];
          ?>
          <?php include_once("includes/draft_image_selector.php") ?><br><br>		  
          <?php include_once("includes/brbl_logo.php") ?><br><br>		 
		  <?php include_once("includes/world_series_winner.php") ?><br><br>
          <?php include_once("includes/apba_baseball_logo.php") ?><br><br>
          <?php
          echo "<img alt=\"MLB Draft Room photo 1\" width=\"180\" height=\"101\" src=\"../images/draft-images/mlb-draft-room1_180x101.jpg\"><br><br>";
          echo "<img alt=\"MLB Draft Room photo 2\" width=\"180\" height=\"120\" src=\"../images/draft-images/mlb-draft-room2_180x120.jpg\"><br><br>";
          echo "<img alt=\"MLB Draft Room photo 4\" width=\"180\" height=\"119\" src=\"../images/draft-images/mlb-draft-room-4_180x119.jpg\"><br><br>";
          echo "<img alt=\"MLB Draft Room photo 5\" width=\"180\" height=\"116\" src=\"../images/draft-images/mlb-draft-room5_180x116.jpg\"><br><br>";
          echo "<img alt=\"MLB Draft Room photo 6\" width=\"180\" height=\"135\" src=\"../images/draft-images/mlb-draft-room6_180x135.jpg\"><br><br>";
          echo "<img alt=\"MLB Network\" width=\"180\" height=\"101\" src=\"../images/draft-images/mlb-network_180x101.jpg\"><br><br>";
          
          ?><br><br>

		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">


            <?php
            function print_block_header($draft_round) {
               echo "<table style=\"width: 90%\"><tr>";
               echo "<td width=\"10%\" align=\"left\" valign=\"top\">
               <span class=\"style5\"></span></td>";                 
               echo "<td width=\"25%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Status</span></td>";   
               echo "<td width=\"10%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Pick</span></td>";
               echo "<td width=\"10%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Team</span></td>";
                echo "<td width=\"40%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Player</span></td>";                 
               echo "<td width=\"5%\" align=\"center\" valign=\"top\">
               <span class=\"style5\">Pos</span></td>";            
               echo "</tr>";                
            }
            
            function SQL1($conn,$query_year) {       

               # Draft Query 
               $mlb_year = $query_year-1;
               $querystr= "        
               SELECT tb.transaction_id, tb.player_id, nt.abbrev as new_team, 
               CONCAT(p.last_name,', ',p.first_name,' ',p.middle_name) as player, py.position,
               tb.transdate, tb.old_team_id, tb.new_team_id, tb.transaction_type,
               tb.draft_year,CONCAT(tb.draft_round,'-',tb.draft_round_pick) as pick,tb.description,tb.comment as comment_t
               FROM transaction_brbl tb
               LEFT JOIN player p ON tb.player_id=p.player_id
               LEFT JOIN (SELECT team_id, team_name, abbrev FROM team) nt ON tb.new_team_id=nt.team_id
               LEFT JOIN (SELECT player_id,position FROM player_year WHERE mlb_year='".$mlb_year."' ) py ON p.player_id=py.player_id
               WHERE tb.transaction_type=1 AND tb.draft_year='".$query_year."'
               ORDER BY draft_round,draft_round_pick";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               print_block_header($draft_round);
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC);                  
                 $draft_round=$row['draft_round']; 
                 $comment = $row['comment_t'];                 
                 $pick = $row['pick'];
                 $new_team = $row['new_team'];
                 $position = $row['position'];
                 $player = $row['player'];  
                 $player_id = $row['player_id'];                            
                 echo "<tr>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style3\"></span></td>";                 
                 echo "<td width=\"25%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$comment."</span></td>";                 
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$pick."</span></td>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><a class=\"style3\" href=\"../teams.php?team=".$new_team."&view=roster&year=".$query_year."\">".$new_team."</a></td>";
                 echo "<td width=\"40%\" align=\"left\" valign=\"top\"><a class=\"style3\" href=\"player.php?player=".$player_id."\">".$player."</a></td>";            
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$position."</span></td>";              
                     echo "</tr>";
               } 
               echo "<tr><td></td></tr></table>";
               $result->close();
               return array($numofrows);
            }
            
            function print_header($query_year) {
               echo "Free Agency Draft Schedule: ".$query_year." | ";
               echo "<a href=\"../draft.php?year=".$query_year."&draft=1\">Draft List</a><br><br>";
               //echo "<ul>";
               //echo "<li>All draft picks are submitted by email by filling in the players full name in the draft template (emailed 
               //out each morning on draft days) and emailing to the league.</li>";                                                         
               //echo "<li>Rounds 1-5, missing two picks in a row opens the possibility of team takeover by the league. Rounds 
               //6-10, missing two picks in a row defaults to frozen roster for remainder of the draft. Teams are encouraged to 
               //stay in communication if expected to miss picks.</li>";
               //echo "<li>Instructions can be provided to the commissioner if you cannot be available for a 
               //particular time spot.</li>";
               //echo "<li>A 24-hour selection rule can be placed in effect anytime the draft is at least 24-hours ahead of schedule.</li>";
 
               
               //echo "</ul>";                    
               
               
            }
            
                      
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