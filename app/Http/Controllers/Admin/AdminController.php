<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin:admin');
    }
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
        $list = Admin::where($map)->paginate(5);
        return view('admin.manager.index',compact('list','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manager.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->password = bcrypt($request->password);
        $admin->status = $request->status;
        if($admin->save()){
            $admin_info = Admin::where('email', $request->email)->first();
            if(count($request->role_id) > 0){
                $role_name = [];
                foreach ($request->role_id as $k=>$v){
                    $role_name[] = Role::where('id',$v)->value('name');
                }
                $admin_info->assignRole($role_name);
            }
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
        $info = Admin::where("id",$id)->first();
//        dd($info->roles->pluck('name')->all());
        return view('admin.manager.edit',compact('info'));
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
        $admin = Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        if($request->password != null){
            $admin->password = bcrypt($request->password);
        }
        $admin->status = $request->status;
        if($admin->save()){
            foreach ($admin->roles->pluck('name')->all() as $v){
                $admin->removeRole($v);
            }
            if(count($request->role_id) > 0){
                $role_name = [];
                foreach ($request->role_id as $k=>$v){
                    $role_name[] = Role::where('id',$v)->value('name');
                }
                $admin->assignRole($role_name);
            }
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
        $info = Admin::where('id',$id)->update(['status'=>-1]);

        if($info){
            $message = [
                'code' => 1,
                'message' => '后台用户删除成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '后台用户删除失败，请稍后重试'
            ];
        }
        return response()->json($message);
    }
}

