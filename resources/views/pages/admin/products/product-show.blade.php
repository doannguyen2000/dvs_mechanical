@extends($showModal ? 'layouts.modal-app' : 'layouts.main-app')

@section('content')
    <div class="card {{ $showModal ? '' : 'mt-4' }} bg-body-tertiary mb-1">
        <div class="card-body z-index-0 text-start">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">{{ __('Product Show') }}</h5>
                <a role="button" class="icon-link icon-link-hover"
                    @if ($showModal) data-bs-dismiss="modal"
                        aria-label="Close" @else href="{{ route('admin.products.list') }}" @endif>
                    <i class="fa-regular fa-circle-left"></i>
                    </span>
                    {{ __('Back') }}
                </a>
            </div>
            <hr class="mb-0">
            <div class="border-0">
                <div class="row g-1">
                    <form class="col-xxl-9 row g-1"
                        @if (!$showModal) action="{{ route('admin.products.update', ['id' => $product->id]) }}" method="POST"
                            enctype="multipart/form-data" @endif>
                        @csrf
                        <div class="col-lg-5 text-center mt-3">
                            <div class="container text-center">
                                <img id="imgShowImg"
                                    src="{{ asset(count($product->productImages) > 0 ? Storage::url($product->productImages->first()->product_image_url) : 'assets/images/Empty.png') }}"
                                    class="img-thumbnail" alt="...">
                            </div>
                            <div class="container mt-3">
                                <input type="file" id="inputselectImg" multiple hidden>
                                <div class="row g-2" id="boxListImage">
                                    @foreach ($product->productImages as $key => $productImage)
                                        <div class="col-2 item position-relative">
                                            <img src="{{ asset(Storage::url($productImage->product_image_url)) }}"
                                                class="img-thumbnail rounded @if ($key === 0) border border-3 border-primary @endif"
                                                alt="...">
                                            <input type="text" name="product_image_ids[]" value="{{ $productImage->id }}"
                                                hidden>
                                            @if (!$showModal)
                                                <i role="button"
                                                    class="fa-regular fa-square-minus delete-item text-danger position-absolute top-0 end-0"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                    @if (!$showModal)
                                        <div class="col-2" id="divSelectImg">
                                            <img style="border: 2px dashed;"
                                                src="{{ asset('assets/images/1200px-Antu_insert-image.svg.png') }}"
                                                class="img-thumbnail opacity-50" alt="...">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7  mt-3 border rounded bg-body-secondary">
                            <div class="card-body">
                                <h5 class="card-title">Product information</h5>
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="inputProductCode" class="form-label">Product code</label>
                                        <input type="text" class="form-control bg-primary-subtle border border-primary"
                                            id="inputProductCode" name="product_code" value="{{ $product->product_code }}"
                                            disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputProductName" class="form-label">Product name</label>
                                        <input type="text"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endIf"
                                            id="inputProductName" name="product_name" value="{{ $product->product_name }}"
                                            @if ($showModal) disabled @endIf>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="selectProductType" class="form-label">Product type</label>
                                        {!! Form::select(
                                            'product_type',
                                            $productTypes->pluck('product_type_name', 'product_type_code')->toArray(),
                                            $productTypes->first()->pluck('product_type_code'),
                                            [
                                                'id' => 'selectProductType',
                                                'class' => 'form-select' . ($showModal ? ' bg-primary-subtle border border-primary' : ''),
                                                'aria-label' => 'Default select example',
                                                'disabled' => $showModal ? true : false,
                                            ],
                                        ) !!}
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputProductPrice" class="form-label">Product price</label>
                                        <input type="number" min="100000" step="any"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endIf"
                                            id="inputProductPrice" name="product_price"
                                            value="{{ $product->product_price }}"
                                            @if ($showModal) disabled @endIf>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="inputProductSale" class="form-label">Product sale</label>
                                        <input type="number" min="0" max="100"
                                            class="form-control @if ($showModal) bg-primary-subtle border border-primary @endIf"
                                            id="inputProductSale" step="any" name="product_sale"
                                            value="{{ $product->product_sale }}"
                                            @if ($showModal) disabled @endIf>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="textareaProductDescription" class="form-label">Product
                                            description</label>
                                        <textarea class="form-control @if ($showModal) bg-primary-subtle border border-primary @endIf"
                                            id="textareaProductDescription" rows="3" name="product_description"
                                            @if ($showModal) disabled @endIf>{{ $product->product_description }}</textarea>
                                    </div>
                                    <div class="col-12 d-flex justify-content-between">
                                        @if (!$showModal)
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        @else
                                            <a class="btn btn-primary" href="{{ Request::url() }}"><span><i
                                                        class="fa-solid fa-file-pen"></i></span>
                                                {{ __('Update now') }}</a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                aria-label="Close">Close</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="col-xxl-3 mt-3">
                        <div class="border rounded h-100" style="min-height: 300px;">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link p-1 border-bottom active" id="product-categories"
                                        data-bs-toggle="tab" data-bs-target="#product-categories-pane" type="button"
                                        role="tab" aria-controls="product-categories-pane"
                                        aria-selected="true">Categories</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link p-1 border-bottom" id="product-comments" data-bs-toggle="tab"
                                        data-bs-target="#product-comments-pane" type="button" role="tab"
                                        aria-controls="product-comments-pane" aria-selected="false">comments</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link p-1 border-bottom" id="product-status" data-bs-toggle="tab"
                                        data-bs-target="#product-status-pane" type="button" role="tab"
                                        aria-controls="product-status-pane" aria-selected="false">status</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="product-categories-pane" role="tabpanel"
                                    aria-labelledby="product-categories" tabindex="0">
                                    {!! Form::open(['class' => 'form-checkbox', 'id' => 'formlistProductCategories']) !!}
                                    {!! Form::text('item_ids', '', ['class' => 'input-form-role-permission', 'hidden' => 'hidden']) !!}
                                    {!! Form::text('item_new_ids', '', ['class' => 'input-form-role-permission-item-new', 'hidden' => 'hidden']) !!}
                                    @if (!$showModal)
                                        <x-button-icon :text="'Add'" :option="[
                                            'id' => 'btnShowFormNewItem',
                                            'class' => 'btn mt-2 btn-sm border',
                                            'type' => 'button',
                                            'data-bs-toggle' => 'modal',
                                            'data-bs-target' => '#addNewProductCategory',
                                        ]" :icon="'fa-solid fa-plus'" />
                                    @endif
                                    <div class="row g-1 mt-2">
                                        @foreach ($product->categories as $item)
                                            <div class="col-6 col-sm-4 col-xxl-12">
                                                <a href="#"
                                                    class="d-inline-flex focus-ring py-1 px-2 text-decoration-none border rounded-2 w-100 d-flex justify-content-between">
                                                    {{ $item->category_name }}
                                                    @if (!$showModal)
                                                        <i onclick=" submitForm(
                                                            'formlistProductCategories',
                                                            '{{ route('admin.products.updateProductCategory', ['id' => $product->id]) }}',
                                                            'post',
                                                            'formlistProductCategories .input-form-role-permission',
                                                            '{{ $item->id }}')"
                                                            class="fa-regular fa-trash-can my-auto text-danger"></i>
                                                    @endif
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="tab-pane fade" id="product-comments-pane" role="tabpanel"
                                    aria-labelledby="product-comments" tabindex="0">...</div>
                                <div class="tab-pane fade" id="product-status-pane" role="tabpanel"
                                    aria-labelledby="product-status" tabindex="0">...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <x-modal-item-show-component :modal-id="'addNewProductCategory'" :modal-size="''" :modal-position="''" modal-title="Permissions">
        <x-table-item-show-component :option="[
            'class' => 'table m-0',
            'id' => 'tableShowCategory',
            'style' => 'min-width: 365px;',
        ]" :values="$categories" :value-others="[]" :has-checkbox-item="true"
            :item-column="[
                'tableColumnName' => ['Category code', 'Category name'],
                'columnImage' => [],
                'column' => ['category_code', 'category_name'],
                'columnWith' => [],
                'columnWithIcon' => [],
            ]" :modal="[]" :item-functions="[]" :form-submit="'formlistProductCategories'" />
        <div class="my-3 d-flex justify-content-between">
            @if (!$showModal)
                <button type="button" id="btnAddNewProductCategories"
                    class="btn btn-primary">{{ __('Add') }}</button>
            @else
                <a class="btn btn-primary" href="{{ Request::url() }}"><span><i class="fa-solid fa-file-pen"></i></span>
                    {{ __('Update now') }}</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">{{ __('Close') }}</button>
            @endif
        </div>
    </x-modal-item-show-component>
