<?php     
	/* END Intra Auth */
@include 'db.php';



$course = '42';
$linkcourse = 'students';
$bastardswitch = " and xlogins.visible=\"1\"";
if ($_POST['course'] == 'bastards') {
  $course = 'Piscine C';
  $bastardswitch = '';
  $linkcourse = 'bastards';
}

    $sort = "cursus_users.level";
    $by = "DESC";
    $year = "";
    $month = "";
    if ($_POST['sort'] && $_POST['by'])
    {
      if ($_POST['sort'] == "xlogin") {
        $sort = "xlogins.login";
      }
      else if ($_POST['sort'] == "lvl") {
        $sort = "cursus_users.level";
      }
      else if ($_POST['sort'] == "cp") {
        $sort = "xlogins.correction_point";
      }
      else if ($_POST['sort'] == "wallet") {
        $sort = "xlogins.wallet";
      }
      else if ($_POST['sort'] == "howach") {
        $sort = "xlogins.howach";
      }
      else if ($_POST['sort'] == "timer") {
        $sort = "xlogins.hours";
      }
      if ($_POST['by'] == "DESC") {
        $by = "DESC";
      }
      else {
        $by = "ASC";
      }
    }
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
$sql = "
SELECT
  xlogins.displayname,
  xlogins.correction_point,
  xlogins.login,
  xlogins.phone,
  xlogins.pool_month,
  xlogins.pool_year,
  xlogins.wallet,
  xlogins.howach,
  xlogins.hours,
  xlogins.location,
  xlogins.lastloc,
  cursus_users.level
FROM
  xlogins
INNER JOIN cursus_users ON xlogins.xid = cursus_users.xid
WHERE xlogins.visible=\"1\" and cursus_users.name=\"" . $course . "\"  " . $year . " " . $month . $bastardswitch ."
ORDER BY " . $sort . " " . $by . ";";
$result = $conn->query($sql);

?>
<?php
foreach ($result as $key => $value) {
?>
<tr<?php if ($value[lastloc] == 0) { echo " class=\"table-success\""; } ?>>
  <td scope="col"><?php echo $key + 1 ?></td>
  <td><a href="<?php echo "/" . $linkcourse . "/" . $value[login] . "/" ; ?>"><?php echo $value[login] ?></a></td>
  <td><?php echo $value[displayname] ?></td>
  <td><?php echo $value[phone] ?></td>
  <td><?php echo $value[level] ?></td>
  <td><?php echo $value[pool_year] ?></td>
  <td><?php echo $value[pool_month] ?></td>
  <td><?php echo $value[wallet] ?></td>
  <td><?php echo $value[correction_point] ?></td>
  <td><?php echo $value[howach] ?></td>
  <td><?php echo $value[hours] ?></td>
  <td><?php echo $value[location] ?></td>
  <td><?php if ($value[lastloc] == 0) { echo "<b>ONLINE</b>"; } else { echo $value[lastloc] ; } ?></td>
</tr>
<?php } ?>
