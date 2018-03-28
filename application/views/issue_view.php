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
                                    <a class="form-actions btn btn-success non-printable" href="/issue/edit/<?php echo $issue['ids']?>" style="float:right;" > تعديل القضية </a>
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
                                                <tr style="font-weight: bolder;" class="non-printable">
                                                    <td colspan="2">
                                                        <a href="/issue/new_discution/<?php echo $issue['ids'] ?>" class="btn default non-printable">إضافة جلسة</a>
                                                    </td>
                                                    <td colspan="2">
                                                        <a href="/issue/backward/<?php echo $issue['ids'] ?>" class="btn default non-printable">إضافة إستئناف</a>
                                                    </td>
                                                    <td colspan="2">
                                                        <a href="/issue/shout/<?php echo $issue['ids'] ?>" class="btn default non-printable">إضافة إشكال</a>
                                                    </td>
                                                    <td colspan="2">
                                                        <a href="/issue/revers/<?php echo $issue['ids'] ?>" class="btn default non-printable">إضافة طعن</a>
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
                                                        <td colspan="1" style="width: 180px">
                                                            تعديل
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

                                                                <td colspan="1" style="width: 180px">
                                                                    <a href="/issue/discution/<?php echo $disscution['id'] ?>" class="btn default non-printable">تعديل بيانات الجلسة</a>
                                                                </td>
                                                            </tr>
                                                    <?php } ?>
                                                </table>
                                        </div>
                                    </div>
                                    <div class="form-group non-printable">
                                        <hr style="width: 730px;">
                                        <label style="font-size: 18px; font-weight: bold;">ملفات القضية</label>
                                        <div class="form-group" style="margin-right: 100px;">
                                            <?php foreach($uploads as $upload): ?>
                                                <a href='/assets/uploads/files/<?php echo $upload['name'] ?>'><?php echo $upload['name'] ?></a><br />
                                            <?php endforeach ?>         
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="form-group">
                                <p class="centered">
                                    تمت إضافة القضية بواسطة <?php echo $issue['user_name'] ?> بتاريخ <?php echo $issue['timestamp'] ?> .
                                </p>
                            </div>
                            <div class="portlet-body form">
                                <div class="form-actions">
                                    <div class="portlet-body form non-printable">
                                        <form action="/issue/comment/<?php echo $issue['ids']?>" method="POST" id="form-submit" class="form-div span12" accept-charset="utf-8">
                                            <div class="form-body">
                                                <div class="form-group">
                                                    <textarea type="text" name="comment" class="form-control" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="submit" name="submit" value="موافق" class="btn btn-success"/>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <h3 class="centered" style="font-weight: bolder;">التعليقات</h3> 
                                            </div>
                                            <?php foreach($comments as $comment ){ ?>
                                                <div class="data-holder">
                                                    <span class="data-head" style="text-align: right !important;"><?php echo $comment['fullname']; ?> </span>
                                                    <br>
                                                    <?php echo $comment['comment']; ?>
                                                    
                                                    <span class="timestamp-data-content" style="text-align: left;"><?php echo $comment['timestamp']; ?> </span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
                </div>
            </div>
        </div>  
    </body>
</html>