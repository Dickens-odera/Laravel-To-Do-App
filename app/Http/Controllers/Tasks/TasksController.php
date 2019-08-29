<?php

namespace App\Http\Controllers\Tasks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Tasks;
use App\User;
use Auth;
class TasksController extends Controller
{
    /**
     * a constructor to ensure that only authenticatd users can access any method here
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id; //get the currently logged in user
        $tasks = Tasks::where('user_id',$user_id)->latest()->get();
        return view('home', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create validation rules for the incoming requests
        $rules = array(
            'title'=>'required',
            'description'=>'nullable'
        );
        //check to see whether these validation rules have been met
        $validator = Validator::make($request->all(), $rules);
        //if the rules have not been met
        if($validator->fails())
        {
            //throw an exception if this fails
            $request->session()->flash('alert-danger',$validator->errors());
            return redirect()->back()->withInput()->with('error',$validator->errors());
        }
        else
        {
            //create a new instance of the Tasks model
            $task = new Tasks; 
            $task->user_id  = Auth::user()->id;           
            $task->title = $request->input('title');
            $task->description = $request->description;
            if($task->save())
            {
                //executes if the new task instance has been successfully created
                $request->session()->flash('alert-success','Your task has been successfully added');
                return redirect()->back()->with('success','Task added succesfully');
            }
            else
            {
                //if the attemt to create the task has failed
                $request->session()->flash('alert-danger','Failed to add the new task');
                return redirect()->back()->withInput()->with('error','Failed to add the new task to the list');
            }
        }
    }
    /**
     * enable the user to change the status of the task once complete
     */
    public function updateTaskStatus(Request $request)
    {
        //get the id of the particular task
        $id = $request->id;
        //if the id is not provided, throw an error
        if(!$id)
        {
            //shhow the user the same page but with an error message
            return redirect()->back()->with('error','Failed to update the task, try again');
        }
        else
        {
            //perform validation
            $validator = Validator::make($request->all(), ['id'=>'required']);
            //if the validation fails
            if($validator->fails())
            {
                // redirect the user to the same page and an error message
                return redirect()->back()->with('error',$validator->errors());
            }
            else
            {
                //if the validation was successful, change the status of the task
                if(Tasks::where('id',$id)->where('status', 'incomplete')->first()->update(['status'=>'complete']))
                {
                    return redirect()->back()->with('success','Task status updated successfully');

                }
                else{
                    //if the status failed to change
                    return redirect()->back()->with('error','Failed to update the status, try again');
                }
                
            }
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
    public function edit(Request $request)
    {
        //find the task item  by its id
        $id = $request->id;
        if(!$id)
        {
            //
            return redirect()->back()->with('error','Task item not found');
        }
        else
        {
            //
            $validator = Validator::make($request->all(), ['id'=>'required']);
            if($validator->fails())
            {
                //
                return redirect()->back()->withInput()->with('error', $validator->errors());
            }
            else
            {
                //
                $task = Tasks::where('id',$id)->first();
                return view('tasks.edit', compact('task'));
            }
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        if(!$id)
        {
            return redirect()->back()->with('error','Task item not found');
        }
        else
        {
            //set validation rules
            $rules = array(
                'id'=>'required',
                'title'=>'required',
                'description'=>'required'
            );
            //perform validation 
            $validator = Validator::make($request->all(),$rules);
            //check that the validation rules have been passed
            if($validator->fails())
            {
                $request->session()->flash('alert-danger',$validator->errors());
                return redirect()->back()->withInput()->with('error',$validator->errors());
            }
            else
            {
                //if the validation rules have been passed, proceed to update the requested task item
                if(Tasks::where('id',$id)->first()->update(['title'=>$request->title,'description'=>$request->input('description')]))
                {
                    $request->session()->flash('alert-success','The task item has been successfully updated');
                    return redirect()->to(route('home'))->with('success','The task item has been succesfully updated');
                }
                else{
                    //if the updation request failed
                    $request->session()->flash('alert-danger','Failed to update the requested task item');
                    return redirect()->back()->with('error','Failed to update the requested task item');
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        //check if the task item id is not provided
        if(!$id)
        {
            $request->session()->flash('alert-danger','Task item not found');
            return redirect()->back()->with('error','Task item not found');
        }
        else
        {
             /** 
              * 
              *if the task item id has been provided
              *proceed to perform the delete request
             */ 
            $validator = Validator::make($request->all(),['id'=>'required']);
            if($validator->fails())
            {
                //throw an error to show the user to provide an id for the task item
                $request->session()->flash('alert-danger','Please ensure that the task item id exists');
                return redirect()->back()->with('error','Please ensure that the task item id exists');
            }
            else
            {
                //if the item id is provided,proceed to delete the item as requested by the user
                if(Tasks::where('id',$id)->first()->delete())
                {
                    //send the user a notfication that task item has been successfully deleted
                    $request->session()->flash('alert-success','The task item has been successfully deleted');
                    return redirect()->back()->with('success','The task item has been successfully deleted');
                }
                else
                {
                    //if the task item has not been deleted
                    $request->session()->flash('alert-danger','Failed to delete the task item');
                    return redirect()->back()->with('error','Failed to delete the task item');
                }

            }
        }
    }
}
