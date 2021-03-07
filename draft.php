<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Annual Free Agency Draft</title>
 <meta name="Description" content="Free Agency Draft for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="brbl draft, brbl free agency draft">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Draft</h1>
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
          $query_draft = $_REQUEST['draft'];
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
          <br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
            <?php
            function print_pos_block_header($p, $r) {
               echo "<table style=\"width: 90%\"><tr>";
               echo "<td width=\"5%\" align=\"center\" valign=\"top\">
               <span class=\"style5\">ID</span></td>";               
               echo "<td width=\"33%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">".$p." (".$r.")</span></td>";
               if ($r>0) {
                  echo "<td width=\"10%\" align=\"left\" valign=\"top\">
                  <span class=\"style5\">Drafted</span></td>";
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">";
                  if ($p=='P') {
                     echo "<span class=\"style5\">T</span></td>";
                  }
                  else {
                     echo "<span class=\"style5\">B</span></td>";
                  }
                  echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">Age</span></td>";
                  echo "<td width=\"7%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">Sp</span></td>";
                  echo "<td width=\"5%\" align=\"left\" valign=\"top\">
                  <span class=\"style5\">Pos</span></td>";
                  echo "<td width=\"7%\" align=\"center\" valign=\"top\">
                  <span class=\"style5\">Def</span></td>";
                  if ($p!='P') {
                     echo "<td width=\"5%\" align=\"center\" valign=\"top\">
                     <span class=\"style5\">Arm</span></td>";
                  }
                  echo "<td width=\"6%\" align=\"left\" valign=\"top\">
                  <span class=\"style5\">GR</span></td>";
                  if ($p=='P') {                  
                     echo "<td width=\"5%\" align=\"left\" valign=\"top\">
                     <span class=\"style5\">CTL</span></td>";
                     echo "<td width=\"4%\" align=\"right\" valign=\"top\">
                     <span class=\"style5\">MRR</span></td>";
                     echo "<td width=\"4%\" align=\"right\" valign=\"top\">
                     <span class=\"style5\">RF</span></td>";
                     echo "<td width=\"4%\" align=\"right\" valign=\"top\">
                     <span class=\"style5\">MBF</span></td>";
                  }
                  else {
                     echo "<td width=\"6%\" align=\"right\" valign=\"top\">                                
                     <span class=\"style5\">PR</span></td>";
                     echo "<td width=\"6%\" align=\"right\" valign=\"top\">
                     <span class=\"style5\">SF</span></td>";
                  }

               }
               echo "</tr>";                
            }
            
            function SQL1($conn,$p, $query_year, $query_draft) {
               if ($p=='C') {
                  $pos_set="('C','C+')";
               }
               elseif ($p=='1B') {
                  $pos_set="('1B','1B+')";
               }
               elseif ($p=='2B') {
                  $pos_set="('2B','2B+')";
               }
               elseif ($p=='3B') {
                  $pos_set="('3B','3B+')";
               }
               elseif ($p=='SS') {
                  $pos_set="('SS','SS+')";
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
               $draft_type=intval($query_draft);

               # Draft Query 
               $mlb_year = $query_year-1;
               $querystr= "        
               SELECT r.player_id,r.team_id, CONCAT(p.last_name,', ',p.first_name,' ',p.middle_name) as player,
               p.bat, p.throw AS th, $mlb_year-p.birthyear AS age, IF(ISNULL(t.abbrev),'UNF',t.abbrev) AS BRBL, 
               pl.speed, pl.position, pl.defense, pl.throw AS arm, pl.grade, pl.control, 
               pl.pr,pl.sf,pl.mrr,pl.rf,pl.maxbf, tr.draft_round, tr.draft_round_pick, nt.abbrev as new_team
               FROM roster_brbl r
               LEFT JOIN draft_track dt ON r.roster_brbl_id=dt.roster_brbl_id
               LEFT JOIN player p ON dt.player_id=p.player_id
               LEFT JOIN player_year pl on p.player_id = pl.player_id
               LEFT JOIN team t on r.team_id=t.team_id
               LEFT JOIN (SELECT * from transaction_brbl WHERE transaction_type='".$draft_type."' AND draft_year='".$query_year."') AS tr ON p.player_id=tr.player_id
               LEFT JOIN team nt on nt.team_id=tr.new_team_id
               WHERE pl.mlb_year=$mlb_year AND dt.transaction_type='".$draft_type."' AND dt.draft_year='".$query_year."' AND pl.position IN $pos_set 
               order by CONCAT(p.last_name,', ',p.first_name,' ',p.middle_name)
               ";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               print_pos_block_header($p,$numofrows);
               $tot_age=0;
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC); 
                 $player_id = $row['player_id'];                 
                 $player = $row['player'];
                 $bat = $row['bat'];
                 $throw = $row['th'];
                 $age = $row['age']; 
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
                 $pick = $row['draft_round']."-".$row['draft_round_pick']."-".$row['new_team'];                                
                 echo "<tr>";
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$player_id."</span></td>";                 
                 echo "<td width=\"33%\" align=\"left\" valign=\"top\"><a class=\"style3\" href=\"player.php?player=".$player_id."\">".$player."</a></td>";
                 echo "<td width=\"10%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$pick."</span></td>";
                 if ($p=='P') {
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$throw."</span></td>";
                 }
                 else {
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$bat."</span></td>";
                 }
                 echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$age."</span></td>";
                 echo "<td width=\"7%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$speed."</span></td>";
                 echo "<td width=\"5%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$position."</span></td>";
                 echo "<td width=\"7%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$defense."</span></td>";
                 if ($p!='P') {                 
                    echo "<td width=\"5%\" align=\"center\" valign=\"top\"><span class=\"style3\">".$arm."</span></td>";
                 }
                 echo "<td width=\"6%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$grade."</span></td>";
                 if ($p=='P') {
                    echo "<td width=\"5%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$control."</span></td>";
                    echo "<td width=\"4%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$mrr."</span></td>";
                    echo "<td width=\"4%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$rf."</span></td>";
                    echo "<td width=\"4%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$maxbf."</span></td>"; 
                 }  
                 else {
                    echo "<td width=\"6%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$pr."</span></td>";
                    echo "<td width=\"6%\" align=\"right\" valign=\"top\"><span class=\"style3\">".$sf."</span></td>";
                 }
                 echo "</tr>";
               } 
               echo "<tr><td></td></tr></table>";
               $result->close();
               return array($numofrows);
            }
            
            function print_header($query_year,$query_draft) {
               if ($query_draft=='1') {
                  echo "Free Agency Draft: ";
               }
               else if ($query_draft=='2') {
                  echo "Pre-Season Waiver Draft: ";
               }
               else if ($query_draft=='3') {
                  echo "Mid-Season Waiver Draft: ";
               }               
               echo $query_year." | ";
               echo "<a href=\"../";
               if ($query_draft=='1') {
                  echo "draft-schedule.php?year=".$query_year."\">";
               }
               else {
                  echo "waiver-draft-schedule.php?year=".$query_year."&draft=".$query_draft."\">";
               }
               echo "Picks/Schedule</a><br><br>";
               
               //if ($query_year=='2016') {
               //   echo "Note: List currently only includes unaffilated players. Team unprotected players to be added.<br><br>";
               //}

               
            }
            
                      
            print_header($query_year,$query_draft);
            
            $total_players=0;
            $positions = array("C","1B","2B","3B","SS","OF","P");
            for ($p=0; $p<count($positions); $p++) {
                $age_data = SQL1($conn,$positions[$p], $query_year, $query_draft);
                $total_players=$total_players+$age_data[0];
            }
            echo "<br>";
            echo "Total Players: ".$total_players."<br><br>";        
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