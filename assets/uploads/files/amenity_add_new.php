<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
      <?php $this->load->view('menu') ?>
      <div id="page-wrapper">
        <div class="a4wrapper">
          <div class="a4page">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
              <div class="page-header">
                <h1 class="centered">Guest Amenity Request</h1>
              </div>
              <?php if(validation_errors() != false): ?>
                <div class="alert alert-danger">
                  <?php echo validation_errors(); ?>
                </div>
              <?php endif ?>         
            </div>
            <div class="container">
              <form action="" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Delivery Date and Time </label>
                      <div class='input-group date' id='datetimepicker1' style="width: 250px; height:33px;">
                          <input type='text' class="form-control" name="date_time"/>
                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <?php foreach ($items as $item):?>
                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                    <?php if(!isset($item['contacts'])): ?>
                      <div class="alert alert-danger" style="width: 80%;">
                        <?php echo "No Data For Such Hotel Room NO# ".$item['room']." !"; ?>
                      </div>
                    <?php endif ?> 
                    <?php foreach($item['contacts'] as $contact):?>
                      <input style="display: none" class="form-control" name="rooms[<?php echo $item['id']?>][id]" value="<?php echo $item['id']?>">
                      <label style="margin-top:5px; font-size: 18px; font-weight:bolder;"> Room No# <?php echo $item['room']?>  </label>
                      <br>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="display: none;">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Guest Name </label>
                      <input type="text" name="rooms[<?php echo $item['id']?>][guest]" class="form-control"   value="<?php echo $contact['guest_name']; ?>" style="width: 250px; height:33px;"/>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="display: none;">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Guest Nationality </label>
                      <input type="text" name="rooms[<?php echo $item['id']?>][nationality]" class="form-control" value="<?php echo $contact['nation']; ?>" style="width: 250px; height:33px;"/> 
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="display: none;">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Arrival Date </label>
                      <input type="text" name="rooms[<?php echo $item['id']?>][arrival]" class="form-control" value="<?php echo $contact['arriv']; ?>" style="width: 250px; height:33px;"/>
                    </div><div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="display: none;">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Departure Date </label>
                      <input type="text" name="rooms[<?php echo $item['id']?>][departure]" class="form-control" value="<?php echo $contact['depart']; ?>" style="width: 250px; height:33px;"/>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0"> 
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Long Stay</label>
                      <input type="checkbox" name="rooms[<?php echo $item['id']?>][long]" value="1" id="long<?php echo $item['id']?>"><p style="font-size: 10px;"><span style="font-weight: bold;">Note:</span> More than 15 days</p>
                      <input type="text" class="form-control" name="rooms[<?php echo $item['id']?>][long_stay]" id="long_stay<?php echo $item['id']?>" style="display: none; width: 250px; height:33px;" />
                    </div>
                    <script type="text/javascript">
                      var checkbox = document.getElementById('long<?php echo $item['id']?>');
                      var input = document.getElementById('long_stay<?php echo $item['id']?>');
                      checkbox.addEventListener('click', function () {
                         if (input.style.display != 'block') {
                          input.style.display = 'block';
                        } else {
                          input.style.display = 'none';
                        }
                      });
                    </script>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;">Refiling</label>
                      <input type="checkbox" name="rooms[<?php echo $item['id']?>][ref]" value="1" id="ref<?php echo $item['id']?>"><p style="font-size: 10px;"><span style="font-weight: bold;">Note:</span> Number of times</p>
                      <input type="text" class="form-control" name="rooms[<?php echo $item['id']?>][refiling]" id="refiling<?php echo $item['id']?>" style="display: none; width: 250px; height:33px;" />
                    </div>
                    <script type="text/javascript">
                      var checkbox = document.getElementById('ref<?php echo $item['id']?>');
                      var input = document.getElementById('refiling<?php echo $item['id']?>');
                      checkbox.addEventListener('click', function () {
                         if (input.style.display != 'block') {
                          input.style.display = 'block';
                        } else {
                          input.style.display = 'none';
                        }
                      });
                    </script>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0" style="display: none;">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> No. of Pax </label>
                      <input type="text" name="rooms[<?php echo $item['id']?>][pax]" class="form-control" style="width: 250px; height:33px;"/> 
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> VIP Full Treatment </label>
                      <select class="form-control" name="rooms[<?php echo $item['id']?>][treatment]" style="width: 250px; height:33px;">
                        <option value="">Select Treatment</option>
                        <option value="VIP (1)">VIP (1)</option> ‎
                        <option value="VIP (2)">VIP (2)</option> 
                        <option value="VIP (3)">VIP (3)</option>
                        <option value="VIP full Treatment">VIP full Treatment</option>
                        <option value="Compensation">Compensation</option>
                      </select>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Others </label>
                      <div class="col-lg-offset-0 col-lg-10 col-md-8 col-md-offset-3" style="width: 600px;">
                        <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][cookies]" value="1">Cookies &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][nuts]" value="1">Nuts &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][wine]" value="1">Bottle Of Wine
                        </div>
                        <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][fruit]" value="1">Fruit Basket &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][beer]" value="1">Beer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][cake]" value="1">Birthday Cake
                        </div>
                        <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][anniversary]" value="1">Anniversary &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][honeymoon]" value="1">Honeymoon &nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][juices]" value="1">Small Can of Juices
                        </div>
                        <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][dinner]" value="1">Candel Light Dinner &nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][sick]" value="1">Sick Meal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][alcohol]" value="1"> Without Alcohol
                        </div>
                        <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][th]" value="1"> TH Bonus &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="checkbox" name="rooms[<?php echo $item['id']?>][uk]" value="1"> TC UK arrival
                        </div>
                      </div>
                    </div>
                </div>
                <?php endforeach ?>
                <?php endforeach ?>
                <script type="text/javascript">
                  document.rooms = <?php echo json_encode($this->input->post('rooms')); ?>;
                </script>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> The Reason </label>
                      <br>
                      <textarea type="text" name="reason" class="form-control" style=" width: 500px; height:100px;"></textarea>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Location </label>
                      <input type="text" name="location" class="form-control" style="width: 250px; height:33px;"/> 
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Others </label>
                      <textarea type="text" name="others" class="form-control" style=" width: 500px; height:100px;"></textarea>
                    </div>
                    <div class="col-lg-offset-0 col-lg-10 col-md-10 col-md-offset-0">
                      <br>
                      <label for="from-hotel" class="col-lg-2 col-md-2 col-sm-2 col-xs-2  control-label " style="margin-top:5px;"> Guest Relations </label>
                      <input type="text" name="relations" class="form-control" style="width: 250px; height:33px;"/> 
                    </div>
                <div class="form-group col-lg-12 col-md-10 col-sm-12 col-xs-12" style="width: 67%;">
                    <input type="hidden" name="amen_id" value="<?php echo $amenity['id']; ?>" />
                      <label for="offers" class="col-lg-3 col-md-4 col-sm-5 col-xs-5 control-label">Report Files</label>
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="true">
                      </div>
                      <script>
                      $("#offers").fileinput({
                          uploadUrl: "/amenity/make_offer/<?php echo $amenity['id'] ?>", // server upload action
                          uploadAsync: true,
                          minFileCount: 1,
                          maxFileCount: 5,
                          overwriteInitial: false,
                          initialPreview: [
                          <?php foreach($uploads as $upload): ?>
                            "<div class='file-preview-text'>" +
                            "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                            "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                          <?php endforeach ?>
                          ],
                          initialPreviewConfig: [
                          <?php foreach($uploads as $upload): ?>
                              {url: "/amenity/remove_offer/<?php echo $amenity['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                          <?php endforeach; ?>
                          ],
                      });
                      </script>
                  </div>
                <div style="    margin-top: 90px;" class="form-group">
                  <div class="col-lg-offset-3 col-lg-10 col-md-10 col-md-offset-3">
                    <br>
                    <br>
                    <br>
                    <br>
                    <input name="submit" value="Submit" type="submit" class="btn btn-success" />
                    <a href="<?= base_url(); ?>amenity" class="btn btn-warning">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(function () {
        $('#datetimepicker1').datetimepicker({
          format: 'DD/MM/YYYY hh:mm a'
        });
      });
    </script>    
  </body>
</html>
