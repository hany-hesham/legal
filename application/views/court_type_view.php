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
                                    <h1 class="centered"> المحكمة رقم <?php echo $court['id'] ?> </h1>
                                    <a class="form-actions btn btn-info non-printable" href="/court/view_all" style="float:left;" > العودة لجميع المحاكم </a>
                                </div>
                            </div>
                            <div class="portlet-body ">
                                <div class="form-body">
                                    <div class="form-group">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <table class="table table-striped table-bordered table-condensed centered">
                                                <tr style="font-weight: bolder;">
                                                    <td colspan="2" style="width: 900px">
                                                        اسم المحكمة
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="width: 900px">
                                                        <?php echo $court['name'] ?>
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
                                تمت إضافة المحكمة بواسطة <?php echo $court['user_name'] ?> بتاريخ <?php echo $court['timestamp'] ?> .
                            </p>
                        </div>
                    </div>
                    <p>&nbsp &nbsp &nbsp &nbsp &nbsp</p>
                </div>
            </div>
        </div>  
    </body>
</html>