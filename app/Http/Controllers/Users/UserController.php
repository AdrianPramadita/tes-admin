<?php

namespace App\Http\Controllers\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Zend\Crypt\Password\Bcrypt;
use App\Http\Controllers\Handlers\PermissionuserHandler;
use Exception;

class UserController extends Controller
{
    public function __construct()
    {
        $this->properties = [
            "header" => "Users",
            "activeUrl" => "/users/user"
        ];
        $this->properties = (object) $this->properties;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table('users')->select(
            'users.*',
            // 'role_management.role_name'
        )
        // ->leftJoin("role_management", "role_management.id", "=", "users.role_access")
        ->whereNull('users.deleted_at')
        ->orderBy("users.created_at", "ASC")
        ->get();
        // return $user;

        return view('Users.user',
            array(
                "properties" => $this->properties,
                "data" => $user,
                // "permission" => $permission,
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(session("iLogged") == false || session("iLogged") == null){
            return redirect('login');
        }

        $this->validate($request, [
            'full_name' => 'required|max:255',
            'email_address' => 'required|email',
            'password' => 'required|min:8|max:12',
        ]);

        $permission = (new PermissionuserHandler)->getPermissionFromCurrentUrl($this->properties->activeUrl);

        DB::beginTransaction();
        try{
            if($permission->create == false){
                throw new \Exception('You dont have permission to write data. Please contact your administrator');
            }

            $bcrypt = new Bcrypt();
            $securePass = $bcrypt->create($request->password);

            DB::table("users")->insert([
                "name" => $request->full_name,
                "email" => $request->email_address,
                "password" => $securePass,
                "job_title" => $request->job_title,
                "department" => $request->department,
                "address" => $request->address,
                "role_access" => $request->role_access,
                "status" => "active",
                "created_by" => session("user_id"),
                "created_at" => now(),
            ]);

            DB::commit();
            return response([
                "message" => "Success! data has been saved.",
            ])->setStatusCode(200);
        }catch(\Exception $e){
            DB::rollback();
            return response([
                "message" => "Failed! ". $e->getMessage(),
                "errors" => $e,
            ])->setStatusCode(500);
        }
    }
}
