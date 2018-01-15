<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;
use Weblee\Mandrill\Mail;
use asies\Http\Requests;
use asies\Models\Cargos;
use asies\Models\TiEmpleados;
use asies\Models\Personas;
use asies\User;
use Bican\Roles\Models\Role;
use Illuminate\Support\Facades\Log;
use \Auth;
use View;
use PDF;
use Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function viewCreate(Request $request){
		$cargos= Cargos::all();
		$tiempleados= TiEmpleados::all();
		$roles = Role::where('id','<>',1)->get();	  
		return view('users/create',array("usuario" => '',"persona"=>'',"cargos" => $cargos,"tiempleados" => $tiempleados,"roles" => $roles));
	}

	public function viewEdit(Request $request,$id){
		$user = User::where('id',$id)->first();
		$persona = Personas::where('cpersona',$user->cpersona)->first();
		$cargos= Cargos::all();
		$tiempleados= TiEmpleados::all();
		$roles = Role::where('id','<>',1)->get();			  
		return view('users/create',array("usuario" => $user,"persona" => $persona,"cargos" => $cargos,"tiempleados" => $tiempleados,"roles" => $roles));
	}

	public function viewList(Request $request){
		if ($request->isMethod('get')){
			$usuarios = user::all();
			return view( 'users/list' , array("usuarios" => $usuarios));
		}
	}
	
	public function create(Request $request){
		$dataBody = $request->all();
		$persona = new Personas();
		$usuario = new User();
		$mensajes = array(
			'unique' => ': Ya en el sistema',
			'min' => ': Su contraseña debe contener minimo 6 caracteres',
			'email' => ': Escriba un correo verdadero',
			'confirmed' => ': No coinciden las contraseñas'
		);
		$validator = Validator::make($dataBody,
			[
				'nombres' => 'required|max:255',
				'apellidos' => 'required|max:255',
				'identificacion' => 'required|max:255|unique:personas',
				'direccion' => 'required|max:255',
				'telefono' => 'required|max:255',
				'celular' => 'required|max:255',
				'email' => 'required|email|max:255|unique:users',
				'ccargo' => 'required|exists:cargos',
				'ctiempleado' => 'required|exists:tiempleados',
				'password' => 'required|min:6|confirmed',
			],$mensajes
		);
		$persona->identificacion = $dataBody['identificacion'];
		$persona->nombres = $dataBody['nombres'];
		$persona->apellidos = $dataBody['apellidos'];
		$persona->direccion = $dataBody['direccion'];
		$persona->telefono = $dataBody['telefono'];
		$persona->celular = $dataBody['celular'];
		$persona->email = $dataBody['email'];
		$persona->ccargo = $dataBody['ccargo'];
		$persona->ctiempleado = $dataBody['ctiempleado'];
		$usuario->name = $dataBody['nombres'].' '.$dataBody['apellidos'];
		$usuario->email = $dataBody['email'];
		$usuario->password = bcrypt($dataBody['password']);
		$usuario->active = 1;
		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}else{
			$user = Auth::user();
			$persona->save();
			$usuario->cpersona = $persona->cpersona;
			$usuario->save();
			$usuario->attachRole($dataBody['role_id']);

			Log::info('Creacion de Persona,',[
				'user' => $user->id,
				'nombres' => $dataBody['nombres'], 
				'apellidos' => $dataBody['apellidos'], 
				'identificacion' => $dataBody['identificacion'], 
				'direccion' => $dataBody['direccion'], 
				'telefono' => $dataBody['telefono'], 
				'celular' => $dataBody['celular'], 
				'email' => $dataBody['email'], 
				'ccargo' => $dataBody['ccargo'], 
				'ctiempleado ' => $dataBody['ctiempleado']
			]);
			Log::info('Creacion de Usuario,',[
				'user' => $user->id,
				'nombres' => $dataBody['nombres'], 
				'email' => $dataBody['email'], 
				'password' => $dataBody['password'], 
				'cpersona ' => $persona->cpersona
			]);
		}


		return response()->json(array("obj"=>$dataBody));
	}

	public function edit(Request $request,$id){
		$dataBody = $request->all();
		$usuario = User::where('id',$id)->first();
		$persona = Personas::where('cpersona',$usuario->cpersona)->first();
		$mensajes = array(
			'unique' => ': Ya en el sistema',
			'min' => ': Su contraseña debe contener minimo 6 caracteres',
			'email' => ': Escriba un correo verdadero',
		);
		$validator = Validator::make($dataBody,
			[
				'nombres' => 'required|max:255',
				'apellidos' => 'required|max:255',
				'identificacion' => 'required|max:255|unique:personas',
				'direccion' => 'required|max:255',
				'telefono' => 'required|max:255',
				'celular' => 'required|max:255',
				'email' => 'required|email|max:255|unique:users',
				'ccargo' => 'required|exists:cargos',
				'ctiempleado' => 'required|exists:tiempleados',
				'password' => 'required|min:6',
			],$mensajes
		);
		$persona->identificacion = $dataBody['identificacion'];
		$persona->nombres = $dataBody['nombres'];
		$persona->apellidos = $dataBody['apellidos'];
		$persona->direccion = $dataBody['direccion'];
		$persona->telefono = $dataBody['telefono'];
		$persona->celular = $dataBody['celular'];
		$persona->email = $dataBody['email'];
		$persona->ccargo = $dataBody['ccargo'];
		$persona->ctiempleado = $dataBody['ctiempleado'];
		$usuario->name = $dataBody['nombres'].' '.$dataBody['apellidos'];
		$usuario->email = $dataBody['email'];
		$usuario->password = bcrypt($dataBody['password']);
		$usuario->active = 1;
		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}else{
			$user = Auth::user();
			$persona->save();
			$usuario->cpersona = $persona->cpersona;
			$usuario->save();
			$usuario->attachRole($dataBody['role_id']);

			Log::info('Edicion de Persona,',[
				'user' => $user->id,
				'nombres' => $dataBody['nombres'], 
				'apellidos' => $dataBody['apellidos'], 
				'identificacion' => $dataBody['identificacion'], 
				'direccion' => $dataBody['direccion'], 
				'telefono' => $dataBody['telefono'], 
				'celular' => $dataBody['celular'], 
				'email' => $dataBody['email'], 
				'ccargo' => $dataBody['ccargo'], 
				'ctiempleado ' => $dataBody['ctiempleado']
			]);
			Log::info('Edicion de Usuario,',[
				'user' => $user->id,
				'nombres' => $dataBody['nombres'], 
				'email' => $dataBody['email'], 
				'password' => $dataBody['password'], 
				'cpersona ' => $persona->cpersona
			]);
		}


		return response()->json(array("obj"=>$dataBody));
	}

	public function change(Request $request,$id){
		$dataBody = $request->all();	
		$status = 0;
		$response = '';
		$usuario = User::where('id',$id)->first();
		//var_dump($usuario->active);exit();
		if($usuario->active == 1){
			$usuario->active = 2;
		}else{
			$usuario->active = 1;
		}
		if($usuario->save()){
			$response = "¡Cambio realizado con exito!";
			$status = 200;
		}else{
			$response = "Error al realizar el cambio";
			$status = 404;
		}
		return response()->json(array("message"=>$response,"status" => $status));
	}
}
