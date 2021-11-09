<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Schools;
use App\Models\Student;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use DB;
use Auth; 
use JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255|unique:schools',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:4',
        ]);
        $schools = Schools::create([   
            'name' => $request->name
        ]);
        $user = User::create([
            'email' => $request->email,
            'schools_id' => $schools->id,
            'password' => Hash::make($request->password),
        ]); 

        $user->roles()->attach($request->role); 
        
        return response()->json(['message' => 'Registration Successful.'], 201);
    }

    public function login(Request $request)
    {  
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) { 
            $status = 200; 
            $user = Auth::user(); 
            $response = [ 
                    'user' => array_merge(
                                $user->toArray(), 
                                ['roles' => $user->roles()->get()->toArray()],
                                ['Schools' => Schools::where('id',$user->schools_id)->first()]
                            ), 
                    'token' => JWTAuth::fromUser($user), 
            ]; 
        }  else { 
            $status = 422;
            $response = ['error' => 'The email or password is incorrect.'];
        }

        return response()->json($response, $status);
    }

    public function getUser()
    {
        $user = auth()->user();

        $data = array_merge(
                $user->toArray(), 
                ['roles' => $user->roles()->get()->toArray()],
                ['Schools' => Schools::where('id',$user->schools_id)->first()]
            );
        return response()->json($data, 200);
    }

    public function getUserByAdmin()
    {
        $user = auth()->user();
        $student = DB::table('role_user')
            ->join('users','role_user.user_id','=','users.id')
            ->join('roles','role_user.role_id','=','roles.id')
            ->join('student','users.id','=','student.users_id')
            ->where(['users.schools_id' => $user->schools_id,'roles.name' => 'STUDENT'])
            ->get(['users.id','users.email','student.student']);

        $teacher = DB::table('role_user')
            ->join('users','role_user.user_id','=','users.id')
            ->join('roles','role_user.role_id','=','roles.id')
            ->join('teachers','users.id','=','teachers.users_id')
            ->where(['users.schools_id' => $user->schools_id,'roles.name' => 'TEACHER'])
            ->get(['users.id','users.email','teachers.teacher']);

        $data = [
            'status' => 200,
            'message' => 'Success',
            'data' => [
                'getStudent' => $student,
                'getTeacher' => $teacher,
                'student' => Student::where('users_id',$user->id)->first(),
                'teacher' => Teachers::where('users_id',$user->id)->first()
            ]
        ];
        return response()->json($data, 200);
    }

    public function createStundent(Request $request, $type)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);
        try {
            $user = auth()->user();
            DB::beginTransaction();
            $pass = explode("@",$request->email);
            $userDB = User::create([
                'email' => strtolower($request->email),
                'schools_id' => $user->schools_id,
                'password' => Hash::make($pass[0]),
            ]); 
            DB::table('role_user')->insert(['user_id' => $userDB->id, 'role_id' => ($type == 'student' ? '3' : '2')]);
            if($type == 'student'){
                DB::table('student')->insert(['users_id' => $userDB->id, 'student' => strtolower($request->name)]);
            }else{
                DB::table('teachers')->insert(['users_id' => $userDB->id, 'teacher' => strtolower($request->name)]);
            }
            DB::commit();
            $data = [
                'status' => 200,
                'message' => 'Success insert data',
            ];
            return response()->json($data, 200);
        } catch (\exception $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function deleteStundent($id)
    {
        DB::beginTransaction();
        try {
            DB::table('users')->where('id', $id)->delete();
            DB::table('student')->where('users_id', $id)->delete();
            DB::table('role_user')->where('user_id', $id)->delete();
            DB::commit();
            $data = [
                'status' => 200,
                'message' => 'Success delete student',
            ];
            return response()->json($data, 200);
        } catch (\exception $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
    }
    
    public function deleteTeacher($id){
        DB::beginTransaction();
        try {
            DB::table('users')->where('id', $id)->delete();
            DB::table('teachers')->where('users_id', $id)->delete();
            DB::table('role_user')->where('user_id', $id)->delete();
            DB::commit();
            $data = [
                'status' => 200,
                'message' => 'Success delete teacher',
            ];
            return response()->json($data, 200);
        } catch (\exception $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function email($id,$type){
        $user = DB::table('users')->where('id',$id)->first();
        if($type == 'STUDENT'){
            $data = [
                'title' => 'Student SmartJen',
                'user'  => $user
            ];
        }else{
            $data = [
                'title' => 'Teacher SmartJen',
                'user'  => $user
            ];
        }
        Mail::to($user->email)->send(new Email($data));
        return response()->json([
            "status" => 200,
            "message" => "Success invite"
        ]);
    }
}
