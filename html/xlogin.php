<?php
$course = '42';
$valid = 49;
if ($_GET['course'] == 'bastards') {
  $course = 'Piscine C';
  $valid = 25;
}

$xlogininfo = "
SELECT
  xl.*,
  cu.*
FROM
  xlogins as xl,
  cursus_users as cu
WHERE
  xl.login=\"" . $_GET['page'] . "\" and
  cu.xlogin=\"" . $_GET['page'] . "\" and 
  cu.name=\"" . $course . "\"
  ;";
$proj = "
SELECT
  pu.*,
  cu.*
FROM
  projects_users as pu,
 (
 SELECT cursus_id 
 FROM cursus_users
 WHERE xlogin=\"" . $_GET['page'] . "\" and name=\"" . $course . "\"
 ) as cu
WHERE
  pu.xlogin=\"" . $_GET['page'] . "\" and pu.cursus_ids=cu.cursus_id
  ;";
$skills = "
SELECT
  cu.*,
  sk.*
FROM
  cursus_users as cu,
  skills as sk
WHERE
  cu.name=\"" . $course . "\" and
  cu.xlogin=\"" . $_GET['page'] . "\" and 
  sk.xlogin=\"" . $_GET['page'] . "\" and
  cu.cursus_id=sk.cursus_id
;";
$result1 = $conn->query($xlogininfo);


$result2 = $conn->query($proj);
$result3 = $conn->query($skills);
$result4 = $conn->query("SELECT SUM(timer) AS sum FROM `time_in_cluster` WHERE xlogin = \"" . $_GET['page'] . "\";");
// INNER JOIN cursus_users ON xlogins.xid = cursus_users.xid
$dataset = $conn->query("SELECT SUM(timer) AS todate, oneday FROM `time_in_cluster` WHERE xlogin=\"" . $_GET['page'] . "\" GROUP BY date(oneday) ORDER BY `oneday` ASC");
$vis = $conn->query("SELECT COUNT(`id`) AS COUNTS FROM `cursus_users` WHERE xlogin=\"" . $_GET['page'] . "\" and `cursus_id`=\"1\";");
$tests = array();
$visible = array();
while ($test = $result4->fetch_all()) $tests[] = $test;
while ($visibles = $vis->fetch_all()) $visible[] = $visibles;
?>
   <?
    $newdata = array();
    $flag = 1;
    $check = 0;
    $tests2 = array();
    while ($test2 = $dataset->fetch_all()) $tests2[] = $test2;
    $tempdate = 0;
    foreach ($tests2[0] as $key => $value) {
      if ($flag == 1) {
        $tempdate = date("d-m-Y", strtotime($value[1]));
      }
      $temp = array(date("d-m-Y", strtotime($value[1])),$value[0]);
      if ($check == 0 && $flag == 1) {
         $newdata[] = $temp;
        $check = 1;
        $flag = 0;
        continue;
      }
      else {
        if (date('d-m-Y',strtotime($tempdate."+1 days")) == date("d-m-Y", strtotime($value[1]))) {
          $newdata[] = $temp;
        }
        else {
          while (1) {
        if (date('d-m-Y',strtotime($tempdate."+1 days")) == date("d-m-Y", strtotime($value[1]))) {
          $newdata[] = $temp;
          break ;
        }
 
          $tempdate = date('d-m-Y',strtotime($tempdate."+1 days"));
          $newdata[] = array($tempdate,0);
}
        }
        $tempdate = date("d-m-Y", strtotime($value[1]));
        $check = 1;
      }   
    }
    while ($tempdate != date("d-m-Y")) {
      $tempdate = date('d-m-Y',strtotime($tempdate."+1 days"));
          $newdata[] = array($tempdate, 0);
    }
    $newnew = array();
    $fix = 0;
    foreach ($newdata as $key) {
      if ($fix) {
        $key[1] += $fix;
        $fix = 0;
      }
      if ($key[1] < 24) {
        $newnew[] = $key;
      }
      else {
        $newnew[] = array($key[0], 24);
        $fix = $key[1] - 24;
      }
    }
    $newdata = $newnew;
    
  $login = "";
  $level42 = "";
  $level1 = "";
  $displayname = "";
  $phone = "";
  $email = "";
  $pooly = "";
  $poolm = "";
  $wallet = "";
  $grade = "";
  $cp = "";
  $ach = "";
  $img = "";
  $lastloc = "";
  $lastlog = "";
  $offer = $visible[0][0][0];
