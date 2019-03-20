<?php

namespace App\Http\Controllers\Admin;

use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $map = [];
        $search = '';
        if($request->search){
            $search = $request->search;
            $map[] = ['name','like','%'.$search.'%'];
        }
//        $map[] = ['status',">=",0];
        $list = Product::where($map)->paginate(5);
        return view('admin.product.index',compact('list','search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //先存储product
        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->image = $request->image;
        $product->on_sale = $request->on_sale;
        //最低价格
        if(count($request->SKU_title)>0) {
            $product->price = min($request->SKU_price);
        }else{
            $product->price = 0;
        }

        if($product->save()){

            //删除之前商品分类
//            CategoryProduct::where('product_id',$product->id)->delete();

            //关联商品分类
            foreach (explode(',',$request->category_id) as $category_id){
                $categoryProduct = new CategoryProduct();
                $categoryProduct->category_id = $category_id;
                $categoryProduct->product_id = $product->id;
                $categoryProduct->save();
            }

            $product_id = $product->id;
            if(count($request->SKU_title)>0){
                foreach ($request->SKU_title as $k=>$v){
                    $product_sku = new ProductSku();
                    $product_sku->title = $request->SKU_title[$k];
                    $product_sku->description = $request->SKU_description[$k];
                    $product_sku->price = $request->SKU_price[$k];
                    $product_sku->stock = $request->SKU_stock[$k];
                    $product_sku->product_id = $product_id;

                    if(!$product_sku->save()){
                        $message = [
                            'code' => 0,
                            'message' => '添加失败'
                        ];
                        return response()->json($message);
                    }
                }
            }
            $message = [
                'code' => 1,
                'message' => '商品添加成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '添加失败'
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
        $info = Product::where("id",$id)->with('skus')->first();
        return view('admin.product.show',compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = Product::where("id",$id)->with('skus','category')->first();
        dd($info->category);
        return view('admin.product.edit',compact('info'));
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
        //先存储product
        $product = Product::where("id",$id)->with('skus')->first();

        $product->title = $request->title;
        $product->description = $request->description;
        $product->image = $request->image;
        $product->on_sale = $request->on_sale;

        //最低价格
        if(count($request->SKU_title)>0) {
            $product->price = min($request->SKU_price);
        }else{
            $product->price = 0;
        }

        if($product->save()){

            //删除之前商品分类
            CategoryProduct::where('product_id',$product->id)->delete();

            //关联商品分类
            foreach (explode(',',$request->category_id) as $category_id){
                $categoryProduct = new CategoryProduct();
                $categoryProduct->category_id = $category_id;
                $categoryProduct->product_id = $product->id;
                $categoryProduct->save();
            }

            //首先对比出有无删减sku
            $old_skus_id = [];
            foreach ($product->skus as $v){
                $old_skus_id[] = $v->id;
            }
            $new_sku_id = $request->SKU_id;
            $delete_sku_id=array_diff($old_skus_id,$new_sku_id);
            //先删除去掉的sku数据
            foreach ($delete_sku_id as $sku_id){
                ProductSku::where("id",$sku_id)->delete();
            }
            //然后修改还剩下的sku库数据
            $i=0;
            foreach ($new_sku_id as $k=>$v){
                $id = $v;
                $i = $k;
                $oldProductSku = ProductSku::find($id);
                $oldProductSku->title = $request->SKU_title[$i];
                $oldProductSku->description = $request->SKU_description[$i];
                $oldProductSku->price = $request->SKU_price[$i];
                $oldProductSku->stock = $request->SKU_stock[$i];
                $oldProductSku->save();
            }

            //剩下新增的sku数据
            foreach ($request->SKU_title as $k=>$v){
                if($k>$i){
                    $productSku = new ProductSku();
                    $productSku->product_id = $product->id;
                    $productSku->title = $request->SKU_title[$k];
                    $productSku->description = $request->SKU_description[$k];
                    $productSku->price = $request->SKU_price[$k];
                    $productSku->stock = $request->SKU_stock[$k];
                    $productSku->save();
                }
            }


            $message = [
                'code' => 1,
                'message' => '商品信息修改成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '商品信息修改失败，请稍后重试'
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
