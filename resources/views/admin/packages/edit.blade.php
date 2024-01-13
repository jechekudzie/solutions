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
                        <h4 class="mb-sm-0">Edit {{$package->name}}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
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
                                    <a href="{{url('/admin/packages/'.$package->service_category->id.'/index')}}"
                                       class="btn btn-info add-btn"><i
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
                        <div style="color: black;font-size: 18px;font-weight: bolder;" class="card-header">
                            Edit: {{$package->name}}
                        </div>


                        <div class="card-body">
                            <!--end add modal-->

                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0">
                                    <form method="post"
                                          action="{{url('/admin/packages/'.$package->id.'/update')}}"
                                          enctype="multipart/form-data">
                                        @method('PATCH')
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="industry_type-field" class="form-label">
                                                        service categories</label>
                                                    <select name="package_category_id" class="form-select"
                                                            id="industry_type-field">
                                                        <option value="">Select package category</option>
                                                        @foreach($package_categories as $package_category)
                                                            <option
                                                                value="{{$package_category->id}}"
                                                                {{$package_category->id == $package->package_category_id ? 'selected':''}}>
                                                                {{$package_category->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="name"
                                                           class="form-label">Package name</label>
                                                    <input type="text" name="name"
                                                           class="form-control rounded-pill mb-3"
                                                           value="{{$package->name}}"
                                                           placeholder="Enter service category name"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="name"
                                                           class="form-label">Price</label>
                                                    <input type="text" name="price"
                                                           class="form-control rounded-pill mb-3"
                                                           value="{{$package->price}}"
                                                           placeholder="Enter price"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="name"
                                                           class="form-label">Standard coverage in (HRS)</label>
                                                    <input type="text" name="standard_coverage"
                                                           class="form-control rounded-pill mb-3"
                                                           value="{{$package->standard_coverage}}"
                                                           placeholder="Enter standard_coverage in HRS"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="description"
                                                           class="form-label">Description</label>
                                                             <textarea name="description" class="editor form-control"
                                                              placeholder="Enter service description">
                                                                 {!! $package->description !!}
                                                            </textarea>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-success" id="add-btn">Update

                                                </button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
