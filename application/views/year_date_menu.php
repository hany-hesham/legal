<div class="portlet-body form  non-printable">
  <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
    <div class="form-body non-printable">
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> السنة </label>
        <select class="form-control input-circle" name="year" style="width: 40%;">
          <option value="">اختار  سنة ...</option>
          <?php foreach ($isses as $iss): ?>
            <option value="<?php echo $iss['years'] ?>"><?php echo $iss['year'] ?></option>
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
    <div class="form-actions non-printable">
      <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
    </div>
  </form>
</div>