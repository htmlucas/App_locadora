<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas = $this->marca->with('modelos')->get(); // nao estamos acessando o metodo estatico de uma classe e sim acessando o metodo de um objeto
        //$marcas = Marca::all();
        return response()->json( $marcas,200);
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
     * @param  \App\Http\Requests\StoreMarcaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarcaRequest $request)
    {
        //$marca = Marca::create($request->all());
        //nome
        //imagem


        $request->validate($this->marca->regras(),$this->marca->feedback());
        //stateless
     
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens','public'); // 2 parametros - nome do diretorio - o disco(default é o local)
        $marca = $this->marca->create([
            'nome' =>$request->nome,
            'imagem' =>$imagem_urn
        ]);
        return response()->json($marca,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if($marca === null){
            return response()->json(['erro' => 'Recurso pesquisado não existe'],404);
        }
        return response()->json($marca,200) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarcaRequest  $request
     * @param  \integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarcaRequest $request,$id)
    {
        //$marca->update($request->all());
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossivel realizar a atualização. O recurso solicitado não existe'],404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no Model
            foreach($marca->regras() as $input => $regra){

                //coletar apenas as regras aos parametros parciais
                if(array_key_exists($input,$request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            
            $request->validate($regrasDinamicas,$marca->feedback());
        }else{
            $request->validate($marca->regras(),$marca->feedback());
        }
        
        //remove o antigo caso um novo tenha sido enviado no request
        if($request->file('imagem')){
            Storage::disk('public')->delete($marca->imagem);
        }
        
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens','public'); // 2 parametros - nome do diretorio - o disco(default é o local)
        
        
        #preencher o objeto marca com os dados do request
        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();

        /* $marca->update([
            'nome' =>$request->nome,
            'imagem' =>$imagem_urn
        ]); */
        
        return response()->json($marca,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'Impossivel realizar a exclusão. O recurso solicitado não existe'],404);
        }

         //remove o antigo 
            Storage::disk('public')->delete($marca->imagem);
        
        $marca->delete();
        return response()->json(['msg'=>'a marca foi removida'],200);
    }
}
