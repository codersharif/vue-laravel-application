<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=User::latest()->paginate(5);

        return $user;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,[
           'name'=>'required|string|max:150',
           'email'=>'required|email|max:191|unique:users',
           'password'=>'required|min:8'
       ]);
               
        $target=new User;

        $target->name =$request->name;
        $target->email =$request->email;
        $target->type =$request->type;
        $target->bio =$request->bio;
        $target->password =$request->password;

        $target->save();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $target=User::findOrFail($id);

        $this->validate($request,[
            'name'=>'required|string|max:150',
            'email'=>'required|email|max:191|unique:users,email,'.$target->id,
            'password'=>'sometimes|min:8'
        ]);
                
         $target->name =$request->name;
         $target->email =$request->email;
         $target->type =$request->type;
         $target->bio =$request->bio;
         if(!empty($request->password)){
            $target->password =$request->password;
         }
         
         $target->save();
         return ['message'=>"User Update Successfully"];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::findOrFail($id);

        $user->delete();

        return ['message'=>"User Delete Successfully"];
    }
}
