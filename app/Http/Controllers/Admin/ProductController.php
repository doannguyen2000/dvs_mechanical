<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\IndexProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(IndexProductRequest $request)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.products.product-list');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created new product False');
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
            $message = $this->productRepository->update($params, $id);
            DB::commit();
            if (!$message) return redirect()->back()->with('error', 'product not foul!');
            return redirect()->route('admin.products.list')->with('success', 'Updated new product success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Updated new product False');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validator = Validator::make(['item_ids' => explode(',', $request->input('item_ids'))], [
                'item_ids.*' => ['required', Rule::exists('products', 'id')],
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $params = $validator->validated();
            $this->productRepository->destroy($params['item_ids']);
            DB::commit();
            return redirect()->route('admin.products.list')->with('success', 'Delete product success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete product False');
        }
    }
}
