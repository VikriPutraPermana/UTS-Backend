<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Digital;
use App\Models\News;
use Illuminate\Http\Request;

class DigitalController extends Controller
{
    public function index(){
        $digital = News::all();
  
        // jika data kosong maka kirim status code 204
        if($digital->isEmpty()){
          $data = [
            "message"=> 'Resource is empty',
          ];
  
          return response()->json($data, 204);  
  
        }
        
        $data = [
          'message' => 'Get All Digital Media',
          'data'=> $digital
        ];
  
        return response()->json($data, 200);
      }
  
      // membuat function store
      public function store(Request $request){
          // validasi data request
          $request->validate([
            "title"=>"required",
            "author"=> "required",
            "description"=> "required",
            "content" => "required",
            "url" => "required",
            "url_image" => "required",
            "published_at" => "required",
            "category" => "required"
          ]);
          // menangkap data request
          $input = [
            'author' => $request->author,
            'description' => $request->description,
            'content' => $request->content,
            'url' => $request->url,
            'url_image' => $request->url_image,
            'published_at' => $request->published_at,
            'category' => $request->category,
            'title' => $request->title
          ];
  
          // menggunakan model news untuk insert data
          $digital = News::create($input);
          
          $data = [
              'message' =>'News Digital Media is Created Succesfully',
              'data'=> $digital,
          ];
  
          // mengembalikan data (json) dan kode 201
          return response()->json($data, 201);
      }
  
      // membuat function update
      public function update(Request $request,$id){
        // mencari data yang ingin di update
        $digital = News::find($id);
  
        // jika data yang dicari tidak ada, kirim kode 404
        if(!$digital){
          $data = [
            'message' => 'Data not Found'
          ];
  
          return response()->json($data, 404);
        }
  
        // menangkap data request 
        $digital->update([
            'title'=> $request->title?? $digital->title,
            'content'=> $request->content ?? $digital->content,
            'category'=> $request->category ?? $digital->category,
            'author'=> $request->author ?? $digital->author,
            'published'=> $request->published ?? $digital->published,
          ]);
  
          // mengupdate nilai student berdasarkan id
          $data = [
            'message'=> 'News Digital Media updated successfully',
            'data'=> $digital
          ];
          
          // mengembalikan data 
          return response()->json($data, 200);
        
      }
      // membuat function delete
      public function destroy($id){
        // cari id news yang ingin dihapus
        $digital = News::find($id);
  
        // jika data yang dicari tidak ada kirim kode 404
        if(!$digital){
          $data = [
            'message' => 'Data not Found'
          ];
  
          return response()->json($data, 404);
        }
        
        // hapus news 
        $digital->delete();
  
        $data = [
          'message'=> 'News Digital Media deleted succesfully',
          'data'=> $digital
        ];
  
        // mengembalikan data kode 200
        return response()->json($data, 200);
    
    }
  
    // membuat detail news
    public function show ($id){
      # cari id news yang ingin didapatkan
      $digital = News::find($id);
  
      if($digital){
        $data = [
          'message' => 'Get detail News Digital Media',
          'data' => $digital
        ];
  
        // mengembalikan data
        return response()->json($data, 200);
      }else{
        $data = [
          'message' => 'News Digital Media not Found',
        ];
  
        // mengembalikan data
        return response()->json($data, 404);
      }
    }
}
