<!DOCTYPE html >
<html lang="en" dir="rtl">
    <head>
        <?php $this->load->view('header'); ?>
        <style type="text/css">
            .sunrise{
                  background-color: #FFECCA !important; 
                  font-weight: bold !important;
                }
            .sunrise1{
                  background-color: #BBBDFA !important; 
                  font-weight: bold !important;
                }
            @media print{
                .sunrise{
                  background-color: #FFECCA !important; 
                  font-weight: bold !important;
                }
                .sunrise1{
                  background-color: #BBBDFA !important; 
                  font-weight: bold !important;
                }
            }
        </style>
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
                                    <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" style="float: left;">طباعة</button>
                                    <div class="header-logo"><img src="/assets/uploads/logos/<?php echo $issue['logo']; ?>"/></div>
                                    <h1 class="centered"><?php echo $issue['hotel_name']; ?></h1>
                                    <h2 class="centered"> القضية رقم <?php echo $issue['id'] ?> </h2>
                                    <a class="form-actions btn btn-info non-printable" href="/issue/view_all" style="float:left;" > العودة لجميع القضايا </a>
                                    <a class="form-actions btn btn-info non-printable" href="/user_issue" style="float:right;" > العودة لجميع القضايا الخاصة ب<?php echo $user->fullname; ?> </a>
                                </div>
                            </div>
                            <div class="portlet-body ">
                                <div class="form-body">
                                    <div class="form-group">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-bordered table-hover table-striped centered">
                                                <tr style="font-weight: bolder;" class="sunrise">
                                                    <td colspan="4">
                                                        الموكل
                                                    </td>
                                                    <td colspan="4">
                                                        صفته
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <?php echo $issue['client_name'] ?>
                                                    </td>
                                                    <td colspan="<?php  if($revers['id']){ 
                                                        echo "1"; 
                                                        }elseif($shout['id']){ 
                                                            echo "2"; 
                                                        }elseif($backward['id']){ 
                                                            echo "2"; 
                                                        }else{ echo "4"; }?>">
                                                        <?php echo $issue['clnt_type'] ?>
                                                    </td>
                                                    <td colspan="<?php echo ($revers['id'])? 1:($shout['id'])? 1:2;?>" style="display: <?php echo ($backward['id'])? "":"none"?>">
                                                        <?php echo $backward['clnt_type'] ?>
                                                    </td>
                                                    <td colspan="1" style="display: <?php echo ($shout['id'])? "":"none"?>">
                                                        <?php echo $shout['clnt_type'] ?>
                                                    </td>
                                                    <td colspan="1" style="display: <?php echo ($revers['id'])? "":"none"?>">
                                                        <?php echo $revers['clnt_type'] ?>
                                                    </td>
                                                </tr>
                                                <tr style="font-weight: bolder;" class="sunrise">
                                                    <td colspan="2">
                                                        الخصم
                                                    </td>
                                                    <td colspan="2">
                                                        عنوان الخصم
                                                    </td>
                                                    <td colspan="4">
                                                        صفته
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <?php echo $issue['opponent'] ?>
                                                    </td>
                                                    <td colspan="2">
                                                        <?php echo $issue['opnt_address'] ?>
                                                    </td>
                                                    <td colspan="<?php  if($revers['id']){ 
                                                        echo "1"; 
                                                        }elseif($shout['id']){ 
                                                            echo "2"; 
                                                        }elseif($backward['id']){ 
                                                            echo "2"; 
                                                        }else{ echo "4"; }?>">
                                                        <?php echo $issue['opnt_type'] ?>
                                                    </td>
                                                    <td colspan="<?php echo ($revers['id'])? 1:($shout['id'])? 1:2;?>" style="display: <?php echo ($backward['id'])? "":"none"?>">
                                                        <?php echo $backward['opnt_type'] ?>
                                                    </td>
                                                    <td colspan="1" style="display: <?php echo ($shout['id'])? "":"none"?>">
                                                        <?php echo $shout['opnt_type'] ?>
                                                    </td>
                                                    <td colspan="1" style="display: <?php echo ($revers['id'])? "":"none"?>">
                                                        <?php echo $revers['opnt_type'] ?>
                                                    </td>
                                                </tr>
                                                <tr style="font-weight: bolder;" class="sunrise">
                                                    <td colspan="1">
                                                        رقم الدعوى
                                                    </td>
                                                    <td colspan="2">
                                                        لسنة
                                                    </td>
                                                    <td colspan="2">
                                                        نوع القضية
                                                    </td>
                                                    <td colspan="2">
                                                        المحكمة
                                                    </td>
                                                    <td colspan="1">
                                                        رقم الدائرة
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1">
                                                        <?php echo $issue['number'] ?>
                                                    </td>
                                                    <td colspan="2">
                                                        <?php echo $issue['year'] ?>
                                                    </td>
                                                    <td colspan="2">
                                                        <?php echo $issue['case_type'] ?>
                                                    </td>
                                                    <td colspan="2">
                                                        <?php echo $issue['court'] ?>
                                                    </td>
                                                    <td colspan="1">
                                                        <?php echo $issue['area_no'] ?>
                                                    </td>
                                                </tr>
                                                <?php if($backward['id']){ ?>
                                                    <tr>
                                                        <td colspan="1">
                                                            <?php echo $backward['number'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $backward['year'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $backward['case_type'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $backward['court'] ?>
                                                        </td>
                                                        <td colspan="1">
                                                            <?php echo $backward['area_no'] ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if($shout['id']){ ?>
                                                    <tr>
                                                        <td colspan="1">
                                                            <?php echo $shout['number'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $shout['year'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $shout['case_type'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $shout['court'] ?>
                                                        </td>
                                                        <td colspan="1">
                                                            <?php echo $shout['area_no'] ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <?php if($revers['id']){ ?>
                                                    <tr>
                                                        <td colspan="1">
                                                            <?php echo $revers['number'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $revers['year'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $revers['case_type'] ?>
                                                        </td>
                                                        <td colspan="2">
                                                            <?php echo $revers['court'] ?>
                                                        </td>
                                                        <td colspan="1">
                                                            <?php echo $revers['area_no'] ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr style="font-weight: bolder;" class="sunrise">
                                                    <td colspan="8">
                                                        موضوع القضية
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8">
                                                        <?php echo $issue['describtion'] ?>
                                                    </td>
                                                </tr>
                                                <tr style="font-weight: bolder;" class="sunrise">
                                                    <td colspan="8">
                                                        ملاحظات المحامي المختص
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8">
                                                        <?php echo $issue['notes'] ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="table table-bordered table-hover table-striped centered">
                                                <tr style="font-weight: bolder;" class="sunrise1">
                                                        <td colspan="1" style="width: 180px">
                                                            جلسة
                                                        </td>
                                                        <td colspan="1" style="width: 180px">
                                                            بيان ما تم 
                                                        </td>
                                                        <td colspan="1" style="width: 180px">
                                                             موقف القضية
                                                        </td>
                                                        <td colspan="1" style="width: 180px">
                                                            آخر ميعاد للطعن 
                                                        </td>
                                                    </tr>
                                                    <?php foreach ($disscutions as $disscution) { ?>
                                                            <tr>
                                                                <td colspan="1" style="width: 180px">
                                                                    <?php echo $disscution['date'] ?>
                                                                </td>
                                                                <td colspan="1" style="width: 900px">
                                                                    <?php echo $disscution['report'] ?>
                                                                </td>
                                                                <td colspan="1" style="width: 180px">
                                                                    <?php echo $disscution['case_state'] ?>
                                                                </td>
                                                                <td colspan="1" style="width: 180px">
                                                                    <?php echo $disscution['appeal'] ?>
                                                                </td>
                                                            </tr>
                                                    <?php } ?>
                                                </table>
                                        </div>
                                    </div>
                                    <div class="portlet-body form">
                <form role="form" method="POST" id="form-submit" enctype="multipart/form-data" class="form-div span12" accept-charset="utf-8">
                  <div class="form-body">
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> تاريخ الجلسة </label>
                      <div class='input-group date' id='datetimepicker1' style="width: 40%;">
                        <input type='text' class="form-control" name="date" value="<?php echo $discs['date'] ?>"/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> تقرير القضية </label>
                      <input type="text" name="report" class="form-control input-circle" style="width: 40%;" value="<?php echo $discs['report'] ?>"/>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> موقف القضية </label>
                      <select class="form-control input-circle" name="state_id" style="width: 40%;">
                        <option value="<?php echo $discs['state_id'] ?>"><?php echo $discs['case_state'] ?></option>
                        <?php foreach ($states as $state): ?>
                          <option value="<?php echo $state['id'] ?>"<?php echo set_select('state_id',$state['id'] ); ?>><?php echo $state['name'] ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label style="font-size: 18px; font-weight: bold;"> آخر ميعاد للطعن </label>
                      <div class='input-group date' id='datetimepicker2' style="width: 40%;">
                        <input type='text' class="form-control" name="appeal" value="<?php echo $discs['appeal'] ?>" />
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="iss_id" value="<?php echo $issue['ids']; ?>" />
                      <label style="font-size: 18px; font-weight: bold;">ملفات القضية</label>
                      <div class="form-group">
                        <input id="offers" name="upload" type="file" class="file" multiple="true" data-show-upload="false" data-show-caption="false" data-show-remove="false">
                      </div>
                      <script>
                        $("#offers").fileinput({
                          uploadUrl: "/issue/make_offer/<?php echo $issue['ids']; ?>", // server upload action
                          uploadAsync: true,
                          minFileCount: 1,
                          maxFileCount: 5,
                          overwriteInitial: false,
                          initialPreview: [
                            <?php foreach($uploads as $upload): ?>
                              "<div class='file-preview-text'>" +
                              "<h2><i class='glyphicon glyphicon-file'></i></h2>" +
                              "<a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a>" + "</div>",
                            <?php endforeach ?>
                          ],
                          initialPreviewConfig: [
                            <?php foreach($uploads as $upload): ?>
                                {url: "/issue/remove_offer/<?php echo $issue['ids'] ?>/<?php echo $upload['id'] ?>", key: "<?php echo $upload['name']; ?>"},
                            <?php endforeach; ?>
                          ],
                        });
                      </script>
                    </div>                 
                  </div>
                  <div class="form-actions">
                    <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
                    <a href="/issue/view/<?php echo $issue['ids'] ?>" class="btn default">إلغاء</a>
                  </div>
                </form>
              </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
                </div>
            </div>
        </div>
        <script type="text/javascript">
      $(function(){
        $('#datetimepicker1').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script> 
    <script type="text/javascript">
      $(function(){
        $('#datetimepicker2').datetimepicker({
          viewMode:'days',
          format:'YYYY-MM-DD'
        });
      });
    </script>   
    </body>
</html>