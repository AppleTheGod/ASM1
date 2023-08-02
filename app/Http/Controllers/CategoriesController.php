<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    //
    public function index()
    {
        $title = 'Bảng điều khiển';
        $categories = Category::all();
        return view('adminn.category.list', compact('categories', 'title'));
    }
    // THÊM
    public function add_category(CategoryRequest $request)
    {
        $validated = $request->validated();
        if ($request->isMethod('post')) {
            $param = $request->post();
            unset($param['_token']);
            // dd($request);
            $category = new Category();
            $category->name = $request->name;
            $category->save();
            if($category->save()){
                Session::flash('success', 'success');
                Alert::success('Đã thêm danh mục !');
                return redirect()->route('list_category');
            }
            else {
                Session::flash('error', 'loi');
            }

        }
        return view('adminn.category.add');
    }
    // SỬA
    public function edit(Request $request, $id)
    {
        $detail = Category::find($id);
        if ($request->isMethod('POST')) {
            $update = Category::where('id', $id)->update($request->except('_token'));
            Alert::success('Cập nhật thành công !');
            return redirect()->route('list_category');
        }
        return view('adminn.category.edit', compact('detail'));
    }
    // XÓA
    public function delete($id)
    {
        if ($id) {
            $delete = Category::where('id', $id)->delete();
            return redirect()->route('list_category');
            Alert::success('Đã xóa danh mục');
        }
    }
}
