<?php

namespace App\Http\Controllers\Publications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\User;
use App\Models\Category;
use Inertia\Inertia;

class PublicationController extends Controller
{   
    public function allPublications(Request $request)
    {
        if ($request->perPage > 0)
        {
            $data = Publication::orderBy('created_at', 'desc')->paginate($request->perPage);
        }
        else
        {
            $data = Publication::orderBy('created_at', 'desc')->get();
        }
        return response()->json($data);
    }
    public function getCategories(Request $request)
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
       
        $user = User::find($request[0]->user_id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $ext = $file->extension();
            $path = '/storage/users/'.$user[0];

            if ($file->move(public_path($path), "image.$ext")) {

                // $application = Application::find($user->application->id);
                $user->image = "$path/image.$ext";
                $user->save();

               return response()->json($request->user_id,200);

            }
        }

        return response()->json($request->user_id,200);
    }
    public function savePublications(Request $request){
      
        try {

            $publication = Publication::firstOrNew([
                'id' => $request->id
            ]);
            $publication->fill($request->all());
            $publication->save();
    
            return response()->json($publication);

        }catch (\Throwable $th) {
            throw $th;
        }
    }
}
