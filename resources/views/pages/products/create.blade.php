@extends('layouts.app')

@section('title', 'Create New Product')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create New Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Product</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Products</h2>
                <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p>

                <div class="card">
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4>Input Text</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input id="name" type="text"
                                    class="form-control @error('name')
                        is-invalid
                    @enderror"
                                    name="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <div class="input-group">

                                    <input type="text" class="form-control" name="description">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <div class="input-group">

                                    <input type="integer"
                                        class="form-control @error('price')
                                    is-invalid
                                @enderror"
                                        name="price">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Stock</label>
                                <div class="input-group">

                                    <input type="number"
                                        class="form-control @error('stock')
                                    is-invalid

                                @enderror"
                                        name="stock">
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="category" value="food" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Food</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="category" value="drink" class="selectgroup-input">
                                        <span class="selectgroup-button">Drink</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="category" value="snack" class="selectgroup-input">
                                        <span class="selectgroup-button">Snack</span>
                                    </label>

                                </div>
                            </div>
                            <div class="form-group">
                                <label>Photo Product</label>
                                <div class="col-sm-9">

                                    <input type="file"
                                        class="form-control @error('image')
                                    is-invalid

                                @enderror"
                                        name="image">
                                    @error('image')
                                        <div class="invalid-feedback" role="alert">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>




                            <div class="form-group">
                                <div class="control-label">Best Seller</div>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox"
                                        name="is_best_seller"
                                        class="custom-switch-input "
                                        value="1" unchecked value="0" >
                                    <span class="custom-switch-indicator"></span>
                                    {{-- <span class="custom-switch-description"></span> --}}
                                </label>
                            </div>

                        </div>
                        <div class="card-footer text-right">

                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
    </div>
    </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush
