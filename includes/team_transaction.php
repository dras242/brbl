<?php 

function print_block_header($p, $r) {
               echo "<table style=\"width: 80%\"><tr>";
               echo "<td width=\"20%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Date</span></td>";
               echo "<td width=\"80%\" align=\"left\" valign=\"top\">
               <span class=\"style5\">Transaction</span></td>";
               echo "</tr>";                
            }
            
function SQL1($conn,$query_team, $query_year) {

                # Team Transactions
               $mlb_year = $query_year-1;
               $querystr= "        
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('SIGNED ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name),' (',py.position,')',' FREE AGENT DRAFT R',cast(tbl.draft_round AS CHAR),'-',CAST(tbl.draft_round_pick AS CHAR)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
     LEFT JOIN player_year py on p.player_id=py.player_id
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL AND py.mlb_year='".$mlb_year."' 
      AND GetTeamAbbrev(tbl.new_team_id)='".$query_team."' 
      AND tbl.new_team_id!=tbl.old_team_id  
      AND tbl.transaction_type=1)
UNION
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('LOST ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name),' (',py.position,')',' FREE AGENT DRAFT TO ', GetTeamAbbrev(tbl.new_team_id),' R',cast(tbl.draft_round AS CHAR),'-',CAST(tbl.draft_round_pick AS CHAR)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id
     LEFT JOIN player_year py on p.player_id=py.player_id
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL AND py.mlb_year='".$mlb_year."'  
      AND GetTeamAbbrev(tbl.old_team_id)='".$query_team."'
      AND tbl.new_team_id!=tbl.old_team_id        
      AND tbl.transaction_type=1)
UNION
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('RE-SIGNED ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name),' (',py.position,')',' FREE AGENT DRAFT R',cast(tbl.draft_round AS CHAR),'-',CAST(tbl.draft_round_pick AS CHAR)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
     LEFT JOIN player_year py on p.player_id=py.player_id
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL AND py.mlb_year='".$mlb_year."' 
      AND GetTeamAbbrev(tbl.new_team_id)='".$query_team."' 
      AND tbl.new_team_id=tbl.old_team_id  
      AND tbl.transaction_type=1)
UNION 
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('SIGNED ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name),' (',py.position,')',' PRE-SEASON WAIVER DRAFT R',cast(tbl.draft_round AS CHAR)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
     LEFT JOIN player_year py on p.player_id=py.player_id
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL AND py.mlb_year='".$mlb_year."'  
      AND GetTeamAbbrev(tbl.new_team_id)='".$query_team."' 
      AND tbl.transaction_type=2)  
UNION 
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('SIGNED ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name),' (',py.position,')',' MID-SEASON WAIVER DRAFT R',cast(tbl.draft_round AS CHAR)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
     LEFT JOIN player_year py on p.player_id=py.player_id
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL AND py.mlb_year='".$mlb_year."' 
      AND GetTeamAbbrev(tbl.new_team_id)='".$query_team."'
      AND tbl.transaction_type=3)
UNION 
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('SIGNED ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name),' (',py.position,')',' MID-SEASON WAIVER SIGNING') AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
     LEFT JOIN player_year py on p.player_id=py.player_id
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL AND py.mlb_year='".$mlb_year."' 
      AND GetTeamAbbrev(tbl.new_team_id)='".$query_team."'
      AND tbl.transaction_type=9)      
UNION 
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('RELEASED ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name),' (',py.position,')') AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
     LEFT JOIN player_year py on p.player_id=py.player_id
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL AND py.mlb_year='".$mlb_year."' 
      AND GetTeamAbbrev(tbl.old_team_id)='".$query_team."'
      AND tbl.transaction_type=4)
UNION 
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('AUTOMATIC RELEASE - UNCARDED FOR MORE THAN 1 YEAR - ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL  
      AND GetTeamAbbrev(tbl.old_team_id)='".$query_team."'
      AND tbl.transaction_type=7)
UNION
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('MID-SEASON WAIVER AUTO-RELEASE - ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL  
      AND GetTeamAbbrev(tbl.old_team_id)='".$query_team."'
      AND tbl.transaction_type=11)
UNION 
 
(SELECT tbl.transdate,tbl.transaction_type,tbl.player_id,
       CONCAT('UNCARDED RELEASE - ',CONCAT(p.first_name,if(p.middle_name=' ',' ',CONCAT(' ',p.middle_name,' ')),p.last_name)) AS description
FROM transaction_brbl tbl 
     LEFT JOIN player p on tbl.player_id=p.player_id 
WHERE tbl.draft_year='".$query_year."' AND tbl.transdate IS NOT NULL  
      AND GetTeamAbbrev(tbl.old_team_id)='".$query_team."'
      AND tbl.transaction_type=8)

UNION 

(SELECT transdate, 5 as transaction_type, 0 as player_id, 
     UPPER(description) AS description
FROM trade_summary  
WHERE draft_year='".$query_year."' AND transdate IS NOT NULL  
      AND (GetTeamAbbrev(team_id_a)='".$query_team."' OR GetTeamAbbrev(team_id_b)='".$query_team."'))
ORDER BY transdate DESC";          
   
               $result = $conn->query($querystr);
               if (!$result) die($conn->error);
               $numofrows = $result->num_rows;
               
               print_block_header();
               for($i = 0; $i < $numofrows; $i++) {
                 $result->data_seek($i);
                 $row = $result->fetch_array(MYSQLI_ASSOC); 
                 $transdate = $row['transdate'];
                 $description = $row['description'];             
                 echo "<tr>";
                 echo "<td width=\"20%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$transdate."</span></td>";
                 echo "<td width=\"80%\" align=\"left\" valign=\"top\"><span class=\"style3\">".$description."</span></td>";
                 echo "</tr>";
               } 
               echo "<tr><td></td></tr></table>";
               $result->close();   
            }
            
                     
SQL1($conn,$query_team, $query_year);
echo "<br><br>";
?>
