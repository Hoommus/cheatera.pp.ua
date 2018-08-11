<?php     
	/* END Intra Auth */
@include 'db.php';
if ($_POST['course'] == 'bastards') {
$course = '42';
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
SELECT pu.*, xl.location, xl.lastloc
FROM
	projects_users as pu,
  (
  SELECT * FROM xlogins 
  WHERE id > 0 " . $year . " " . $month . " ORDER BY xlogins.login ASC
  ) as xl
WHERE pu.xlogin = xl.login and cursus_ids=\"4\" and 
  pu.slug=\"" . $_POST['name'] . "\"
ORDER BY pu.final_mark DESC, pu.xlogin ASC
;";
  $sql = $conn->query("SELECT `year`,`month`,`id` FROM `pools` ORDER BY `id` DESC LIMIT 0, 1");
  $data_array = array();
  $row = mysqli_fetch_assoc($sql);
  $data_array['year'] = $row['year'];
  $data_array['month'] = $row['month'];
  $course = 'Piscine C';
  $sql3 = "
  SELECT pu.*, xl.location, xl.lastloc
  FROM
    projects_users as pu,
      (
      SELECT * FROM xlogins 
      WHERE id > 0 " . $year . " " . $month . " ORDER BY xlogins.login ASC
      ) as xl
  WHERE pu.xlogin = xl.login and cursus_ids=\"4\" and 
    pu.slug=\"" . $_POST['name'] . "\"
  ORDER BY pu.final_mark DESC, pu.xlogin ASC
  ;";
}

$result2 = $conn->query($sql3);

    foreach ($result2 as $key => $value) {
    ?>
    <tr<?php if ($value[lastloc] == 0) { echo " class=\"table-success\""; } ?>>
      <td scope="col"><?php echo $key + 1 ?></td>
      <td><a href="<?php echo "/" . $_POST['course'] . "/" . $value[xlogin] . "/" ; ?>"><?php echo $value[xlogin]  ?></a></td>
      <td><?php echo $value[final_mark]  ?></td>
      <td><?php echo $value[status] ?></td>
      <td><?php echo $value[validated] ?></td>
      <td><?php echo $value[location] ?></td>
      <td><?php if ($value[lastloc] == 0) { echo "<b>ONLINE</b>"; } else { echo $value[lastloc] ; } ?></td>

    <?php } ?>