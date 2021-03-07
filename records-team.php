<!doctype html>
<html lang="en">
<head>
 <title>BRBL - Historic Team Records</title>
 <meta name="Description" content="historical team records for the Babe Ruth Baseball League (BRBL).">
 <meta name="Keywords" content="player records, team records, historical statistics">
 <meta name="robots" content="index,follow">
 <meta charset="utf-8">
 <link type="text/css" rel="stylesheet" href="http://www.brbl-apba.com/brbl.css">   
 
</head>

<body>
  <div id="header">
  <h1>Babe Ruth Baseball League - Team Records</h1>
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
			 <td width="20%" align="left" valign="top"><span class="style9b_90">Single Game</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Regular Season</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Post Season</span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Most hits</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">30 ATL - 2 times (ATL@NYM 6/3/18, ATL@PHL 5/7/19) </span></td>
             <td width="40%" align="left" valign="top"><span class="style8">21 BOS (BOS@SEA 17 innings 10/4/2015 Game 2 Divisional Series). Record for 9 inning game: 16 TOR (TOR@LAA 10/7/16 Game 4 Divisional Series)</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Most hits - teams combined</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">44 (NYY@BOS 9/11/20)</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">30 (BOS@SEA 17 innings 10/4/2015 Game 2 Divisional Series). Record for 9 inning game: 25 (LAA@MIN 10/6/19 Game 4 Divisional Series)</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Most runs</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">29 LAA (LAA@TEX 9/20/19) </span></td>
             <td width="40%" align="left" valign="top"><span class="style8">16 LAA (LAA@MIN 10/6/19 Game 4 Divisional Series)</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Most runs - teams combined</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">39 (LAA@TEX 9/20/19) </span></td>
             <td width="40%" align="left" valign="top"><span class="style8">21 (LAA@MIN 10/6/19 Game 4 Divisional Series)</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Most errors</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">6 CIN (CIN@MIA 13 innings 6/12/20). Record for 9 inning game: 5 NYM (NYM@CHI 5/26/20)</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">4 - twice - LAD (LAD@COL Game 4 (14 innings) Division Series 10/6/20), KCR (CWS@KCR Game 4 Divisional Series 10/7/16)</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Most errors - teams combined</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">8 (CHI@NYM 5/26/20) </span></td>
             <td width="40%" align="left" valign="top"><span class="style8">6 (LAD@COL 14 innings Game 4 Division Series 10/6/20). Record for 9 inning game: 5 (NYM@CHI Game 6 NL Championship Sereis 10/19/17, CWS@KCR Game 4 Divisional Series 10/7/16)</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Longest game</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">24 innings (LAA@TEX 7/6/16) </span></td>
             <td width="40%" align="left" valign="top"><span class="style8">21 innings (BOS@SEA Game 2 Divisional Series 10/4/15)</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"><span</td>
             </tr>			 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style9b_90">Season - Team Batting</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Regular Season</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Post Season</span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">AVG - Highest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">.295 - LAA 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">.277 - MIN 2020</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">AVG - Lowest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">.205 - OAK 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">.128 - KCR 2019</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Home Runs - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">351 - CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">38 - KCR 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Home Runs - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">107 - TOR 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1 - SFG 2015, CHI 2015</span></td>
             </tr>	
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Runs - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1101 - CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">95 - CWS 2018</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Runs - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">479 - OAK 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">6 - LAA 2016</span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">RBIs - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1,054 - CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">93 - CWS 2018</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">RBIs - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">444 - OAK 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">6 - LAA 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hits - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1712 - LAA 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">158 - CHI 2017</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hits - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1114 - OAK 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">16 - KCR 2019</span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Doubles - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">347 - TBR 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">42 - CWS 2018</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Doubles - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">185 - OAK 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">2 - SFG 2015</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Triples - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">48 - COL 2019</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">6 - STL 2016, NYM 2015, ATL 2019</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Triples - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">9 - NYM 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">0 - multiple times</span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Total Bases - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">3057 - CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">297 - KCR 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Total Bases - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1775 - OAK 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">39 - LAA 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Stolen Bases - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">162 - PIT 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">18 - LAA 2019</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Stolen Bases - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">25 - COL 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">0 - multiple times</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Strikeouts - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1749 - ARI 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">210 - CHI 2017</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Strikeouts - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1074 - SFG 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">27 - SFG 2015, LAA 2016</span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Walks - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">685 - CWS 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">66 - CWS 2018</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Walks - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">369 - KCR 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">4 - LAA 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Double Plays - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">149 - TOR 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">15 - NYM 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Double Plays - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">60 - CIN 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">0 - KCR 2015</span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hit By Pitch - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">87 - CHI 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">12 - KCR 2016, CHI 2017</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hit By Pitch - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">17 - BOS 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">0 - multiple times</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Sacrafice Hits - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">179 - CIN 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">9 - SFG 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Sacrafice Hits - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">0 - NYY 2019, TOR 2019</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">0 - multiple times</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Sacrafice Fly - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">50- SDP 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">6 - SFG 2016</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Sacrafice Fly - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">11 - NYM 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">0 - multiple times</span></td>
             </tr>	

			 <tr>
			 <td width="20%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"></td>
             <td width="40%" align="left" valign="top"><span</td>
             </tr>			 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style9b_90">Season - Team Pitching</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Regular Season</span></td>
             <td width="40%" align="left" valign="top"><span class="style9b_90">Post Season</span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Games Won</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">115 - STL 2012</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Games Lost</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">124 - NYM 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">ERA - Lowest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">2.69 - SFG 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">ERA - Highest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">5.68 - ARI 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Saves - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">55 - KCR 2015, SFG 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Saves - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">20 - NYM 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Complete Games - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">41 - DET 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Complete Games - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1 - ARI 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Shutouts - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">19 - PIT 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Shutouts - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1 - ARI 2017, SEA 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Quality Starts - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">115 - LAD 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Quality Starts - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">48 - LAA 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Base Hits - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1732 - MIN 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Base Hits - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1084 - KCR 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Runs - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1010 - ARI 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Runs - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">484 - SFG 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Earned Runs - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">910 - DET 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Earned Runs - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">435 - SFG 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>		
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Home Runs - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">303 - DET 2018</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Home Runs - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">126 - SEA 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>		
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Strikeouts - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1594 - TBR 2017</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Strikeouts - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">1047 - BOS 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>				 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Walks - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">693 - TOR 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Walks - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">344 - MIA 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Intentional Walks - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">70 - STL 2016</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Intentional Walks - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">7 - TEX 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>			 
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Batters Faced - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">6551 - TOR 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Batters Faced - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">5818 - SFG 2015</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hit Batters - Most</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">75 - SFG 2020</span></td>
             <td width="40%" align="left" valign="top"><span class="style8"></span></td>
             </tr>	
			 <tr>
			 <td width="20%" align="left" valign="top"><span class="style8">Hit Batters - Fewest</span></td>
             <td width="40%" align="left" valign="top"><span class="style8">24 - LAA 2017</span></td>
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