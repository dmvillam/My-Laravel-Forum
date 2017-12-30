<?php namespace App\Http\Controllers\Admin;

use App\Board;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBoardRequest;
use App\Http\Requests\EditLogoRequest;
use Illuminate\Http\Request;

use App\Http\Requests;

class BoardsController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order', 'ASC')->get(['name'])->toArray();
        foreach($categories as $index => $category)
        {
            $categories[$index] = 'Despues de ' . $category['name'];
        }
        $c_orders = array_merge(['first' => '(Al inicio)', 'last' => '(Al final)'], $categories);
        $c_orders_edit = array_merge(['default' => '(Conservar posición)', 'first' => '(Al inicio)'], $categories);

        $categories = Category::orderBy('order', 'ASC')->get();
        $c_names = array();
        foreach($categories as $category)
        {
            $c_names[$category->id] = $category->name;
        }

        return view('admin.boards.index', [
            'categories' => Category::orderBy('order', 'ASC')->get(),
            'c_orders' => $c_orders,
            'c_orders_edit' => $c_orders_edit,
            'c_names' => $c_names,
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('order', 'ASC')->get();
        $c_names = array();
        foreach($categories as $category)
        {
            $c_names[$category->id] = $category->name;
        }

        // TODO: Child boards
        /*$b_names = array('default' => '(ninguno)');
        foreach (Category::orderBy('order', 'ASC')->get() as $category)
        {
            $boards = Board::where('board_id', '=', 0)
                ->where('category_id', '=', $category->id)
                ->orderBy('order', 'ASC')->get();
            $b_names[$category->name] = array();
            foreach ($boards as $board)
            {
                $b_names[$category->name][$board->id] = $board->name;
            }
        }*/

        return view('admin.boards.create', [
            'c_names' => $c_names,
            //'b_names' => $b_names,
        ]);
    }

    public function store(CreateBoardRequest $request)
    {
        $boards = count(Category::find($request->category_id)->boards);
        if ($boards > 0)
        {
            $request['order'] = $boards;
        }
        else $request['order'] = 0;
        Category::find($request->category_id)->boards()->create($request->all());
        return \Redirect::route('admin.boards.index');
    }

    public function edit($id)
    {
        $categories = Category::orderBy('order', 'ASC')->get();
        $c_names = array('default' => '(No cambiar categoría)');
        foreach($categories as $category)
        {
            $c_names[$category->id] = $category->name;
        }

        $boards = Board::where('category_id', Board::find($id)->category->id)
            ->orderBy('order', 'ASC')
            ->get();
        $b_names = array();
        foreach($boards as $index => $board)
        {
            $b_names[$index] = 'Despues de ' . $board['name'];
        }

        return view('admin.boards.edit', [
            'board' => Board::find($id),
            'c_names' => $c_names,
            'b_names' => array_merge(['default' => '(Conservar posición)', 'first' => '(Al inicio)', 'last' => '(Al final)'], $b_names),
        ]);
    }

    public function update(CreateBoardRequest $request, $id)
    {
        $board = Board::find($id);
        if ($request->category_id == "default")
        {
            $request['category_id'] = Board::find($id)->category->id;
            if ($request->order != "default")
            {
                $this->reArrangeBoards($id, $request);
            }
            else $request['order'] = $board->order;
        }
        else
        {
            if (count(Category::find($request->category_id)->boards) > 0)
            {
                $request['order'] = Board::where('category_id', '=', $request->category_id)
                        ->orderBy('order', 'ASC')
                        ->get()->last()->order + 1;
            }
            else $request['order'] = 0;
        }

        $board->fill($request->all());
        $board->save();
        return \Redirect::route('admin.boards.index');
    }

    public function delete($id)
    {
        $this->removeCategory($id);
        Board::destroy($id);
        return \Redirect::route('admin.boards.index');
    }

    public function updatelogo(EditLogoRequest $request, $id)
    {
        $board = Board::find($id);

        $imageName = $board->id . '.' .
            $request->file('logo')->getClientOriginalExtension();

        $request->file('logo')->move(
            public_path() . '/logos/', $imageName
        );

        $board->fill(['logo' => $imageName]);
        $board->save();

        \Session::flash('message', 'El logo de la board <strong>' . $board->name . '</strong> ha sido actualizado!');
        return \Redirect::route('admin.boards.index');
    }

    private function removeCategory($id)
    {
        $deleted_order = Board::find($id)->order;
        $array = $this->CreateOrderArray($id);

        unset($array[$deleted_order]);
        $array = array_values($array);

        $this->UpdateOrderArray($array);
    }

    private function reArrangeBoards($id, CreateBoardRequest $request)
    {
        if ($request->order == "first")
        {
            $new_element_position = 0;
        }
        else if ($request->order == "last")
        {
            $new_element_position = Board::where('category_id', '=', Board::find($id)->category->id)
                ->orderBy('order', 'ASC')
                ->get()
                ->last()
                ->order;
        }
        else
        {
            $new_element_position = $request->order;
            $current_position = Board::find($id)->order;
            if ($current_position > $new_element_position)
            {
                $new_element_position++;
            }
        }

        $array = $this->CreateOrderArray($id);

        unset($array[array_search($id, $array)]);
        $array = array_values($array);

        array_splice($array, $new_element_position, 0, $id);

        $this->UpdateOrderArray($array);

        $request['order'] = $new_element_position;
    }

    private function CreateOrderArray($id)
    {
        $array = array();
        $boards = Board::where('category_id', '=', Board::find($id)->category->id)
            ->orderBy('order', 'ASC')
            ->get();
        foreach ($boards as $board)
        {
            array_push($array, $board->id);
        }
        return $array;
    }

    private function UpdateOrderArray(&$array)
    {
        foreach ($array as $brd_order => $brd_id)
        {
            if ($brd_id != '*')
            {
                $board = Board::find($brd_id);
                $board->order = $brd_order;
                $board->save();
            }
        }
    }
}

