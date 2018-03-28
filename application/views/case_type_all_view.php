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
            <?php $this->load->view('head_view'); ?>
            <div class="breadcrumbs">
                <h1>&nbsp &nbsp</h1>
            </div>
                    <div class="container-fluid">
                        <div class="page-content hany">
                                    <div class="col-md-12">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <button onclick="window.print()" class="non-printable form-actions btn btn-success" href="" style="float: left;">طباعة</button>
                                        <br class="non-printable">
                                        <br class="non-printable">
                                        <div class="centered">
                                <h1>عرض جميع أنواع القضايا</h1>
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
                                                    <th class="header centered">كود نوع القضية<i class="fa fa-sort"></i></th>
                                                    <th class="header centered">نوع القضية<i class="fa fa-sort"></i></th>
                                                    <th class="header centered non-printable">عرض<i class="fa fa-sort"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($types as $type ){?>
                                                    <?php if ($type['type'] != NULL){?>
                                                        <tr class="active">
                                                            <td class="centered"> &nbsp &nbsp <?php echo $type['id'] ?></td>
                                                            <td class="centered"> &nbsp &nbsp <?php echo $type['type'] ?></td>
                                                            <td class="centered non-printable">
                                                                <a href="/case_type/view/<?php echo $type['ids'] ?> " class="btn btn-primary">عرض نوع القضية</a>
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
                        <a href="#index" class="go2top">
                            <i class="icon-arrow-up"></i>
                        </a>
                    </div>
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
            }
          }
        })
        // initialize the pager plugin
        // ****************************
        .tablesorterPager(pagerOptions)
        .find(".tablesorter-filter-row td:last input").replaceWith('<a href="<?php echo base_url(); ?>case_type/view_all" class="reset-filters btn btn-warning non-printable">Reset</a>');
      });
    </script>
    </body>
</html>
