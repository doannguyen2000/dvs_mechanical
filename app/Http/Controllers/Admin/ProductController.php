<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\DestroyProductRequest;
use App\Http\Requests\IndexProductRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateRolePermissionRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductTypeRepository;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productRepository, $productTypeRepository, $categoryRepository;

    public function __construct(ProductRepository $productRepository, ProductTypeRepository $productTypeRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->productTypeRepository = $productTypeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(IndexProductRequest $request)
    {

        $params = $request->validated();
        return view('pages.admin.products.product-list', ['products' => $this->productRepository->getAll($params), 'productTypes' => $this->productTypeRepository->getAll(['paginate' => 0])]);
        try {
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Show list product False');
        }
    }

    public function show(ShowUserRequest $request, $id)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.products.product-show', ['product' => $this->productRepository->getById($id), 'productTypes' => $this->productTypeRepository->getAll(['paginate' => 0]), 'categories' => $this->categoryRepository->getAll(['paginate' => 0]), 'showModal' => $params['show_modal'] ?? false]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Show product False');
        }
    }

    public function store(CreateProductRequest $request)
    {
        try {
            $params = $request->validated();
            $this->productRepository->create($params);
            DB::commit();
            return redirect()->route('admin.products.list')->with('success', 'Created new product success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Created new product False');
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $result =  $this->productRepository->update($params, $id);
            if (!$result['status'])  return redirect()->back()->with('error', $result['message']);
            DB::commit();
            return redirect()->back()->with('success', 'Updated new product success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Updated new product False');
        }
    }

    public function updateProductCategory(UpdateProductCategoryRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $message = $this->productRepository->updateProductCategory($params, $id);
            DB::commit();
            if (!is_null($message)) {
                DB::rollBack();
                return redirect()->back()->with('error', $message);
            };
            return redirect()->back()->with('success', 'Updated role permissions success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Updated role permissions False');
        }
    }

    public function destroy(DestroyProductRequest $request)
    {
        try {
            $params = $request->validated();
            $this->productRepository->destroy($params['item_ids']);
            DB::commit();
            return redirect()->back()->with('success', 'Delete product success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete product False');
        }
    }
}
