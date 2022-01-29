<?php

namespace App\Http\Controllers;

use App\Todo;
use App\Http\Requests\TodoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Auth::user()->todo();

        if ($search !== null) {
            $search_split = mb_convert_kana($search, 's');
            $search_split2 = preg_split('/[\s]+/', $search_split, -1, PREG_SPLIT_NO_EMPTY);

            foreach ($search_split2 as $value) {
                $query->where('title', 'like', '%'.$value.'%')
                      ->orwhere('description', 'like', '%'.$value.'%');
            }
        };

        $query->orderBy('registration_date', 'desc');
        $query->orderBy('completion_date', 'asc');
        $query->orderBy('expiration_date', 'asc');
        
        $todos = $query->paginate(9);
            
        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Todo $todo)
    {
        return view('todos.create', compact('todo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $todo = new Todo();
        $todo->fill($request->all());
        // ログインユーザーID
        $todo->user_id = Auth::user()->id;
        // 登録日 = 現在の年月日
        $todo->registration_date = date('Y-m-d');
        $todo->save();

        return redirect()->route('todos.show', $todo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        $this->checkUserID($todo);
        return view('todos.show', compact('todo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        $this->checkUserID($todo);
        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $this->checkUserID($todo);
        $todo->fill($request->all())->save();
        return redirect()->route('todos.show', $todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $this->checkUserID($todo);
        $todo->delete();
        return redirect()->route('todos.index');
    }

    /**
     * ログインユーザーがIDを間違っている場合は「HttpException（エラーメッセージ）」をスロー
     *
    * @param Todo $todo
    * @param integer $status
    * @return void
    */
    protected function checkUserID(Todo $todo, int $status = 404)
    {
        if (Auth::user()->id != $todo->user_id) {
            abort($status);
        }
    }
}
