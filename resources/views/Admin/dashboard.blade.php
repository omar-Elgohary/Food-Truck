@extends('Admin.layouts.app')
@section('content')
<div class="main-content">

<div class="page-content">
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box d-flex align-items-center justify-content-between">
<h4 class="mb-0">الرئيسية</h4>
</div>
</div>
</div>
<!-- end page title -->

<div class="row">
<div class="col-md-6 col-xl-3">
<div class="card">
<div class="card-body d-flex justify-content-around">
    <div class="float-end mt-2">
        <div id="total-revenue-chart" data-colors='["--bs-primary"]'></div>
    </div>

    <div>
        <h5 class="mb-1 mt-1">0</span>
            </h4>
            <p class="text-muted mb-0">عدد العملاء</p></div>
</div>
</div>
</div> <!-- end col-->

<div class="col-md-6 col-xl-3">
<div class="card">
<div class="card-body d-flex justify-content-around">
    <div class="float-end mt-2">
        <div id="growth-chart" data-colors='["--bs-warning"]'></div>
    </div>
    <div>
        <h4 class="mb-1 mt-1"><span
                data-plugin="counterup">0</span>
        </h4>
        <p class="text-muted mb-0">عدد مقدمي الخدمة</p>
    </div>
</div>
</div>
</div> <!-- end col-->

<div class="col-md-6 col-xl-3">
<div class="card">
<div class="card-body d-flex justify-content-around">
    <div class="float-end mt-2">
        <div id="orders-chart" data-colors='["--bs-success"]'> </div>
    </div>
    <div>
        <h4 class="mb-1 mt-1"><span
                data-plugin="counterup">0</span></h4>
        <p class="text-muted mb-0">عدد الأقسام</p>
    </div>
</div>
</div>
</div> <!-- end col-->

<div class="col-md-6 col-xl-3">
<div class="card">
<div class="card-body d-flex justify-content-around">
    <div class="float-end mt-2">
        <div id="customers-chart" data-colors='["--bs-primary"]'> </div>
    </div>
    <div>
        <h4 class="mb-1 mt-1"><span
                data-plugin="counterup">0</span></h4>
        <p class="text-muted mb-0">عدد المنتجات</p>
    </div>
</div>
</div>
</div> <!-- end col-->
</div> <!-- end row-->


<div class="row">
<div class="col-xl-6">
<div class="card">
<div class="card-body">
    <div class="float-end">
        {{-- <div class="dropdown">
            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted">All Members<i
                        class="mdi mdi-chevron-down ms-1"></i></span>
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                <a class="dropdown-item" href="#">Locations</a>
                <a class="dropdown-item" href="#">Revenue</a>
                <a class="dropdown-item" href="#">Join Date</a>
            </div>
        </div> --}}
    </div>
    <h4 class="card-title mb-4">المستخدمين</h4>

    <div data-simplebar style="max-height: 339px;">
        <div class="table-responsive">
            <table class="table table-borderless table-centered table-nowrap">
                <tbody>
                    <tr>
                        <td style="width: 20px;"><img
                                src="#"
                                class="avatar-xs rounded-circle " alt="...">
                        </td>

                        <td>
                            <h6 class="font-size-15 mb-1 fw-normal">tedjhwrtj</h6>
                            <p class="text-muted font-size-13 mb-0"><i
                                    class="mdi mdi-phone"></i> 024567455</p>
                        </td>

                        <td><span class="badge bg-soft-success font-size-12">Success</span></td>

                        <td class="text-muted fw-semibold text-end"><i
                                class="icon-xs icon me-2 text-success"
                                data-feather="trending-up"></i>
                        </td>
                    </tr>
                    <tr>

                </tbody>
            </table>
        </div> <!-- enbd table-responsive-->
    </div> <!-- data-sidebar-->
</div><!-- end card-body-->
</div> <!-- end card-->
</div><!-- end col -->


<div class="col-xl-6">
<div class="card">
<div class="card-body">
    <div class="float-end">
        {{-- <div class="dropdown">
            <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted">All Members<i
                        class="mdi mdi-chevron-down ms-1"></i></span>
            </a>

            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                <a class="dropdown-item" href="#">Locations</a>
                <a class="dropdown-item" href="#">Revenue</a>
                <a class="dropdown-item" href="#">Join Date</a>
            </div>
        </div> --}}
    </div>
    <h4 class="card-title mb-4">مقدمي الخدمات</h4>

    <div data-simplebar style="max-height: 339px;">
        <div class="table-responsive">
            <table class="table table-borderless table-centered table-nowrap">
                <tbody>
                    <tr>
                        <td style="width: 20px;"><img
                                src="#"
                                class="avatar-xs rounded-circle " alt="...">
                        </td>

                        <td>
                            <h6 class="font-size-15 mb-1 fw-normal">rtjwrkyietyki</h6>
                            <p class="text-muted font-size-13 mb-0"><i
                                    class="mdi mdi-phone"></i> 0121567496584</p>
                        </td>

                        <td><span class="badge bg-soft-success font-size-12">Success</span></td>

                        <td class="text-muted fw-semibold text-end"><i
                                class="icon-xs icon me-2 text-success"
                                data-feather="trending-up"></i>
                        </td>
                    </tr>
                    <tr>

                </tbody>
            </table>
        </div> <!-- enbd table-responsive-->
    </div> <!-- data-sidebar-->
</div><!-- end card-body-->
</div> <!-- end card-->
</div><!-- end col -->
</div> <!-- container-fluid -->
</div>
@endsection