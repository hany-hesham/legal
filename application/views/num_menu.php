<div class="portlet-body form non-printable">
  <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
    <div class="form-body non-printable">
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> رقم الدعوة </label>
        <select class="form-control input-circle" name="number" style="width: 40%;">
          <option value="">اختار رقم ...</option>
          <?php foreach ($isses as $iss): ?>
            <option value="<?php echo $iss['number'] ?>"><?php echo $iss['numbers'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="form-actions non-printable">
      <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
    </div>
  </form>
</div>