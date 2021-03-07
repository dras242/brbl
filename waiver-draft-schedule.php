<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Waiver Draft Schedule and Picks</title>
 <meta name="Description" content="Waiver Draft Schedule and picks for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="brbl waiver draft, brbl waiver players">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Waiver Draft Schedule</h1>
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
            function print_block_header($draft_round, $query_draft) {
               echo "<table style=\"width: 90%\"><tr>";
               echo "<td  align=\"left\" valign=\"top\">
               <span class=\"style5\"></span></td>";    
               if ($query_draft =='2' || $query_draft =='3') {                
                 echo "<td  align=\"left\" valign=\"top\">
                 <span class=\"style5\">Round</span></td>";
               }
               elseif ($query_draft =='9') {
                 echo "<td  align=\"left\" valign=\"top\">
                 <span class=\"style5\">AIM Date</span></td>";           
               }
               echo "<td  align=\"left\" valign=\"top\">
               <span class=\"style5\">Team</span></td>";
               echo "<td  align=\"left\" valign=\"top\">
               <span class=\"style5\">Pos</span></td>";                    
                echo "<td align=\"left\" valign=\"top\">
               <span class=\"style5\">Player</span></td>";                        
                echo "<td align=\"left\" valign=\"top\">
               <span class=\"style5\">Released</span></td>"; 
               echo "</tr>";                
            }
            
            function SQL1($conn, $query_year, $query_draft) {

               # Draft Query 
               $mlb_year = $query_year-1;
               $querystr= "        
               SELECT tb.transaction_id, tb.player_id, nt.abbrev as new_team, tb.transdate,
               CONCAT(p.last_name,', ',p.first_name,' ',p.middle_name) as player, py.position,
               tb.transdate, tb.old_team_id, tb.new_team_id, tb.transaction_type,
               tb.draft_year,tb.draft_round as round,tb.description,tb.comment as comment_t, 
               pr.released, pr.player_id as released_id
               FROM transaction_brbl tb
               LEFT JOIN player p ON tb.player_id=p.player_id
               LEFT JOIN (SELECT team_id, team_name, abbrev FROM team) nt ON tb.new_team_id=nt.team_id
               LEFT JOIN (SELECT player_id,position FROM player_year WHERE mlb_year='".$mlb_year."' ) py ON p.player_id=py.player_id
               LEFT JOIN (SELECT player_id,CONCAT(last_name,', ',first_name,' ',middle_name) as released FROM player) pr ON pr.player_id=tb.waiver_release_id
               WHERE tb.transaction_type='".$query_draft."' AND tb.draft_year='".$query_year."'
               ORDER BY round, transaction_id";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               print_block_header($draft_round, $query_draft);
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC);                                                                   
                 $round = $row['round'];
                 $new_team = $row['new_team'];
                 $position = $row['position'];
                 $player = $row['player'];  
                 $player_id = $row['player_id'];
                 $released = $row['released']; 
                 $released_id = $row['released_id']; 
                 $transdate = $row['transdate'];                           
                 echo "<tr>";
                 echo "<td  align=\"left\" valign=\"top\"><span class=\"style3\"></span></td>";    
                 if ($query_draft =='2' || $query_draft =='3') {                               
                    echo "<td  align=\"left\" valign=\"top\"><span class=\"style3\">".$round."</span></td>";
                 }  
                 elseif ($query_draft =='9') {                               
                    echo "<td  align=\"left\" valign=\"top\"><span class=\"style3\">".$transdate."</span></td>";
                 }                    
                 echo "<td  align=\"left\" valign=\"top\"><a class=\"style3\" href=\"../teams.php?team=".$new_team."&view=roster&year=".$query_year."\">".$new_team."</a></td>";
                 echo "<td  align=\"left\" valign=\"top\"><span class=\"style3\">".$position."</span></td>";
                 echo "<td  align=\"left\" valign=\"top\"><a class=\"style3\" href=\"player.php?player=".$player_id."\">".$player."</a></td>";            
                 echo "<td  align=\"left\" valign=\"top\"><a class=\"style3\" href=\"player.php?player=".$released_id."\">".$released."</a></td>";               
                 echo "</tr>";
               } 
               echo "<tr><td></td></tr></table>";
               $result->close();
               return array($numofrows);
            }
            
            function print_header($query_year, $query_draft) {
               if ($query_draft=='2') {
                  echo "Pre-Season ";
               }
               elseif ($query_draft=='3') {
                  echo "Mid-Season ";
               }
               elseif ($query_draft=='9') {
                  echo "Mid-Season ";
               }
               
               if ($query_draft =='2' || $query_draft =='3') {         
                  echo "Waiver Draft: ".$query_year." | ";
                  echo "<a href=\"../draft.php?year=".$query_year."&draft=".$query_draft."\">Draft List</a><br><br>";
                  echo "<ul>";
                  echo "<li>All draft picks are submitted by emailing to the league.</li>";
                  echo "<li>Instructions can be provided to the commissioner if you cannot be available.</li>";
                  echo "<li>The draft selection order is based on most current team records from worst to best 
                  (see Constitution for detailed criteria) and will be provided to the league by email prior to 
                  the draft.</li>";   
                  echo "</ul>";
                }
                if ($query_draft =='9') {   
                  echo "Waiver Signings: ".$query_year."";
                  echo "<br><br>"; 
                  echo "<ul>";
                  echo "<li>Emergency waiver signings to cover roster availability issues.</li>";
                  echo "<li>Waiver pool includes all available sub 600 OBS players, SP grade <= 3, and RP grade <= 5.</li>";                                                                          
                  echo "<li>Player must be released anytime roster exceeds 40 players.</li>";
                  echo "<li>Signed players are automatically released at the end of the season.</li>"; 
                  echo "</ul>";                
                }              
                           
            }
            
            // Make a MySQL Connection
            require_once ("/var/www/config/brbl_connect.class.php");
            $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) die($conn->connect_error);             
            // Get request from referring page
            $query_year = $_REQUEST['year'];
            $query_draft = $_REQUEST['draft'];
                      
            print_header($query_year, $query_draft);
            
            SQL1($conn, $query_year, $query_draft);

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