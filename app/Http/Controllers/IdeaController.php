<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

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

    public function synchronizeLikes(Request $request, $id)
    {
        //Primero creamos el validador
        $validator=Validator::make(
            //Los datos que va a validar, el id viene de la ruta '/ideas/{idea}/dislikes'
            ['id'=>$id],   
            //Las reglas que va a usar para validarlos
             ['id'=> 'required|numeric|exists:ideas,id']
        );

        //inicializamos variables, primero array vacio y luego status
        $datos =[];
        $status = 200;


        // fails se usa en laravel cuando has hecho un validador para comprobarlo
        if($validator->fails()){
            $datos = [
                'error'=> true,
                'respuesta'=> $validator->errors()->first()//con first() muestra solo el primer error que salta. errors() es un metodo de laravel que devuelve los errores de la validacion.
            ];
            $status = 400;
        }else{

        //Una vez ya validado el id, buscamos la informacion de la ieda con la que trbajamos en la tabla de datos para poder usar su informacion
            $idea= Idea::find($id);//find() en LAravel Eloquent es una función utilizada para buscar y recuperar un único registro específico de la base de datos

            $this->authorize('updateLikes',$idea); //autorizamos que solo un usuario diferente al creador de la idea haga like, eso esta hecho en IdeaPolicy.php

            $request->user()->ideasLiked()->toggle([$idea->id]); // pone el like
            $request->user()->ideasDisliked()->detach($idea->id);//para que quite el like si hay dislike

            //Actualizamos los contadores de like y dislike
            $idea->likes = $idea->users()->count();
            $idea->dislikes = $idea->usersDisliked()->count();
            $idea->save();

            $datos = [
                'error'=> false,
                'respuesta'=> [
                    //contadores de like y dislike de la idea
                    'likes' => $idea->likes,
                    'dislikes' => $idea->dislikes,
                    //Boolean que le indica si el usuario le ha dado like o dislike
                    'liked' => $request->user()->ideasLiked->contains($idea->id),
                    'disliked' => false
                ]];
            $status = 200;
        }

        return response()->json($datos, $status);
       
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
        ], 200);

    }


    public function gestionLikes (Request $request){


        $datos = [
            'error'=> true,
            'respuesta'=> ""];

        $status = 400;
        $idIdea = $request->input('id');
        $reaccionIdea = $request->input('reaccion');

        $validator=Validator::make(
            ['id'=>$idIdea,   
            'reaccion'=> $reaccionIdea ],
            ['id'=> 'required|numeric|exists:ideas,id',
             'reaccion'=> 'string|in:like,dislike']
        );

        if($validator->fails()){
            $datos = [
                'respuesta'=> $validator->errors()->first()
            ];
            return response()->json($datos, $status);
        }

        $idea= Idea::find($idIdea);
        $this->authorize('updateLikes',$idea);

        if($reaccionIdea ==='like'){

            $request->user()->ideasLiked()->toggle([$idea->id]);
            $request->user()->ideasDisliked()->detach($idea->id);

        }else{
            $request->user()->ideasDisliked()->toggle([$idea->id]); 
            $request->user()->ideasLiked()->detach($idea->id);
        };

        $idea->likes = $idea->users()->count();
        $idea->dislikes = $idea->usersDisliked()->count();
        $idea->save();

        $datos = [
                'error'=> false,
                'respuesta'=> [
                    'likes' => $idea->likes,
                    'dislikes' => $idea->dislikes,
                    'liked' => $request->user()->ideasLiked->contains($idea->id),
                    'disliked' => $request->user()->ideasDisliked->contains($idea->id)
                ]];
            $status = 200;

        return response()->json($datos, $status);



    }










}
