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
                  <h1 class="centered"> إضافة منشور إداري </h1>
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
                      <label style="font-size: 18px; font-weight: bold;"> موضوع المنشور </label>
                      <input type="text" name="subject" class="form-control input-circle" style="width: 40%;"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> تاريخ الإجتماع </label>
                      <div class='input-group date' id='datetimepicker1' style="width: 40%;">
                        <input type='text' class="form-control" name="date"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> القرارات المتفق عليها </label>
                      <textarea type="text" name="decision" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="assumed_id" value="<?php echo $assumed_id; ?>" />
                      <label style="font-size: 18px; font-weight: bold;">ملفات القضية</label>
                      <div class="form-group">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="false" data-show-remove="false">
                      </div>
                      <script>
                        $("#offers").fileinput({
                          uploadUrl: "/management/make_offer/<?php echo $assumed_id; ?>", // server upload action
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
                                {url: "/management/remove_offer/<?php echo $assumed_id ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
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
      $(function(){
        $('#datetimepicker1').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script>   
  </body>
</html>
