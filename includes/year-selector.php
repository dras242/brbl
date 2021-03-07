               <?php
               echo " ".$query_year;             
               if ($query_year=='2015') {
                  if ($webpage=='teams') {
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2021\">2021</a>";  
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2020\">2020</a>"; 
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2019\">2019</a>";                  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2018\">2018</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2017\">2017</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2016\">2016</a>";
                  }
                  elseif ($webpage=='trades') {
					 echo " | <a href=\"trades.php?year=2021\">2021</a>"; 
					 echo " | <a href=\"trades.php?year=2020\">2020</a>";
                     echo " | <a href=\"trades.php?year=2019\">2019</a>";  
                     echo " | <a href=\"trades.php?year=2018\">2018</a>";  
                     echo " | <a href=\"trades.php?year=2017\">2017</a>";  
                     echo " | <a href=\"trades.php?year=2016\">2016</a>";                   
                  }
               }
               elseif ($query_year=='2016') { 
                  if ($webpage=='teams') {
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2021\">2021</a>"; 
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2020\">2020</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2019\">2019</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2018\">2018</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2017\">2017</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2015\">2015</a>";

                  }
                  elseif ($webpage=='trades') {
					 echo " | <a href=\"trades.php?year=2021\">2021</a>";   
					 echo " | <a href=\"trades.php?year=2020\">2020</a>";    
                     echo " | <a href=\"trades.php?year=2019\">2019</a>";                    
                     echo " | <a href=\"trades.php?year=2018\">2018</a>"; 
                     echo " | <a href=\"trades.php?year=2017\">2017</a>";     
                     echo " | <a href=\"trades.php?year=2015\">2015</a>";              
                  }
                  
               }
               elseif ($query_year=='2017') { 
                  if ($webpage=='teams') {
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2021\">2021</a>"; 
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2020\">2020</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2019\">2019</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2018\">2018</a>";                
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2016\">2016</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2015\">2015</a>";

                  }
                  elseif ($webpage=='trades') {
					 echo " | <a href=\"trades.php?year=2021\">2021</a>"; 
					 echo " | <a href=\"trades.php?year=2020\">2020</a>";
                     echo " | <a href=\"trades.php?year=2019\">2019</a>";                    
                     echo " | <a href=\"trades.php?year=2018\">2018</a>"; 
                     echo " | <a href=\"trades.php?year=2016\">2016</a>"; 
                     echo " | <a href=\"trades.php?year=2015\">2015</a>";                  
                  }
                  
               }
               elseif ($query_year=='2018') { 
                  if ($webpage=='teams') {
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2021\">2021</a>"; 
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2020\">2020</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2019\">2019</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2017\">2017</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2016\">2016</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2015\">2015</a>";

                  }
                  elseif ($webpage=='trades') {
					 echo " | <a href=\"trades.php?year=2021\">2021</a>";  
					 echo " | <a href=\"trades.php?year=2020\">2020</a>";  
                     echo " | <a href=\"trades.php?year=2019\">2019</a>";                    
                     echo " | <a href=\"trades.php?year=2017\">2017</a>"; 
                     echo " | <a href=\"trades.php?year=2016\">2016</a>"; 
                     echo " | <a href=\"trades.php?year=2015\">2015</a>";                  
                  }
                  
               }
               elseif ($query_year=='2019') { 
                  if ($webpage=='teams') {
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2021\">2021</a>";   
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2020\">2020</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2018\">2018</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2017\">2017</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2016\">2016</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2015\">2015</a>";

                  }
                  elseif ($webpage=='trades') {
					 echo " | <a href=\"trades.php?year=2021\">2021</a>";  
					 echo " | <a href=\"trades.php?year=2020\">2020</a>"; 
                     echo " | <a href=\"trades.php?year=2018\">2018</a>";                    
                     echo " | <a href=\"trades.php?year=2017\">2017</a>"; 
                     echo " | <a href=\"trades.php?year=2016\">2016</a>"; 
                     echo " | <a href=\"trades.php?year=2015\">2015</a>";                  
                  }
                  
               }
                elseif ($query_year=='2020') { 
                  if ($webpage=='teams') {
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2021\">2021</a>";   
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2019\">2019</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2018\">2018</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2017\">2017</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2016\">2016</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2015\">2015</a>";

                  }
                  elseif ($webpage=='trades') {
					 echo " | <a href=\"trades.php?year=2021\">2021</a>"; 
                     echo " | <a href=\"trades.php?year=2019\">2019</a>";
					 echo " | <a href=\"trades.php?year=2018\">2018</a>";                    
                     echo " | <a href=\"trades.php?year=2017\">2017</a>"; 
                     echo " | <a href=\"trades.php?year=2016\">2016</a>"; 
                     echo " | <a href=\"trades.php?year=2015\">2015</a>";                  
                  }
				}  
                 elseif ($query_year=='2021') { 
                  if ($webpage=='teams') {
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2020\">2020</a>";   
					 echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2019\">2019</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2018\">2018</a>";  
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2017\">2017</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2016\">2016</a>";
                     echo " | <a href=\"teams.php?team=".$query_team."&view=".$query_view."&year=2015\">2015</a>";

                  }
                  elseif ($webpage=='trades') {
					 echo " | <a href=\"trades.php?year=2020\">2020</a>"; 
                     echo " | <a href=\"trades.php?year=2019\">2019</a>";
					 echo " | <a href=\"trades.php?year=2018\">2018</a>";                    
                     echo " | <a href=\"trades.php?year=2017\">2017</a>"; 
                     echo " | <a href=\"trades.php?year=2016\">2016</a>"; 
                     echo " | <a href=\"trades.php?year=2015\">2015</a>";                  
                  }                 
               }
                                                 
               ?>