<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <?php $this->load->view('header'); ?>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo">
        <div class="wrapper">
            <?php $this->load->view('head_report'); ?>
            <div class="breadcrumbs">
                <h1>&nbsp &nbsp</h1>
            </div>
                    <div class="container-fluid">
                        <div class="page-content hany">
                                    <div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <br class="non-printable">
                                        <br class="non-printable">
                                        <div class="centered">
                                            <h1>الاستعلام باسم الخصم</h1>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group" style="float: right; margin-right: 50px;">
                                        <a href="/report/report_opnt_all"> الاستعلام باسم الخصم لكل الفنادق</a>
                                    </div>
                                    <div class="form-group" style="float: left; margin-left: 50px;">
                                        <a href="/report/report_opnt"> الاستعلام باسم الخصم للفندق</a>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group" style="float: right; margin-right: 50px;">
                                        <a href="/report/report_opnt_selected"> الاستعلام باسم الخصم لكل الفنادق في فترة محددة</a>
                                    </div>
                                    <div class="form-group" style="float: left; margin-left: 50px;">
                                        <a href="/report/report_opnt_hotel_selected"> الاستعلام باسم الخصم للفندق في فترة محددة</a>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                <a href="#index" class="go2top non-printable">
                    <i class="icon-arrow-up non-printable"></i>
                </a>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('footer'); ?>
    </body>
</html>
