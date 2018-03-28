<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <?php $this->load->view('header'); ?>
        <style type="text/css">
            @media print{
                .hany{
                    width: 1000px !important;
                }
                .sunrise{
                  background-color: #FFECCA !important; 
                  font-weight: bold !important;
                }
            }
        </style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo">
        <div class="wrapper">
            <?php $this->load->view('head_report'); ?>
            <div class="container-fluid">
                        <div class="page-content hany">
                    <div class="breadcrumbs non-printable">
                        <h1>&nbsp &nbsp &nbsp &nbsp &nbsp</h1>
                    </div>
                    <?php $this->load->view('date_menu'); ?>
                        <?php if(isset($date) && isset($date1)): ?>
                                    <div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" style="float: left;">طباعة</button>
                                        <br class="non-printable">
                                        <br class="non-printable">
                                        <div class="centered">
                                            <h1>عرض التقرير الشهري المجمع بتاريخ من&nbsp<?php echo $date ?> إلى&nbsp<?php echo $date1 ?></h1>
                                        </div>
                                    
                                        <table class="table table-bordered table-hover table-striped hanys" style="width: 100%">
                                              <tr class="non-printable">
                                                    <th class="header centered">رقم الدعوى</th>
                                                    <th class="header centered">الموكل</th>
                                                    <th class="header centered">الخصم</th>
                                                    <th class="header centered">الجلسة السابقة</th>
                                                    <th class="header centered">الجلسة القادمة</th>
                                                    <th class="header centered non-printable">عرض</th>
                                                </tr>
                                              <?php foreach($issues_hotel as $issued ){?>
                                                  <?php if ($issued['issues']){?>
                                                  <tbody>
                                                    <tr class="sunrise"> 
                                                      <td colspan="6" class="centered" style="background-color: #FFECCA; font-weight: bold;"> 
                                                        <?php echo $issued['hotel_name'] ?> عدد <?php echo $issued['count'] ?> قضية
                                                      </td>
                                                    </tr>
                                                  </tbody>
                                                  <tbody>
                                                    <?php foreach($issued['issues'] as $issue ){?>
                                                        <tr class="active">
                                                            <td class="centered"> 
                                                                <?php echo $issue['number'] ?> لسنة <?php echo $issue['year'] ?> <?php echo $issue['case_type'] ?>
                                                                <?php if ($issue['backward']['id']){ ?>
                                                                <br>
                                                                <?php echo $issue['backward']['number'] ?> لسنة <?php echo $issue['backward']['year'] ?> <?php echo $issue['backward']['case_type'] ?>
                                                              <?php } ?>
                                                              <?php if ($issue['shout']['id']){ ?>
                                                                <br>
                                                                <?php echo $issue['shout']['number'] ?> لسنة <?php echo $issue['shout']['year'] ?> <?php echo $issue['shout']['case_type'] ?>
                                                              <?php } ?>
                                                              <?php if ($issue['revers']['id']){ ?>
                                                                <br>
                                                                <?php echo $issue['revers']['number'] ?> لسنة <?php echo $issue['revers']['year'] ?> <?php echo $issue['revers']['case_type'] ?>
                                                              <?php } ?>
                                                            </td>
                                                            <td class="centered"> 
                                                              <?php if ($issue['revers']['id']){ ?>
                                                                <?php echo $issue['client_name'] ?> <br> <?php echo $issue['revers']['clnt_type'] ?>
                                                              <?php }elseif ($issue['shout']['id']){ ?>
                                                                 <?php echo $issue['client_name'] ?> <br> <?php echo $issue['shout']['clnt_type'] ?>
                                                              <?php }elseif ($issue['backward']['id']){ ?>
                                                                <?php echo $issue['client_name'] ?> <br> <?php echo $issue['backward']['clnt_type'] ?>
                                                              <?php }else{ ?>
                                                              <?php echo $issue['client_name'] ?> <br> <?php echo $issue['clnt_type'] ?>
                                                              <?php } ?>
                                                            </td>
                                                            <td class="centered"> 
                                                              <?php if ($issue['revers']['id']){ ?>
                                                                <?php echo $issue['opponent'] ?> <br> <?php echo $issue['revers']['opnt_type'] ?>
                                                              <?php }elseif ($issue['shout']['id']){ ?>
                                                                 <?php echo $issue['opponent'] ?> <br> <?php echo $issue['shout']['opnt_type'] ?>
                                                              <?php }elseif ($issue['backward']['id']){ ?>
                                                                <?php echo $issue['opponent'] ?> <br> <?php echo $issue['backward']['opnt_type'] ?>
                                                              <?php }else{ ?>
                                                              <?php echo $issue['opponent'] ?> <br> <?php echo $issue['opnt_type'] ?>
                                                              <?php } ?>
                                                            </td>
                                                            <td class="centered"> 
                                                              <?php if($issue['count'] >= 2){ ?>
                                                                <?php echo $issue['dates'][1]['date'] ?> <br> <?php echo $issue['dates'][1]['report'] ?>
                                                              <?php } ?>
                                                            </td>
                                                            <td class="centered"> 
                                                                <?php echo $issue['dates'][0]['date'] ?> <br> <?php echo $issue['dates'][0]['report'] ?>
                                                            </td>
                                                            <td class="centered non-printable">
                                                                <a href="/issue/view/<?php echo $issue['ids'] ?> " class="btn btn-primary">عرض القضية</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                  </tbody>
                                                  <?php } ?>
                                              <?php } ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                <a href="#index" class="go2top non-printable">
                    <i class="icon-arrow-up non-printable"></i>
                </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php $this->load->view('footer'); ?>
        
    </body>
</html>
