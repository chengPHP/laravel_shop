<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class FileController extends Controller
{
//    use ResponseJsonMessageService;
    private $upload_folder = 'uploads';

    //图片上传接口
    public function imageUpload(Request $request)
    {
        //上传验证
        $rule = [
            'file' => 'bail|required|image|max:2048'
        ];
        $message = [
            'file.required' => '请选择上传文件',
            'file.image' => '上传文件必须是图片',
            'file.max' => '上传图片大小不能大于2M',
        ];
        $file = $request->file();
        $validator = Validator::make($file, $rule, $message);
        if ($validator->fails()) {
            self::setStatus(0);
            self::setMessage($validator->errors()->first('file'));
        } else {
            //上传图片
            $upload_file = $file['file'];
            if ($upload_file->isValid()) {
                $image_upload_config = config('filesystems.disks.image');
                //设置保存目录
                $save_path = date("Ym", time())
                    . '/' . date("d", time());
                //文件的扩展名
                $ext = $upload_file->getClientOriginalExtension();
                $uniqid = uniqid();
                //设置保存文件名
                $save_name = $uniqid . '.' . $ext;
                //文件转存
                $new_file = $upload_file->move($image_upload_config['root'] . '/'
                    . $save_path, $save_name);
                $path = $image_upload_config['base_path'] . '/' . $save_path . '/' . $save_name;
                //数据库保存上传文件信息
                $file_info = new File();
                $file_info->type = $upload_file->getClientMimeType();
                $file_info->name = $save_name;
                $file_info->old_name = $upload_file->getClientOriginalName();
                $file_info->width = 0;
                $file_info->height = 0;
                $file_info->suffix = $ext;
                $file_info->file_path =  $new_file->getRealPath();
                $file_info->path = $path;
                $file_info->url = asset($path);
                $file_info->size = $upload_file->getClientSize();
//                $file_info->ip = $request->ip();
//                $file_info->upload_mode = 'image';
//                $file_info->uniqid = $uniqid;

//                dd($file_info);

                if ($file_info->save()) {
                    $message = [
                        'code' => 1,
                        'ids' => $file_info->toArray(),
                        'message' => '文件上传成功'
                    ];
                } else {
                    $message = [
                        'code' => 0,
                        'message' => '文件上传失败，请稍后重试'
                    ];
                }
            } else {
                $message = [
                    'code' => 0,
                    'message' => '上传失败！请联系管理员'
                ];
            }
        }
        return response()->json($message);
    }

    //文件上传接口
    public function fileUpload(Request $request)
    {
        //上传验证
        $rule = [
            'file' => 'bail|max:2048'
        ];
        $message = [
            'file.max' => '上传文件大小不能大于2M',
        ];
        $file = $request->file();
        $validator = Validator::make($file, $rule, $message);
        if ($validator->fails()) {
            self::setStatus(0);
            self::setMessage($validator->errors()->first('file'));
        } else {
            //上传图片
            $upload_file = $file['file'];
            if ($upload_file->isValid()) {
                $disk = Storage::disk('file');
                $file_upload_config = config('filesystems.disks.file');
                //设置保存目录
                $save_path = date("Ym", time())
                    . '/' . date("d", time());
                //文件的扩展名
                $ext = $upload_file->getClientOriginalExtension();
                $uniqid = uniqid();
                //设置保存文件名
                $save_name = $uniqid . '.' . $ext;
                $path = $file_upload_config['base_path'] . '/' . $save_path . '/' . $save_name;
                //文件转存
                $bool = $disk->putFileAs($save_path,$upload_file,$save_name);
                //数据库保存上传文件信息
                $file_info = new FileModel();
                $file_info->type = $upload_file->getClientMimeType();
                $file_info->name = $save_name;
                $file_info->old_name = $upload_file->getClientOriginalName();
                $file_info->suffix = $ext;
                $file_info->file_path = public_path() . '/' . $path;
                $file_info->path = $path;
                $file_info->url = asset($path);
                $file_info->size = $upload_file->getClientSize();
//                $file_info->org_id = get_current_login_user_org_id();
                $file_info->ip = $request->ip();
//                $file_info->user_id = get_current_login_user_info();
                $file_info->upload_mode = 'file';
                $file_info->uniqid = $uniqid;

                if ($bool && $file_info->save()) {
                    $message = [
                        'code' => 1,
                        'ids' => $file_info->toArray(),
                        'message' => '文件上传成功'
                    ];
                } else {
                    $message = [
                        'code' => 0,
                        'message' => '文件上传失败，请稍后重试'
                    ];
                }
            } else {
                $message = [
                    'code' => 0,
                    'message' => '上传失败！请联系管理员'
                ];
            }
        }
        return response()->json($message);
    }
}
