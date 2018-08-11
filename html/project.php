<?php
	/* Intra Auth */

	/* END Intra Auth */
@include 'db.php';
$sql3 = "
SELECT pu.*, xl.location, xl.lastloc
FROM
	projects_users as pu,
  (
  SELECT * FROM xlogins 
  WHERE xlogins.kick=\"1\" ORDER BY xlogins.login ASC
  ) as xl
WHERE pu.xlogin = xl.login and cursus_ids=\"1\" and 
  pu.slug=\"" . $_GET['name'] . "\"
ORDER BY pu.final_mark DESC, pu.xlogin ASC
;";
// echo "<pre>";
// print_r($sql3);
// echo "</pre>";
if ($_GET['course'] == 'bastards') {
  $sql = $conn->query("SELECT `year`,`month`,`id` FROM `pools` ORDER BY `id` DESC LIMIT 0, 1");
  $data_array = array();
  $row = mysqli_fetch_assoc($sql);
  $data_array['year'] = $row['year'];
  $data_array['month'] = $row['month'];
  $bas = 1;
  $cids = 4;
  $course = 'Piscine C';
  $sql3 = "
  SELECT pu.*, xl.location, xl.lastloc
  FROM
    projects_users as pu,
      (
      SELECT * FROM xlogins 
      WHERE xlogins.pool_year = \"2018\" and xlogins.pool_month=\"august\" ORDER BY xlogins.login ASC
      ) as xl
  WHERE pu.xlogin = xl.login and cursus_ids=\"4\" and 
    pu.slug=\"" . $_GET['name'] . "\"
  ORDER BY pu.final_mark DESC, pu.xlogin ASC
  ;";
}

$result2 = $conn->query($sql3);
$name = '';
foreach ($result2 as $key => $value) {
  $name = $value[name];
}
?>
<h5 class="mt-5"><? echo $name?></h5>
     <div style="margin: 10px 0px;">
      <?php if ($_GET['course'] == 'bastards') { ?><select class="year arrow">
        <option>All</option>
        <option>2016</option>
        <option>2017</option>
        <option <?php if ($bas && 2018 == $data_array['year']) echo 'selected'?>>2018</option>
      </select>
        <select class="month arrow">
        <option>All</option>
        <option>february</option>
        <option <?php if ($bas && "july" == $data_array['month']) echo 'selected'?>>july</option>
        <option <?php if ($bas && "august" == $data_array['month']) echo 'selected'?>>august</option>
        <option <?php if ($bas && "september" == $data_array['month']) echo 'selected'?>>september</option>
        <option>october</option>
        <option>november</option>
        </select>
      </div><?php } else { ?>
      <script>
      $(document).ready(function() {
        $('#proj').DataTable( {
          "lengthMenu": [ [50, -1], [50, "All"] ],
        } );

      });</script>
      <?php } ?>
        <table class="table table-striped" id="proj" >
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">xlogin</th>
              <th scope="col">final mark</th>
              <th scope="col">status</th>
              <th scope="col">validated</th>
              <th scope="col" data-toggle="tooltip" title="">location</th>
              <th scope="col" data-toggle="tooltip" title="The time of the last login in the cluster">last(GMT+0)</th>
            </tr>
          </thead>
          <tbody id="projects">
            <?php
            foreach ($result2 as $key => $value) {
            ?>
            <tr<?php if ($value[lastloc] == 0) { echo " class=\"table-success\""; } ?>>
              <td scope="col"><?php echo $key + 1 ?></td>
              <td><a href="<?php echo "/" . $_GET['course'] . "/" . $value[xlogin] . "/" ; ?>"><?php echo $value[xlogin]  ?></a></td>
              <td><?php echo $value[final_mark]  ?></td>
              <td><?php echo $value[status] ?></td>
              <td><?php echo $value[validated] ?></td>
              <td><?php echo $value[location] ?></td>
              <td><?php if ($value[lastloc] == 0) { echo "<b>ONLINE</b>"; } else { echo $value[lastloc] ; } ?></td>

            <?php } ?>
          </tbody>
        </table>
      </div>
      </div>
 
        </div>
      </div>
    </div>
  </div>

<script>
  
  $(document).on('click change', '.arrow', function(e){
    $('#projects').fadeTo(50, 0.15);
    $.ajax({
        type:"POST",
        url: '/duty/project-ajax.php',
      data: {
          name: "<?php echo $_GET['name'] ?>",
          course: "<?php echo $_GET['course'] ?>",
          course_id: "<?php echo $cids ?>",
          year: $( ".year option:selected" ).text(),
          month: $( ".month option:selected" ).text()
      },
        success: function(response){
          $('#projects').html(response);
          $('#projects').fadeTo(50, 1);
      }
    });
});
</script>
