<?php

namespace App\Http\Controllers\Publications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\User;
use App\Models\Category;
use Inertia\Inertia;
use Carbon\Carbon;

class PublicationController extends Controller
{   
    public function tablePublications(Request $request)
    {
        if ($request->perPage > 0)
        {   
            $data = Publication::with('category', 'author')->whereDate('created_at', date('Y-m-d'))->paginate($request->perPage);
        }
        else
        {
            $data = Publication::with('category')->orderBy('created_at', 'desc')->with('category')->get(); 
        }
        return response()->json($data);
    }
    public function create(){
        
       return Inertia::render('Publications/Save');

    }
    
    public function selectCategories(Request $request)
    {
        if ($request->perPage > 0)
        {
            $data = Category::orderBy('created_at', 'desc')->paginate($request->perPage);
        }
        else
        {
            $data = Category::orderBy('created_at', 'desc')->get();
        }
        return response()->json($data);
    }
    public function uploadImages(Request $request)
    {
       
        $publication_id = $request->publication_id; 
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = $file->extension();
            $path = '/storage/publication/'.$publication_id;

            if ($file->move(public_path($path), "image.$ext")) {
                $form = Publication::find($publication_id);
                $form->image = "$path/image.$ext";
                $form->save();
                return response()->json($publication_id,200);
            }
        }
    
    }
    public function savePublications(Request $request){
      
        try {
            $form_obj = (object) $request->data;
            $form = new Publication();
            $form->title = $form_obj->title;
            $form->category_id = $form_obj->category_id;
            $form->summary = $form_obj->summary;
            $form->description = $form_obj->description;
            $form->user_id = auth()->user()->id;
            $form->save();
            
            return response()->json($form->id);
           
        }catch (\Throwable $th) {
            throw $th;
        }
    }
    public function detailPublications($id)
    {
        $publicationData = Publication::with('category', 'author')
        ->where('publications.user_id', $id)->first();
          
            $data = ['data'=>$publicationData];

           return Inertia::render('Publications/Detail', $data);
    }
    public function deletePublication($id)
    {
        $client = Publication::find($id);
        $client->delete();

        return Inertia::render('Publication/Index');
    }
}
