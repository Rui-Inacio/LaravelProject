<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware(['auth', 'verified', 'activated']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        //$users = User::where('ativo',1)->paginate(15);
        //$this->validate($request, [
            //'num_socio' => 'nullable|integer|max:10',
            //'nome_informal' => 'nullable|alpha|max:40',
            //'email' => 'nullable|email',
            //'direcao' => 'nullable|between:0,1',
            //'tipo_socio' => 'nullable',
            
        //]);
        $users = $this->indexFiltros($request);
        return view('users.index', compact( 'users'));
        
        
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $this->authorize('create', User::class);
        $user = new User();
        $user->data_nascimento = date('d/m/Y', strtotime($user->data_nascimento));
        return view('users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Zà-Ú ]+$/|max:255',
            'nome_informal' => 'required|string|max:40',
            'email' => ['required' ,'email', Rule::unique('users')->ignore($user->id)],
            'nif' => 'nullable|digits:9',
            'data_nascimento' => 'required|date_format:"d/m/Y"',
            'telefone' => 'nullable|max:20',
            'file_foto' => 'image',
            'num_licenca' => 'max:30',
            'tipo_licenca' => 'nullable||Exists:tipos_licencas,code',
            'validade_licenca' => 'required|date_format:"d/m/Y"',
            'num_certificado'=> 'max:30',
            'classe_certificado' => 'nullable||Exists:classes_certificados,code', 
            'validade_certificado' => 'required|date_format:"d/m/Y"',
            'file_licenca' => 'mimes:pdf',
            'file_certificado' => 'mimes:pdf',
            'num_socio' => ['numeric','min:0' , Rule::unique('users')->ignore($user->id)],
            'sexo' => 'required|in:M,F',
            'tipo_socio' => 'required|in:P,NP,A',
            'quota_paga' => 'required|in:1,0',
            'ativo' => 'required|in:1,0',
            'direcao' => 'required|in:1,0',
            'aluno' => 'required|in:1,0|different:instrutor',
            'instrutor' => 'required|in:1,0|different:aluno',
            'certificado_confirmado' => 'in:1,0',
            'licenca_confirmada' => 'in:1,0',

        ]);

        $user = new User;
        $user->fill($request->all());
        $date = str_replace('/', '-', $user->data_nascimento);
        $user->data_nascimento = date("Y-m-d",strtotime($date));
        $data_criacao = date("Y-m-d");
        $user->password = Hash::make($data_criacao);
        $user->save();

        return redirect()
        ->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function edit($user) //$user tem de ter o mesmo nome que o valor passado na rota;
    {
        $user = User::findOrFail($user);
        $user->data_nascimento = date('d/m/Y', strtotime($user->data_nascimento));
        $this->authorize('edit', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('edit', $user);
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Zà-Ú ]+$/|max:255',
            'nome_informal' => 'required|string|max:40',
            'email' => ['required' ,'email', Rule::unique('users')->ignore($user->id)],
            'nif' => 'nullable|digits:9',
            'data_nascimento' => 'required|date_format:"d/m/Y"',
            'telefone' => 'nullable|max:20',
            'file_foto' => 'image',
            'num_licenca' => 'max:30',
            'tipo_licenca' => 'nullable||Exists:tipos_licencas,code',
            'validade_licenca' => 'required|date_format:"d/m/Y"',
            'num_certificado'=> 'max:30',
            'classe_certificado' => 'nullable||Exists:classes_certificados,code', 
            'validade_certificado' => 'required|date_format:"d/m/Y"',
            'file_licenca' => 'mimes:pdf',
            'file_certificado' => 'mimes:pdf',
            'num_socio' => ['numeric','min:0' , Rule::unique('users')->ignore($user->id)],
            'sexo' => 'required|in:M,F',
            'tipo_socio' => 'required|in:P,NP,A',
            'quota_paga' => 'required|in:1,0',
            'ativo' => 'required|in:1,0',
            'direcao' => 'required|in:1,0',
            'aluno' => 'required|in:1,0|different:instrutor',
            'instrutor' => 'required|in:1,0|different:aluno',
            'certificado_confirmado' => 'in:1,0',
            'licenca_confirmada' => 'in:1,0',

        ]);
         
        if ($user->direcao || $user->tipo_socio === 'P') {
            $user->fill($request->all());
        }
        else{
            $user->fill($request->except(['num_socio','ativo', 'quota_paga','sexo','tipo_socio', 'validade_certificado', 'validade_licenca','num_licenca','tipo_licenca','num_certificado','classe_certificado','direcao','instrutor','aluno', 'certificado_confirmado','licenca_confirmada']));
        }
        
        if(! is_null($request['file_foto'])) {

            Storage::delete( 'public/fotos/' . $user->foto_url);
            $file_foto = $request->file('file_foto');
            $name = $user->id . '_'. time() . '.' . $file_foto->getClientOriginalExtension();

            $path = Storage::putFileAs('public/fotos', $file_foto, $name);
            $user->foto_url = $name;
        }
        
        if(! is_null($request['file_licenca'])) {

            Storage::delete( 'docs_piloto/' . 'licenca_' . $user->id . '.pdf' );
            $file_licenca = $request->file('file_licenca');
            $name = 'licenca_' . $user->id .  '.' . $file_licenca->getClientOriginalExtension();

            $path = Storage::putFileAs('docs_piloto/', $file_licenca, $name);
            $user->licenca_confirmada = NULL;
        }

        if(! is_null($request['file_certificado'])){

            Storage::delete( 'docs_piloto/' . 'certificado_' . $user->id . '.pdf' );
            $file_certificado = $request->file('file_certificado');
            $name = 'certificado' . $user->id .  '.' . $file_licenca->getClientOriginalExtension();

            $path = Storage::putFileAs('docs_piloto/', $file_certificado, $name);
            $user->certificado_confirmado = NULL;
        }
        
        $date = str_replace('/', '-', $user->data_nascimento);
        $user->data_nascimento = date("Y-m-d",strtotime($date));
        
        $data_licenca = str_replace('/', '-', $user->validade_licenca);
        $user->validade_licenca = date("Y-m-d",strtotime($data_licenca));
        
        $data_certificado = str_replace('/', '-', $user->validade_certificado);
        $user->validade_certificado = date("Y-m-d",strtotime($data_certificado));
        
        
        $user->save();

        return redirect()
        ->route('users.index');
            // ->with('success', 'Socio editado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //$this->authorize('delete', $user);

        $user->delete();
        return redirect()
        ->route('users.index');
            //->with('success', 'User deleted successfully!');
    }

    public function reset_quotas()
    {
     $users = User::all();
     foreach ($users as $user) {
        $user->quota_paga = false;
    }   
}


