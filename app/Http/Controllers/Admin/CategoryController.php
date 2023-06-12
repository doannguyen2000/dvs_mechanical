<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DatabaseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\DestroyCategoryRequest;
use App\Http\Requests\IndexCategoryRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(IndexCategoryRequest $request)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.categories.category-list', ['categories' => $this->categoryRepository->getAll($params), 'tables' => DatabaseHelper::getTables()]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Created show list category False');
        }
    }

    public function show(ShowUserRequest $request, $id)
    {
        try {
            $params = $request->validated();
            return view('pages.admin.categories.category-show', ['category' => $this->categoryRepository->getById($id), 'showModal' => $params['show_modal'] ?? false]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Show category False');
        }
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            $params = $request->validated();
            $this->categoryRepository->create($params);
            DB::commit();
            return redirect()->route('admin.categories.list')->with('success', 'Created new category success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Created new category False');
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $message = $this->categoryRepository->update($params, $id);
            DB::commit();
            if (!$message) return redirect()->back()->with('error', 'category not foul!');
            return redirect()->route('admin.categories.list')->with('success', 'Updated category success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Updated category False');
        }
    }

    public function destroy(DestroyCategoryRequest $request)
    {
        try {
            $params = $request->validated();
            $this->categoryRepository->destroy($params['item_ids']);
            DB::commit();
            return redirect()->route('admin.categories.list')->with('success', 'Delete category success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Delete category False');
        }
    }
}
