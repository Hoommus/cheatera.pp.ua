<?php     
	/* END Intra Auth */
@include 'db.php';

    $year = " and xlogins.pool_year=\"2018\" ";
    $month = "and xlogins.pool_month=\"august\" ";
    if ($_POST['year']) {
      if ($_POST['year'] != "All") {
        if (in_array($_POST['year'], $calendar)) {
          $year = "and xlogins.pool_year=" . $_POST['year'] . " ";
        }
        else {
          $year = "";
        }
      }
      else {
        $year = "";
      }
    }
    if ($_POST['month']) {
      if ($_POST['month'] != "All") {
         if (in_array($_POST['month'], $calendar)) {
          $month = "and xlogins.pool_month=\"" . $_POST['month'] . "\" ";
          }
          else {
            $month = "";
          }
      }
      else {
        $month = "";
      }
     }
$sql3 = "
SELECT
  pu.cursus_ids,
  pu.parent_id,
  pu.name,
  pu.slug,
  pu.status,
  pu.validated,
  pu.final_mark
FROM
	projects_users as pu,
    (
        SELECT * FROM xlogins 
		WHERE id > 0 " . $year . " " . $month . " ORDER BY xlogins.login ASC
    ) as xl
WHERE pu.xlogin = xl.login and pu.cursus_ids=\"4\"
ORDER BY pu.final_mark DESC, pu.xlogin ASC
;";
    

$result2 = $conn->query($sql3);
    $prs = array();
    $temp = $result2;
    foreach ($result2 as $key => $value) {
      if ($value[cursus_ids] == $_POST['course_id'] && $value[parent_id] == 0) {
        $prs[$value[name]][] = $value;
      }
    }
    $newnew = $prs;
    $tempar = array();
    foreach ($prs as $key => $value) {
      $tempar[] = array($key, $value[0][slug]); 
    }
?>
<?php foreach ($tempar as $key => $val) { ?>
<tr>
  <td><?php echo $key + 1?></td>
  <td><a href="<?php echo "/" . $_POST['course'] . "/projects/" . $val[1] . "/" ; ?>"><?php echo $val[0] ?></a></td>
  <?php
    $it = 0;
    $fm = 0;
    $valid = 0;
    $fin = 0;
    $fail = 0;
    $ip = 0;
    $sag = 0;
    $cg = 0;
    $wfc = 0;
    foreach ($newnew[$val[0]] as $val) {
      if ($val[status] == "in_progress") {
        $ip++;
      }
      if ($val[status] == "searching_a_group") {
        $sag++;
      }
      if ($val[status] == "creating_group") {
        $cg++;
      }
      if ($val[status] == "waiting_for_correction") {
        $wfc++;
      }
      if ($val[validated] != "None") {
        if ($val[validated] == "True") { $valid++; } else { $fail++; } 
        $it++;
        $fm += $val[final_mark];                          
      }
    }
    echo "<td>".round($fm / $it, 0)."</td><td>".$valid."</td><td>".($valid+$fail)."</td><td>".$fail."</td><td>".$wfc."</td><td>".$ip."</td><td>".$sag."</td><td>".$cg."</td>";                          
  ?>
</tr>
<?php } ?>