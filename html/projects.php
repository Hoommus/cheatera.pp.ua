<?php
$course = '42';
$bas = 0;
$cids = 1;
$sql2 = "
SELECT *
FROM
  projects_users as pu,
  (
  SELECT xlogins.login FROM xlogins WHERE xlogins.kick=\"1\"
  ) AS xl
WHERE
  pu.xlogin=xl.login;";
if ($_GET['course'] == 'bastards') {
  $sql = $conn->query("SELECT `year`,`month`,`id` FROM `pools` ORDER BY `id` DESC LIMIT 0, 1");
  $data_array = array();
  $row = mysqli_fetch_assoc($sql);
  $data_array['year'] = $row['year'];
  $data_array['month'] = $row['month'];
  $bas = 1;
  $cids = 4;
  $course = 'Piscine C';
  $sql2 = "
SELECT pu.*
FROM
	projects_users as pu,
    (
        SELECT * FROM xlogins 
		WHERE xlogins.pool_year = \"" . $data_array['year'] . "\" and xlogins.pool_month=\"" . $data_array['month'] . "\" ORDER BY xlogins.login ASC
    ) as xl
WHERE pu.xlogin = xl.login and pu.cursus_ids=\"4\"
ORDER BY pu.final_mark DESC, pu.xlogin ASC
  ;";
}

$result2 = $conn->query($sql2);
 foreach ($result2 as $key => $value) {
// echo "<pre>";
//    print_r($value);
// echo "</pre>";
 }
    $prs = array();
    $temp = $result2;
    foreach ($result2 as $key => $value) {
      if ($value[cursus_ids] == $cids && $value[parent_id] == 0) {
        $prs[$value[name]][] = $value;
      }
    }
    $newnew = $prs;
    $tempar = array();
    foreach ($prs as $key => $value) {
      $tempar[] = array($key, $value[0][slug]); 
    }
?>

<!-- <script>
$(document).ready(function() {
  $('#proj').DataTable( {
    "lengthMenu": [ [50, -1], [50, "All"] ],
  } );
  
});</script> -->
<div style="max-width: 100%; overflow: auto;">

<h5 class="mt-5">All projects</h5>

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
                      <th scope="col">Name</th>
                      <th scope="col">averageFinalMark</th>
                      <th scope="col">Validated</th>
                      <th scope="col">Finished</th>
                      <th scope="col">Failed</th>
                      <th scope="col">Waiting for correction</th>
                      <th scope="col">In progress</th>
                      <th scope="col">Searching a group</th>
                      <th scope="col">Creating group</th>
                    </tr>
                  </thead>
                  <tbody id="projects">
                      <?php foreach ($tempar as $key => $val) { ?>
                      <tr>
                        <td><?php echo $key + 1?></td>
                        <td><a href="<?php echo "/" . $_GET['course'] . "/projects/" . $val[1] . "/" ; ?>"><?php echo $val[0] ?></a></td>
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
                  </tbody>
        </table>
      </div>

<script>
  
  $(document).on('click change', '.arrow', function(e){
    $('#projects').fadeTo(50, 0.15);
    $.ajax({
        type:"POST",
        url: '/duty/projects-ajax.php',
      data: {
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
