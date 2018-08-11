<div class="container">
  <div class="row">
    <div class="col-lg-12 mx-auto">
      <input class="form-control" id="search" type="text" placeholder="Type anything...">
    </div>
  </div>
</div>
<table class="table table-striped" >
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><span class="arrow" name="xlogin" id="ASC">⇧</span>xlogin<span  class="arrow"  name="xlogin" id="DESC">⇩</span></th>
      <th scope="col">name</th>
      <th scope="col">phone</th>
      <th scope="col"><span class="arrow" name="lvl" id="ASC">⇧</span>level<span  class="arrow"  name="lvl" id="DESC">⇩</span></th>
      <th scope="col">
      <select class="year arrow">
        <option>All</option>
        <option>2016</option>
        <option>2017</option>
        <option <?php if ($bas && 2018 == $data_array['year']) echo 'selected'?>>2018</option>
      </select>
      </th>
      <th scope="col">
        <select class="month arrow">
        <option>All</option>
        <option>february</option>
        <option <?php if ($bas && "july" == $data_array['month']) echo 'selected'?>>july</option>
        <option <?php if ($bas && "august" == $data_array['month']) echo 'selected'?>>august</option>
        <option <?php if ($bas && "september" == $data_array['month']) echo 'selected'?>>september</option>
        <option>october</option>
        <option>november</option>
        </select>
      </th>
      <th scope="col"><span class="arrow" name="wallet" id="ASC">⇧</span>wallet<span  class="arrow"  name="wallet" id="DESC">⇩</span></th>
      <th scope="col" data-toggle="tooltip" title="Correction Point"><span class="arrow" name="cp" id="ASC">⇧</span>CP<span  class="arrow"  name="cp" id="DESC">⇩</span></th>
      <th scope="col" data-toggle="tooltip" title="Number of awards received in Intra"><span class="arrow" name="howach" id="ASC">⇧</span>Achiv<span  class="arrow"  name="howach" id="DESC">⇩</span></th>
      <th scope="col" data-toggle="tooltip" title="The number of hours spent at UNIT Factory"><span class="arrow" name="timer" id="ASC">⇧</span>Hours<span  class="arrow"  name="timer" id="DESC">⇩</span></th>
      <th scope="col" data-toggle="tooltip" title="">location</th>
      <th scope="col" data-toggle="tooltip" title="The time of the last login in the cluster">last(GMT+0)</th>
    </tr>
  </thead>
  <tbody id="alldata">
    <?php
    foreach ($result as $key => $value) {
    ?>
    <tr<?php if ($value[lastloc] == 0) { echo " class=\"table-success\""; } ?>>
      <td scope="col <?php ?>"><?php echo $key + 1 ?></td>
      <td><a href="<?php echo "/" . $_GET['course'] . "/" . $value[login] . "/" ; ?>"><?php echo $value[login] ?></a></td>
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
  </tbody>
</table>
