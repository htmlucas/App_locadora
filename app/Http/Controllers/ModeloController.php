<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function __construct(Modelo $modelo){
        $this->modelo = $modelo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modelos = array();

        if($request->has('atributos_marca')){
            $atributos_marca = $request->atributos_marca; 
            $modelos = $this->modelo->with('marca:id,'.$atributos_marca); 
            #é necessario sempre trazer o id porque tem um relacionamento
        }else{
            $modelos = $this->modelo->with('marca');
        }
        if($request->has('atributos')){
            $atributos = $request->atributos; # -> id,nome,imagem,marca_id
            $modelos = $modelos->selectRaw($atributos)->get(); 
            #utilizando selectRAW o laravel vai conseguir ler a string de atributos e lidar da melhor forma
            #na consulta de get no postman é necessario mandar marca_id junto para que o relacionamento apareça
        }else{
            $modelos = $modelos->get();
        }
        return response()->json($modelos,200);
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
     * @param  \App\Http\Requests\StoreModeloRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModeloRequest $request)
    {
        //$marca = Marca::create($request->all());
        //nome
        //imagem

        $request->validate($this->modelo->regras());
        //stateless
     
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/modelos','public'); // 2 parametros - nome do diretorio - o disco(default é o local)
        
        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' =>$request->nome,
            'imagem' =>$imagem_urn,
            'numero_portas' =>$request->numero_portas,
            'lugares' =>$request->lugares,
            'air_bag' =>$request->air_bag,
            'abs' =>$request->abs
        ]);
        return response()->json($modelo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if($modelo === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'],404);
        }
        return response()->json($modelo,200) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModeloRequest  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     * 
     */
    public function update(UpdateModeloRequest $request, $id)
    {
        $modelo = $this->modelo->find($id);

         if($modelo === null){
             return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'],404);
         }
 
         if($request->method() === 'PATCH'){
             $regrasDinamicas = array();
 
             //percorrendo todas as regras definidas no Model
             foreach($modelo->regras() as $input => $regra){
 
                 //coletar apenas as regras aos parametros parciais
                 if(array_key_exists($input,$request->all())){
                     $regrasDinamicas[$input] = $regra;
                 }
             }
             
             $request->validate($regrasDinamicas);
         }else{
             $request->validate($modelo->regras());
         }
         
         //remove o antigo caso um novo tenha sido enviado no request
         if($request->file('imagem')){
             Storage::disk('public')->delete($modelo->imagem);
         }
 
         $imagem = $request->file('imagem');
         $imagem_urn = $imagem->store('imagens/modelos','public'); // 2 parametros - nome do diretorio - o disco(default é o local)
         
         $modelo->fill($request->all());
         $modelo->imagem = $imagem_urn;
         $modelo->save();

         /* $modelo->update([
            'marca_id' => $request->marca_id,
            'nome' =>$request->nome,
            'imagem' =>$imagem_urn,
            'numero_portas' =>$request->numero_portas,
            'lugares' =>$request->lugares,
            'air_bag' =>$request->air_bag,
            'abs' =>$request->abs
         ]); */
         
         return response()->json($modelo,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'],404);
        }

         //remove o antigo 
            Storage::disk('public')->delete($modelo->imagem);
        
        $modelo->delete();
        return response()->json(['msg'=>'o modelo foi removida'],200);
    }
}