// echo "<pre>";
// print_r($visible);
foreach ($result1 as $key => $value) { 
//   echo $value;
    $it++;
    $login = $value[login];
    $level42 = $value[level];
    $displayname = $value[displayname];
    $phone = $value[phone];
    $email = $value[email];
    $pooly = $value[pool_year];
    $poolm = $value[pool_month];
    $wallet = $value[wallet];
    $grade = $value[grade];
    $cp = $value[correction_point];
    $ach = $value[howach];
    $img = $value[image_url];
    $lastloc = $value[location];
    $lastlog = $value[lastloc];
}
// echo "</pre>";
?>

<div class="container xlogin">
  <div class="row"> <div class="col-lg-12 mx-auto">
              <div class="progress my-shadow" style="margin: 0.75rem auto ;">
            <div class="progress-bar <?
            if ($level42 < 7)
              echo "bg-success ";
            if ($level42 >= 7)           
              echo "bg-info ";
            if ($level42 >= 14)           
              echo "bg-warning ";
            if ($level42 >= 16)           
              echo "bg-danger ";
            ?>progress-bar-striped progress-bar-animated" role="progressbar" style="width: <? echo $level42/(21/100) ?>%">
             <? echo $level42 ?>
            </div>
           </div>
           </div>
    <div class="col-lg-3 mx-auto">
      <div class="card" style="width: 100%;">
        <img class="card-img-top " src="<?php echo $img;?>" alt="">
        <div class="card-body">
        <h5 class="card-title"><?php echo $displayname;?></h5>
         <p class="card-text"><b>Login:</b> <? echo $login ?></p>
         <p class="card-text"><b>Level:</b> <? echo $level42 ?></p>
         <p class="card-text"><b>Name:</b> <? echo $displayname ?></p>
         <p class="card-text"><b>Phone:</b> <? echo $phone ?></p>
         <p class="card-text"><b>Email:</b> <? echo $email ?></p>
         <p class="card-text"><b>Pool year:</b> <? echo $pooly?></p>
         <p class="card-text"><b>Pool month:</b> <? echo $poolm ?></p>
         <p class="card-text"><b>Wallet:</b> <? echo $wallet ?></p>
         <p class="card-text"><b>Grade:</b> <? echo $grade ?></p>
         <p class="card-text"><b>Correction Point:</b> <? echo $cp ?></p>
         <p class="card-text"><b>Achivements:</b> <? echo $ach ?></p>
         <p class="card-text"><b>Host:</b> <? echo $lastloc ?></p>
         <p class="card-text"><b>Last login(GMT+0):</b> <?php if ($lastlog == 0) { echo "<b>ONLINE</b>"; } else { echo $lastlog ; }?></p>
         <p class="card-text"><b>Hours at cluster:</b> <? echo round($tests[0][0][0],2) ?></p>
         <a href="//profile.intra.42.fr/users/<?php echo $login ?>" target="_blank" class="btn btn-warning">Intra</a>
          <?php
          if ($_GET['course'] == 'bastards' && $offer == 1) { ?>
          <a href="/students/<?php echo $login; ?>/" class="btn btn-success">42 Profile</a>
          <?php } else if ($_GET['course'] == 'students') { ?>
          <a href="/bastards/<?php echo $login; ?>/" class="btn btn-success">Pool Profile</a>
          <?php } ?>
        </div>
      </div>
      <div class="card" style="width: 100%;">
        <div class="card-body">
        <h5 class="card-title">Навыки</h5>
        <?php
          foreach ($result3 as $key => $value) { ?>
            <div class="progress" style="background-color: #717070;margin: 8px 0px ;">
              <div class="progress-bar progress-bar-animated bg-primary progress-bar-striped" role="progressbar" style="width:<?php echo $value[skills_level]/(21/100) ?>%"><?php  echo  $value[skills_name] ?></div>
            </div>
          <?php }?>
        </div>
      </div>
    </div>
    <div class="col-lg-9 mx-auto">
      <div class="card" style="width: 100%;">
        <div class="card-body">
          <h5 class="card-title">Projects (validated)</h5>
          <div style="max-width: 100%; overflow: auto;">
          <table class="table ">
            <thead>
              <tr>
                <th scope="col">name</th>
                <th scope="col">final mark</th>
                <th scope="col">Retray</th>
                <th scope="col">status</th>
                <th scope="col">validated?</th>
              </tr>
            </thead>
            <tbody id="alldata">
              <?php
              $parent = array();
              $nameparent = array();
              $check_failed = 0;
              $check_in_progress = 0;
              $check_searching_a_group = 0;
              $check_creating_group = 0;
              $check_waiting_for_correction = 0;
              foreach ($result2 as $key => $value) {
                if ($value[parent_id] == 0) {
                  if ($value[status] == "in_progress") {
                    $check_in_progress++;
                  }
                  if ($value[status] == "searching_a_group") {
                    $check_searching_a_group++;
                  }
                  if ($value[status] == "creating_group") {
                    $check_creating_group++;
                  }
                  if ($value[status] == "waiting_for_correction") {
                    $check_waiting_for_correction++;
                  }
                }
                if ($value[parent_id] == 0 && $value[validated] == "True") {
                  $nameparent[$value[project_id]] = $value[name];
              ?>
              <tr>
                <td>
                        <div class="progress my-shadow">
                          <div class="progress-bar <?php if ($value[final_mark] > $valid) { echo "bg-success" ;} else { echo "bg-warning" ; }?>" role="progressbar" style="width:<?php echo $value[final_mark]/(125/100) ?>%">
                            <span style="text-align:left;"><a style="color:black; " href="<?php echo "/" . $_GET['course'] . "/projects/" . $value[slug] . "/" ?>"><?php echo $value[name] ?></a></span>
                          </div>
                        </div>
                </td>
                <td><?php echo $value[final_mark] ?></td>
                <td><?php echo $value[occurrence] ?></td>
                <td><?php echo $value[status] ?></td>
                <td><?php echo $value[validated] ?></td>
              </tr>
              <?php } else if ($value[parent_id] == 0 && $value[validated] == "False") { $check_failed++; }
                else if ($value[parent_id] != 0) { $parent[$value[parent_id]][] = $value; } }
              if ($check_failed) { ?>
              <tr><td colspan="5"><h5 class="card-title">Projects (failed)</h5></td></tr>
              <?php
              foreach ($result2 as $key => $value) {
                 $nameparent[$value[project_id]] = $value[name];
                if ($value[parent_id] == 0 && $value[validated] == "False") {
              ?>
              <tr>
                <td>
                        <div class="progress my-shadow">
                          <div class="progress-bar <?php if ($value[final_mark] > $valid) { echo "bg-success" ;} else { echo "bg-warning" ; }?>" role="progressbar" style="width:<?php echo $value[final_mark]/(125/100) ?>%">
                            <span style="text-align:left;"><a style="color:black; " href="<?php echo "/" . $_GET['course'] . "/projects/" . $value[slug] . "/" ?>"><?php echo $value[name] ?></a></span>
                          </div>
                        </div>
                </td>
                <td><?php echo $value[final_mark] ?></td>
                <td><?php echo $value[occurrence] ?></td>
                <td><?php echo $value[status] ?></td>
                <td><?php echo $value[validated] ?></td>
              </tr>
              <?php } } }
              foreach ($parent as $key => $value) { ?>  
              <tr><td colspan="5"><h5 class="card-title"><?php if ($value[0][parent_id] == 61) { echo "Rushes"; } else if ($value[0][parent_id] == 167) {echo "Day 09"; } else echo($nameparent[$value[0][parent_id]]); ?></h5></td></tr>
              <?php foreach ($value as $key2 => $value2) { ?>
              <tr>
                <td>
                        <div class="progress my-shadow">
                          <div class="progress-bar <?php if ($value2[final_mark] > $valid) { echo "bg-success" ;} else { echo "bg-warning" ; }?>" role="progressbar" style="width:<?php echo $value2[final_mark]/(125/100) ?>%">
                          <span style="color:black; text-align:left;"><?php echo $value2[name] ?></span>
                          </div>
                        </div>
                </td>
                <td><?php echo $value2[final_mark] ?></td>
                <td><?php echo $value2[occurrence] ?></td>
                <td><?php echo $value2[status] ?></td>
                <td><?php echo $value2[validated] ?></td>
              </tr>
              <?php } 
              }
              if ($check_in_progress) { ?>
              <tr><td colspan="5"><h5 class="card-title">Projects (in progress)</h5></td></tr>
                            <?php
              foreach ($result2 as $key => $value) {
                 $nameparent[$value[project_id]] = $value[name];
                if ($value[parent_id] == 0 && $value[status] == "in_progress") {
              ?>
              <tr>
                <td>
                        <div class="progress my-shadow">
                          <div class="progress-bar <?php if ($value[final_mark] > $valid) { echo "bg-success" ;} else { echo "bg-warning" ; }?>" role="progressbar" style="width:<?php echo $value[final_mark]/(125/100) ?>%">
                            <span style="text-align:left;"><a style="color:black; " href="<?php echo "/" . $_GET['course'] . "/projects/" . $value[slug] . "/" ?>"><?php echo $value[name] ?></a></span>
                          </div>
                        </div>
                </td>
                <td><?php echo $value[final_mark] ?></td>
                <td><?php echo $value[occurrence] ?></td>
                <td><?php echo $value[status] ?></td>
                <td><?php echo $value[validated] ?></td>
              </tr>
              <?php } } }
              if ($check_searching_a_group) { ?>
              <tr><td colspan="5"><h5 class="card-title">Projects (searching a group)</h5></td></tr>
                            <?php
              foreach ($result2 as $key => $value) {
                 $nameparent[$value[project_id]] = $value[name];
                if ($value[parent_id] == 0 && $value[status] == "searching_a_group") {
              ?>
              <tr>
                <td>
                        <div class="progress my-shadow">
                          <div class="progress-bar <?php if ($value[final_mark] > $valid) { echo "bg-success" ;} else { echo "bg-warning" ; }?>" role="progressbar" style="width:<?php echo $value[final_mark]/(125/100) ?>%">
                            <span style="text-align:left;"><a style="color:black; " href="<?php echo "/" . $_GET['course'] . "/projects/" . $value[slug] . "/" ?>"><?php echo $value[name] ?></a></span>
                          </div>
                        </div>
                </td>
                <td><?php echo $value[final_mark] ?></td>
                <td><?php echo $value[occurrence] ?></td>
                <td><?php echo $value[status] ?></td>
                <td><?php echo $value[validated] ?></td>
              </tr>
              <?php } } }
              if ($check_creating_group) { ?>
              <tr><td colspan="5"><h5 class="card-title">Projects (creating group)</h5></td></tr>
                            <?php
              foreach ($result2 as $key => $value) {
                 $nameparent[$value[project_id]] = $value[name];
                if ($value[parent_id] == 0 && $value[status] == "creating_group") {
              ?>
              <tr>
                <td>
                  <div class="progress my-shadow">
                    <div class="progress-bar <?php if ($value[final_mark] > $valid) { echo "bg-success" ;} else { echo "bg-warning" ; }?>" role="progressbar" style="width:<?php echo $value[final_mark]/(125/100) ?>%">
                      <span style="text-align:left;"><a style="color:black; " href=" <?php echo "/" . $_GET['course'] . "/projects/" . $value[slug] . "/" ?>"><?php echo $value[name] ?></a></span>
                    </div>
                  </div>
                </td>
                <td><?php echo $value[final_mark] ?></td>
                <td><?php echo $value[occurrence] ?></td>
                <td><?php echo $value[status] ?></td>
                <td><?php echo $value[validated] ?></td>
              </tr>
              <?php } } }
              if ($check_waiting_for_correction) { ?>
              <tr><td colspan="5"><h5 class="card-title">Projects (waiting for correction)</h5></td></tr>
                            <?php
              foreach ($result2 as $key => $value) {
                 $nameparent[$value[project_id]] = $value[name];
                if ($value[parent_id] == 0 && $value[status] == "waiting_for_correction") {
              ?>
              <tr>
                <td>
                  <div class="progress my-shadow">
                    <div class="progress-bar <?php if ($value[final_mark] > $valid) { echo "bg-success" ;} else { echo "bg-warning" ; }?>" role="progressbar" style="width:<?php echo $value[final_mark]/(125/100) ?>%">
                      <span style="color:lign:left;"><a href="style="black; text-a" <?php echo "/" . $_GET['course'] . "/projects/" . $value[slug] . "/" ?>"><?php echo $value[name] ?></a></span>
                    </div>
                  </div>
                </td>
                <td><?php echo $value[final_mark] ?></td>
                <td><?php echo $value[occurrence] ?></td>
                <td><?php echo $value[status] ?></td>
                <td><?php echo $value[validated] ?></td>
              </tr>
              <?php } } }?>
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <hr>
        <div class="card" style="width: 100%;">
       <div class="card-body">
         <h5 class="card-title">Time at cluster</h5>
         <canvas id="timer" width="770" height="385" style="display: block; width: 770px; height: 385px;"></canvas>
      </div>
      </div>
    </div>
    <div class="col-lg-12 mx-auto">
      </div>
  </div>
</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<script>
// Any of the following formats may be used
var ctx = document.getElementById("timer");
var ctx = document.getElementById("timer").getContext("2d");
var ctx = $("#timer");
var ctx = "timer";
var timer = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?
          foreach ($newdata as $key => $value) { ?>
            "<? echo date("d-m-Y", strtotime($value[0])) ?>",
          <? } ?>],
        datasets: [{
            label: '# hours in day',
          steppedLine: false,
            data: [<?
          foreach ($newdata as $key => $value) { ?>
            "<? echo round($value[1],2) ?>",
          <? } ?>],
            borderColor: "rgb(75, 192, 192)",
          "lineTension":0.1
        }]
    },
    options: {
        scales: {},
        responsive: true,
    }
});
</script>