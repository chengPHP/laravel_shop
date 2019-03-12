<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
        $list = Role::where($map)->paginate(5);
        return view('admin.role.index',compact('list','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //权限列表
        $permissions = Permission::get();
        return view("admin.role.add",compact("permissions"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->guard_name = 'web';
        $role->status = $request->status;
        if($role->save()){
            $role_info = Role::where("name",$request->name)->first();

            if(count($request->permissions)>0){
                //中间表插入数据
                $role_info->syncPermissions($request->permissions);
            }
            $message = [
                'code' => 1,
                'message' => '角色添加成功'
            ];

        }else{
            $message = [
                'code' => 1,
                'message' => '角色添加失败，请稍后重试'
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
        //权限列表
        $permissions = Permission::get();
        $info = Role::where("id",$id)->with("permissions")->first();

        $arr = [];
        //获取当前角色下所有权限
        foreach ($info->permissions as $k=>$v){
            $arr[] = $v->id;
        }

        foreach ($permissions as $k=>$v){
            if(in_array($v->id,$arr)){
                $permissions[$k]['checked'] = true;
            }
        }

        return view("admin.role.edit",compact('permissions','info'));
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
        $role = Role::find($id);
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->status = $request->status;
        if($role->save()){
            $role_id = $id;
            if(count($request->permissions)>0){
                /*//先删除之前的关联数据
                Permission_role::where("role_id",$role_id)->delete();
                //再添加关联表数据
                //中间表插入数据
                foreach ($request->permissions as $k=>$v){
                    $arr = [
                        'permission_id' => $v,
                        'role_id' => $role_id
                    ];
                    Permission_role::insert($arr);
                }*/
                //先删除之前的关联数据
                $permissions = $role->getAllPermissions();
                foreach ($permissions as $k=>$v){
                    $role->revokePermissionTo($v);
                }

                $role->syncPermissions($request->permissions);
//                $role_info->syncPermissions($request->permissions);

            }
            $message = [
                'code' => 1,
                'message' => '角色信息修改成功'
            ];

        }else{
            $message = [
                'code' => 1,
                'message' => '角色信息修改失败，请稍后重试'
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

    }
}
