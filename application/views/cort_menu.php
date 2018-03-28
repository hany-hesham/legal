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
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
    </div>
  </form>
</div>