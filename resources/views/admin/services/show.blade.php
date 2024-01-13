@extends('layouts.admin')
@push('head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Services</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Services</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div class="flex-grow-1">
                                    <a href="{{url('/admin/services')}}" class="btn btn-info add-btn"><i
                                            class="ri-arrow-left-line align-bottom"></i> Back
                                    </a>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="hstack text-nowrap gap-2">
                                        <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                                aria-expanded="false" class="btn btn-soft-info"><i
                                                class="ri-more-2-fill"></i></button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->

                @if($errors->any())
                    @include('errors')
                @endif
                @if (session('message'))
                    <div class="col-lg-6">
                        <!-- Primary Alert -->
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <strong> Hi! </strong> <b>{{session('message')}} </b> !
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <div class="col-xxl-9">
                    <div class="card" id="companyList">
                        <div class="card-header">
                            {{$service->name}}
                        </div>
                        <!-- Default Modals -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-xxl-12">
                                            <div class="card border card-border-primary">
                                                <div class="card-header">

                                                    <h6 class="card-title mb-0"> {{$service->name}}
                                                    {{-- <span class="badge bg-danger align-middle fs-10">Poor</span></h6>--}}
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        {!! $service->description !!}
                                                    </p>
                                                </div>
                                                <hr/>
                                                <div class="card-body">
                                                    <div class="text-left">
                                                        <a href="javascript:void(0);" class="link-primary fw-medium">
                                                            <i class="ri-pencil-line align-middle"></i>
                                                            Edit
                                                        </a>
                                                        ||
                                                        <a href="javascript:void(0);" class="link-primary fw-medium"
                                                           data-bs-toggle="modal" data-bs-target="#myModal">
                                                            <i class="ri-delete-bin-line align-middle"></i>
                                                            Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end col -->

                                    </div><!-- end row -->
                                </div><!-- end col -->
                            </div>
                        </div>
                        <form method="post" action="{{url('/admin/services/'.$service->id)}}"
                              enctype="multipart/form-data">
                            @method('DELETE')
                            @csrf
                            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                                 aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="fs-15">
                                                DELETE {{$service->name}}
                                            </h5>

                                            <p>Are you sure you want to delete this item?</p>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="submit" class="btn btn-primary ">Yes Delete</button>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </form>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->

            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
@stop
@push('scripts')
    <!-- ckeditor -->

    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script type="text/javascript">
        ClassicEditor
            .create(document.querySelector('.editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function () {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>

@endpush
