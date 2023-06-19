@extends('template.template')

@section('title','Trash Monitoring System | Dashboard')

{{-- kalau ada css tambahan selain dari template.blade --}}
@push('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<section class="section">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    {{-- @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                </div>
                @endif --}}
            </div>
            <section class="section">
                <div class="container-fluid">
                    <!-- ========== title-wrapper start ========== -->
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>Dashboard Trash Monitoring System</h2>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-md-6">
                                <div class="breadcrumb-wrapper mb-30">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="https://demo.plainadmin.com/index.html#0">Dashboard</a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">
                                                eCommerce
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- ========== title-wrapper end ========== -->
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon purple">
                                    <i class="lni lni-cart-full"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">New Orders</h6>
                                    <h3 class="text-bold mb-10">34567</h3>
                                    <p class="text-sm text-success">
                                        <i class="lni lni-arrow-up"></i> +2.00%
                                        <span class="text-gray">(30 days)</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon success">
                                    <i class="lni lni-dollar"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">Total Income</h6>
                                    <h3 class="text-bold mb-10">$74,567</h3>
                                    <p class="text-sm text-success">
                                        <i class="lni lni-arrow-up"></i> +5.45%
                                        <span class="text-gray">Increased</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon primary">
                                    <i class="lni lni-credit-cards"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">Total Expense</h6>
                                    <h3 class="text-bold mb-10">$24,567</h3>
                                    <p class="text-sm text-danger">
                                        <i class="lni lni-arrow-down"></i> -2.00%
                                        <span class="text-gray">Expense</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                        <div class="col-xl-3 col-lg-4 col-sm-6">
                            <div class="icon-card mb-30">
                                <div class="icon orange">
                                    <i class="lni lni-user"></i>
                                </div>
                                <div class="content">
                                    <h6 class="mb-10">New User</h6>
                                    <h3 class="text-bold mb-10">34567</h3>
                                    <p class="text-sm text-danger">
                                        <i class="lni lni-arrow-down"></i> -25.00%
                                        <span class="text-gray"> Earning</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Cart -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card-style calendar-card mb-30">
                                <div id="calendar-mini" class="fc fc-media-screen fc-direction-ltr fc-theme-standard">
                                    <div class="fc-header-toolbar fc-toolbar ">
                                        <div class="fc-toolbar-chunk">
                                            <h2 class="fc-toolbar-title" id="fc-dom-1">June 2023</h2>
                                        </div>
                                        <div class="fc-toolbar-chunk"></div>
                                        <div class="fc-toolbar-chunk"><button type="button" title="This month" disabled="" aria-pressed="false" class="fc-today-button fc-button fc-button-primary">today</button>
                                            <div class="fc-button-group"><button type="button" title="Previous month" aria-pressed="false" class="fc-prev-button fc-button fc-button-primary"><span class="fc-icon fc-icon-chevron-left"></span></button><button type="button" title="Next month" aria-pressed="false" class="fc-next-button fc-button fc-button-primary"><span class="fc-icon fc-icon-chevron-right"></span></button></div>
                                        </div>
                                    </div>
                                    <div aria-labelledby="fc-dom-1" class="fc-view-harness fc-view-harness-active" style="height: 215.556px;">
                                        <div class="fc-dayGridMonth-view fc-view fc-daygrid">
                                            <table role="grid" class="fc-scrollgrid  fc-scrollgrid-liquid">
                                                <thead role="rowgroup">
                                                    <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-header ">
                                                        <th role="presentation">
                                                            <div class="fc-scroller-harness">
                                                                <div class="fc-scroller" style="overflow: hidden scroll;">
                                                                    <table role="presentation" class="fc-col-header " style="width: 276px;">
                                                                        <colgroup></colgroup>
                                                                        <thead role="presentation">
                                                                            <tr role="row">
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sun">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Sunday" class="fc-col-header-cell-cushion">Sun</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-mon">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Monday" class="fc-col-header-cell-cushion">Mon</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-tue">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Tuesday" class="fc-col-header-cell-cushion">Tue</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-wed">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Wednesday" class="fc-col-header-cell-cushion">Wed</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-thu">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Thursday" class="fc-col-header-cell-cushion">Thu</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-fri">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Friday" class="fc-col-header-cell-cushion">Fri</a></div>
                                                                                </th>
                                                                                <th role="columnheader" class="fc-col-header-cell fc-day fc-day-sat">
                                                                                    <div class="fc-scrollgrid-sync-inner"><a aria-label="Saturday" class="fc-col-header-cell-cushion">Sat</a></div>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody role="rowgroup">
                                                    <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-body  fc-scrollgrid-section-liquid">
                                                        <td role="presentation">
                                                            <div class="fc-scroller-harness fc-scroller-harness-liquid">
                                                                <div class="fc-scroller fc-scroller-liquid-absolute" style="overflow: hidden scroll;">
                                                                    <div class="fc-daygrid-body fc-daygrid-body-unbalanced " style="width: 275px;">
                                                                        <table role="presentation" class="fc-scrollgrid-sync-table" style="width: 275px; height: 358px;">
                                                                            <colgroup></colgroup>
                                                                            <tbody role="presentation">
                                                                                <tr role="row">
                                                                                    <td aria-labelledby="fc-dom-2" role="gridcell" data-date="2023-05-28" class="fc-day fc-day-sun fc-day-past fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="May 28, 2023" id="fc-dom-2" class="fc-daygrid-day-number">28</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-4" role="gridcell" data-date="2023-05-29" class="fc-day fc-day-mon fc-day-past fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="May 29, 2023" id="fc-dom-4" class="fc-daygrid-day-number">29</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-6" role="gridcell" data-date="2023-05-30" class="fc-day fc-day-tue fc-day-past fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="May 30, 2023" id="fc-dom-6" class="fc-daygrid-day-number">30</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-8" role="gridcell" data-date="2023-05-31" class="fc-day fc-day-wed fc-day-past fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="May 31, 2023" id="fc-dom-8" class="fc-daygrid-day-number">31</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-10" role="gridcell" data-date="2023-06-01" class="fc-day fc-day-thu fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 1, 2023" id="fc-dom-10" class="fc-daygrid-day-number">1</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-12" role="gridcell" data-date="2023-06-02" class="fc-day fc-day-fri fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 2, 2023" id="fc-dom-12" class="fc-daygrid-day-number">2</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-14" role="gridcell" data-date="2023-06-03" class="fc-day fc-day-sat fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 3, 2023" id="fc-dom-14" class="fc-daygrid-day-number">3</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td aria-labelledby="fc-dom-16" role="gridcell" data-date="2023-06-04" class="fc-day fc-day-sun fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 4, 2023" id="fc-dom-16" class="fc-daygrid-day-number">4</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-18" role="gridcell" data-date="2023-06-05" class="fc-day fc-day-mon fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 5, 2023" id="fc-dom-18" class="fc-daygrid-day-number">5</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-20" role="gridcell" data-date="2023-06-06" class="fc-day fc-day-tue fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 6, 2023" id="fc-dom-20" class="fc-daygrid-day-number">6</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-22" role="gridcell" data-date="2023-06-07" class="fc-day fc-day-wed fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 7, 2023" id="fc-dom-22" class="fc-daygrid-day-number">7</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-24" role="gridcell" data-date="2023-06-08" class="fc-day fc-day-thu fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 8, 2023" id="fc-dom-24" class="fc-daygrid-day-number">8</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-26" role="gridcell" data-date="2023-06-09" class="fc-day fc-day-fri fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 9, 2023" id="fc-dom-26" class="fc-daygrid-day-number">9</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-28" role="gridcell" data-date="2023-06-10" class="fc-day fc-day-sat fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 10, 2023" id="fc-dom-28" class="fc-daygrid-day-number">10</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td aria-labelledby="fc-dom-30" role="gridcell" data-date="2023-06-11" class="fc-day fc-day-sun fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 11, 2023" id="fc-dom-30" class="fc-daygrid-day-number">11</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-32" role="gridcell" data-date="2023-06-12" class="fc-day fc-day-mon fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 12, 2023" id="fc-dom-32" class="fc-daygrid-day-number">12</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-34" role="gridcell" data-date="2023-06-13" class="fc-day fc-day-tue fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 13, 2023" id="fc-dom-34" class="fc-daygrid-day-number">13</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-36" role="gridcell" data-date="2023-06-14" class="fc-day fc-day-wed fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 14, 2023" id="fc-dom-36" class="fc-daygrid-day-number">14</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-38" role="gridcell" data-date="2023-06-15" class="fc-day fc-day-thu fc-day-past fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 15, 2023" id="fc-dom-38" class="fc-daygrid-day-number">15</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-40" role="gridcell" data-date="2023-06-16" class="fc-day fc-day-fri fc-day-today fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 16, 2023" id="fc-dom-40" class="fc-daygrid-day-number">16</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-42" role="gridcell" data-date="2023-06-17" class="fc-day fc-day-sat fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 17, 2023" id="fc-dom-42" class="fc-daygrid-day-number">17</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td aria-labelledby="fc-dom-44" role="gridcell" data-date="2023-06-18" class="fc-day fc-day-sun fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 18, 2023" id="fc-dom-44" class="fc-daygrid-day-number">18</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-46" role="gridcell" data-date="2023-06-19" class="fc-day fc-day-mon fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 19, 2023" id="fc-dom-46" class="fc-daygrid-day-number">19</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-48" role="gridcell" data-date="2023-06-20" class="fc-day fc-day-tue fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 20, 2023" id="fc-dom-48" class="fc-daygrid-day-number">20</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-50" role="gridcell" data-date="2023-06-21" class="fc-day fc-day-wed fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 21, 2023" id="fc-dom-50" class="fc-daygrid-day-number">21</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-52" role="gridcell" data-date="2023-06-22" class="fc-day fc-day-thu fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 22, 2023" id="fc-dom-52" class="fc-daygrid-day-number">22</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-54" role="gridcell" data-date="2023-06-23" class="fc-day fc-day-fri fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 23, 2023" id="fc-dom-54" class="fc-daygrid-day-number">23</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-56" role="gridcell" data-date="2023-06-24" class="fc-day fc-day-sat fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 24, 2023" id="fc-dom-56" class="fc-daygrid-day-number">24</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td aria-labelledby="fc-dom-58" role="gridcell" data-date="2023-06-25" class="fc-day fc-day-sun fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 25, 2023" id="fc-dom-58" class="fc-daygrid-day-number">25</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-60" role="gridcell" data-date="2023-06-26" class="fc-day fc-day-mon fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 26, 2023" id="fc-dom-60" class="fc-daygrid-day-number">26</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-62" role="gridcell" data-date="2023-06-27" class="fc-day fc-day-tue fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 27, 2023" id="fc-dom-62" class="fc-daygrid-day-number">27</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-64" role="gridcell" data-date="2023-06-28" class="fc-day fc-day-wed fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 28, 2023" id="fc-dom-64" class="fc-daygrid-day-number">28</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-66" role="gridcell" data-date="2023-06-29" class="fc-day fc-day-thu fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 29, 2023" id="fc-dom-66" class="fc-daygrid-day-number">29</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-68" role="gridcell" data-date="2023-06-30" class="fc-day fc-day-fri fc-day-future fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="June 30, 2023" id="fc-dom-68" class="fc-daygrid-day-number">30</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-70" role="gridcell" data-date="2023-07-01" class="fc-day fc-day-sat fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 1, 2023" id="fc-dom-70" class="fc-daygrid-day-number">1</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr role="row">
                                                                                    <td aria-labelledby="fc-dom-72" role="gridcell" data-date="2023-07-02" class="fc-day fc-day-sun fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 2, 2023" id="fc-dom-72" class="fc-daygrid-day-number">2</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-74" role="gridcell" data-date="2023-07-03" class="fc-day fc-day-mon fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 3, 2023" id="fc-dom-74" class="fc-daygrid-day-number">3</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-76" role="gridcell" data-date="2023-07-04" class="fc-day fc-day-tue fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 4, 2023" id="fc-dom-76" class="fc-daygrid-day-number">4</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-78" role="gridcell" data-date="2023-07-05" class="fc-day fc-day-wed fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 5, 2023" id="fc-dom-78" class="fc-daygrid-day-number">5</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-80" role="gridcell" data-date="2023-07-06" class="fc-day fc-day-thu fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 6, 2023" id="fc-dom-80" class="fc-daygrid-day-number">6</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-82" role="gridcell" data-date="2023-07-07" class="fc-day fc-day-fri fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 7, 2023" id="fc-dom-82" class="fc-daygrid-day-number">7</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td aria-labelledby="fc-dom-84" role="gridcell" data-date="2023-07-08" class="fc-day fc-day-sat fc-day-future fc-day-other fc-daygrid-day">
                                                                                        <div class="fc-daygrid-day-frame fc-scrollgrid-sync-inner">
                                                                                            <div class="fc-daygrid-day-top"><a aria-label="July 8, 2023" id="fc-dom-84" class="fc-daygrid-day-number">8</a></div>
                                                                                            <div class="fc-daygrid-day-events">
                                                                                                <div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>
                                                                                            </div>
                                                                                            <div class="fc-daygrid-day-bg"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Col -->
                        <div class="col-lg-7">
                            <div class="card-style mb-30">
                                <div class="title d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="left">
                                        <h6 class="text-medium mb-30">Top Selling Products</h6>
                                    </div>
                                    <div class="right">
                                        <div class="select-style-1">
                                            <div class="select-position select-sm">
                                                <select class="light-bg">
                                                    <option value="">Yearly</option>
                                                    <option value="">Monthly</option>
                                                    <option value="">Weekly</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- end select -->
                                    </div>
                                </div>
                                <!-- End Title -->
                                <div class="table-responsive">
                                    <table class="table top-selling-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>
                                                    <h6 class="text-sm text-medium">Products</h6>
                                                </th>
                                                <th class="min-width">
                                                    <h6 class="text-sm text-medium">Category</h6>
                                                </th>
                                                <th class="min-width">
                                                    <h6 class="text-sm text-medium">Price</h6>
                                                </th>
                                                <th class="min-width">
                                                    <h6 class="text-sm text-medium">Sold</h6>
                                                </th>
                                                <th class="min-width">
                                                    <h6 class="text-sm text-medium">Profit</h6>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="check-input-primary">
                                                        <input class="form-check-input" type="checkbox" id="checkbox-1">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product">
                                                        <div class="image">
                                                            <img src="./PlainAdmin Demo _ Bootstrap 5 Admin Template_files/product-mini-1.jpg" alt="">
                                                        </div>
                                                        <p class="text-sm">Arm Chair</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm">Interior</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$345</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">43</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$45</p>
                                                </td>
                                                <td>
                                                    <div class="action justify-content-end">
                                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="lni lni-more-alt"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Remove</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Edit</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="check-input-primary">
                                                        <input class="form-check-input" type="checkbox" id="checkbox-1">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product">
                                                        <div class="image">
                                                            <img src="./PlainAdmin Demo _ Bootstrap 5 Admin Template_files/product-mini-2.jpg" alt="">
                                                        </div>
                                                        <p class="text-sm">SOfa</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm">Interior</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$145</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">13</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$15</p>
                                                </td>
                                                <td>
                                                    <div class="action justify-content-end">
                                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="lni lni-more-alt"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Remove</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Edit</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="check-input-primary">
                                                        <input class="form-check-input" type="checkbox" id="checkbox-1">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product">
                                                        <div class="image">
                                                            <img src="./PlainAdmin Demo _ Bootstrap 5 Admin Template_files/product-mini-3.jpg" alt="">
                                                        </div>
                                                        <p class="text-sm">Dining Table</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm">Interior</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$95</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">32</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$215</p>
                                                </td>
                                                <td>
                                                    <div class="action justify-content-end">
                                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="lni lni-more-alt"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Remove</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Edit</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="check-input-primary">
                                                        <input class="form-check-input" type="checkbox" id="checkbox-1">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product">
                                                        <div class="image">
                                                            <img src="./PlainAdmin Demo _ Bootstrap 5 Admin Template_files/product-mini-4.jpg" alt="">
                                                        </div>
                                                        <p class="text-sm">Office Chair</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm">Interior</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$105</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">23</p>
                                                </td>
                                                <td>
                                                    <p class="text-sm">$345</p>
                                                </td>
                                                <td>
                                                    <div class="action justify-content-end">
                                                        <button class="more-btn ml-10 dropdown-toggle" id="moreAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="lni lni-more-alt"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreAction1">
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Remove</a>
                                                            </li>
                                                            <li class="dropdown-item">
                                                                <a href="https://demo.plainadmin.com/index.html#0" class="text-gray">Edit</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- End Table -->
                                </div>
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>
                </div>
                <!-- end container -->
            </section>
            <!-- end col -->
            <div class="col-md-6">
                <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#0">Pegawai</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Page
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
</section>
@endsection

@push('js')
@include('sweetalert::alert')
@endpush