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
                  <h1 class="centered"> إضافة صفة </h1>
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
                      <label style="font-size: 18px; font-weight: bold;"> الصفة </label>
                      <input type="text" name="type" class="form-control input-circle" style="width: 40%;"/>
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
  </body>
</html>
