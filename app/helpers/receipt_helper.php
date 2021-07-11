<?php
function cashoutExists($db)
{
  $query = 'SELECT cash_id FROM dr_cashout';

  $result = SelectCondFree($query, 'dr_cashout', $db);

  $row = $result->get_result();

  if($row->num_rows > 0){
      return true;
  }else{
    return false;
  }
}