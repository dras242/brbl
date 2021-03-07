<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Historic Player Records</title>
 <meta name="Description" content="historical player records for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="player records, team records, historical statistics">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
 
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Player Records</h1>
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
		     // Make a MySQL Connection
             require_once ("/var/www/config/brbl_connect.class.php");
             $link=mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
             mysql_select_db(DB_NAME) or die(mysql_error());

             include("includes/record_categories.php");			 
		     ?>
			 
             <table style=\"width: 100%\">
			 <tr>
			 <td width="20%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"><span</td>
             </tr>			 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style9b_90">Season - Batting</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Regular Season</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Post Season</span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">AVG</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">.380 - Jose Altuve LAA 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>		
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Home Runs</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">74 - Giancarlo Stanton CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Runs</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">159 - Jose Altuve LAA 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">RBIs</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">163 - Giancarlo Stanton CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hits</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">252 - Jose Altuve LAA 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Doubles</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">68 - Xander Bogaerts BOS 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Triples</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">17 - Mallex Smith ATL 2019</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Total Bases</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">443 - Giancarlo Stanton CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Stolen Bases</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">83 - Billy Hamilton CIN 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Strikeouts</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">242 - Chris Davis TOR 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Walks</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">136 - Joey Votto CIN 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Intentional Walks</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">29 - Anthony Rendon ATL 2019</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">At Bats</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">701 - Jose Altuve LAA 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Plate Appearances</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">773 - Charlie Blackmon CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Double Plays</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">31 - Miguel Cabrera DET 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hit By Pitch</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">32 - Anthony RIzzo CHI 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>		
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Sacrafice Hits</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">24 - Chris Johnson CIN 2015, Jay Bruce CIN 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Sacrafice Fly</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">10 - Nolan Arenado COL 2020, Albert Pujols SFG 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	

			 <tr>
			 <td width="20%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"><span</td>
             </tr>			 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style9b_90">Season - Pitching</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Regular Season</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Post Season</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Games Won</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">25 - Adam Wainwright PIT 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Games Lost</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">24 - AJ Burnett NYY 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">ERA</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1.21 - Clayton Kershaw LAD 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Saves</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">43 - Kanley Jansen LAD 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Complete Games</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">17 - Jake Arrieta MIN 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Shutouts</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">7 - Adam Wainwright PIT 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Quality Starts</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">31 - Adam Wainwright PIT 2015, Johhny Cueto CIN 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Strikeouts</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">329 - Jake Arrieta MIN 2016, Clayton Kershaw LAD 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>					 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Walks</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">112 - Lance Lynn TOR 2019</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Intentional Walks</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">17 - Jim Johnson 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Appearances</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">81 - Craig Stammen CHI 2019</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Innings Pitched</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">269.1 - Jake Arrieta MIN 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Base Hits</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">285 - Michael Pineda NYY 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Runs</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">163 - CC Sabathia NYY 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>		
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Earned Runs</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">142 - CC Sabathia NYY 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
		
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Home Runs</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">48 - CC Sabathia NYY 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>		
			 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Batters Faced</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1041 - Corey Kluber CIN 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hit Batters</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">16 - Mike Minor COL 2020, Charlie Morton PIT 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>				 
			 </table>
			 
		  </td>
          <td width="10%"  valign="top" align="center" id="main_column3">
              <?php include("includes/menu.php");  ?>  
          </td>
	  </tr>
  </table>
  <?php include("includes/footer.php");  ?>          
</body>
</html>