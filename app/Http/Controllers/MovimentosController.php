<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Aeronave;
use App\User;
use App\Rules\ValidationInstrutor;
class MovimentosController extends Controller{

    public function __construct(){

        $this->middleware(['auth','activated','verified']);
    }

    public function index(){

        $movimentos = Movimento::paginate(30);
        $users = User::all();
        return view('movimentos.index', compact('movimentos','users'));

    }

    public function getFilter(Request $request){
      switch ($request->filtro) {
        case '1':
          $movimentos = Movimento::where('id', $request->search);
          break;

        case '2':
          $movimentos = Movimento::where('aeronave', $request->search);
          break;

        case '3':
          $movimentos = Movimento::where('piloto_id', $request->search);
          break;

        case '4':
          $movimentos = Movimento::where('data', $request->search);
          break;

        case '5':
          $movimentos = Movimento::where('natureza', $request->search);
          break;

        case '6':
        $movimentos = Movimento::where('confirmado', $request->search);
          break;

        default:
          redirect()->route('movimentos.index')->with('errors', 'Não foram encontrados resultados');
          break;
      }
      return view('movimentos.index', compact('movimentos'));
    }

    public function create() {
      $this->authorize('create', Movimento::class);
      $movimento = new Movimento();
      return view('movimentos.create',compact('movimento'));

    }

    public function store(Request $request){
      $this->authorize('create', Movimento::class);
      $request->validate([
        'data' => 'required|date_format:"d/m/Y"',//|before(date|after:'.$request->data,
        'hora_descolagem' => 'required|date_format:"H:i"',//|before:'.$request->hora_aterragem,
        'hora_aterragem' => 'required|date_format:"H:i"', //|after:'.$request->hora_descolagem,
        'natureza' => 'required|in:T,I,E',
        'aerodromo_partida' => 'required|string|max:20|Exists:aerodromos,code',
        'aerodromo_chegada' => 'required|string|max:20|Exists:aerodromos,code',
        'num_aterragens' => 'required|integer|min:1',
        'num_descolagens' => 'required|integer|min:1',
        'num_pessoas' => 'required|integer|min:1',
        'tempo_voo' => 'required|integer|min:0',
        'preco_voo' => 'required|numeric|min:0',
        'modo_pagamento' => 'required|in:N,M,T,P',
        'tipo_instrucao' => 'nullable|required_if:natureza,I|in:D,S',
        'num_recibo' => 'required|max:20|min:1',
        'confirmado' => 'boolean',
        'aeronave' => 'required|Exists:aeronaves,matricula',
        'piloto_id' => 'required|Exists:users,id',
        'conta_horas_inicio' => 'required|integer|min:0',
        'conta_horas_fim' => 'required|integer|min:0|gt:conta_horas_inicio',
        'instrutor_id' => ['sometimess','nullable','required_if:natureza,I', 'Exists:users,id', new ValidationInstrutor],
        'num_diario' => 'required|integer|min:1',
        'num_servico' => 'required|integer|min:1',
        'classe_certificado_piloto' => 'required',
        'validade_certificado_piloto' => 'required',
      ]);
      $movimento->fill($request->all());
      $movimento->save();
    }


    public function edit(Movimento $movimento){
      $this->authorize('update',$movimento);
        return view('movimentos.edit', compact('movimento'));

    }

    public function update(Request $request, Movimento $movimento){
     $this->authorize('update',$movimento);
     $request->validate([
        'data' => 'required|date_format:"d/m/Y"',//|before(date|after:'.$request->data,
        'hora_descolagem' => 'required|date_format:"H:i"',//|before:'.$request->hora_aterragem,
        'hora_aterragem' => 'required|date_format:"H:i"', //|after:'.$request->hora_descolagem,
        'natureza' => 'required|in:T,I,E',
        'aerodromo_partida' => 'required|string|max:20|Exists:aerodromos,code',
        'aerodromo_chegada' => 'required|string|max:20|Exists:aerodromos,code',
        'num_aterragens' => 'required|integer|min:1',
        'num_descolagens' => 'required|integer|min:1',
        'num_pessoas' => 'required|integer|min:1',
        'tempo_voo' => 'required|integer|min:0',
        'preco_voo' => 'required|numeric|min:0',
        'modo_pagamento' => 'required|in:N,M,T,P',
        'tipo_instrucao' => 'nullable|required_if:natureza,I|in:D,S',
        'num_recibo' => 'required|max:20|min:1',
        'confirmado' => 'boolean',
        'aeronave' => 'required|Exists:aeronaves,matricula',
        'piloto_id' => 'required|Exists:users,id',
        'conta_horas_inicio' => 'required|integer|min:0',
        'conta_horas_fim' => 'required|integer|min:0|gt:conta_horas_inicio',
        'instrutor_id' => ['sometimess','nullable','required_if:natureza,I', 'Exists:users,id', new ValidationInstrutor],
        'num_diario' => 'required|integer|min:1',
        'num_servico' => 'required|integer|min:1',
        'classe_certificado_piloto' => 'required',
        'validade_certificado_piloto' => 'required',
      ]);
      $movimento->fill($request->all());
      $movimento->save();

      return redirect()
        ->route('movimento.index')
        ->with('success', 'Movimento editado com sucesso!');

    }

    public function destroy(Movimento $movimento){
      $movimento->delete();
      return redirect()
        ->route('movimento.index')
        ->with('success', 'Movimento apagado com sucesso!');


    }

    public function estatisticas(){
      $movimentos = Movimento::all();
      return view('movimentos.estatisticas', compact('movimentos'));
    }

    public function getEstatisticas(Request $request){

      $ano = $request->ano;
      $mes = $request->mes;
      $tipo = $request->tipo;

      $time = [];
      $control = 0;
      $users = User::all();
      $planes = Aeronave::all();
      $movimentos = [];

      // -----------------------------------------------------
      foreach($users as $user){
        $movimentos[] = Movimento::whereMonth('data', $mes)
          ->whereYear('data', $ano)
          ->where('piloto_id', $user->id)
          ->get();
      }


      foreach($movimentos as $mov){
        for($i=0;$i<sizeof($mov);$i++){
          $time[$i] = $mov[$i];        
        }
      }


    }
}
