<?php
	/* Intra Auth */
//  session_start();
// 	if ($_SESSION['cheat'] == session_id())
//   {

    
	/* END Intra Auth */

$course = '42';
if ($_GET['course'] == 'bastards') {
  $course = 'Piscine C';
}
$bas = 0;
$bastardswitch = "and xlogins.visible=\"1\"";
if ($_GET['course'] == 'bastards') {
  $sql = $conn->query("SELECT `year`,`month`,`id` FROM `pools` ORDER BY `id` DESC LIMIT 0, 1");
  $data_array = array();
  $row = mysqli_fetch_assoc($sql);
  $data_array['year'] = $row['year'];
  $data_array['month'] = $row['month'];
  $bas = 1;
  $bastardswitch = "and xlogins.pool_year=\"" . $data_array['year'] . "\" and xlogins.pool_month=\"" . $data_array['month'] . "\"";
}
//   || $_GET['course'] == 'students')
// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 
// echo "Connected successfully";
//     SELECT xlogins.displayname, xlogins.login, xlogins.phone, xlogins.hours, cursus_users.level FROM xlogins INNER JOIN cursus_users ON xlogins.xid = cursus_users.xid INNER JOIN projects_users ON xlogins.login = projects_users.xlogin WHERE cursus_users.name="Piscine C" and cursus_users.level > 5 and projects_users.name="First Internship" and projects_users.validated = "True" ORDER BY cursus_users.level DESC
$sql = "
SELECT
  xlogins.correction_point,
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
WHERE xlogins.visible=\"1\" and cursus_users.name=\"" . $course . "\" " . $bastardswitch ."
ORDER BY cursus_users.level DESC, xlogins.login ASC;";
$result = $conn->query($sql);
// $result2 = $conn->query("");
// $data_array = array();
// while ($row = mysqli_fetch_assoc($result2)) {
//     $data_array[$row['xlogin']] = $row['TTT'];
// }
?>

<h1 class="mt-5"></h1>
<div style="max-width: 100%; overflow: auto;">

<?php @include 'duty/userstable.php' ?>

</div>

<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#alldata tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

  $(document).on('click change', '.arrow', function(e){
    e.preventDefault();
    $('#alldata').fadeTo(50, 0.15);
    $.ajax({
        type:"POST",
        url: '/duty/userstable-ajax.php',
      data: {
          sort: e.target.getAttribute("name"),
          by: e.target.id,
          year: $( ".year option:selected" ).text(),
          month: $( ".month option:selected" ).text(),
          course: "<?php echo $_GET['course'] ?>"
      },
        success: function(response){
          $('#alldata').html(response);
          $('#alldata').fadeTo(25, 1);
      }
    });
});
</script>


<?php
//   }
//   else
//      header("Location: http://cheatera.pp.ua/");
?>