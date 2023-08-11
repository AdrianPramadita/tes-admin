<!DOCTYPE html>
<html>
<head>
    <title>Toko</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->

    <link rel="shortcut icon" type="image/x-icon" href="{!! URL::asset('images/logo.png') !!}">
    <title>Mobile Consigment</title>

    <!-- APPLICATION -->
    <link rel="stylesheet" href="{!! URL::asset('Themes/dist/assets/css/main/app.css') !!}" type="text/css">
    <link rel="stylesheet" href="{!! URL::asset('Themes/dist/assets/css/main/app-dark.css') !!}" type="text/css">
    <link rel="shortcut icon" href="{!! URL::asset('Themes/dist/assets/images/logo/logo.png') !!}" type="image/x-icon">
    <link rel="shortcut icon" href="{!! URL::asset('Themes/dist/assets/images/logo/logo.png') !!}" type="image/png">
    
    <!-- DATATABLE -->

    <link rel="stylesheet" href="{!! URL::asset('Themes/dist/assets/css/pages/fontawesome.css') !!}">
    <link rel="stylesheet" href="{!! URL::asset('Themes/dist/assets/css/shared/iconly.css') !!}">
    <link rel="stylesheet" href="{!! URL::asset('Themes/dist/assets/extensions/simple-datatables/style.css') !!}">
    <link rel="stylesheet" href="{!! URL::asset('Themes/dist/assets/css/pages/simple-datatables.css') !!}">
    <link rel="stylesheet" href="{!! URL::asset('plugins/Fullscreen-Loading-Modal/css/jquery.loadingModal.css') !!}">
    <link rel="stylesheet" href="{!! URL::asset('Themes/dist/assets/extensions/sweetalert2/sweetalert2.min.css') !!}">
</head>

<body>
    <div id="app">
        @include('components.sidebar')
    </div>

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        
        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Store</h3>
                        <p class="text-subtitle text-muted">Manage your store</p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Master</li>
                                <li class="breadcrumb-item active" aria-current="page">Store</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h4 class="card-title">Store List</h4>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12" style="display: flex; justify-content: flex-end">
                                <div class="buttons">
                                    @if($permission->create == true)
                                        <a href="{{ $properties->activeUrl }}/create" class="btn icon icon-left btn-primary"><i data-feather="plus"></i>Add Store</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-striped " id="table1">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Group</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $el)
                                    <tr>
                                        <td>{{ $el->store_code }}</td>
                                        <td>{{ $el->store_desc }}</td>
                                        <td>{{ $el->store_group_desc }}</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td style="display: flex; justify-content: flex-end">
                                            <div class="buttons">
                                                @if($permission->update == true)
                                                    <a href="{{ $properties->activeUrl }}/update?id={{$el->id}}&disabled=" class="btn icon btn-primary"><i class="bi bi-pencil"></i></a>
                                                @endif

                                                <a href="{{ $properties->activeUrl }}/update?id={{$el->id}}&disabled=disabled" class="btn icon btn-secondary"><i class="bi bi-info-circle"></i></a>
                                                
                                                @if($permission->destroy == true)
                                                    <button type="button" class="btn icon btn-danger" onClick="destoryFunctions({{$el->id}})"><i class="bi bi-x"></i></button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2023 &copy; Surya Data Infokreasi</p>
                </div>
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                            href="https://saugi.me">Surya Data Infokreasi</a></p>
                </div>
            </div>
        </footer>
    </div>

    
    <!-- APPLICATION -->
    <script src="{!! URL::asset('Themes/dist/assets/js/bootstrap.js') !!} "></script>
    <script src="{!! URL::asset('Themes/dist/assets/js/app.js') !!} "></script>
    
    <!-- EXTENTION -->
    <script src="{!! URL::asset('plugins/jquery-370.js') !!} "></script>
    <script src="{!! URL::asset('Themes/dist/assets/extensions/simple-datatables/umd/simple-datatables.js') !!} "></script>
    <script src="{!! URL::asset('Themes/dist/assets/js/pages/simple-datatables.js') !!} "></script>
    <script src="{!! URL::asset('plugins/Fullscreen-Loading-Modal/js/jquery.loadingModal.js') !!} "></script>
    <script src="{!! URL::asset('Themes/dist/assets/extensions/sweetalert2/sweetalert2.min.js') !!} "></script>

    <!-- CUSTOM -->
    <script type="text/javascript">
        $(document).ready(function() {
            const token = "{!! csrf_token() !!}";

            
            let dataTable = new simpleDatatables.DataTable(document.getElementById("table1"));
            // Move "per page dropdown" selector element out of label
            // to make it work with bootstrap 5. Add bs5 classes.
            function adaptPageDropdown() {
                const selector = dataTable.wrapper.querySelector(".dataTable-selector");
                selector.parentNode.parentNode.insertBefore(selector, selector.parentNode);
                selector.classList.add("form-select");
            }

            // Add bs5 classes to pagination elements
            function adaptPagination() {
                const paginations = dataTable.wrapper.querySelectorAll(
                    "ul.dataTable-pagination-list"
                );

                for (const pagination of paginations) {
                    pagination.classList.add(...["pagination", "pagination-primary"]);
                }

                const paginationLis = dataTable.wrapper.querySelectorAll(
                    "ul.dataTable-pagination-list li"
                );

                for (const paginationLi of paginationLis) {
                    paginationLi.classList.add("page-item");
                }

                const paginationLinks = dataTable.wrapper.querySelectorAll(
                    "ul.dataTable-pagination-list li a"
                );

                for (const paginationLink of paginationLinks) {
                    paginationLink.classList.add("page-link");
                }
            }

            // Patch "per page dropdown" and pagination after table rendered
            dataTable.on("datatable.init", function () {
                adaptPageDropdown();
                adaptPagination();
            });

            // Re-patch pagination after the page was changed
            dataTable.on("datatable.page", adaptPagination);

            destoryFunctions = (ID) => {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('body').loadingModal({
                            text: 'Loading...'
                        });
                        $('body').loadingModal('show');

                        $.ajax({
                            type: "POST",
                            url: "{!! $properties->activeUrl !!}" + ("/destroy"),
                            data: {
                                _token: token,
                                id: ID,
                            },
                            headers: {'X-CSRF-TOKEN': token},
                            success: (data) => {
                                $('body').loadingModal('hide');

                                Swal.fire({
                                    icon: "success",
                                    title: "Deleted!",
                                    text: "Data has been deleted",
                                }).then((result) => {
                                    location.reload();
                                })
                            },
                            error: (xhr) => {
                                const res = JSON.parse(xhr.responseText);
                                console.log(res);
                                
                                $('body').loadingModal('hide')

                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: res.message,
                                })
                            },
                        });
                    }
                })
            }
        });
    </script>
</body>

</html>