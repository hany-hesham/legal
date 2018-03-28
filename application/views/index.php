<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <?php $this->load->view('header'); ?>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo">
        <div class="wrapper">
            <?php $this->load->view('head_add'); ?>
            <div class="container-fluid">
                <div class="page-content">
                    <div class="breadcrumbs">
                        <h1>&nbsp &nbsp &nbsp &nbsp &nbsp</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="/issue/view_all">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $count; ?>"></span>
                                    </div>
                                    <div class="desc"> عدد القضايا </div>
                                </div>
                            </a>
                        </div>
                        <?php 
                            $count1=0;
                            foreach ($issues as $issue) {
                                foreach ($issue['disscutions'] as $disscution) {
                                    if ($disscution['state_id'] == 5) {
                                        $count1++;
                                    }
                                }
                            }
                         ?>                        
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="/issue/running">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $count1; ?>"></span>
                                    </div>
                                    <div class="desc"> عدد القضايا المتداولة </div>
                                </div>
                            </a>
                        </div>
                        <?php 
                            $count2=0;
                            foreach ($issues as $issue) {
                                foreach ($issue['disscutions'] as $disscution) {
                                    if ($disscution['state_id'] == 1) {
                                        $count2++;
                                    }
                                }
                            }
                         ?>    
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="/issue/won">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $count2; ?>"></span>
                                    </div>
                                    <div class="desc"> عدد القضايا الرابحة </div>
                                </div>
                            </a>
                        </div>
                        <?php 
                            $count3=0;
                            foreach ($issues as $issue) {
                                foreach ($issue['disscutions'] as $disscution) {
                                    if ($disscution['state_id'] == 2) {
                                        $count3++;
                                    }
                                }
                            }
                         ?> 
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 purple" href="/issue/lose">
                                <div class="visual">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" data-value="<?php echo $count3; ?>">0</span> 
                                    </div>
                                    <div class="desc"> عدد القضايا الخاسرة </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light tasks-widget bordered">
                                <div class="portlet-title">
                                    <div class="caption" >
                                        <i class="icon-share font-dark hide"></i>
                                        <span class="caption-subject font-dark bold uppercase">المنشورات الإدارية</span>
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="task-content">
                                        <div class="scroller" style="height: 312px;" data-always-visible="1" data-rail-visible1="1">
                                            <!-- START TASK LIST -->
                                            <ul class="task-list">
                                             <?php foreach ($managements as $management) { ?>
                                                <li>
                                                    <div class="task-title">
                                                        <span class="task-title-sp"> <?php echo $management['subject']?> </span>
                                                        <p><?php echo $management['decision']?></p>
                                                    </div>
                                                    <div class="task-config">
                                                        <div class="task-config-btn btn-group">
                                                            <a href="/management/view/<?php echo $management['id'] ?>">
                                                                <i class="fa fa-eye"></i> عرض المنشور 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light tasks-widget bordered">
                                <div class="portlet-title">
                                    <div class="caption" >
                                        <i class="icon-share font-dark hide"></i>
                                        <span class="caption-subject font-dark bold uppercase">المهام الخاصة بـ<?php echo $user->fullname; ?></span>
                                    </div>
                                    <div class="actions">
                                        <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="task-content">
                                        <div class="scroller" style="height: 312px;" data-always-visible="1" data-rail-visible1="1">
                                            <!-- START TASK LIST -->
                                            <ul class="task-list">
                                             <?php foreach ($members as $member) { ?>
                                                <li>
                                                    <div class="task-title">
                                                        <span class="task-title-sp"> <?php echo $member['number']?> </span>
                                                        <p><?php echo $member['describtion']?></p>
                                                    </div>
                                                    <div class="task-config">
                                                        <div class="task-config-btn btn-group">
                                                            <a href="/issue/view/<?php echo $member['issue_id'] ?>">
                                                                <i class="fa fa-eye"></i> عرض القضية 
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
        <?php $this->load->view('footer'); ?>
    </body>
</html>
