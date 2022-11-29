<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return $product;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gambarproduct = $request->gambarproduct;
            $gambar = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $gambarproduct));

            //
            $namagambar = "gambar-product-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $filename = $namagambar . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('datagambarproduct/');
            //image uploading folder path
            file_put_contents($path . $filename, $gambar);
            $postgambar = 'datagambarproduct/' . $filename;

        $katproduct = ProductCategory::where('id', $request->id_kategori)->first();
        $table = Product::create([
            "namaproduct" => $request->namaproduct,
            "namakategori" => $katproduct->namakategori,
            "id_kategori" => $request->id_kategori,
            "deskripsiproduct" => $request->deskripsiproduct,
            "gambarproduct" => $postgambar,
            "stok" => $request->stok,
            "harga" => $request->harga
        ]);

        return response()->json([
            'succes' => 201,
            'message' => 'data berhasil disimpan',
            'data' => $table
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json([
                'status' => 200,
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'id atas' . $id . 'tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $product = Product::find($id);
            if ($product) {
                if ($request->gambarproduct != '') {
                    $gambarproduct = $request->gambarproduct;
                    $gambar = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $gambarproduct));

                    //
                    $namagambar = "gambar-product-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
                    $filename = $namagambar . '.' . 'jpg';
                    //rename file name with random number
                    $path = public_path('datagambarproduct/');
                    //image uploading folder path
                    file_put_contents($path . $filename, $gambar);

                    // 
                    $postgambar = 'datagambarproduct/' . $filename;

                    $product->namaproduct = $request->namaproduct ? $request->namaproduct : $product->namaproduct;
                    $product->namakategori = $request->namakategori ? $request->namakategori : $product->namakategori;
                    $product->id_kategori = $request->id_kategori ? $request->id_kategori : $product->id_kategori;
                    $product->deskripsiproduct = $request->deskripsiproduct ? $request->deskripsiproduct : $product->deskripsiproduct;
                    $product->gambarproduct = $postgambar ? $postgambar : $product->gambarproduct;
                    $product->stok = $request->stok ? $request->stok : $product->stok;
                    $product->harga = $request->harga ? $request->harga : $product->harga;
                    $product->save();
                } else {
                    $product->namaproduct = $request->namaproduct ? $request->namaproduct : $product->namaproduct;
                    $product->namakategori = $request->namakategori ? $request->namakategori : $product->namakategori;
                    $product->id_kategori =  $request->id_kategori ?  $request->id_kategori : $product->id_kategori;
                    $product->deskripsiproduct = $request->deskripsiproduct ? $request->deskripsiproduct : $product->deskripsiproduct;
                    $product->gambarproduct = $product->gambarproduct;
                    $product->stok = $request->stok ? $request->stok : $product->stok;
                    $product->harga = $request->harga ? $request->harga : $product->harga;
                    $product->save();
                }

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $product
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id produk ' . $id . ' tidak ditemukan'
                ], 404);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = product::where('id',$id)->first();
        if($product){
            $product->delete();
            return response()->json([
                'status' => 200,
                'data' => $product
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'id' . $id . 'tidak ditemukan'
            ], 404);
        }
    }
}
