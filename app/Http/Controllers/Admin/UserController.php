<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 后台管理员管理
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $map = [];
        $search = '';
        if($request->search){
            $search = $request->search;
            $map[] = ['name','like','%'.$search.'%'];
        }
        $map[] = ['status',">=",0];
        $list = User::where($map)->paginate(5);
        return view('admin.user.index',compact('list','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;
        if($user->save()){
            $message = [
                'code' => 1,
                'message' => '用户添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '用户添加失败，请稍后重试'
            ];
        }

        return response()->json($message);
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
        $info = User::where("id",$id)->first();
//        dd($info->roles->pluck('name')->all());
        return view('admin.user.edit',compact('info'));
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if($request->password != null){
            $user->password = bcrypt($request->password);
        }
        $user->status = $request->status;
        if($user->save()){
            $message = [
                'code' => 1,
                'message' => '用户信息修改成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '用户信息修改失败，请稍后重试'
            ];
        }

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info = User::where('id',$id)->update(['status'=>-1]);

        if($info){
            $message = [
                'code' => 1,
                'message' => '前台用户删除成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '前台用户删除失败，请稍后重试'
            ];
        }
        return response()->json($message);
    }
}

