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
                                    <br>
                                    <br>
                                    <div class="header-logo"><img src="/assets/uploads/files/<?php echo $hotel['logo'] ?>"/></div>
                                    <h1 class="centered"> الفندق رقم <?php echo $hotel['id'] ?> </h1>
                                    <a class="form-actions btn btn-info non-printable" href="/hotel/view_all" style="float:left;" > العودة لجميع الفنادق </a>
                                </div>
                            </div>
                            <div class="portlet-body ">
                                <div class="form-body">
                                    <div class="form-group">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-bordered table-condensed centered">
                                                <tr style="font-weight: bolder; border:">
                                                    <td style="width: 450px;">
                                                            اسم الفندق
                                                    </td>
                                                    <td style="width: 450px">
                                                            كود الفندق
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 450px">
                                                        <?php echo $hotel['name'] ?>
                                                    </td>
                                                    <td style="width: 450px">
                                                        <?php echo $hotel['code'] ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <p class="centered">
                                تمت إضافة الخصم بواسطة <?php echo $hotel['user_name'] ?> بتاريخ <?php echo $hotel['timestamp'] ?> .
                            </p>
                        </div>
                    </div>
                    <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
                </div>
            </div>
        </div>  
    </body>
</html>