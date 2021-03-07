<!doctype html>
<html lang="en">
<head>
 <title>BRBL - League Teams</title>
 <meta name="Description" content="Team index for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="brbl teams, brbl team rosters">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
 
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Teams</h1>
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
          $query_team = $_REQUEST['team'];
          $query_view = $_REQUEST['view'];            
          $query_year = $_REQUEST['year'];		  
		  ?>
		  <?php include_once("includes/team_page_photo_panel.php") ?>
		  <br><br>
		  </td>
		  <td width="70%"  valign="top" align="left" id="main_column2">
		     <?php 
             function print_header($conn,$query_team, $query_year,$query_view) {
               $querystr= "SELECT team_id,team_name,abbrev FROM team WHERE abbrev='".$query_team."'";
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $row = $result->fetch_array(MYSQLI_ASSOC);
               echo "<span class=\"style7c\">".$row['team_name']."</span> (";
               echo "<a class=\"style10\" href=\"teams.php?team=".$query_team."&view=main&year=".$query_year."\">Main</a> | ";
               echo "<a class=\"style10\" href=\"teams.php?team=".$query_team."&view=roster&year=".$query_year."\">Roster</a> | ";
               echo "<a class=\"style10\" href=\"teams.php?team=".$query_team."&view=transaction&year=".$query_year."\">Transactions</a> | ";               
               echo "<a class=\"style10\" href=\"teams.php?team=".$query_team."&view=games&year=".$query_year."\">Games</a> | ";
               echo "<a class=\"style10\" href=\"teams.php?team=".$query_team."&view=batting&year=".$query_year."\">Batting</a> | ";
               echo "<a class=\"style10\" href=\"teams.php?team=".$query_team."&view=pitching&year=".$query_year."\">Pitching</a> ";                
               echo ")<br>";
               if ($query_view=='roster') {
                  echo "Roster: ";
               }
               else if ($query_view=='transaction') {
                  echo "Transactions:";
               }
               else if ($query_view=='games') {
                  echo "Games/Scores:";
               }
               else if ($query_view=='main') {
                  echo "Team Page";
               }
               else if ($query_view=='batting') {
                  echo "Batting:";
               }
               else if ($query_view=='pitching') {
                  echo "Pitching: ";
               }
               $webpage='teams';
               include("includes/year-selector.php");
              
               echo "<br><br>";                             
               $result->close(); 
             }		     
		     
		     
		     if (!$query_team) {          
               include("includes/team_inventory.php");
             }
             else {
               print_header($conn,$query_team,$query_year,$query_view);
            
               if ($query_view=='roster') {
                  include("includes/team_roster.php");        
               }
               else if ($query_view=='transaction') {
                  include("includes/team_transaction.php");        
               }
               else if ($query_view=='games') {
                  include("includes/team_games.php");        
               }
               else if ($query_view=='main') {
                  include("includes/team_main.php");        
               }
               else if ($query_view=='batting') {
                  include("includes/team_batting.php");        
               }
               else if ($query_view=='pitching') {
                  include("includes/team_pitching.php");        
               }

             }
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