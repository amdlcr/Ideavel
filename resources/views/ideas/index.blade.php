<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/boton.css') }}">


</head>
<body>
    
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session()->has('message'))
            <div class="text-center bg-gray-100 rounded-md p-2">
                <span class="text-indigo-600 text-xl font-semibold">{{ session('message') }}</span>
            </div>
            @endif
            <div class="overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 text-gray-900 dark:text-gray-100s space-x-8">
                    <a href="{{route('idea.create')}}"
                        class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">Agregar</a>
                    <a href="{{route('idea.index', ['filtro'=> 'mis-ideas'])}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">Mis Ideas</a>
                    <a href="{{route('idea.index', ['filtro'=> 'las-mejores'])}}" class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-sm text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700">Las Mejores</a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                @forelse($ideas as $idea)
                <div class="p-6 flex space-x-2">
                    <svg fill="#ffffff" width="24px" height="24px" viewBox="0 0 32 32" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" transform="rotate(0)">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <title>lightbulb-on</title>
                            <path
                                d="M20 24.75h-8c-0.69 0-1.25 0.56-1.25 1.25v2c0 0 0 0 0 0 0 0.345 0.14 0.658 0.366 0.885l2 2c0.226 0.226 0.538 0.365 0.883 0.365 0 0 0.001 0 0.001 0h4c0 0 0.001 0 0.002 0 0.345 0 0.657-0.14 0.883-0.365l2-2c0.226-0.226 0.365-0.538 0.365-0.883 0-0.001 0-0.001 0-0.002v0-2c-0.001-0.69-0.56-1.249-1.25-1.25h-0zM18.75 27.482l-1.268 1.268h-2.965l-1.268-1.268v-0.232h5.5zM27.125 12.558c0.003-0.098 0.005-0.214 0.005-0.329 0-2.184-0.654-4.216-1.778-5.91l0.025 0.040c-1.919-3.252-5.328-5.447-9.263-5.644l-0.027-0.001h-0.071c-3.934 0.165-7.338 2.292-9.274 5.423l-0.028 0.049c-1.17 1.687-1.869 3.777-1.869 6.031 0 0.012 0 0.025 0 0.037v-0.002c0.184 2.294 0.923 4.383 2.081 6.176l-0.032-0.052c0.322 0.555 0.664 1.102 1.006 1.646 0.671 0.991 1.314 2.13 1.862 3.322l0.062 0.151c0.194 0.455 0.637 0.768 1.153 0.768 0 0 0.001 0 0.001 0h-0c0.173-0 0.338-0.035 0.489-0.099l-0.008 0.003c0.455-0.194 0.768-0.638 0.768-1.155 0-0.174-0.036-0.34-0.1-0.49l0.003 0.008c-0.669-1.481-1.374-2.739-2.173-3.929l0.060 0.095c-0.327-0.523-0.654-1.044-0.962-1.575-0.939-1.397-1.557-3.083-1.71-4.901l-0.003-0.038c0.019-1.735 0.565-3.338 1.485-4.662l-0.018 0.027c1.512-2.491 4.147-4.17 7.185-4.332l0.022-0.001h0.052c3.071 0.212 5.697 1.934 7.162 4.423l0.023 0.042c0.864 1.293 1.378 2.883 1.378 4.593 0 0.053-0 0.107-0.002 0.16l0-0.008c-0.22 1.839-0.854 3.496-1.807 4.922l0.026-0.041c-0.287 0.487-0.588 0.968-0.889 1.446-0.716 1.066-1.414 2.298-2.020 3.581l-0.074 0.175c-0.067 0.148-0.106 0.321-0.106 0.503 0 0.69 0.56 1.25 1.25 1.25 0.512 0 0.952-0.308 1.146-0.749l0.003-0.008c0.625-1.33 1.264-2.452 1.978-3.52l-0.060 0.096c0.313-0.498 0.625-0.998 0.924-1.502 1.131-1.708 1.891-3.756 2.12-5.961l0.005-0.058zM15.139 5.687c-0.199-0.438-0.633-0.737-1.136-0.737-0.188 0-0.365 0.041-0.525 0.116l0.008-0.003c-2.463 1.415-4.215 3.829-4.711 6.675l-0.008 0.057c-0.011 0.061-0.017 0.132-0.017 0.204 0 0.617 0.447 1.129 1.035 1.231l0.007 0.001c0.063 0.011 0.135 0.018 0.209 0.018h0c0.615-0.001 1.126-0.446 1.23-1.031l0.001-0.008c0.366-2.067 1.575-3.797 3.252-4.852l0.030-0.017c0.437-0.2 0.735-0.634 0.735-1.138 0-0.187-0.041-0.364-0.115-0.523l0.003 0.008zM1.441 3.118l4 2c0.16 0.079 0.348 0.126 0.546 0.126 0.69 0 1.25-0.56 1.25-1.25 0-0.482-0.273-0.9-0.672-1.109l-0.007-0.003-4-2c-0.16-0.079-0.348-0.126-0.546-0.126-0.69 0-1.25 0.56-1.25 1.25 0 0.482 0.273 0.9 0.672 1.109l0.007 0.003zM26 5.25c0.001 0 0.001 0 0.002 0 0.203 0 0.395-0.049 0.564-0.135l-0.007 0.003 4-2c0.407-0.212 0.679-0.63 0.679-1.112 0-0.69-0.56-1.25-1.25-1.25-0.199 0-0.387 0.046-0.554 0.129l0.007-0.003-4 2c-0.413 0.21-0.69 0.631-0.69 1.118 0 0.69 0.559 1.25 1.249 1.25h0zM30.559 20.883l-4-2c-0.163-0.083-0.355-0.132-0.559-0.132-0.69 0-1.249 0.559-1.249 1.249 0 0.486 0.278 0.908 0.683 1.114l0.007 0.003 4 2c0.163 0.083 0.355 0.132 0.559 0.132 0.69 0 1.249-0.559 1.249-1.249 0-0.486-0.278-0.908-0.683-1.114l-0.007-0.003zM5.561 18.867l-3.913 1.83c-0.428 0.205-0.718 0.634-0.718 1.131 0 0.691 0.56 1.25 1.25 1.25 0.191 0 0.372-0.043 0.534-0.119l-0.008 0.003 3.913-1.83c0.428-0.205 0.718-0.634 0.718-1.131 0-0.691-0.56-1.25-1.25-1.25-0.191 0-0.372 0.043-0.534 0.119l0.008-0.003zM2 13.25h1c0.69 0 1.25-0.56 1.25-1.25s-0.56-1.25-1.25-1.25v0h-1c-0.69 0-1.25 0.56-1.25 1.25s0.56 1.25 1.25 1.25v0zM30 10.75h-1c-0.69 0-1.25 0.56-1.25 1.25s0.56 1.25 1.25 1.25v0h1c0.69 0 1.25-0.56 1.25-1.25s-0.56-1.25-1.25-1.25v0z">
                            </path>
                        </g>
                    </svg>
                    <div class="flex-1 pl-3">
                        <div class="flex justify-end items-center">
                            <div>
                                <span class="text-gray-800 dark:text-gray-100">{{$idea->user->name}}</span>
                                <small class="ml-2 text-sm text-gray-600 dark:text-gray-100">{{$idea->created_at->format('d/m/Y')}}</small>
                            </div>
                            @auth
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button style= "margin-left: 10px">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                        
                                    @can('update',$idea)
                                        <x-dropdown-link :href="route('idea.edit', $idea)">
                                            Editar
                                        </x-dropdown-link>
                                    @endcan
                                    @can('delete',$idea)
                                        <form method="POST" action="{{ route('idea.delete', $idea) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link href="#"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                Eliminar
                                            </x-dropdown-link>

                                        </form>
                                    @endcan

                                </x-slot>
                            </x-dropdown>
                            @endauth
                        </div>
                        <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{$idea->title}}</p>
                        <p class="text-base text-gray-600 dark:text-gray-400">{{$idea->description}}</p>
                        <small class="text-sm text-gray-400 flex mt-3">





                        

