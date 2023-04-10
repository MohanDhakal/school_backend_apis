<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    
    public $successStatus = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = DB::table('users')->get();
        return $admins;  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(Request $request){ 

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
             $exceptionMessage =ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
            // Log::error($exceptionMessage);
            return response()->json(['error' => "The provided credentials are incorrect"], 400);            

        }

        $expires_at = now()->addMinutes(60); 
        $new_access_token = $user->createToken($user->name,['expires_in' => 60],$expires_at);        
        $access_token = $new_access_token->accessToken;            
        $response= [
            'success'=>true,
            'message'=>"user logged in successfully",
            'access_token'=>$new_access_token->plainTextToken,
            'expires_in_min'=> $access_token->abilities['expires_in'],
            'expires_at'=>$expires_at,
        ];
        return response()->json($response, 200);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'c_password' => 'required|string|min:8|same:password',
        ];        //validation
        
        $messages = [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'The password must be at least :min characters long.',
            'password.confirmed' => 'The password and confirmation password do not match.',
            'c_password.required' => 'Please confirm your password.',
            'c_password.min' => 'The confirmation password must be at least :min characters long.',
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){            
            $errors = $validator->errors();
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);

        }else{
            //return success
            $input= $request->all();
            $input['password']= bcrypt($input['password']);
            $input['c_password']= bcrypt($input['c_password']);
                 
            $user=User::create($input);
            $tokenName = $user->name . $user->id;
            $success['name'] = $user->name;  

            $new_access_token = $user->createToken($tokenName,['expires_in' => 60],);        
            $access_token = $new_access_token->accessToken;            
            $response= [
                'success'=>true,
                'message'=>"user registered successfully",
                'access_token'=>$new_access_token->plainTextToken,
                'expires_in_min'=> $access_token->abilities['expires_in'],
            ];
            return response()->json($response,200);
           }
    }
}
