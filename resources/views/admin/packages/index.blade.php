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
                        <h4 class="mb-sm-0">Add {{ $serviceCategory->name }} Packages</h4>

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
                                    <a href="{{url('/admin/service_categories/'.$serviceCategory->service->id.'/index')}}" class="btn btn-info add-btn"><i
                                            class="ri-arrow-go-back-fill me-1 align-bottom"></i> Back to {{$serviceCategory->name}} categories
                                    </a>
                                    <button class="btn btn-danger add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="ri-add-fill me-1 align-bottom"></i> Add
                                        a {{ $serviceCategory->name }} package
                                    </button>

                                    <a href="{{url('/admin/packages/'.$serviceCategory->id.'/package_compare')}}" class="btn btn-warning add-btn"><i
                                            class="ri-asterisk me-1 align-bottom"></i> Compare {{$serviceCategory->name}} packages
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            <!--end col-->
                <div class="col-xxl-9">
                    <div class="card" id="companyList">
                        <div class="card-header">
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="search-box">
                                        <input type="text" class="form-control search"
                                               placeholder="Search for company...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-md-auto ms-auto">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-muted">filter by: </span>
                                        <select class="form-control mb-0" data-choices data-choices-search-false
                                                id="choices-single-default">
                                            <option value="Owner">filter 1</option>
                                            <option value="Owner">filter 3</option>
                                            <option value="Owner">filter 3</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="table-responsive table-card mb-3">
                                    <table class="table align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 50px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkAll"
                                                           value="option">
                                                </div>
                                            </th>
                                            <th class="sort" data-sort="name" scope="col">Package</th>
                                            <th class="sort" data-sort="owner" scope="col">Package Category</th>
                                            <th class="sort" data-sort="owner" scope="col">Coverage in HRS</th>
                                            <th class="sort" data-sort="owner" scope="col">SKU</th>
                                            <th class="sort" data-sort="owner" scope="col">Price</th>
                                            <th class="sort" data-sort="owner" scope="col">Configure Package</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="list form-check-all">
                                        @foreach($packages as $package)
                                            <tr>
                                                <td scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="chk_child"
                                                               value="option1">
                                                    </div>
                                                </td>
                                                <td class="owner">{{$package->name}}(@if($package->package_category){{$package->package_category->name}}@endif)</td>
                                                <td class="owner">@if($package->package_category){{$package->package_category->name}}@endif</td>
                                                <td class="owner">{{$package->standard_coverage}}</td>
                                                <td class="owner">{{$package->sku}}</td>
                                                <td class="owner">{{$package->price}}</td>
                                                <td class="owner"><a href="{{url('/admin/packages/' . $package->id . '/create')}}">Configure package</a></td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="View">
                                                            <a href="{{url('/admin/packages/'.$package->id.'/show')}}"
                                                               class="view-item-btn"><i
                                                                    class="ri-eye-fill align-bottom text-muted"></i></a>
                                                        </li>
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Edit">
                                                            <a class="edit-item-btn"
                                                               href="{{url('/admin/packages/'.$package->id.'/edit')}}"><i
                                                                    class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <div class="pagination-wrap hstack gap-2">
                                        <a class="page-item pagination-prev disabled" href="#">
                                            Previous
                                        </a>
                                        <ul class="pagination listjs-pagination mb-0"></ul>
                                        <a class="page-item pagination-next" href="#">
                                            Next
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- add modal-->
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0">
                                        <div class="modal-header bg-soft-info p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                {{ $serviceCategory->name }} Package
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form method="post"
                                              action="{{url('/admin/packages/'.$serviceCategory->id.'/store')}}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
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
                                                                        value="{{$package_category->id}}">{{$package_category->name}}</option>
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
                                                                   value="{{old('name')}}"
                                                                   placeholder="Enter service category name"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="name"
                                                                   class="form-label">Price</label>
                                                            <input type="text" name="price"
                                                                   class="form-control rounded-pill mb-3"
                                                                   value="{{old('price')}}"
                                                                   placeholder="Enter price"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="name"
                                                                   class="form-label">Standard coverage in (HRS)</label>
                                                            <input type="text" name="standard_coverage"
                                                                   class="form-control rounded-pill mb-3"
                                                                   value="{{old('standard_coverage')}}"
                                                                   placeholder="Enter standard_coverage in HRS"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="description"
                                                                   class="form-label">Description</label>
                                                            <textarea name="description" class="editor form-control"
                                                                      placeholder="Enter service description">

                                                            </textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-success">Add
                                                        Package
                                                    </button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- add modal-->


                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-3">
                    <div class="card" id="company-view-detail">

                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Section Description</h6>
                            <p class="text-muted mb-4">Description of this page comes here</p>
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
