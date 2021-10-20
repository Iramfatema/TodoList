<?php

namespace App\Http\Controllers;

use App\TodoList;
use Illuminate\Http\Request;
use DataTables;

class TodoListController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $res = new TodoList();
        $res->user_id = $userId;
        $res->description = $request->input('desc');
        $res->save();

        $request->session()->flash('msg','Note Added');
        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $todoList)
    {
        $user_id = auth()->user()->id;
        return view('home')->with('todoArr',TodoList::where('user_id',$user_id)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoList $todoList,$id)
    {
        return view('todo.edit')->with('todoArr',TodoList::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoList $todoList)
    {
        $userId = auth()->user()->id;
        $res = TodoList::find($request->id);
        $res->description = $request->input('desc');
        $res->user_id = $userId;
        $res->save();

        $request->session()->flash('msg','Note Edited!');
        return redirect('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TodoList  $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $todoList,$id)
    {
        TodoList::destroy(array('id',$id));
         return redirect('home');
    }

    public function complete($id){
        $res = TodoList::find($id);
        if($res->status){
            $res->update(['status'=> false]);
            return redirect()->back();
        }
        else{
            $res->update(['status' => true]);
            return redirect()->back();
        }
        
    }

    // public function incomplete(TodoList $todoList){
    //     $res = TodoList::find($request->id);
    //     $res->status=0;
    // }

    public function list()
    {
        return view('home');
    }

    public function listView(Request $request,TodoList $todoList){
        if ($request->ajax()) {
            
            $user_id = auth()->user()->id;
            $data = TodoList::select('id','description','status')->where('user_id',$user_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="todo/edit/'.$row->id.'" class="edit btn btn-primary">Edit</a>&nbsp;&nbsp;&nbsp;';
                    $btn = $btn.'<a href="delete/'.$row->id.'" class="delete btn btn-danger">Delete</a>';
        
                    return $btn;
                })
                ->editColumn('description', function($row){
                    if($row->status==0)
                    {
                        $des = '<a href="complete/'.$row->id.'"><b style="color:black;">'.$row->description.'</b></a>';
                        return $des; 
                    }
                    else
                    {
                        $des = '<a href="complete/'.$row->id.'"><b style="color:black;"><del>'.$row->description.'</del></b></a>';
                        return $des;
                    }
                })
                ->rawColumns(['action','description'])
                ->make(true);
        }
    }
}
