<footer class="footer">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            {{-- <script>document.write(new Date().getFullYear())</script> © Minible. --}}
        </div>
        <div class="col-sm-6">
            <div class="text-sm-end d-none d-sm-block">
                Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://www.ektml.com/" target="_blank" class="text-reset">Ektaml</a>
            </div>
        </div>
    </div>
</div>
</footer>
</div>
<!-- end main content-->
</div><!-- END layout-wrapper -->


<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center p-3">

            <h5 class="m-0 me-2">الاعدادات</h5>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="m-0" />
        <div class="p-4">
            {{-- <h6 class="mb-3">تخطيط</h6>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout"
                    id="layout-vertical" value="vertical">
                <label class="form-check-label" for="layout-vertical">عمودي</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout"
                    id="layout-horizontal" value="horizontal">
                <label class="form-check-label" for="layout-horizontal">افقي</label>
            </div> --}}

            <h6 class="mt-4 mb-3 pt-2">وضع التخطيط</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-mode"
                    id="layout-mode-light" value="light">
                <label class="form-check-label" for="layout-mode-light">فاتح</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-mode"
                    id="layout-mode-dark" value="dark">
                <label class="form-check-label" for="layout-mode-dark">داكن</label>
            </div>

            <h6 class="mt-4 mb-3 pt-2"></h6>حجم التخطيط</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-width"
                    id="layout-width-fuild" value="fuild" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                <label class="form-check-label" for="layout-width-fuild">ممتد</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-width"
                    id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                <label class="form-check-label" for="layout-width-boxed">محاط</label>
            </div>

            <h6 class="mt-4 mb-3 pt-2">موضع التخطيط</h6>

            <h6 class="mt-4 mb-3 pt-2">لون الشريط العلوي</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="topbar-color"
                    id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                <label class="form-check-label" for="topbar-color-light">فاتح</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="topbar-color"
                    id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                <label class="form-check-label" for="topbar-color-dark">داكن</label>
            </div>

            <h6 class="mt-4 mb-3 pt-2 sidebar-setting">حجم الشريط الجانبي</h6>

            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-size"
                    id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                <label class="form-check-label" for="sidebar-size-default">الافتراضي</label>
            </div>
            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-size"
                    id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'small')">
                <label class="form-check-label" for="sidebar-size-compact">مضغوط</label>
            </div>
            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-size"
                    id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                <label class="form-check-label" for="sidebar-size-small">صغير (عرض الأيقونات)</label>
            </div>

            <h6 class="mt-4 mb-3 pt-2 sidebar-setting">لون الشريط الجانبي</h6>

            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-color"
                    id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                <label class="form-check-label" for="sidebar-color-light">فاتح</label>
            </div>
            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-color"
                    id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                <label class="form-check-label" for="sidebar-color-dark">داكن</label>
            </div>
            <div class="form-check sidebar-setting">
                <input class="form-check-input" type="radio" name="sidebar-color"
                    id="sidebar-color-colored" value="colored" onchange="document.body.setAttribute('data-sidebar', 'colored')">
                <label class="form-check-label" for="sidebar-color-colored">ملون</label>
            </div>

            <h6 class="mt-4 mb-3 pt-2">الاتجاه</h6>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-direction"
                    id="layout-direction-ltr" value="ltr">
                <label class="form-check-label" for="layout-direction-ltr">LTR</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="layout-direction"
                    id="layout-direction-rtl" value="rtl">
                <label class="form-check-label" for="layout-direction-rtl">RTL</label>
            </div>
        </div>
    </div> <!-- end slimscroll-menu-->
</div><!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    <!-- JAVASCRIPT -->
    <script src="{{ asset("assets/libs/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("assets/libs/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/libs/metismenu/metisMenu.min.js") }}"></script>
    <script src="{{ asset("assets/libs/simplebar/simplebar.min.js") }}"></script>
    <script src="{{ asset("assets/libs/node-waves/waves.min.js") }}"></script>
    <script src="{{ asset("assets/libs/waypoints/lib/jquery.waypoints.min.js") }}"></script>
    <script src="{{ asset("assets/libs/jquery.counterup/jquery.counterup.min.js") }}"></script>
    <!-- apexcharts -->
    <script src="{{ asset("assets/libs/apexcharts/apexcharts.min.js") }}"></script>
    <script src="{{ asset("assets/js/pages/dashboard.init.js") }}"></script>
    <!-- App js -->
    <script src="{{ asset("assets/js/app.js") }}"></script>
    <script src="{{ asset("assets/js/all.min.js") }}"></script>

</body>
</html>
