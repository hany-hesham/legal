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
                  <a class="form-actions btn btn-info non-printable" href="/issue/view/<?php echo $issue['id']?>" style="float:left;" > العودة للقضية </a>
                  <h1 class="centered"> تعديل قضية </h1>
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
                      <label style="font-size: 18px; font-weight: bold;"> اسم الفندق </label>
                      <select class="form-control input-circle" name="hotel_id" style="width: 40%;">
                        <option value="<?php echo $issue['hotel_id'] ?>"><?php echo $issue['hotel_name'] ?></option>
                        <?php foreach ($hotels as $hotel): ?>
                          <option value="<?php echo $hotel['id'] ?>"<?php echo set_select('hotel_id',$hotel['id'] ); ?>><?php echo $hotel['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> اسم الموكل </label>
                      <select class="form-control input-circle" name="client_id" style="width: 40%;">
                        <option value="<?php echo $issue['client_id'] ?>"><?php echo $issue['client_name'] ?></option>
                        <?php foreach ($clients as $client): ?>
                          <option value="<?php echo $client['id'] ?>"<?php echo set_select('client_id',$client['id'] ); ?>><?php echo $client['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> صفة لموكل </label>
                      <select class="form-control input-circle" name="client_type" style="width: 40%;">
                        <option value="<?php echo $issue['client_type'] ?>"><?php echo $issue['clnt_type'] ?></option>
                        <?php foreach ($client_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('client_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($backward['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> صفة لموكل في الإستئناف </label>
                      <select class="form-control input-circle" name="backward_client_type" style="width: 40%;">
                        <option value="<?php echo $backward['client_type'] ?>"><?php echo $backward['clnt_type'] ?></option>
                        <?php foreach ($client_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('client_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($revers['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> صفة لموكل في الإشكال </label>
                      <select class="form-control input-circle" name="revers_client_type" style="width: 40%;">
                        <option value="<?php echo $revers['client_type'] ?>"><?php echo $revers['clnt_type'] ?></option>
                        <?php foreach ($client_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('client_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($shout['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> صفة لموكل في الطعن </label>
                      <select class="form-control input-circle" name="shout_client_type" style="width: 40%;">
                        <option value="<?php echo $shout['client_type'] ?>"><?php echo $shout['clnt_type'] ?></option>
                        <?php foreach ($client_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('client_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> اسم الخصم </label>
                      <input type="text" name="opponent" class="form-control input-circle" value="<?php echo $issue['opponent'] ?>" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> عنوان الخصم </label>
                      <input type="text" name="opnt_address" class="form-control input-circle" value="<?php echo $issue['opnt_address'] ?>" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> صفة الخصم </label>
                      <select class="form-control input-circle" name="opponent_type" style="width: 40%;">
                        <option value="<?php echo $issue['opponent_type'] ?>"><?php echo $issue['opnt_type'] ?></option>
                        <?php foreach ($opponent_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('opponent_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($backward['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> صفة الخصم في الإستئناف </label>
                      <select class="form-control input-circle" name="backward_opponent_type" style="width: 40%;">
                        <option value="<?php echo $backward['opponent_type'] ?>"><?php echo $backward['clnt_type'] ?></option>
                        <?php foreach ($opponent_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('opponent_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($revers['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> صفة الخصم في الإشكال </label>
                      <select class="form-control input-circle" name="revers_opponent_type" style="width: 40%;">
                        <option value="<?php echo $revers['opponent_type'] ?>"><?php echo $revers['clnt_type'] ?></option>
                        <?php foreach ($opponent_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('opponent_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($shout['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> صفة الخصم في الطعن </label>
                      <select class="form-control input-circle" name="shout_opponent_type" style="width: 40%;">
                        <option value="<?php echo $shout['opponent_type'] ?>"><?php echo $shout['clnt_type'] ?></option>
                        <?php foreach ($opponent_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('opponent_type',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> نوع القضية</label>
                      <select class="form-control input-circle" name="case_type_id" style="width: 40%;">
                        <option value="<?php echo $issue['case_type_id'] ?>"><?php echo $issue['case_type'] ?></option>
                        <?php foreach ($case_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('case_type_id',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($backward['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> نوع القضية في الإستئناف </label>
                      <select class="form-control input-circle" name="backward_case_type_id" style="width: 40%;">
                        <option value="<?php echo $backward['case_type_id'] ?>"><?php echo $backward['case_type'] ?></option>
                        <?php foreach ($case_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('case_type_id',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($revers['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> نوع القضية في الإشكال </label>
                      <select class="form-control input-circle" name="revers_case_type_id" style="width: 40%;">
                        <option value="<?php echo $revers['case_type_id'] ?>"><?php echo $revers['case_type'] ?></option>
                        <?php foreach ($case_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('case_type_id',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($shout['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> نوع القضية في الطعن </label>
                      <select class="form-control input-circle" name="shout_case_type_id" style="width: 40%;">
                        <option value="<?php echo $shout['case_type_id'] ?>"><?php echo $shout['case_type'] ?></option>
                        <?php foreach ($case_types as $type): ?>
                          <option value="<?php echo $type['id'] ?>"<?php echo set_select('case_type_id',$type['id'] ); ?>><?php echo $type['type'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> موضوع القضية </label>
                      <textarea type="text" name="describtion" class="form-control" rows="3"><?php echo $issue['describtion'] ?></textarea>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> المحكمة </label>
                      <select class="form-control input-circle" name="court_id" style="width: 40%;">
                        <option value="<?php echo $issue['court_id'] ?>"><?php echo $issue['court'] ?></option>
                        <?php foreach ($courts as $court): ?>
                          <option value="<?php echo $court['id'] ?>"<?php echo set_select('court_id',$court['id'] ); ?>><?php echo $court['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($backward['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> المحكمة في الإستئناف </label>
                      <select class="form-control input-circle" name="backward_court_id" style="width: 40%;">
                        <option value="<?php echo $backward['court_id'] ?>"><?php echo $backward['court'] ?></option>
                        <?php foreach ($courts as $court): ?>
                          <option value="<?php echo $court['id'] ?>"<?php echo set_select('court_id',$court['id'] ); ?>><?php echo $court['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($revers['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> المحكمة في الإشكال </label>
                      <select class="form-control input-circle" name="revers_court_id" style="width: 40%;">
                        <option value="<?php echo $revers['court_id'] ?>"><?php echo $revers['court'] ?></option>
                        <?php foreach ($courts as $court): ?>
                          <option value="<?php echo $court['id'] ?>"<?php echo set_select('court_id',$court['id'] ); ?>><?php echo $court['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group" style="display: <?php echo ($shout['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> المحكمة في الطعن </label>
                      <select class="form-control input-circle" name="shout_court_id" style="width: 40%;">
                        <option value="<?php echo $shout['court_id'] ?>"><?php echo $shout['court'] ?></option>
                        <?php foreach ($courts as $court): ?>
                          <option value="<?php echo $court['id'] ?>"<?php echo set_select('court_id',$court['id'] ); ?>><?php echo $court['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة </label>
                      <input type="text" name="area_no" value="<?php echo $issue['area_no'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group" style="display: <?php echo ($backward['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة في الإستئناف </label>
                      <input type="text" name="backward_area_no" value="<?php echo $backward['area_no'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group" style="display: <?php echo ($revers['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة في الإشكال </label>
                      <input type="text" name="revers_area_no" value="<?php echo $revers['area_no'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group" style="display: <?php echo ($shout['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة في الطعن </label>
                      <input type="text" name="shout_area_no" value="<?php echo $shout['area_no'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدعوى </label>
                      <input type="text" name="number" value="<?php echo $issue['number'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group" style="display: <?php echo ($backward['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدعوى في الإستئناف </label>
                      <input type="text" name="backward_number" value="<?php echo $backward['number'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group" style="display: <?php echo ($revers['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدعوى في الإشكال </label>
                      <input type="text" name="revers_number" value="<?php echo $revers['number'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group" style="display: <?php echo ($shout['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدعوى في الطعن </label>
                      <input type="text" name="shout_number" value="<?php echo $shout['number'] ?>" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> لسنة </label>
                      <div class='input-group date' id='datetimepicker1' style="width: 40%;">
                        <input type='text' class="form-control" name="year" value="<?php echo $issue['year'] ?>" style="height: 100%;"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group" style="display: <?php echo ($backward['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة في الإستئناف </label>
                      <div class='input-group date' id='datetimepicker2' style="width: 40%;">
                        <input type='text' class="form-control" name="backward_year" value="<?php echo $backward['year'] ?>" style="height: 100%;"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group" style="display: <?php echo ($revers['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة في الإشكال </label>
                      <div class='input-group date' id='datetimepicker3' style="width: 40%;">
                        <input type='text' class="form-control" name="revers_year" value="<?php echo $revers['year'] ?>" style="height: 100%;"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group" style="display: <?php echo ($shout['id'])? "":"none"?>">
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدائرة في الطعن </label>
                      <div class='input-group date' id='datetimepicker4' style="width: 40%;">
                        <input type='text' class="form-control" name="shout_year" value="<?php echo $shout['year'] ?>" style="height: 100%;"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> ملاحظات </label>
                      <textarea type="text" name="notes" class="form-control" rows="3"><?php echo $issue['notes'] ?></textarea>
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
                    <a href="/issue/view/<?php echo $issue['id']?>" class="btn default">إلغاء</a>
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
  </body>
</html>
