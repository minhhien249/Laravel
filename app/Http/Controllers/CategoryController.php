<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = Category::getAll();

        return view('admin.category.index',
        [
              'data' => $data
        ]);
    }
    public function create(){
        if (Auth::check()){
           if (Auth::user()->role_id == 1){
               $data = Category::getAll();

               return view('admin.category.create',[
                'data' => $data
               ]);
           } else
           {
             return redirect()->back()->with('msg', 'Bạn không có quyền');
           }
        }
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $category = $request->only('parent_id','name','position','is_active');
        Category::createDB($category);


        return redirect()->route('category.index');
    }
    public function show($id)
    {
        $category = Category::findId($id);

        return view('admin.category.show', [
            'category' => $category
        ]);
    }
}
