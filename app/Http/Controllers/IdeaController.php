<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IdeaController extends Controller
{

    private $rules = [
        'title'=> 'required|string|max:100',
        'description'=> 'required|string|max:300',
        ];

    private array $errorMessages = [
        'title.required'=> 'El campo título es obligatorio',
        'description.required'=> 'El campo descripción es obligatorio',
        'string'=> 'Este campo debe ser de tipo String',
        'title.max'=> 'El campo título no debe ser mayor a 100 carácteres',
        'description.max'=> 'El campo descripción no debe ser mayor a :max carácteres',
        ];


    public function index(Request $request): View
    {

        $ideas = Idea::myIdeas($request->filtro)->TheBest($request->filtro)->latest('id')->get();//es un select* from a la BBDD de ideas
        return view('ideas.index',['ideas'=> $ideas] );    

    }

    public function create(): View
    {
        return view('ideas.create_or_edit');
    }

    public function store(Request $request):RedirectResponse
    {
       $validated = $request->validate($this->rules,$this->errorMessages);
    
        Idea::create([
            'user_id' => auth()->user()->id,
            'title'=>$validated['title'],
            'description'=>$validated['description']
        ]);

        session()->flash('message', 'La idea ha sido creada correctamente');

        return redirect()->route('idea.index');
    }


    public function edit(Idea $idea):View
    {
        $this->authorize('update',$idea);
        return view('ideas.create_or_edit')->with('idea',$idea);

    }

    public function update(Request $request, Idea $idea): RedirectResponse
    {
        $this->authorize('update',$idea); //protegemos la idea, solo puede ser actualizada por su dueño
    
        $validated = $request->validate($this->rules,$this->errorMessages);

        $idea->update($validated);

        session()->flash('message', 'La idea se ha actualizado correctamente');
        return redirect(route('idea.index'));

    }


     public function show(Idea $idea): View
    {
        return view('ideas.show')->with('idea', $idea);
    }


    public function delete(Idea $idea): RedirectResponse
    {
        $this->authorize('delete',$idea);
        $idea->delete();
        session()->flash('message', 'La idea se ha eliminado correctamente');
        return redirect()->route('idea.index');
    }

    public function synchronizeLikes(Request $request, Idea $idea)
    {
        $this->authorize('updateLikes',$idea);

        $request->user()->ideasLiked()->toggle([$idea->id]); // pone el like

        $request->user()->ideasDisliked()->detach($idea->id);//para que quite el like si hay dislike

        //Actualizamos los contadores de like y dislike
        $idea->likes = $idea->users()->count();
        $idea->dislikes = $idea->usersDisliked()->count();
        $idea->save();

        return response()->json([
            //contadores de like y dislike de la idea
            'likes' => $idea->likes,
            'dislikes' => $idea->dislikes,
            //Boolean que le indica si el usuario le ha dado like o dislike
            'liked' => $request->user()->ideasLiked->contains($idea->id),
            'disliked' => false
        ]);
    }


    public function synchronizeDislikes(Request $request, Idea $idea)
    {
        $this->authorize('updateLikes', $idea);

        $request->user()->ideasDisliked()->toggle([$idea->id]); //pone el dislike

        $request->user()->ideasLiked()->detach($idea->id);//para que quite el dislike si hay like

        //Actualizamos los contadores de like y dislike
        $idea->likes = $idea->users()->count();
        $idea->dislikes = $idea->usersDisliked()->count();
        $idea->save();

        return response()->json([
            //contadores de like y dislike de la idea
            'likes' => $idea->likes,
            'dislikes' => $idea->dislikes,
            //Boolean que le indica si el usuario le ha dado like o dislike
            'liked' => false,
            'disliked' => $request->user()->ideasDisliked->contains($idea->id)
        ]);
    }




}
