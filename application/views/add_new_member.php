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
                  <h1 class="centered"> إضافة أفراد القضية </h1>
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
                      <label style="font-size: 18px; font-weight: bold;"> رقم الدعوة </label>
                      <select class="form-control input-circle" name="issue_id" style="width: 40%;">
                        <option value="">اختار رقم ...</option>
                        <?php foreach ($issues as $issue): ?>
                          <option value="<?php echo $issue['id'] ?>"<?php echo set_select('issue_id',$issue['id'] ); ?>><?php echo $issue['number']." لسنة ".$issue['year'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <div id="items-container" data-items="1">
                        <span class="btn btn-primary" id="add-item" style="width: 100px; float: left;">إضافة</span>
                        <br>
                        <div id="item-1" style="margin-top: 20px;">
                          <select class="form-control input-circle" name="users[1][stuff_id]" id="item-1-user" style="width: 40%;">
                            <option value="">اختار محامي ...</option>
                            <?php foreach ($users as $user): ?>
                              <option value="<?php echo $user['id'] ?>"><?php echo $user['fullname'] ?></option>
                            <?php endforeach ?>
                          </select>
                          <span data-item-id="" class="btn btn-danger remove-item" style="width: 100px; float: left;">مسح</span>
                        </div>
                      </div>
                    </div>
                    <script type="text/javascript">
                      document.items = <?php echo json_encode($this->input->post('users')); ?>;
                    </script>
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
    <script id="item-template" type="text/x-handlebars-template">
      <div id="item-{{id}}">
        <div class="centered" style="margin-top: 20px;">
          <select class="form-control input-circle" name="users[{{id}}][stuff_id]" id="item-{{id}}-user" style="width: 40%;">
            <option value="">اختار رقم ...</option>
            <?php foreach ($users as $user): ?>
              <option value="<?php echo $user['id'] ?>"><?php echo $user['fullname'] ?></option>
            <?php endforeach ?>
          </select>
          <span data-item-id="{{id}}" class="btn btn-danger remove-item" style="width: 100px; float: left;">مسح</span>
        </div>
      </div>
    </script>
  </body>
</html>
