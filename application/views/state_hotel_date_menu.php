<div class="portlet-body form non-printable">
  <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
    <div class="form-body">
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> حالة القضية </label>
        <select class="form-control input-circle" name="state" style="width: 40%;">
          <option value="">اختار نوع قضية ...</option>
          <?php foreach ($states as $state): ?>
            <option value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> اسم الفندق </label>
        <select class="form-control input-circle" name="hotel_id" style="width: 40%;">
          <option value="">اختار فندق ...</option>
          <?php foreach ($hotels as $hotel): ?>
            <option value="<?php echo $hotel['id'] ?>"><?php echo $hotel['name'] ?></option>
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