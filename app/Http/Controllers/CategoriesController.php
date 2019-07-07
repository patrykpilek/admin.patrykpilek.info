<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryDestroyRequest;
use Exception;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {
        $this->middleware('verified');
        $this->middleware('auth');
        $this->middleware('check-permissions');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categories = Category::with('posts')->orderBy('title')->paginate($this->limit);
        $categoriesCount = Category::count();

        return view("categories.index", compact('categories', 'categoriesCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $category = new Category();
        return view("categories.create", compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:25'
        ]);

        $category = Category::create($request->all());

        return redirect("categories/" . $category->slug ."/edit")->with("success", "Category [ ". $category->title . " ] created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return Response
     */
    public function edit(Category $category)
    {
        return view("categories.edit", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:25'
        ]);

        $category->update($request->all());
        return redirect("categories/" . $category->slug ."/edit")->with("success", "Category [ ". $category->title . " ] updated.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryDestroyRequest $request
     * @param Category $category
     * @return Response
     * @throws Exception
     */
    public function destroy(CategoryDestroyRequest $request, Category $category)
    {
        Post::withTrashed()->where('category_id', $category->id)->update(['category_id' => config('cms.default_category_id')]);
        $category->delete();
        return redirect("/categories")->with("success", "[ ". $category->title . " ] deleted.");
    }
}
