<div class="portlet-body form non-printable">
  <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
    <div class="form-body">
      <div class="form-group">
        <label style="font-size: 18px; font-weight: bold;"> السنة </label>
        <select class="form-control input-circle" name="year" style="width: 40%;">
          <option value="">اختار  سنة ...</option>
          <?php foreach ($isses as $iss): ?>
            <option value="<?php echo $iss['years'] ?>"><?php echo $iss['year'] ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
    <div class="form-actions">
      <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
    </div>
  </form>
</div>
<script type="text/javascript">
  $(function () {
    $('#datetimepicker1').datetimepicker({
      viewMode: 'years',
      minViewMode: "years",
      format: 'YYYY'
    });
  });
</script>