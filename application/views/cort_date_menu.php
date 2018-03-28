<div class="portlet-body form non-printable">
  <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
    <div class="form-body">
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> المحكمة </label>
        <select class="form-control input-circle" name="cort" style="width: 40%;">
          <option value="">اختار محكمة ...</option>
          <?php foreach ($courts as $court): ?>
            <option value="<?php echo $court['id'] ?>"><?php echo $court['name'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="form-group">
        <label for="from" class="date-lbl col-lg-1 col-md-1 col-sm-1 col-xs-1 control-label" style="font-size: 18px; font-weight: bold;"> من </label>
        <div>
          <input class="form-control input-large date-picker input-circle" size="" type="text" value="" data-date-format="yyyy-mm-dd" name="date" />
        </div>
      </div>
      <div class="form-group">
        <label for="from" class="date-lbl col-lg-1 col-md-1 col-sm-1 col-xs-1  control-label" style="font-size: 18px; font-weight: bold;"> إلى </label>
        <div>
          <input class="form-control input-large date-picker input-circle" size="" type="text" value="" data-date-format="yyyy-mm-dd" name="date1" />
        </div>
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
    </div>
  </form>
</div>