<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }
    public function create(){
        $users = User::getAll();
        $cate = Category::getAll();
        return view('admin.item.create',[
            'users' => $users,
            'cate' => $cate
        ]);
    }
    public function index(){
        $data = Item::getAll();

        return view('admin.item.index',['data' => $data]);
    }
    public function store(Request $request){
       $request->validate([
           'name'  => 'required|string',
           'slug'  => 'required|string',
           'price' => 'required|min:0',
           'stock' => 'required|min:1',
       ]);
       $item = $request->only('name','slug','stock','user_id','category_id','is_active');
       Item::createDB($item);


       return redirect()->route('item.index');
    }
    public function edit($id)
    {
        $item = Item::getById($id);
//         foreach ($item as $i){dd($i->slug);}
        $data = Item::getAll();
        $category = Category::getAll();

        return view('admin.item.edit',[
            'category' => $category,
            'item' => $item,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
        ]);

        $item = Item::getById($id);
        $item->name = $request->input('name');
        $item->slug = str_slug($request->input('name'));
        $item->stock = $request->input('stock');
        $item->price = $request->input('price');
        $item->category_id = $request->input('category_id');
        $item->is_active = $request->input('is_active');
        $item->save();

        return redirect()->route('item.index');
    }
    public function destroy($id)
    {
        Item::deleteDB($id);

        return redirect()->route('item.index');
    }
    public function search(Request $request){
        $keyword = $request->input('tu-khoa');
        $data = Item::searchKeyWord($keyword);

        return view('admin.user.index',
        [
            'data' => $data
        ]);
    }

}

