<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\category\StorecategoryRequest;
use App\Http\Requests\category\UpdatecategoryRequest;

class AdminCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:categories-list|categories-create|categories-edit|categories-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:categories-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:categories-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:categories-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecategoryRequest $request)
    {
        $category = Category::create($request->only([
            'category_name',
            'promotion_name',
            'required_points',
            'description',
            'color',
            'is_default',
            'is_fixed',
            'active',
        ]));
        
        if ($category) {
            return redirect()->route('categories.index')
                ->with('alert-success', 'تم اضافة الفئة بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الفئة');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatecategoryRequest  $request
     * @param  \App\Models\Category  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatecategoryRequest $request, Category $category)
    {

        if($category->update($request->only([
            'category_name',
            'promotion_name',
            'required_points',
            'description',
            'color',
            'is_fixed',
            'is_default',
            'active',
        ]))) {
            return redirect()->route('categories.index')
            ->with('alert-success', 'تم تعديل معلومات الفئة بنجاح');
        }
        
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء تعديل معلومات الفئة ');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        if ($category->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف الفئة ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء خذف الفئة ');
    }
}
