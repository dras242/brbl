<!doctype html>
<html lang="en">
<head>
 <title>BRBL APBA Baseball League</title>
 <meta name="Description" content="The official website of the APBA Babe Ruth Memorial Baseball League. The BRBL is a computer APBA baseball league featuring 24 MLB based baseball team affiliations.">
 <meta name="Keywords" content="brbl, apba, apba baseball league, apba league, computer baseball, computer baseball league">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl-home.css">   
</head>
<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - APBA Baseball League</h1>
  <p><a href="teams.php">Teams</a> | <a href="player.php">Players</a> | <a href="records.php?stat=career_batting">All-Time Records</a> | <a href="../docs/BRBL-Constitution.pdf" target="_blank">Constitution</a></p> 
  </div>
  
  
  <table style="width: 100%">
	  <tr>
		  <td width="20%" align="center" valign="top" id="main_column1">
		  <?php include_once("includes/brbl_logo.php") ?><br><br>
		  <?php include_once("includes/world_series_winner.php") ?><br><br>
		  <?php include_once("includes/apba_baseball_logo.php") ?><br><br>
		  <?php include_once("includes/mlb_logo.php") ?><br><br>


		  </td>
		  <td width="55%"  valign="top" align="left" id="main_column2">
		  <h2>League News:</h2>
		  
		  <?php
		  $league_year='2021';
          $homepage_year='2021';  
		  //echo "<p>Opening Day! March 11, 2017</p>";
		  //echo "<p>Free Agent Draft Begins Monday 2/26 </p>";
		  //echo "<p>Twins Win World Series!</p>";	  
		  include_once("includes/home_page_on_the_board_alert.php") // Used for draft results
		  //include_once("includes/home_page_trade_alert.php"); // Used for trade alerts
		  //include_once("includes/home_page_game_result_alerts.php"); // Weekly Game Results
		  //include_once("includes/post_season_game_result_alerts.php"); // Post Season Series Results


		  ?>
		  
		  <p></p>
		 <div id="BRBL-2021-Season">
		  <h2>2021</h2>
            <table style="width: 100%">
			  <tr>
				  <td width="50%" align="left" valign="top">
				  <p><a href="standings.php?year=2021">Standings</a></p>			  
		      				     	                          		     	             	             			  
				  </td>
				  <td width="50%" align="left" valign="top">					  
				     <p><a href="trades.php?year=2021">Trades</a></p>
					 <p><a href="draft.php?year=2021&draft=1">Free Agent Draft</a> | 
					 <a href="draft-schedule.php?year=2021&draft=1">Order/Picks</a></p> 

					 				     				 				     
				  </td>
			  </tr>
		  </table> 

		  </div>  		  
		  
		 <div id="BRBL-2020-Season">
		  <h2>2020</h2>
            <table style="width: 100%">
			  <tr>
				  <td width="50%" align="left" valign="top">
				  <p><a href="standings.php?year=2020">Standings</a></p>
				  <p><a href="game-scores.php?year=2020">Game Results</a></p>
				  <p><a href="stats.php?year=2020&stat=annual_batting">Stats</a>
                  | <a href="accomplishments.php?year=2020">Accomplishments</a></p>				  
                  <p><a target="_blank" href="year-2020/Steal-Allowance-Rating-Modifications_2020.pdf">Player Steal Rating Modifications</a></p>				  
		      				     	                          		     	             	             			  
				  </td>
				  <td width="50%" align="left" valign="top">	
                     <p><a href="year-2020/post-season/index.php">Post Season</a></p>					  
				     <p><a href="trades.php?year=2020">Trades</a></p>
		             <p><a href="draft.php?year=2020&draft=1">Free Agent Draft</a> | 
					 <a href="draft-schedule.php?year=2020&draft=1">Order/Picks</a></p> 
					 <p><a href="draft.php?year=2020&draft=2">Pre-Season Waiver Draft</a> | 
					 <a href="waiver-draft-schedule.php?year=2020&draft=2">Picks</a></p>
					 <p><a href="waiver-draft-schedule.php?year=2020&draft=9">Mid-Season Waiver Signings</a></p>

					 				     				 				     
				  </td>
			  </tr>
		  </table> 

		  </div>  
		  
		  <div id="BRBL-2019-Season">
		  <h2>2019</h2>
            <table style="width: 100%">
			  <tr>
				  <td width="50%" align="left" valign="top">
				  <p><a href="standings.php?year=2019">Standings</a></p>		
				  <p><a href="game-scores.php?year=2019">Game Results</a></p>
				  <p><a href="stats.php?year=2019&stat=annual_batting">Stats</a>
				  | <a href="accomplishments.php?year=2019">Accomplishments</a></p>
				  <p><a target="_blank" href="year-2019/ytd-injuries-2019.html">YTD Injuries</a></p>			
				  <p><a target="_blank" href="year-2019/Steal-Allowance-Rating-Modifications_2019.pdf">Player Steal Rating Modifications</a></p>		      				     	                          		     	             	             			  
				  </td>
				  <td width="50%" align="left" valign="top">
				     <p><a href="year-2019/post-season/index.php">Post Season</a></p>			  
				     <p><a href="trades.php?year=2019">Trades</a></p>
		             <p><a href="draft.php?year=2019&draft=1">Free Agent Draft</a> | 
					 <a href="draft-schedule.php?year=2019&draft=1">Order/Picks</a></p> 
					 <p><a href="draft.php?year=2019&draft=2">Pre-Season Waiver Draft</a> | 
					 <a href="waiver-draft-schedule.php?year=2019&draft=2">Picks</a></p>
					 <p><a href="waiver-draft-schedule.php?year=2019&draft=9">Mid-Season Waiver Signings</a></p>
					 <p><a target="_blank" href="year-2019/Proposals-2019.pdf">Proposal Voting</a></p>	
					 				     
					 
				     
				  </td>
			  </tr>
		  </table> 

		  </div>
		  
		  
		  <div id="BRBL-2018-Season">
		  <h2>2018</h2>
            <table style="width: 100%">
			  <tr>
				  <td width="50%" align="left" valign="top">
				     <p><a href="standings.php?year=2018">Standings</a></p>
				     <p><a href="game-scores.php?year=2018">Game Results</a></p>	
				     <p><a href="stats.php?year=2018&stat=annual_batting">Stats</a>
				     | <a href="accomplishments.php?year=2018">Accomplishments</a></p>		
		             <p><a target="_blank" href="year-2018/ytd-injuries-2018.html">YTD Injuries</a></p>			
                     <p><a target="_blank" href="year-2018/Steal-Allowance-Rating-Modifications_2018.pdf">Player Steal Rating Modifications</a></p>					      				     	                          		     	             	             			  
				  </td>
				  <td width="50%" align="left" valign="top">
				     <p><a href="year-2018/post-season/index.php">Post Season</a></p>				  
				     <p><a href="trades.php?year=2018">Trades</a></p>
		             <p><a href="draft.php?year=2018&draft=1">Free Agent Draft</a> | 
					 <a href="draft-schedule.php?year=2018&draft=1">Order/Picks</a></p> 		 
					 <p><a href="draft.php?year=2018&draft=2">Pre-Season Waiver Draft</a> | 
					 <a href="waiver-draft-schedule.php?year=2018&draft=2">Picks</a></p>
					 <p><a href="waiver-draft-schedule.php?year=2018&draft=9">Mid-Season Waiver Signings</a></p>
					 <p><a target="_blank" href="year-2018/Proposals-2018.pdf">Proposal Voting</a></p>					 
				     
				  </td>
			  </tr>
		  </table> 

		  </div>
		  
		  
		  <div id="BRBL-2017-Season">
		  <h2>2017</h2>
            <table style="width: 100%">
			  <tr>
				  <td width="50%" align="left" valign="top">
				     <p><a href="standings.php?year=2017">Standings</a></p>	
				     <p><a href="stats.php?year=2017&stat=annual_batting">Stats</a>
				      | <a href="accomplishments.php?year=2017">Accomplishments</a></p>	     			     
                     <p><a href="game-scores.php?year=2017">Game Results</a></p>		
		             <p><a target="_blank" href="year-2017/ytd-injuries-2017.html">YTD Injuries</a></p>			
                     <p><a target="_blank" href="year-2017/Steal-Allowance-Rating-Modifications_2017.pdf">Player Steal Rating Modifications</a></p>		                          		     	             	             			  
				  </td>
				  <td width="50%" align="left" valign="top">
				     <p><a href="year-2017/post-season/index.php">Post Season</a></p>
				     <p><a href="trades.php?year=2017">Trades</a></p>
		             <p><a href="draft.php?year=2017&draft=1">Free Agent Draft</a> | 
					 <a href="draft-schedule.php?year=2017&draft=1">Order/Picks</a></p> 
					 <p><a href="draft.php?year=2017&draft=2">Pre-Season Waiver Draft</a> | 
					 <a href="waiver-draft-schedule.php?year=2017&draft=2">Picks</a></p>
					 <p><a href="waiver-draft-schedule.php?year=2017&draft=9">Mid-Season Waiver Signings</a></p>
					 <p><a target="_blank" href="year-2017/Proposals-2017.pdf">Proposal Voting</a></p>					 
				     
				  </td>
			  </tr>
		  </table> 

		  </div>
		  
          <div id="BRBL-2016-Season">
		  <h2>2016</h2>
		  <table style="width: 100%">
			  <tr>
				  <td width="50%" align="left" valign="top">
				     <p><a href="standings.php?year=2016">Standings</a></p> 
				     <p><a href="stats.php?year=2016&stat=annual_batting">Stats</a>
				     | <a href="accomplishments.php?year=2016">Accomplishments</a></p>
                     <p><a href="game-scores.php?year=2016">Game Results</a></p>
                     <p><a target="_blank" href="year-2016/ytd-injuries-2016.html">YTD Injuries</a></p>	
                     <p><a target="_blank" href="year-2016/Steal-Allowance-Rating-Modifications_2016.pdf">Player Steal Rating Modifications</a></p>
	             	             			  
				  </td>
				  <td width="50%" align="left" valign="top">
				     <p><a href="year-2016/post-season/index.php">Post Season</a></p>          
					 <p><a href="trades.php?year=2016">Trades</a></p>
		             <p><a href="draft.php?year=2016&draft=1">Free Agent Draft</a> | 
					 <a href="draft-schedule.php?year=2016&draft=1">Order/Picks</a></p> 
					 <p><a href="draft.php?year=2016&draft=2">Pre-Season Waiver Draft</a> | 
					 <a href="waiver-draft-schedule.php?year=2016&draft=2">Picks</a></p>
		             <p><a href="waiver-draft-schedule.php?year=2016&draft=9">Mid-Season Waiver Signings</a></p>
		             <p><a target="_blank" href="year-2016/Proposals-2016.pdf">Proposal Voting</a></p>
				  </td>
			  </tr>
		  </table> 
          </div>
		  
          <div id="BRBL-2015-Season">		  
		  <h2>2015</h2>
		  <table style="width: 100%">
			  <tr>
				  <td width="50%" align="left" valign="top">
		             <p><a href="standings.php?year=2015">Standings</a></p> 
		             <p><a href="stats.php?year=2015&stat=annual_batting">Stats</a> 
					 | <a href="accomplishments.php?year=2015">Accomplishments</a></p>
		             <p><a href="game-scores.php?year=2015">Game Results</a></p>		             
		             <p><a target="_blank" href="year-2015/ytd-injuries-2015.html">YTD Injuries</a></p>	
		             <p><a target="_blank" href="year-2015/Steal-Allowance-Rating-Modifications_2015.pdf">Player Steal Rating Modifications</a></p>	             	             			  
				  </td>
				  <td width="50%" align="left" valign="top">
                     <p><a href="year-2015/post-season/index.php">Post Season</a></p>	
		             <p><a href="trades.php?year=2015">Trades</a></p>
		             <p><a href="draft.php?year=2015&draft=1">Free Agent Draft</a> | 
					 <a href="draft-schedule.php?year=2015&draft=1">Picks</a></p> 
		             <p><a href="draft.php?year=2015&draft=2">Pre-Season Waiver Draft</a> | 
					 <a href="waiver-draft-schedule.php?year=2015&draft=2">Picks</a></p>					 
		             <p><a href="draft.php?year=2015&draft=3">Mid-Season Waiver Draft</a> | 
					 <a href="waiver-draft-schedule.php?year=2015&draft=3">Picks</a></p>	
  
				  </td>
			  </tr>
		  </table>
		  </div>   
		  </td>
		  <td width="25%" align="center" valign="top" id="main_column3">
          <span class="style1">2021 STANDINGS</span><br>
          <?php
            // Make a MySQL Connection
            require_once ("/var/www/config/brbl_connect.class.php");
            $conn=new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) die($conn->connect_error);     
            
                           
            $querystr= "        
               SELECT d.division_id,d.division_name as division, t.team_name as team, t.abbrev, s.total_win AS win, s.total_loss AS loss, 
               if(ISNULL(s.total_win/(s.total_win+s.total_loss)),.000,s.total_win/(s.total_win+s.total_loss)) AS pct, s.gb 
               FROM standings s
               LEFT JOIN team t ON s.team_id=t.team_id
               LEFT JOIN division d ON d.division_id = t.division_id
               WHERE s.league_year=".$league_year." 
               ORDER by division_id, pct desc, abbrev";           
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
		       
		       echo "<table style=\"width: 100%\"><tr>";
				  
               $division_hold="zzz";
               for ($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC);                 
                 $division=$row['division'];
                 if ($division!=$division_hold) {
                    echo "<tr>";
                    echo "<td width=\"25%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$division."</span></td>";
                    echo "<td width=\"10%\" align=\"right\" valign=\"top\"><span class=\"style3\">W</span></td>";
                    echo "<td width=\"15%\" align=\"right\" valign=\"top\"><span class=\"style3\">L</span></td>";
                    echo "<td width=\"20%\" align=\"right\" valign=\"top\"><span class=\"style3\">PCT</span></td>";
                    echo "<td width=\"15%\" align=\"right\" valign=\"top\"><span class=\"style3\">GB</span></td>";
                    echo "<td width=\"15%\" align=\"right\" valign=\"top\"><span class=\"style3\"></span></td>";
                    echo "</tr>";
                    $division_hold=$division;
                 }
                 $abbrev=$row['abbrev'];
                 $win=$row['win'];
                 $loss=$row['loss'];
                 $pct=explode(".", number_format($row['pct'],3));
                 $pct=".".$pct[1];
                 if ($row['gb']==0) {
                    $gb="-";
                 } 
                 else {
                    $gb=$row['gb'];
                 }                
                 echo "<tr>";
                 echo "<td width=\"25%\" align=\"left\"  valign=\"top\"><span class=\"style2\">
                 <a href=\"http://www.brbl-apba.com/teams.php?team=".$abbrev."&view=main&year=".$homepage_year."\">".$abbrev."</a></span></td>";
                 echo "<td width=\"10%\" align=\"right\" valign=\"top\"><span class=\"style2\">".$win."</span></td>";
                 echo "<td width=\"15%\" align=\"right\" valign=\"top\"><span class=\"style2\">".$loss."</span></td>";
                 echo "<td width=\"20%\" align=\"right\" valign=\"top\"><span class=\"style2\">".$pct."</span></td>"; 
                 echo "<td width=\"15%\" align=\"right\" valign=\"top\"><span class=\"style2\">".$gb."</span></td>";
                 echo "<td width=\"15%\" align=\"right\" valign=\"top\"><span class=\"style2\"></span></td>";
                 echo "</tr>";
               }
               echo "</table>";
               $result->close();
               $conn->close();
               ?>
		  </td>

	  </tr>
  </table>
          

  <h2>&nbsp;</h2>
  <p></p>   
  <?php include("includes/footer.php");  ?>          
</body>
</html>