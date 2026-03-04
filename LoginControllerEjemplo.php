<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Auth;
use Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Usuario;
use App\Providers\AccessMails;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Psy\Readline\Hoa\Console;

class LoginController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectAfterLogout = '/login';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    protected function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function getData($email,$password){
        
    }

    ## Función que hace la redirección al servicio web de logueo
    ## htttp://localhost/login
    public function login(Request $request){
        
        $validador = Validator::make($request->all(),[
            'email' => 'required|email|ends_with:uaemex.mx',
        ]);

        if ($validador->fails()) {
            return redirect()->route('login')->with('status' ,'Debe acceder con un correo institucional valido.');
        }

        $accessToken = config('tenan.token'); // d5ca350b-7159-4b51-94f8-128c1f169546-31108eedff37ecsefds2c8a404654596
        $ldapApiUrl = config('tenan.url'); // https://wsauth.dev.uaemex.mx/ldap/api/v2/autenticar/ldap/api/v2/autenticar
        
        $url = $ldapApiUrl . '?access_token=' . $accessToken . '&correo=' . urlencode($request->email);
        #$url = 'https://wsauth.dev.uaemex.mx/ldap/api/v2/autenticar/ldap/api/v2/autenticar?access_token=d5ca350b-7159-4b51-94f8-128c1f169546-31108eedff37ecsefds2c8a404654596&correo='.urlencode($request->email);
        return redirect($url);
    }

    ## Función que recibe la respuesta del login en la nube 
    ## htttp://localhost/auth/callback
    public function azureCallback(Request $request){

        if ($request->data == null) {
            $status = 401;
            return redirect()->route('login')->with('status' ,'Servicio no disponible.');
        }

        #Decodificamos los datos recibidos
        #dentro de la respuesta recibida, la información se regresa codificada en base64 
        $data = base64_decode($request->data);
        $jsonData = json_decode($data,true);
        $error = $jsonData['error'];
        $mensaje = $jsonData['mensaje'];

        if($error == 0){
            $empleado = $jsonData['empleado'];
            $correo = $empleado['correo'];
            $clave = $empleado['clave'];
            #Hay una segunda verificación que de momento es opcional y consiste en hacer una petición a la url https://wsauth.dev.uaemex.mx/ldap/api/v2/autorizar
            #Esa verificación es la que se muestra a continuación
            //Validamos que el correo no este vacio
            if(!empty($correo)){
                 $access_token = config('tenan.token'); 
                 $response = Http::post('https://wsauth.dev.uaemex.mx/ldap/api/v2/autorizar', [                    
                        'access_token' => $access_token,
                        'clave' => $clave
                    ]);
                if($response->successful()){
                    $datos = $response->json();
                    $correo_empleado = $datos['correo'];
                    $verificado = $datos['verificado'];
                    if($verificado == 1 && strcmp($correo,$correo_empleado) == 0){
                        ##A partir de este momento es cuando se implementa la logica de inicio de sesión que correspanda al sistema desarrollado
                        $usuario = User::where('email', $correo)->where('activo', true)->get();
                
                        //Validamos que encuentre un registro en BD con el correo ingresado
                        if(count($usuario) > 0){
                            $nombre = $usuario[0]['name'];
                            $numero_empleado = $usuario[0]['numero_empleado'];
                        # $roles = User::with('rol')->where('id', $usuario[0]['id'])->get();
                        # $rol = $roles[0]['rol'];

                            $status = 200;
                            $data = [
                                'error' => 0,
                                'empleado' =>[
                                    'id' => $usuario[0]['id'],
                                    'nombre' => $nombre,
                                    'numero_empleado' => $numero_empleado,
                                    'rol' => 1,
                                    'espacios' => [],
                                    'fotografia' => ''
                                ],
                                'message' => 'Registro encontrado.',
                            ];

                            //Autenticamos al usuario y redirigimos al menu principal
                            if(Auth::loginUsingId($data['empleado']['id'])){
                                Session::put('empleado', $data['empleado']);
                                return redirect('inicio');
                            }else{
                                $status = 401;
                                return redirect()->route('login')->with('status' ,'Error al iniciar sesión.');
                            }
                        }else{
                            $status = 401;
                            return redirect()->route('login')->with('status' ,'No cuenta con permisos para acceder a la aplicación.');
                        }
                    }else{
                        $status = 401;
                        return redirect()->route('login')->with('status' ,'1. Error al iniciar sesión.');
                    }
                }else{
                    $status = 401;
                    return redirect()->route('login')->with('status' ,'2. Error al iniciar sesión.');
                }

            }else{
                $status = 401;
                return redirect()->route('login')->with('status' ,'No cuenta con permisos para acceder a la aplicación.');
            }

        }else{
            $status = 401;
            return redirect()->route('login')->with('status' ,$mensaje);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect($this->redirectAfterLogout);
    }

    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
