<header class="page-header">
    <nav class="navbar mega-menu" role="navigation">
        <div class="container-fluid">
            <div class="clearfix navbar-fixed-top">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a id="index" class="page-logo" href="/welcome">
                    <h1 class="font-white navbar-brand" style="font-weight: bolder;">الأجندة القانونية</h1> 
                </a>
                <div class="topbar-actions navbar-ex1-collapse">
                    <div id="navbar" class="nav-collapse collapse navbar-collapse navbar-responsive-collapse navbar-collapse collapse" style="margin-top: -10px !important;">
                        <ul class="nav navbar-nav">
                            <li class="dropdown more-dropdown" style="width: 230px;">
                                <a href="javascript:;" class="text-uppercase" style="font-size: 13px;">
                                    <span><?php echo $user->fullname; ?></span> 
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/agenda">
                                            <i class="icon-calendar"></i> الاجندة 
                                        </a>
                                    </li>
                                    <?php if ($is_admin) {?>
                                        <li>
                                            <a href="/backend">
                                                <i class="icon-wrench"></i> الاعدادات 
                                            </a>
                                        </li>
                                    <?php } ?>
                                    <li>
                                        <a href="/auth/change_password">
                                            <i class="icon-lock"></i> تغير كلمة السر
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/auth/logout">
                                            <i class="icon-key"></i> تسجيل خروج
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="nav-collapse navbar-collapse navbar-responsive-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown dropdown-fw  active open selected">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="icon-home"></i> جديد </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li >
                                <a href="/issue">
                                    <i class="icon-bar-chart"></i> إضافة قضية 
                                </a>
                            </li>
                            <li >
                                <a href="/client">
                                    <i class="icon-bar-chart"></i> إضافة موكل 
                                </a>
                            </li>
                            <li >
                                <a href="/type">
                                    <i class="icon-bar-chart"></i> إضافة صفة 
                                </a>
                            </li>
                            <li >
                                <a href="/case_type">
                                    <i class="icon-bar-chart"></i> إضافة نوع قضية 
                                </a>
                            </li>
                            <li >
                                <a href="/court">
                                    <i class="icon-bar-chart"></i> إضافة محكمة
                                </a>
                            </li>
                            <li >
                                <a href="/hotel">
                                    <i class="icon-bar-chart"></i> إضافة فندق
                                </a>
                            </li> 
                            <li >
                                <a href="/management">
                                    <i class="icon-bar-chart"></i> إضافة منشور إداري
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-fw">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="icon-home"></i> عرض </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li >
                                <a href="/issue/view_all">
                                    <i class="icon-bar-chart"></i> عرض جميع القضايا 
                                </a>
                            </li>
                            <li >
                                <a href="/user_issue">
                                    <i class="icon-bar-chart"></i> عرض جميع القضايا الخاصة ب<?php echo $user->fullname; ?>
                                </a>
                            </li>
                            <li >
                                <a href="/client/view_all">
                                    <i class="icon-bar-chart"></i> عرض جميع الموكلين 
                                </a>
                            </li>
                            <li >
                                <a href="/type/view_all">
                                    <i class="icon-bar-chart"></i> عرض جميع الصفات 
                                </a>
                            </li>
                            <li >
                                <a href="/case_type/view_all">
                                    <i class="icon-bar-chart"></i> عرض جميع أنواع القضايا 
                                </a>
                            </li>
                            <li >
                                <a href="/court/view_all">
                                    <i class="icon-bar-chart"></i> عرض جميع المحاكم
                                </a>
                            </li>
                            <li >
                                <a href="/hotel/view_all">
                                    <i class="icon-bar-chart"></i> عرض جميع الفنادق
                                </a>
                            </li>
                            <li >
                                <a href="/management/view_all">
                                    <i class="icon-bar-chart"></i> عرض جميع المنشورات الإدارية
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-fw">
                        <a href="javascript:;" class="text-uppercase">
                            <i class="icon-home"></i> التقارير 
                        </a>
                        <ul class="dropdown-menu dropdown-menu-fw">
                            <li >
                                <a href="/report/hotel_menu">
                                    <i class="icon-bar-chart" ></i> الاستعلام باسم الفندق
                                </a>
                            </li>
                            <li >
                                <a href="/report/report_num">
                                    <i class="icon-bar-chart" ></i> الاستعلام برقم الدعوة
                                </a>
                            </li>
                            <li >
                                <a href="/report/year_menu">
                                    <i class="icon-bar-chart" ></i> الاستعلام بالسنة
                                </a>
                            </li>
                            <li >
                                <a href="/report/clnt_menu">
                                    <i class="icon-bar-chart" ></i> الاستعلام باسم الموكل 
                                </a>
                            </li>
                            <li >
                                <a href="/report/opnt_menu">
                                    <i class="icon-bar-chart" ></i> الاستعلام باسم الخصم 
                                </a>
                            </li>
                            <li >
                                <a href="/report/report_date">
                                    <i class="icon-bar-chart" ></i> الاستعلام بتاريخ الجلسة 
                                </a>
                            </li>
                            <li >
                                <a href="/report/type_menu">
                                    <i class="icon-bar-chart" ></i> الاستعلام بنوع القضية 
                                </a>
                            </li>
                            <li >
                                <a href="/report/cort_menu">
                                    <i class="icon-bar-chart" ></i> الاستعلام بالمحكمة
                                </a>
                            </li>
                            <li >
                                <a href="/report/state_menu">
                                    <i class="icon-bar-chart" ></i> الاستعلام بحالة القضية
                                </a>
                            </li>
                            <li >
                                <a href="/report/report_monthly">
                                    <i class="icon-bar-chart" ></i> التقرير الشهري المجمع
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>