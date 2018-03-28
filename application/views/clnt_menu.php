<div class="portlet-body form non-printable">
  <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
    <div class="form-body">
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> اسم الموكل </label>
        <select class="form-control input-circle" name="client_id" style="width: 40%;">
          <option value="">اختار موكل ...</option>
          <?php foreach ($clients as $client): ?>
            <option value="<?php echo $client['id'] ?>"><?php echo $client['name'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
    </div>
  </form>
</div>