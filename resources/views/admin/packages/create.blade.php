@extends('layouts.admin')
@push('head')

    <link rel="stylesheet" href="{{asset('administration/assets/libs/@simonwep/pickr/themes/monolith.min.css')}}"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0"> {{$package->name}} - {{$package->package_category->name}}
                            (${{$package->price}}) </h4>

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

                <div class="col-xxl-12">
                    <div class="card" id="companyList">
                        <div style="color: black;font-size: 18px;font-weight: bolder;" class="card-header">
                            Configure: {{$package->name}} - {{$package->package_category->name}} (${{$package->price}})
                        </div>


                        <div class="card-body form-steps">
                            <form class="vertical-navs-step" method="post" action="{{url('/admin/packages/'.$package->id.'/values')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-5">
                                    <div class="col-lg-3">
                                        <div class="nav flex-column custom-nav nav-pills" role="tablist"
                                             aria-orientation="vertical">
                                            <button class="nav-link active" id="v-pills-bill-info-tab"
                                                    data-bs-toggle="pill" data-bs-target="#v-pills-bill-info"
                                                    type="button" role="tab" aria-controls="v-pills-bill-info"
                                                    aria-selected="true">
                                                        <span class="step-title me-2">
                                                            <i class="ri-close-circle-fill step-icon me-2"></i> Step 1
                                                        </span>
                                                Package Essentials
                                            </button>
                                            <button class="nav-link" id="v-pills-bill-address-tab" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-bill-address" type="button" role="tab"
                                                    aria-controls="v-pills-bill-address" aria-selected="false">
                                                        <span class="step-title me-2">
                                                            <i class="ri-close-circle-fill step-icon me-2"></i> Step 2
                                                        </span>
                                                Accessories
                                            </button>
                                        </div>
                                        <!-- end nav -->
                                    </div> <!-- end col-->
                                    <div class="col-lg-9">
                                        <div class="px-lg-4">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="v-pills-bill-info"
                                                     role="tabpanel" aria-labelledby="v-pills-bill-info-tab">
                                                    <div>
                                                        <h2 style="font-size: 18px;font-weight: bold;margin-bottom: 15px;">
                                                            Package Essentials</h2>
                                                        <p class="text-muted"></p>
                                                    </div>
                                                    @foreach ($essentials as $essential)
                                                        <div>
                                                            <div class="row g-3">
                                                                <div class="col-sm-12">
                                                                    <h5 style="font-size: 16px;font-weight: bold;padding: 10px;">{{$essential->name}}</h5>
                                                                    <div class="row g-3">
                                                                        @foreach ($package->package_essential_items as $package_essential_item)
                                                                            @if ($package_essential_item->essential_item->essential->id == $essential->id)
                                                                                <div class="col-sm-3">
                                                                                    <div>
                                                                                        <h5 style="color: black;" class="fs-13 fw-medium">
                                                                                            {{$package_essential_item->essential_item->name}}</h5>
                                                                                        <div class="input-step">
                                                                                            <button type="button" class="minus">–</button>
                                                                                            <input name="package_essential_item[{{$package_essential_item->id}}][value]" type="number"
                                                                                                   class="product-quantity"
                                                                                                   value="{{$package_essential_item->value}}" min="0" max="100">
                                                                                            <button type="button" class="plus">+</button>
                                                                                        </div>
                                                                                        <input class="form-control" name="package_essential_item[{{$package_essential_item->id}}][id]"
                                                                                               value="{{$package_essential_item->id}}"
                                                                                               id="validationCustom01" type="hidden">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="d-flex align-items-start gap-3 mt-4">
                                                        <button type="button"
                                                                class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                                data-nexttab="v-pills-bill-address-tab"><i
                                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
                                                        </button>
                                                    </div>

                                                </div>
                                                <!-- end tab pane -->
                                                <div class="tab-pane fade" id="v-pills-bill-address" role="tabpanel"
                                                     aria-labelledby="v-pills-bill-address-tab">
                                                    <div>
                                                        <h2 style="font-size: 18px;font-weight: bold;margin-bottom: 15px;">
                                                            Package Accessories</h2>
                                                        <p class="text-muted"></p>
                                                    </div>

                                                    <div>
                                                        <div class="row g-3">
                                                            <div class="col-sm-12">
                                                                <h5 style="font-size: 16px;font-weight: bold;padding: 10px;">Accessories</h5>
                                                                <div class="row g-3">
                                                                    @foreach ($package->package_accessories as $package_accessory)
                                                                            <div class="col-sm-3">
                                                                                <div>
                                                                                    <h5 style="color: black;" class="fs-13 fw-medium">
                                                                                        {{$package_accessory->accessory->name}}</h5>
                                                                                    <div class="input-step">
                                                                                        <button type="button" class="minus">–</button>
                                                                                        <input name="package_accessory[{{$package_accessory->id}}][value]" type="number"
                                                                                               class="product-quantity small"
                                                                                               value="{{$package_accessory->value}}" min="0" max="100">
                                                                                        <button type="button" class="plus">+</button>
                                                                                    </div>
                                                                                    <input class="form-control" name="package_accessory[{{$package_accessory->id}}][id]"
                                                                                           value="{{$package_accessory->id}}"
                                                                                           id="validationCustom01" type="hidden">
                                                                                </div>
                                                                            </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-start gap-3 mt-4">
                                                        <button type="button" class="btn btn-light btn-label previestab"
                                                                data-previous="v-pills-bill-info-tab"><i
                                                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                            Back
                                                        </button>
                                                        <button type="submit"
                                                                class="btn btn-success btn-label right ms-auto "><i
                                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                                            Finish
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end tab pane -->
                                            </div>
                                            <!-- end tab content -->
                                        </div>
                                    </div>

                                </div>
                                <!-- end row -->
                            </form>
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

    <script src="{{asset('/administration/assets/js/pages/form-wizard.init.js')}}"></script>
    <script src="{{asset('/administration/assets/js/pages/form-pickers.init.js')}}"></script>

    <!-- init js -->
    <script src="{{asset('/administration/assets/js/pages/form-advanced.init.js')}}"></script>
    <!-- input spin init -->
    <script src="{{asset('/administration/assets/js/pages/form-input-spin.init.js')}}"></script>
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
