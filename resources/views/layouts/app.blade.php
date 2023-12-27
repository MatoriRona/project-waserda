<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Koperasi Waserda</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweetalert/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <style>
        .btn-group button:first-child.btn-sm {
            border-top-left-radius: 1rem !important;
            border-bottom-left-radius: 1rem !important;
        }

        .btn-group button:last-child.btn-sm {
            border-top-right-radius: 1rem !important;
            border-bottom-right-radius: 1rem !important;
        }

        .nav-header .brand-logo a b img {
            max-width: 2.1rem;
        }
    </style>
    @yield('css')

</head>

<body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        {{-- <div class="nav-header" style="background-color: #006a4e;">
            <div class="brand-logo">
                <a href="{{ route('dashboard') }}">
                    <b class="logo-abbr"><img src="{{ asset('assets/images/masjid/logo-1.png') }}" alt=""></b>
                    <span class="logo-compact"><img src="{{ asset('assets/images/masjid/logo.png') }}" alt=""></span>
                    <span class="brand-title">
                        <h4 style="color: white;">KS MRLJ</h4>
                    </span>
                </a>
            </div>
        </div> --}}

        <div class="nav-header" style="background-color: #006a4e;">
            <div class="brand-logo">
                <a href="{{ route('dashboard') }}">
                    <b class="logo-abbr"><img src="{{ asset('assets/images/masjid/logo-2.png') }}" style="margin-top: -5px !important;" alt=""> </b>
                    <span class="logo-compact"><img src="{{ asset('assets/images/masjid/logo-2.png') }}" style="margin-top: -5px !important;" alt=""></span>
                    <span class="brand-title">
                        <img src="{{ asset('assets/images/masjid/logo-text.png') }}" style="width: 10em; margin-top: -10px !important;" alt="">
                    </span>
                </a>
            </div>
        </div>

        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    
                </div>
                <div class="header-right">
                    <ul class="clearfix">
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="{{ asset('assets/images/user/1.png') }}" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile   dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#profileModal"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
                                        <li><a href="{{ route('logout') }}"><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="modal fade" id="profileModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Profile</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <form id="profileForm" name="profileForm" onsubmit="event.preventDefault(); profileAjaxRequest(profileForm)" action="{{ route('users.self-update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="error-bag"></div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" class="form-control" name="nohp" value="{{ auth()->user()->nohp }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                                <span style="color: red; font-size: 12px;"><i>*Kosongkan jika tidak ingin ganti password</i></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>


        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('layouts.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            @yield('content')
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by <a href="#">Kelompok 1</a> {{ date('Y') }}</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('assets/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/gleek.js') }}"></script>
    <script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>

    <script src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/js/sweetalert2.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/pdfmake/build/pdfmake.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pdfmake/build/vfs_fonts.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"
        integrity="sha512-U0/lvRgEOjWpS5e0JqXK6psnAToLecl7pR+c7EEnndsVkWq3qGdqIGQGN2qxSjrRnCyBJhoaktKXTVceVG2fTw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    @if (session()->has('message'))
    <script>
        $('#message').show();
        setInterval(function () {
            $('#message').hide();
        }, 5000);
    </script>
    @endif

    <script>
        $(document).ready(function() {
            autoNumericInput()
        })

        function swalLoading(text = 'Sedang mengirim...') {
            Swal.fire({
                title: 'Please wait',
                icon: 'info',
                html: `<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> <p>${text}</p></div>`,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                showCancelButton: false,
                showCloseButton: false,
                returnFocus: false,
            })
        }

        function reloadTable(element = '.dataTable') {
            element = $(element).DataTable()
            if (element.ajax) {
                if (element.ajax.url) {
                    element.ajax.reload()
                }
            }
        }

        function autoNumericInput() {
            new AutoNumeric.multiple('input[autonumeric="true"]:not(.numerized)', {
                currencySymbol: 'Rp. ',
                decimalPlaces: 0
            })
            $('input[autonumeric="true"]:not(.numerized)').addClass('numerized')
        }

        function toRupiah(value){
            return (value).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }

        function profileAjaxRequest(form) {
            data = new FormData(form)
            url = $(form).attr('action')
            formId = $(form).attr('id')
            $(`#${formId} .errorBag`).html('')
            swalLoading()
            $.ajax({
                type: $(form).attr('method'),
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                contentType: false,
                processData: false,
                success: (res) => {
                    if (res.success) {
                        Swal.fire({
                            title: 'Success!',
                            icon: 'success',
                            text: res.message,
                        })
                        $('.modal').modal('hide')
                        $(form).trigger('reset')
                        location.reload();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            text: res.message,
                        })
                    }
                },
                error: (err) => {
                    if (err.status === 422) {
                        Swal.fire({
                            title: "Error!",
                            icon: 'error',
                            text: err.responseJSON.message
                        })
                        $(`#${formId} .error-bag`).html(
                            '<div class="alert alert-danger mt-2"><h5>Oops! Ada yang salah!</h5><ul></ul></div>'
                        )
                        err.responseJSON.errors.forEach((msg, i) => {
                            $(`#${formId} .error-bag ul`).append(`<li>${msg}</li>`)
                        })
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            icon: 'error',
                            text: err.responseJSON.message,
                        })
                    }
                }
            })
        }

    </script>

    @yield('js')

</body>

</html>