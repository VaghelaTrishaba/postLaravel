<?php

namespace App\Http\Controllers\API;

use App\Models\post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index() //fetch data from post
    {
        $data['posts']=Post::all(); //fetch all data
        return  response()->json($data);
    }

    
    public function store(Request $request) //add data in post
    {
       $ValidateUser = Validator::make(
            $request->all(),
     [
               'title'=>'required',
               'description'=>'required',
               'image' => 'nullable|image|mimes:jpg,jpeg,png'
            ]
       );

       if ($ValidateUser->fails())
       {
         return response()->json([
            'message'=>'Validator error',
            'status'=>false,
            'error'=> $ValidateUser->errors()->first(),
         ]);
       }

       $img = $request->image;     //tack image name
       $ext = $img-> getClientOriginalExtension();   //tack thier extension
       $image =time(). '.' .$ext;     //convert there name first corrent time and then extension
       $img ->move(public_path().'/uploads', $image); //move in my  folder public folder ecreate uplode and save in them

       $post = Post::create([
            'title'=> $request->title,
            'description'=> $request->description,
            'image'=>$image,
       ]);

       return response()->json(['post'=>$post,'message'=> 'Data Add',]);
    
    }

   
    public function show(string $id)  // fetch one record
    {
        $data['post']=Post::select('id','title','description','image')->where(['id' => $id])->first();
        return response()->json(['data'=>$data]);
    }


    public function update(Request $request, $id)
    {
        $ValidationUser=Validator::make(
            $request->all(),
     [
                'title'=> 'required',
                'description'=>'required',
                'image'=>'required|mimes:png,jpg,jpeg,gif',
            ]
        );     
        
        if ($ValidationUser->fails())
        {
            return response()->json([
                'message'=> 'Validator Error',
                'status'=>false,
                'error'=> $ValidationUser->errors()->all(),
            ]);
        }

        $PostImage = Post::select('id','image')->where(['id'=>$id])->first();

        if ($request->image != '')
        {
            $path = public_path().'/uploads';
            if($request->image != '' && $PostImage->image != '')
            {
                $old_data = $path. $PostImage->image;
                if(file_exists($old_data))
                {
                    unlink($old_data);
                } 
            }

            $img = $request->image;     
            $ext = $img->getClientOriginalExtension();   
            $image =time().'.'.$ext;    
            $img ->move(public_path().'/uploads', $image);            
        }
        else
        {
            $image = $request->image;
        }

        $post=Post::where('id',$id)->update([
            'title' => $request->title,
            'description'=> $request->description,
            'image'=> $request->image,
        ]);

        return response()->json(['post'=>$post,'message'=> 'Post Updated',]);
    }

   
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if ($post->image) {
            $path = public_path('uploads/' . $post->image);

            if (file_exists($path)) {
                unlink($path);
            }
        }

        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data Deleted Successfully'
        ]);
    }

}
