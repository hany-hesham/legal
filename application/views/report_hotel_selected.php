<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <?php $this->load->view('header'); ?>
        <style type="text/css">
            @media print{
                .hany{
                    width: 1000px !important;
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
                    <?php $this->load->view('hotel_date_menu'); ?>
                        <?php if(isset($hotel)): ?>
                                    <div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" style="float: left;">طباعة</button>
                                        <br class="non-printable">
                                        <br class="non-printable">
                                        <div class="centered">
                                            <h1>عرض جميع القضايا للفندق &nbsp <?php echo $hotel['name']; ?></h1>
                                        </div>
                                    <div class="pager tablesorter-pager non-printable">
                                            Page: <select class="form-control gotoPage pager-filter non-printable" aria-disabled="false"></select>
                                            <i class="fa fa-fast-backward pager-nav first disabled non-printable" alt="First" title="First page" tabindex="0" aria-disabled="true"></i>
                                            <i class="fa fa-backward pager-nav prev disabled non-printable" alt="Prev" title="Previous page" tabindex="0" aria-disabled="true"></i>
                                            <span class="pagedisplay non-printable"></span>
                                            <i class="fa fa-forward pager-nav next non-printable" alt="Next" title="Next page" tabindex="0" aria-disabled="false"></i>
                                            <i class="fa fa-fast-forward pager-nav last non-printable" alt="Last" title="Last page" tabindex="0" aria-disabled="false"></i>
                                            <select class="form-control pagesize pager-filter non-printable" aria-disabled="false">
                                              <option class="non-printable" selected="selected" value="10">10</option>
                                              <option value="30">30</option>
                                              <option value="50">50</option>
                                            </select>
                                        </div>
                                        <table class="table table-bordered table-hover table-striped tablesorter hanys">
                                            <thead class="non-printable">
                                                <tr>
                                                    <th class="header centered">رقم الدعوى<i class="fa fa-sort"></i></th>
                                                    <th class="header centered">المستخدم<i class="fa fa-sort"></i></th>
                                                    <th class="header centered">الموكل<i class="fa fa-sort"></i></th>
                                                    <th class="header centered">الخصم<i class="fa fa-sort"></i></th>
                                                    <th class="header centered">الجلسة السابقة<i class="fa fa-sort"></i></th>
                                                    <th class="header centered">الجلسة القادمة<i class="fa fa-sort"></i></th>
                                                    <th class="header centered non-printable">عرض<i class="fa fa-sort"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($issues as $issue ){?>
                                                    <?php if ($issue['number'] != NULL){?>
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
                                                            <td class="centered"> <?php echo $issue['user_name'] ?></td>
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
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="pager tablesorter-pager non-printable">
          Page: <select class="form-control gotoPage pager-filter non-printable" aria-disabled="false"></select>
          <i class="fa fa-fast-backward pager-nav first disabled non-printable" alt="First" title="First page" tabindex="0" aria-disabled="true"></i>
          <i class="fa fa-backward pager-nav prev disabled non-printable" alt="Prev" title="Previous page" tabindex="0" aria-disabled="true"></i>
          <span class="pagedisplay non-printable"></span>
          <i class="fa fa-forward pager-nav next non-printable" alt="Next" title="Next page" tabindex="0" aria-disabled="false"></i>
          <i class="fa fa-fast-forward pager-nav last non-printable" alt="Last" title="Last page" tabindex="0" aria-disabled="false"></i>
          <select class="form-control pagesize pager-filter non-printable" aria-disabled="false">
            <option class="non-printable" selected="selected" value="10">10</option>
            <option value="30">30</option>
            <option value="50">50</option>
          </select>
        </div>
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
        <script type="text/javascript">
      $(function(){
        // define pager options
        var pagerOptions = {
          // target the pager markup - see the HTML block below
          container: $(".pager"),
          // output string - default is '{page}/{totalPages}'; possible variables: {page}, {totalPages}, {startRow}, {endRow} and {totalRows}
          output: '{startRow} - {endRow} / {filteredRows} ({totalRows})',
          // if true, the table will remain the same height no matter how many records are displayed. The space is made up by an empty
          // table row set to a height to compensate; default is false
          fixedHeight: true,
          // remove rows from the table to speed up the sort of large tables.
          // setting this to false, only hides the non-visible rows; needed if you plan to add/remove rows with the pager enabled.
          removeRows: false,
          // go to page selector - select dropdown that sets the current page
          cssGoto: '.gotoPage'
        };
        // Initialize tablesorter
        // ***********************
        $("table")
        .tablesorter({
          theme: 'bootstrap',
          headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
          widthFixed: true,
          widgets: ['filter'],
          widgetOptions: {
            filter_reset : '.reset-filters',
            filter_functions: {
              1: {
                <?php foreach ($users as $user) :?>
                "<?php echo $user['fullname']; ?>":function(e, n, f, i, $r) { return f == e; },
                <?php endforeach; ?>
              },
            }
          }
        })
        // initialize the pager plugin
        // ****************************
        .tablesorterPager(pagerOptions)
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>issue/view_all" class="reset-filters btn btn-warning non-printable">Reset</a>');
      });
    </script>
    </body>
</html>