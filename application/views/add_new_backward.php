<!DOCTYPE html >
<html lang="en" dir="rtl">
  <head>
    <?php $this->load->view('header'); ?>
  </head>
  <body>
    <div id="wrapper">
      <div id="page-wrapper">
        <div class="a4wrapper">
          <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
          <div class="col-md-12">
            <div class="portlet light bordered">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="page-header">
                  <a class="form-actions btn btn-info non-printable" href="/welcome" style="float:left;" > العودة للسابق </a>
                  <h1 class="centered"> إضافة جديد </h1>
                </div>
                <?php if(validation_errors() != false): ?>
                  <div class="alert alert-danger">
                    <?php echo validation_errors(); ?>
                  </div>
                <?php endif ?>
              </div>
              <div class="portlet-body form">
                <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                  <div class="form-body">
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> صفة لموكل </label>
                      <select class="form-control input-circle" name="client_type" style="width: 40%;">
                        <option value="">اختار صفه ..</option>
                        <?php foreach ($client_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('client_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> صفة الخصم </label>
                      <select class="form-control input-circle" name="opponent_type" style="width: 40%;">
                        <option value="">اختار صفه ..</option>
                        <?php foreach ($opponent_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('opponent_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> نوع القضية</label>
                      <select class="form-control input-circle" name="case_type_id" style="width: 40%;">
                        <option value="">اختار صفه ...</option>
                        <?php foreach ($case_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('case_type_id',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> المحكمة </label>
                      <select class="form-control input-circle" name="court_id" style="width: 40%;">
                        <option value="">اختار محكمة ...</option>
                        <?php foreach ($courts as $court): ?>
                          <option value="<?php echo $court['id'] ?>"<?php echo set_select('court_id',$court['id'] ); ?>><?php echo $court['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة </label>
                      <input type="text" name="area_no" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدعوى </label>
                      <input type="text" name="number" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> لسنة </label>
                      <div class='input-group date' id='datetimepicker1' style="width: 40%;">
                        <input type='text' class="form-control" name="year" style="height: 100%;"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> تاريخ الجلسة </label>
                      <div class='input-group date' id='datetimepicker2' style="width: 40%;">
                        <input type='text' class="form-control" name="date"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> تقرير القضية </label>
                      <input type="text" name="report" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> موقف القضية </label>
                      <select class="form-control input-circle" name="state_id" style="width: 40%;">
                        <option value=""></option>
                        <?php foreach ($states as $state): ?>
                          <option value="<?php echo $state['id'] ?>"<?php echo set_select('state_id',$state['id'] ); ?>><?php echo $state['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> آخر ميعاد للطعن </label>
                      <div class='input-group date' id='datetimepicker3' style="width: 40%;">
                        <input type='text' class="form-control" name="appeal" value="" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="iss_id" value="<?php echo $issue['id']; ?>" />
                      <label style="font-size: 18px; font-weight: bold;">ملفات القضية</label>
                      <div class="form-group">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="false" data-show-remove="false">
                      </div>
                      <script>
                        $("#offers").fileinput({
                          uploadUrl: "/issue/make_offer/<?php echo $issue['id']; ?>", // server upload action
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
                                {url: "/issue/remove_offer/<?php echo $issue['id'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                            <?php endforeach; ?>
                          ],
                        });
                      </script>
                    </div>
                  </div>
                  <div class="form-actions">
                    <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
                    <a href="<?= base_url(); ?>" class="btn default">إلغاء</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
        </div>
      </div>
    </div>  
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                viewMode: 'years',
                minViewMode: "years",
                format: 'YYYY'
            });
        });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker2').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script>
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker3').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script>
  </body>
</html>
