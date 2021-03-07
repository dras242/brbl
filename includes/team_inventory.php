            <?php
            echo "<table style=\"width: 100%\"><tr><td width=\"50%\" align=\"left\" valign=\"top\">";

           $standings_year = "2021";           
           $main_year = "2021";  
           $roster_year = "2021";
           $transaction_year = "2021";  
           $games_year = "2021";            
           $batting_year = "2021"; 
           $pitching_year = "2021";            
           
           // Team Information
           $querystr="
           SELECT d.division_name,t.team_name,t.abbrev,IF(ISNULL(gdt.gm_id),'-- Vacant --', 
           CONCAT(gm.first_name,' ',gm.last_name)) AS GM, mgr.manager_name, mgr.filename, l.total_win as win, 
           l.total_loss as loss
           FROM division d
           LEFT JOIN organization o ON d.organization_id=o.organization_id
           LEFT JOIN team t ON d.division_id=t.division_id
           LEFT JOIN gm_division_teams gdt ON t.team_id=gdt.team_id
           LEFT JOIN GM gm ON gdt.gm_id=gm.gm_id
           LEFT JOIN manager mgr ON gm.manager_id=mgr.manager_id
           LEFT JOIN (SELECT team_id,total_win,total_loss from standings where league_year=".$standings_year." ) l                
           ON t.team_id=l.team_id
           WHERE o.organization_id=2 AND d.division_id<=3 AND gdt.end_date IS NULL
           ORDER BY d.division_id,t.team_name;           
           ";
           
           $result = $conn->query($querystr);
           if (!$result) die($conn->error);
           $numofrows = $result->num_rows;
           
           $division="zzzz";
           for($i = 0; $i < $numofrows; $i++) {
              $result->data_seek($i);
              $row = $result->fetch_array(MYSQLI_ASSOC);
              $division_name = $row['division_name'];
              if ($division_name != $division) {
                 if ($division != "zzzz") {
                    echo "</ul>";
                 }
                 echo "<h2><span class=\"leftbuffer\">".$division_name."</span></h2><ul class=\"no_bullet\">";
                  $division=$division_name;
              }

              $team_name = $row['team_name']; 
              $team_abbrev = $row['abbrev'];
              $gm_name = $row['GM'];
              $mgr_name = $row['manager_name'];
              $filename = $row['filename'];
              $win = $row['win']; 
              $loss = $row['loss'];
              echo "<li><table id=\".$team_abbrev.\"><tr>
              <td>
              <img class=\"imagebuffer1\" alt=\"Team Logo ".$team_name."\" width=\"62\" height=\"60\" src=\"images/team-logos/".strtolower($team_abbrev)."_62x60.jpg\">
              </td>
              <td>
              <span class=\"style2\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=main&year=".$main_year."\">".$team_name."</a></span> <span class=\"style3\">(".$win."-".$loss.")</span><br>
              <span class=\"style4\"> 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=roster&year=".$roster_year."\">Roster</a> | 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=transaction&year=".$transaction_year."\">Transactions</a> | 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=games&year=".$games_year."\">Games</a> |  
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=batting&year=".$batting_year."\">Batting</a> | 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=pitching&year=".$pitching_year."\">Pitching</a>
              </span><br>
              <span class=\"style3\">GM: ".$gm_name."</span><br>
              <span class=\"style3\">Manager: <a href=\"http://www.brbl-apba.com/docs/managers/".$filename."\">".$mgr_name."</a></span>
              </td></tr></table></li>";
           }
           echo "</ul></td><td width=\"50%\" align=\"left\" valign=\"top\">";
           $result->close();

           // Retrieve Ad from marstravel
           $querystr="
           SELECT d.division_name,t.team_name,t.abbrev,IF(ISNULL(gdt.gm_id),'-- Vacant --', 
           CONCAT(gm.first_name,' ',gm.last_name)) AS GM, mgr.manager_name, mgr.filename, l.total_win as win, 
           l.total_loss as loss
           FROM division d
           LEFT JOIN organization o ON d.organization_id=o.organization_id
           LEFT JOIN team t ON d.division_id=t.division_id
           LEFT JOIN gm_division_teams gdt ON t.team_id=gdt.team_id
           LEFT JOIN GM gm ON gdt.gm_id=gm.gm_id
           LEFT JOIN manager mgr ON gm.manager_id=mgr.manager_id
           LEFT JOIN (SELECT team_id,total_win,total_loss from standings where league_year=".$standings_year." ) l                
           ON t.team_id=l.team_id
           WHERE o.organization_id=2 AND d.division_id>3 AND gdt.end_date IS NULL
           ORDER BY d.division_id,t.team_name;         
           ";

           $result = $conn->query($querystr);
           if (!$result) die($conn->error);
           $numofrows = $result->num_rows;

           $division="zzzz";
           for($i = 0; $i < $numofrows; $i++) {
              $result->data_seek($i);
              $row = $result->fetch_array(MYSQLI_ASSOC);

              $division_name = $row['division_name'];
              if ($division_name != $division) {
                 if ($division != "zzzz") {
                    echo "</ul>";
                 }
                 echo "<h2><span class=\"leftbuffer\">".$division_name."</span></h2><ul class=\"no_bullet\">";
                  $division=$division_name;
              }

              $team_name = $row['team_name']; 
              $team_abbrev = $row['abbrev'];
              $gm_name = $row['GM'];
              $mgr_name = $row['manager_name'];
              $filename = $row['filename'];
              $win = $row['win']; 
              $loss = $row['loss'];                
              echo "<li><table id=\".$team_abbrev.\"><tr>
              <td>
              <img class=\"imagebuffer1\" alt=\"Team Logo ".$team_name."\" width=\"62\" height=\"60\" src=\"images/team-logos/".strtolower($team_abbrev)."_62x60.jpg\">
              </td>
              <td>
              <span class=\"style2\"><a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=main&year=".$main_year."\">".$team_name."</a></span> <span class=\"style3\">(".$win."-".$loss.")</span><br>
              <span class=\"style4\"> 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=roster&year=".$roster_year."\">Roster</a> | 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=transaction&year=".$transaction_year."\">Transactions</a> | 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=games&year=".$games_year."\">Games</a> |  
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=batting&year=".$batting_year."\">Batting</a> | 
              <a href=\"http://www.brbl-apba.com/teams.php?team=".$team_abbrev."&view=pitching&year=".$pitching_year."\">Pitching</a>
              </span><br>
              <span class=\"style3\">GM: ".$gm_name."</span><br>
              <span class=\"style3\">Manager: <a href=\"http://www.brbl-apba.com/docs/managers/".$filename."\">".$mgr_name."</a></span>
              </td></tr></table></li>";
           }
           echo "</ul>";
           $result->close();

           echo "</td></tr></table>";
           

           
           ?>   