@endsection

@section('style-js')
    <script>
        $(document).ready(function() {
            resizeImageSquare();
            $(window).resize(function() {
                resizeImageSquare();
            });

            $(document).on('click', '#divSelectImg', function() {
                $('#inputselectImg').click();
            });

            $('#inputselectImg').change(function() {
                let files = $(this).prop('files');

                for (let i = 0; i < files.length; i++) {
                    let file = files[i];

                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);

                    let reader = new FileReader();
                    reader.onload = (function(file) {
                        return function(e) {

                            let div = $('<div>').attr({
                                class: 'col-2 item position-relative',
                            })

                            let input = $('<input>').attr({
                                type: 'file',
                                name: 'product_new_images[]',
                                hidden: true,
                            });
                            input[0].files = dataTransfer.files;

                            let img = $('<img>').attr({
                                class: 'img-thumbnail',
                                src: e.target.result,
                            })

                            let iconButton = $('<i>').attr({
                                class: 'fa-regular fa-square-minus delete-item position-absolute top-0 end-0',
                                role: 'button',
                            })

                            div.append(input);
                            div.append(img);
                            div.append(iconButton);
                            $('#divSelectImg').before(div);
                        }
                    })(file);
                    reader.readAsDataURL(file);
                }
            });

            $(document).on('click', '.delete-item', function() {
                $(this).closest('.item').remove();
            });

            $(document).on('click', '.item', function(e) {
                var imgSrc = $(this).find('img').attr('src');
                $('#imgShowImg').attr('src', imgSrc);
            });

            $('#boxListImage .item img').click(function() {
                $('#boxListImage .item img').removeClass('border border-3 border-primary');
                $(this).addClass('border border-3 border-primary');
            });

            $('#btnAddNewProductCategories').click(function() {
                getSelectedCheckboxValues('addNewProductCategory',
                    'formlistProductCategories .input-form-role-permission-item-new');
                submitForm('formlistProductCategories.form-checkbox',
                    '{{ route('admin.products.updateProductCategory', ['id' => $product->id]) }}',
                    'post');
            });

            $('#addNewProductCategory .checkbox-all').change(function() {
                CheckCheckBoxAll('addNewProductCategory');
            });

            $('#addNewProductCategory .checkbox-item').change(function() {
                CheckCheckBoxItem('addNewProductCategory')
            });
        })

        function resizeImageSquare() {
            var squareDiv = $('.square-div');
            var img = $('#imgSquare');

            var divWidth = squareDiv.width();
            var imgWidth = img.width();

            if (imgWidth > divWidth) {
                var newImgWidth = divWidth;
                var newImgHeight = newImgWidth / imgWidth * img.height();
                var topOffset = (divWidth - newImgHeight) / 2;
                img.css({
                    width: newImgWidth,
                    height: newImgHeight,
                    top: topOffset
                });
            } else {
                img.css({
                    width: '100%',
                    height: 'auto',
                    top: 0
                });
            }
        }
    </script>
@endsection
