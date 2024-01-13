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
                                    <a href="{{url('/admin/packages/'.$package->id.'/create')}}"
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
                            <form class="vertical-navs-step" method="post"
                                  action="{{url('/admin/packages/'.$package->id.'/confirm_values')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row gy-5">
                                    <div class="col-lg-3">
                                        <!-- end nav -->
                                    </div> <!-- end col-->
                                    <div class="col-lg-9">
                                        <div class="col-lg-6">
                                            <div class="card pricing-box ribbon-box right">
                                                <div class="card-body p-4 m-2">
                                                    <div class="ribbon-two ribbon-two-danger">
                                                        <span>{{$package->package_category->name}}</span></div>
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-grow-1">
                                                                <h5 class="mb-1 fw-semibold">{{$package->name}}</h5>
                                                                <p class="text-muted mb-0">{{$package->sku}}</p>
                                                            </div>
                                                            <div class="avatar-sm">
                                                                <div
                                                                    class="avatar-title bg-light rounded-circle text-primary">
                                                                    <i class="ri-medal-line fs-20"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="pt-4">
                                                            <h2 style="font-size: 15px;">
                                                                <sup><small>$</small></sup> {{$package->price}}<span
                                                                    class="fs-13 text-muted">/{{$package->service_category->name}}</span>
                                                            </h2>
                                                        </div>
                                                    </div>
                                                    <hr class="my-4 text-muted">
                                                    <div>
                                                        <ul class="list-unstyled vstack gap-3 text-muted">
                                                            @foreach ($essentials as $essential)
                                                                <div class="flex-grow-1">
                                                                    <h5 class="mb-1 fw-semibold">{{$essential->name}}</h5>
                                                                </div>
                                                                <div class="row g-3">
                                                                    @foreach ($package_essential_items as $package_essential_item)
                                                                        <span style="display: none;">
                                                                            {{$p_essential_item = \App\Models\PackageEssentialItem::find($package_essential_item['id'])}}
                                                                        </span>
                                                                        @if ($p_essential_item->essential_item->essential->id == $essential->id)
                                                                            <div class="col-sm-4">
                                                                                <li>
                                                                                    <div class="d-flex">
                                                                                        <div
                                                                                            class="flex-shrink-0 {{$package_essential_item['value'] > 0 ? 'text-success':'text-danger'}} me-1">
                                                                                            <i class="{{$package_essential_item['value'] > 0 ? 'ri-checkbox-circle-fill':'ri-close-circle-fill'}} fs-15 align-middle"></i>
                                                                                        </div>
                                                                                        <div class="flex-grow-1">
                                                                                            ({{$package_essential_item['value']}}) {{$p_essential_item->essential_item->name}}
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endforeach

                                                            <div class="flex-grow-1">
                                                                <h5 class="mb-1 fw-semibold">Accessories</h5>
                                                            </div>
                                                            <div class="row g-3">
                                                                @foreach ($package_accessories as $package_accessory)
                                                                    <span style="display: none;">
                                                                            {{$p_accessory = \App\Models\PackageAccessory::find($package_accessory['id'])}}
                                                                        </span>
                                                                    <div class="col-sm-4">
                                                                        <li>
                                                                            <div class="d-flex">
                                                                                <div
                                                                                    class="flex-shrink-0 {{$package_accessory['value'] > 0 ? 'text-success':'text-danger'}}  me-1">
                                                                                    <i class="{{$package_accessory['value'] > 0 ? 'ri-checkbox-circle-fill':'ri-close-circle-fill'}} fs-15 align-middle"></i>
                                                                                </div>
                                                                                <div class="flex-grow-1">
                                                                                    ({{$package_accessory['value']}}) {{$p_accessory->accessory->name}}
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </div>
                                                                @endforeach
                                                            </div>



                                                        </ul>
                                                        <div class="mt-4">
                                                            <button type="submit"
                                                                    class="btn btn-success w-100 waves-effect waves-light">
                                                                Confirm package
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