<div class="flex items-center space-x-8">

    <!-- Like -->
     <!-- Con la clase comprobamos si la idea ya ha sido "like" por el usuario logado y si es asi que mantenga su color, si no nada. 
     Para que lo mantenga o no aunque el usuario navegue por la pagina -->

        <button type="button" class="btn_like {{ auth()->user()->ideasLiked->contains($idea->id) ? 'liked_color' : '' }}" data-id="{{ $idea->id }}">
           <svg class="icono_like" width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="currentColor" d="M144 224C161.7 224 176 238.3 176 256L176 512C176 529.7 161.7 544 144 544L96 544C78.3 544 64 529.7 64 512L64 256C64 238.3 78.3 224 96 224L144 224zM334.6 80C361.9 80 384 102.1 384 129.4L384 133.6C384 140.4 382.7 147.2 380.2 153.5L352 224L512 224C538.5 224 560 245.5 560 272C560 291.7 548.1 308.6 531.1 316C548.1 323.4 560 340.3 560 360C560 383.4 543.2 402.9 521 407.1C525.4 414.4 528 422.9 528 432C528 454.2 513 472.8 492.6 478.3C494.8 483.8 496 489.8 496 496C496 522.5 474.5 544 448 544L360.1 544C323.8 544 288.5 531.6 260.2 508.9L248 499.2C232.8 487.1 224 468.7 224 449.2L224 262.6C224 247.7 227.5 233 234.1 219.7L290.3 107.3C298.7 90.6 315.8 80 334.6 80z"/></svg>
        </button>
           <span class="likes_count">{{ $idea->likes }}</span>
    

    <!-- Dislike -->
    <!-- Con la clase comprobamos si la idea ya ha sido "dislike" por el usuario logado y si es asi que mantenga su color, si no nada. 
     Para que lo mantenga o no aunque el usuario navegue por la pagina -->

        <button type="button" class="btn_dislike {{ auth()->user()->ideasDisliked->contains($idea->id) ? 'disliked_color' : '' }}" data-id="{{ $idea->id }}">
            <svg class="btn_rojo" width="25px" height="25px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path fill="currentColor" d="M448 96C474.5 96 496 117.5 496 144C496 150.3 494.7 156.2 492.6 161.7C513 167.2 528 185.8 528 208C528 217.1 525.4 225.6 521 232.9C543.2 237.1 560 256.6 560 280C560 299.7 548.1 316.6 531.1 324C548.1 331.4 560 348.3 560 368C560 394.5 538.5 416 512 416L352 416L380.2 486.4C382.7 492.7 384 499.5 384 506.3L384 510.5C384 537.8 361.9 559.9 334.6 559.9C315.9 559.9 298.8 549.3 290.4 532.6L234.1 420.3C227.4 407 224 392.3 224 377.4L224 190.8C224 171.4 232.9 153 248 140.8L260.2 131.1C288.6 108.4 323.8 96 360.1 96L448 96zM144 160C161.7 160 176 174.3 176 192L176 448C176 465.7 161.7 480 144 480L96 480C78.3 480 64 465.7 64 448L64 192C64 174.3 78.3 160 96 160L144 160z"/></svg>
        </button>
            <span class="dislikes_count">{{ $idea->dislikes }}</span>

</div>










                                @unless($idea->created_at->eq($idea->updated_at))
                                <small class="text-sm text-gray-400"> &middot; {{ __('Idea ctualizada.') }}</small>
                                @endunless
                        </small>
                    </div>
                </div>

                @empty
                <h2 class="text-xl text-black p-4">No existen ideas almacenadas!</h2>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('js/likes.js') }}"></script>



</body>
</html>







