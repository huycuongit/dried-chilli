<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/admin/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/js/bootstrap.js') }}"></script>
@php
    $adminNotifications = collect($errors->all())->map(fn ($message) => ['type' => 'error', 'message' => $message]);
    foreach (['success', 'error', 'warning', 'info'] as $type) {
        if (session()->has($type)) $adminNotifications->push(['type' => $type, 'message' => session($type)]);
    }
@endphp
<script>window.adminNotifications = @json($adminNotifications);</script>
<script src="{{ asset('assets/admin/js/admin-notifications.js') }}?v=1"></script>
<script src="{{ asset('assets/admin/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/js/menu.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- endbuild -->

<!-- Vendors JS -->
@if (request()->routeIs('admin.dashboard.*'))
<script src="{{ asset('assets/admin/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/swiper/swiper.js') }}"></script>
@endif
@if (request()->routeIs('admin.users.*'))
<script src="{{ asset('assets/admin/vendor/libs/select2/select2.js') }}"></script>
@endif
@if (request()->routeIs('admin.users.*', 'admin.roles.*', 'admin.news.index', 'admin.projects.index', 'admin.services.index', 'admin.contacts.index', 'admin.ecom_orders.index', 'admin.ecom_products.index', 'admin.ecom_customers.index', 'admin.ecom_inventory.index', 'admin.ecom_coupons.index', 'admin.ecom_bundles.index'))
<script src="{{ asset('assets/admin/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endif

<!-- Main JS -->
<script src="{{ asset('assets/admin/js/main.js') }}"></script>

<!-- Page JS -->
@if (request()->routeIs('admin.users.*'))
<script src="{{ asset('assets/admin/js/forms-selects.js') }}"></script>
@endif

<!-- Js __construct -->
<script>
    function comfirmLogout() {
        $('.nav-logout').on('click', function(e) {
            e.preventDefault();
        });
    }

    function notImplemented() {
        $('.not-implemented').click(function(event) {
            event.preventDefault();
            AdminUI.toast('This feature is under development.', 'info');
        });
    }

    $(function() {
        var _token = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': _token
            }
        });

        //-- Setup CKFinder & CkEditor
        var _routeIs = $('#route-is').val();
        if (_routeIs !== 'admin.dashboard.index') {
            // allFunctionCkfinder();
            // selectAllCKeditors();
        }

        //-- Logout
        comfirmLogout();

        //-- Not Implemented
        notImplemented();
    })
</script>
<!-- /. Js __construct -->

@yield('js')
@stack('js')
