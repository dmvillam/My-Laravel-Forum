<?php namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoriesController extends Controller
{
    /**
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->insertNewCateogory($request);
        Category::create($request->all());
        return \Redirect::route('admin.boards.index');
    }

    public function update(CreateCategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if ($request->order != "default")
        {
            $this->reArrangeCategories($id, $request);
        }
        else $request['order'] = $category->order;

        $category->fill($request->all());
        $category->save();
        return \Redirect::route('admin.boards.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $this->removeCategory(Category::find($id)->order);
        Category::destroy($id);
        return \Redirect::route('admin.boards.index');
    }

    private function insertNewCateogory(CreateCategoryRequest $request)
    {
        if ($request->order == "first")
        {
            $new_element_position = 0;
        }
        else if ($request->order == "last")
        {
            if (count(Category::all()) > 0)
            {
                $new_element_position = Category::orderBy('order', 'ASC')->get()->last()->order + 1;
            }
            else
            {
                $new_element_position = 0;
            }
        }
        else
        {
            $new_element_position = $request->order + 1;
        }

        $c_arrays = $this->CreateOrderArray();
        array_splice($c_arrays, $new_element_position, 0, '*');
        $this->UpdateOrderArray($c_arrays);
        $request['order'] = $new_element_position;
    }

    private function removeCategory($deleted_order)
    {
        $c_arrays = $this->CreateOrderArray();

        unset($c_arrays[$deleted_order]);
        $c_arrays = array_values($c_arrays);

        $this->UpdateOrderArray($c_arrays);
    }

    private function reArrangeCategories($id, CreateCategoryRequest $request)
    {
        if ($request->order == "first")
        {
            $new_element_position = 0;
        }
        else if ($request->order == "last")
        {
            if (count(Category::all()) > 0)
            {
                $new_element_position = Category::orderBy('order', 'ASC')->get()->last()->order + 1;
            }
            else
            {
                $new_element_position = 0;
            }
        }
        else
        {
            $new_element_position = $request->order;
        }

        $c_arrays = $this->CreateOrderArray();

        unset($c_arrays[array_search($id, $c_arrays)]);
        $c_arrays = array_values($c_arrays);

        array_splice($c_arrays, $new_element_position, 0, $id);

        $this->UpdateOrderArray($c_arrays);

        $request['order'] = $new_element_position;
    }

    private function CreateOrderArray()
    {
        $c_arrays = array();
        foreach (Category::orderBy('order', 'ASC')->get() as $category)
        {
            array_push($c_arrays, $category->id);
        }
        return $c_arrays;
    }

    private function UpdateOrderArray(&$array)
    {
        foreach ($array as $cat_order => $cat_id)
        {
            if ($cat_id != '*')
            {
                $category = Category::find($cat_id);
                $category->order = $cat_order;
                $category->save();
            }
        }
    }
}
