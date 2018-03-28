<!DOCTYPE html >
<html lang="en" dir="rtl">
    <head>
        <?php $this->load->view('header'); ?>
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
                                    <h1 class="centered"> المنشور رقم <?php echo $management['id'] ?> </h1>
                                    <a class="form-actions btn btn-info non-printable" href="/management/view_all" style="float:left;" > العودة لجميع المنشورات الإدارية </a>
                                </div>
                            </div>
                            <div class="portlet-body ">
                                <div class="form-body">
                                    <div class="form-group">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-bordered table-condensed centered">
                                                <tr style="font-weight: bolder; border:">
                                                    <td style="width: 450px;">
                                                            موضوع المنشور
                                                    </td>
                                                    <td style="width: 450px">
                                                            تاريخ الإجتماع
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 450px">
                                                        <?php echo $management['subject'] ?>
                                                    </td>
                                                    <td style="width: 450px">
                                                        <?php echo $management['date'] ?>
                                                    </td>
                                                </tr>
                                                <tr style="font-weight: bolder;">
                                                    <td colspan="2" style="width: 900px">
                                                        القرارات المتفق عليها
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="width: 900px">
                                                        <?php echo $management['decision'] ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group non-printable">
                                        <hr style="width: 730px;">
                                        <label style="font-size: 18px; font-weight: bold;">المنشور</label>
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
                            <p class="centered">
                                تمت إضافة المنشور الإداري بواسطة <?php echo $management['user_name'] ?> بتاريخ <?php echo $management['timestamp'] ?> .
                            </p>
                        </div>
                    </div>
                    <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
                </div>
            </div>
        </div>  
    </body>
</html>