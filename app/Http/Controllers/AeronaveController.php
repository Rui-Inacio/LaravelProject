<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aeronave;
use App\AeronavesPilotos;
use App\User;
use App\AeronavesValores;
use App\Movimento;
use Illuminate\Support\Facades\Auth;

class AeronaveController extends Controller{

	public function __construct(){
		$this->middleware(['auth', 'verified', 'activated']);
	}

	public function index(){
		$planes = Aeronave::all();
		return view('planes.index', compact('planes'));
	}

	public function create(){
		$this->authorize('create', Aeronave::class);
		$plane = new Aeronave();
		return view('planes.create', compact('plane'));
	}

	public function store(Request $request){
		$this->authorize('create', Aeronave::class);

		$this->validate($request, [
			'matricula' => 'required|max:8',
			'marca' => 'required|max:40',
			'modelo' => 'required|max:40',
			'conta_horas' => 'required|integer|min:0',
			'num_lugares' => 'required|integer|min:1',
			'preco_hora' => 'required|numeric|min:0'
		]);

		$plane = new Aeronave;
		$plane->fill($request->all());
		$plane->save();
		self::newMapping($plane);

		return redirect()
			->route('planes.index')
			->with('success', 'Aeronave criada com sucesso!');

	}

	public function edit(Aeronave $plane){
		$this->authorize('edit', $plane);
		$maps = AeronavesValores::where('matricula', $plane->matricula)->get();
		return view('planes.edit', compact('plane', 'maps'));
	}

	public function update(Request $request, Aeronave $plane){
		$this->authorize('edit', $plane);
		$this->validate($request, [
			'matricula' => 'required|max:8',
			'marca' => 'required|max:40',
			'modelo' => 'required|max:40',
			'conta_horas' => 'required|integer|min:0',
			'num_lugares' => 'required|integer|min:1',
			'preco_hora' => 'required|numeric|min:0',
			'minutos.*' => 'required|numeric|min:0|max:60',
			'preco.*' => 'required|numeric'
         ]);

		$plane->fill($request->only([
			'matricula',
			'marca',
			'modelo',
			'conta_horas',
			'num_lugares',
			'preco_hora'
		]));
		$plane->save();

		$maps = AeronavesValores::where('matricula', $plane->matricula)->get();	

		for($i=0;$i<10;$i++){
			$maps[$i]->minutos = $request->minutos[$i];
			$maps[$i]->preco = $request->preco[$i];
			$maps[$i]->save();
		}


		return redirect()
			->route('planes.index')
			->with('success', 'Aeronave editada com sucesso!');

	}

	public function isAssociated(Aeronave $plane){
		$movs = Movimento::all();
		foreach ($movs as $mov) {
			if($mov->aeronave == $plane->matricula){
				return true;
			}else{
				return false;
			}
		}
	}

	public function destroy(Aeronave $plane){

		$this->authorize('destroy', $plane);

		if(self::isAssociated($plane)){
			//dd('softDelete')
			$plane->delete();
		}else{
			//dd('hardDelete');
			$plane->forceDelete();
		}

		return redirect()
			->route('planes.index')
			->with('success', 'Aeronave apagada com sucesso!');
	}

// Mostrar, adicionar e remover pilotos -----------------------------------------------------------


	public function mostrarPilotos(Aeronave $plane){
		$this->authorize('pilotos', $plane);
		$aeroPilots = AeronavesPilotos::where('matricula', '=', $plane->matricula)->get();
		$ids = [];
		for($i=0;$i<sizeof($aeroPilots);$i++){
			$ids[$i] = $aeroPilots[$i]->piloto_id;
		}
		$pilotos = User::find($ids);
		return view('planes.pilotos.index', compact('plane', 'pilotos'));
	}

	public function addPiloto(Aeronave $plane){
		$this->authorize('pilotos', $plane);
		$aps = AeronavesPilotos::where('matricula', $plane->matricula)->get();
		$users= [];
		foreach ($aps as $ap) {
			$users = User::where('id', '!=', $ap->piloto_id)->get();	
		}
		return view('planes.pilotos.add', compact('plane', 'users'));
	}

	public function storePiloto( Aeronave $plane, User $user){
		$this->authorize('pilotos', $plane);
		$aeroPilot = new AeronavesPilotos();
		$id = $user->id;
		$matricula = $plane->matricula;
		$aeroPilot->fill(['piloto_id' => $id, 'matricula' => $matricula]);
		$aeroPilot->save();
		return redirect()
			->route('pilotos.index', $plane)
			->with('success', 'Piloto adicionado com sucesso!');
	}

	public function deletePiloto(Aeronave $plane, User $piloto){
		$this->authorize('pilotos', $plane);
		$mat = $plane->matricula;
		$id = $piloto->id;

		$forDeleate = AeronavesPilotos::where('matricula', $mat)->where('piloto_id', $id)->get();
		$forDeleate[0]->delete();
	 	return redirect()
	 		->route('pilotos.index', $plane)
	 		->with('success', 'Piloto removido com sucesso!');
	}

	// --------------------------------------------- Mapear valores para aeronave ---------------

	public function newMapping(Aeronave $plane){

		$preco = $plane->preco_hora / 10;
		$map = [10];

		for($i=0;$i<10;$i++){
			$map[$i] = new AeronavesValores;
			$map[$i]->matricula = $plane->matricula;
			$map[$i]->unidade_conta_horas = $i+1;
			$map[$i]->minutos = ($i+1) * 6;
			$map[$i]->preco = $preco * ($i+1);
			$map[$i]->save();
		}

	}

	public function getMapping(Aeronave $plane){
		$map = AeronavesValores::where('matricula', $plane->matricula)->get();
		return response()->json($map);
	}

	public function linhaGrafico(Aeronave $plane){
		return view('planes.graph', compact('plane'));
	}

	public function makeGraph(Request $request, Aeronave $plane){
		
		
	}

}
