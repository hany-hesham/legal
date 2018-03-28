<div class="portlet-body form non-printable">
  <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
    <div class="form-body">
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> نوع القضية </label>
        <select class="form-control input-circle" name="type" style="width: 40%;">
          <option value="">اختار نوع قضية ...</option>
          <?php foreach ($case_types as $type): ?>
            <option value="<?php echo $type['id'] ?>"><?php echo $type['type'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
    </div>
  </form>
</div>