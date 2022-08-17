<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use Exception;
use Illuminate\Http\Request;
use Validator;
use Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilmsController extends Controller
{
    public function index()
    {
       $films = Film::latest()->get();
       return FilmResource::collection($films);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|min:4|max:200',
            'slug' => 'required|string|min:4|max:200|unique:films,slug',
            'description' => 'required|string|min:4|max:1500',
            'release_date' => 'required|date',
            'rating' => 'required|numeric|min:0.1|max:5',
            'price' => 'required|numeric',
            'country' => 'required|string|min:4|max:200',
            'genre' => 'required|array|min:1|max:20',
            'photo' => 'required|file|mimes:jpg,png|max:1024'
        ]);
        if (!$validator->passes()) {
            return response()->json(['status'=>false,'error'=>$validator->errors()->all()],400);
        }
        if($request->slug !== Str::slug($request->slug,'-')){
            return response()->json(['status'=>false,'error'=>["slug" => 'slug must be without space and separated with dashes \'-\' ']],400);
        }
        $file_name = null;
        try{
            if($request->hasFile('photo')){
                $file_name = $request->photo->store('films_photos');
            } 
            $film = Film::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug,'-'),
                'description' => $request->description,
                'release_date' => $request->release_date,
                'rating' => $request->rating,
                'price' => $request->price,
                'country' => $request->country,
                'genre' => json_encode($request->genre),
                'photo' => $file_name,
                'created_by' => Auth::id(),
            ]);
        }catch(Exception $ex){
            if($file_name != null)
                Storage::delete($file_name);
            return response()->json(['error'=>$ex->getMessage()],500);
            // throw $ex;
        }
        return response()->json([
            'message' => 'Film added successfully.',
            'film' => new FilmResource($film)
        ],201);
    }

    public function show($id)
    {
        $film = Film::where('slug',$id)->firstOrFail();
        return new FilmResource($film);
    }
}
