<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DatabaseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\IndexCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            return redirect()->back()->with('categoryFalse', 'Created new category False');
        }
    }

    public function store(CreateCategoryRequest $request)
    {
        try {
            $params = $request->validated();
            $this->categoryRepository->create($params);
            DB::commit();
            return redirect()->route('admin.categories.list')->with('categorySuccess', 'Created new category success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('categoryFalse', 'Created new category False');
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $params = $request->validated();
            $message = $this->categoryRepository->update($params, $id);
            DB::commit();
            if (!$message) return redirect()->back()->with('categoryFalse', 'category not foul!');
            return redirect()->route('admin.categories.list')->with('categorySuccess', 'Updated new category success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('categoryFalse', 'Updated new category False');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $validator = Validator::make(['category_ids' => explode(',', $request->input('category_ids'))], [
                'category_ids.*' => ['required', Rule::exists('categories', 'id')],
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $params = $validator->validated();
            $this->categoryRepository->destroy($params['category_ids']);
            DB::commit();
            return redirect()->route('admin.categories.list')->with('categorySuccess', 'Delete category success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('categoryFalse', 'Delete category False');
        }
    }
}