public function indexFiltros(Request $request)
{
        //Somente o campo nome_informal preenchido
    if ($request->filled('nome_informal') && !$request->filled('num_socio') && !$request->filled('email') && !$request->filled('tipo') && !$request->filled('direcao'))
        return User::where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
        //Somente o campo num socio preenchido
    if ($request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email') && !$request->filled('tipo') && !$request->filled('direcao'))
        return User::where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
        //Somente o campo email preenchido
    if ($request->filled('email') && !$request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('tipo') && !$request->filled('direcao'))
        return User::where('email', 'like', "%{$request->query('email')}%")->paginate(15);
        //Somente o direcao preenchido
    if ($request->filled('direcao') && !$request->filled('name') && !$request->filled('status')){
        if ($request->query('direcao') == '1')
            return User::where('direcao', 1)->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('direcao', 0)->paginate(15);
    }
        //Somente o tipo_socio preenchido
    if ($request->filled('tipo') && !$request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('email') && !$request->filled('direcao')){
        if ($request->query('tipo') == 'Não Piloto')
            return User::where('tipo_socio', 'NP')->paginate(15);
        if ($request->query('tipo') == 'Piloto')
            return User::where('tipo_socio', 'P')->paginate(15);
        if ($request->query('tipo') == 'Aeromodelista')
            return User::where('tipo_socio', 'A')->paginate(15);
    }

        //Nome e num socio preenchido
    if ($request->filled('nome_informal') && $request->filled('num_socio') && !$request->filled('email') && !$request->filled('tipo') && !$request->filled('direcao')){
     return User::where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
 }
        //Nome e email preenchido
 if ($request->filled('nome_informal') && $request->filled('email') && !$request->filled('num_socio') && !$request->filled('tipo') && !$request->filled('direcao')){
     return User::where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
 }
        //Nome e direcao preenchido
 if ($request->filled('nome_informal') && $request->filled('direcao') && !$request->filled('email') && !$request->filled('tipo') && !$request->filled('num_socio')){
    if ($request->query('direcao') == '1')
        return User::where('direcao', 1)->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('direcao', 0)->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
        //Nome e tipo_socio preenchido
if ($request->filled('nome_informal') && $request->filled('tipo') && !$request->filled('email') && !$request->filled('direcao') && !$request->filled('num_socio')){
    if ($request->query('tipo') == 'Não Piloto')
        return User::where('tipo_socio', 'NP')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    if ($request->query('tipo') == 'Piloto')
        return User::where('tipo_socio', 'P')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    if ($request->query('tipo') == 'Aeromodelista')
        return User::where('tipo_socio', 'A')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
        //Num socio e Email preenchido
if ($request->filled('email') && $request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('tipo') && !$request->filled('direcao')){
 return User::where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
            //Num Socio e direcao preenchido
if ($request->filled('num_socio') && $request->filled('direcao') && !$request->filled('email') && !$request->filled('tipo') && !$request->filled('nome_informal')){
    if ($request->query('direcao') == '1')
        return User::where('direcao', 1)->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('direcao', 0)->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
            //Num socio e Tipo Socio preenchido
if ($request->filled('num_socio') && $request->filled('tipo') && !$request->filled('email') && !$request->filled('direcao') && !$request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto')
        return User::where('tipo_socio', 'NP')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('tipo') == 'Piloto')
        return User::where('tipo_socio', 'P')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('tipo') == 'Aeromodelista')
        return User::where('tipo_socio', 'A')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
            //Email e direcao preenchido
if ($request->filled('email') && $request->filled('direcao') && !$request->filled('num_socio') && !$request->filled('tipo') && !$request->filled('nome_informal')){
    if ($request->query('direcao') == '1')
        return User::where('direcao', 1)->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('direcao', 0)->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
}
            //Email e Tipo Socio preenchido
if ($request->filled('email') && $request->filled('tipo') && !$request->filled('num_socio') && !$request->filled('direcao') && !$request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto')
        return User::where('tipo_socio', 'NP')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('tipo') == 'Piloto')
        return User::where('tipo_socio', 'P')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('tipo') == 'Aeromodelista')
        return User::where('tipo_socio', 'A')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
}

            //Direcao e Tipo Socio
if($request->filled('direcao') && $request->filled('tipo')  && !$request->filled('email') && !$request->filled('num_socio') && !$request->filled('nome_informal')){
                //Tipo : P e direção
    if ($request->query('admin') == '1' && $request->filled('tipo') == 'Piloto')
        return User::where('admin', 1)->where('tipo_socio','P')->paginate(15);
                //Tipo : P e  Não direção
    if ($request->query('admin') == '0' && $request->filled('tipo') == 'Piloto')
        return User::where('admin', 0)->where('tipo_socio','P')->paginate(15);
                //Tipo : NP e direção
    if ($request->query('admin') == '1' && $request->filled('tipo') == 'Não Piloto')
        return User::where('admin', 1)->where('tipo_socio','NP')->paginate(15);
                //Tipo : NP e  Não direção
    if ($request->query('admin') == '0' && $request->filled('tipo') == 'Não Piloto')
        return User::where('admin', 0)->where('tipo_socio','NP')->paginate(15);
                //Tipo : A e direção
    if ($request->query('admin') == '1' && $request->filled('tipo') == 'Aeromodelista')
        return User::where('admin', 1)->where('tipo_socio','A')->paginate(15);
                //Tipo : A e  Não direção
    if ($request->query('admin') == '0' && $request->filled('tipo') == 'Aeromodelista')
        return User::where('admin', 0)->where('tipo_socio','A')->paginate(15);
}

            //Nome e Numero e Email preenchido
if ($request->filled('email') && $request->filled('num_socio') && $request->filled('nome_informal') && !$request->filled('tipo') && !$request->filled('direcao')){
 return User::where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
//Nome  numero e Direcao preenchido
if ($request->filled('num_socio') && !$request->filled('tipo') && !$request->filled('email') && $request->filled('direcao') && $request->filled('nome_informal')){
    if ($request->query('direcao') == '1'){
         return User::where('direcao', '1')->where('num_socio', '=', "{$request->query('num_socio')}")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    }
    if ($request->query('direcao') == '0')
    {
        return User::where('direcao', '0')->where('num_socio', '=', "{$request->query('num_socio')}")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
}

//Nome  numero e Tipo Socio preenchido
if ($request->filled('num_socio') && $request->filled('tipo') && !$request->filled('email') && !$request->filled('direcao') && $request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto'){
         return User::where('tipo_socio', 'NP')->where('num_socio', '=', "{$request->query('num_socio')}")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        return User::where('tipo_socio', 'P')->where('num_socio', '=', "{$request->query('num_socio')}")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
   return User::where('tipo_socio', 'A')->where('num_socio', '=', "{$request->query('num_socio')}")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
}

//Nome  email e Direcao preenchido
if (!$request->filled('num_socio') && !$request->filled('tipo') && $request->filled('email') && $request->filled('direcao') && $request->filled('nome_informal')){
    if ($request->query('direcao') == '1'){
         return User::where('direcao', '1')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    }
    if ($request->query('direcao') == '0')
    {
        return User::where('direcao', '0')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
}

//Nome  email e Tipo Socio preenchido
if (!$request->filled('num_socio') && $request->filled('tipo') && $request->filled('email') && !$request->filled('direcao') && $request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto'){
         return User::where('tipo_socio', 'NP')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        return User::where('tipo_socio', 'P')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
   return User::where('tipo_socio', 'A')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
}

//Nome  Direcao e Tipo Socio preenchido
if (!$request->filled('num_socio') && $request->filled('tipo') && !$request->filled('email') && $request->filled('direcao') && $request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto'){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('tipo_socio','NP')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('tipo_socio','NP')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        if ($request->query('direcao') == '1')
         return User::where('admin', 1)->where('tipo_socio','P')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
     if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','P')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
    if ($request->query('direcao') == '1')
        return User::where('admin', 1)->where('tipo_socio','A')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','A')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
}
            //Num socio e Email e Direção preenchido
if ($request->filled('email') && $request->filled('num_socio') && !$request->filled('nome_informal') && !$request->filled('tipo') && $request->filled('direcao')){
    if ($request->query('direcao') == '1')
        return User::where('direcao', 1)->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('direcao', 0)->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
            //Num socio e Email e Tipo Socio preenchido
if ($request->filled('num_socio') && $request->filled('tipo') && $request->filled('email') && !$request->filled('direcao') && !$request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto')
        return User::where('tipo_socio', 'NP')->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('tipo') == 'Piloto')
        return User::where('tipo_socio', 'P')->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('tipo') == 'Aeromodelista')
        return User::where('tipo_socio', 'A')->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
}

//Numero  Direcao e Tipo Socio preenchido
if ($request->filled('num_socio') && $request->filled('tipo') && !$request->filled('email') && $request->filled('direcao') && !$request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto'){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('tipo_socio','NP')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('tipo_socio','NP')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        if ($request->query('direcao') == '1')
         return User::where('admin', 1)->where('tipo_socio','P')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
     if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','P')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
    if ($request->query('direcao') == '1')
        return User::where('admin', 1)->where('tipo_socio','A')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','A')->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
}

//Email  Direcao e Tipo Socio preenchido
if (!$request->filled('num_socio') && $request->filled('tipo') && $request->filled('email') && $request->filled('direcao') && !$request->filled('nome_informal')){
    if ($request->query('tipo') == 'Não Piloto'){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        if ($request->query('direcao') == '1')
         return User::where('admin', 1)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
     if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
    if ($request->query('direcao') == '1')
        return User::where('admin', 1)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
}
}

//Numero Nome Email Direcao
if ($request->filled('nome_informal') && $request->filled('num_socio') && $request->filled('email') && $request->filled('direcao') && !$request->filled('tipo')){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
   
}
 
//Numero Nome Email Tipo
if ($request->filled('nome_informal') && $request->filled('num_socio') && $request->filled('email') && !$request->filled('direcao') && $request->filled('tipo')){
    if ($request->query('tipo') == 'Não Piloto')
            return User::where('tipo_socio','NP')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('tipo') == 'Piloto')
         return User::where('tipo_socio','P')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
    if ($request->query('tipo') == 'Aeromodelista')
        return User::where('tipo_socio','A')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->where('email', 'like', "%{$request->query('email')}%")->paginate(15);
}           

//Numero Nome Direção Tipo
if ($request->filled('nome_informal') && $request->filled('num_socio') && !$request->filled('email') && $request->filled('direcao') && $request->filled('tipo')){
    if ($request->query('tipo') == 'Não Piloto'){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('tipo_socio','NP')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('tipo_socio','NP')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        if ($request->query('direcao') == '1')
         return User::where('admin', 1)->where('tipo_socio','P')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
     if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','P')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
    if ($request->query('direcao') == '1')
        return User::where('admin', 1)->where('tipo_socio','A')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','A')->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
}

//Numero email Direção Tipo
if (!$request->filled('nome_informal') && $request->filled('num_socio') && $request->filled('email') && $request->filled('direcao') && $request->filled('tipo')){
    if ($request->query('tipo') == 'Não Piloto'){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        if ($request->query('direcao') == '1')
         return User::where('admin', 1)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
     if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
    if ($request->query('direcao') == '1')
        return User::where('admin', 1)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
}

//Nome email Direção Tipo
if ($request->filled('nome_informal') && !$request->filled('num_socio') && $request->filled('email') && $request->filled('direcao') && $request->filled('tipo')){
    if ($request->query('tipo') == 'Não Piloto'){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        if ($request->query('direcao') == '1')
         return User::where('admin', 1)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
     if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
    if ($request->query('direcao') == '1')
        return User::where('admin', 1)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->paginate(15);
}
}

    //Todos Preenchidos
    //Nome email Direção Tipo
if ($request->filled('nome_informal') && $request->filled('num_socio') && $request->filled('email') && $request->filled('direcao') && $request->filled('tipo')){
    if ($request->query('tipo') == 'Não Piloto'){
        if ($request->query('direcao') == '1')
            return User::where('admin', 1)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
        if ($request->query('direcao') == '0')
            return User::where('admin', 0)->where('tipo_socio','NP')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    }
    if ($request->query('tipo') == 'Piloto')
    {
        if ($request->query('direcao') == '1')
         return User::where('admin', 1)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
     if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','P')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
if ($request->query('tipo') == 'Aeromodelista')
{
    if ($request->query('direcao') == '1')
        return User::where('admin', 1)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
    if ($request->query('direcao') == '0')
        return User::where('admin', 0)->where('tipo_socio','A')->where('email', 'like', "%{$request->query('email')}%")->where('nome_informal', 'like', "%{$request->query('nome_informal')}%")->where('num_socio', '=', "{$request->query('num_socio')}")->paginate(15);
}
}
 
    
    //Nenhum dos campos preenchidos
    return User::where('ativo',1)->paginate(15);
    
}
}
