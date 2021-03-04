<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('category_name', 'ASC')->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_category = Category::where('is_parent', 1)->orderBy('category_name', 'ASC')->get();
        return compact('parent_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'string|required',
            'photo' => 'string|required',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable',
            'status' => 'nullable|in:active,inactive'
        ]);

        $data = $request->all();
        if($request->is_parent ==1)
        {
            $data['parent_id'] = null;
        }
        else{
            $data['parent_id'] = $request->input('parent_id', null);
        }

        $status = false;

        try{
            $status = Category::create($data);
        } catch (Exception $e) {

        }

        $parent_category = Category::where('is_parent', 1)->orderBy('category_name', 'ASC')->get();

        if($status) {
            return redirect()->route('category.index', compact($parent_category))->with('success', "Successfully created category.");
        }
        else {
            return back()->with('error', "Something went wrong.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.category.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findorfail($id);
        if($category) {
            $status = $category->delete();
            if($status) {
                return redirect()->route('category.index')->with('success', "Successfully deleted category.");
            }
            else {
                return back()->with('error', "Data not found");
            }
        }
        else {
            return back()->with('error', 'Data not found');
        }
    }
}
