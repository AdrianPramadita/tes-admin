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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        if(session("iLogged") == false || session("iLogged") == null){
            return redirect('login');
        }

        $permission = (new PermissionuserHandler)->getPermissionFromCurrentUrl($this->properties->activeUrl);
        if($permission->update == false && $request->query('disabled') == ""){
            return view('Errors.permission-denied',
                array(
                    "properties" => $this->properties,
                )
            );
        }

        try{
            $event = DB::table("im_event")->select("*")->where("id", $request->query('id'))->first();

            $store = DB::table("im_store_master")->select("*")
            ->whereNull("deleted_at")
            ->where("active_flag", "active")
            ->orderBy("im_store_master.created_at", "ASC")
            ->get();

            $str_group = DB::table("im_store_group")->select("*")
            ->whereNull("deleted_at")
            ->where("status", "active")
            ->orderBy("created_at", "ASC")
            ->get();

            $import_prd = DB::table("temporary_import_prd")->select("*")
            ->whereNull("deleted_at")
            ->orderBy("id", "ASC")
            ->get();
            // return $import_prd;

            return view('Master.Event.update-event',
                array(
                    "properties" => $this->properties,
                    "id" => $request->query('id'),
                    "store" => $store,
                    "str_group" => $str_group,
                    "data" => $event,
                    "import" => $import_prd,
                    "disabled" => $request->query('disabled'),
                    "permission" => $permission,
                )
            );
        }catch(\Exception $e){
            return view('Errors.system-errors',
                array(
                    "properties" => $this->properties,
                    "message" => $e->getMessage(),
                )
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(session("iLogged") == false || session("iLogged") == null){
            return redirect('login');
        }

        $this->validate($request, [
            'event_code' => 'required|max:255',
        ]);

        $permission = (new PermissionuserHandler)->getPermissionFromCurrentUrl($this->properties->activeUrl);

        DB::beginTransaction();
        try{
            if($permission->update == false){
                throw new Exception('You dont have permission to write data. Please contact your administrator');
            }

            /** data salesman */
            $spg = DB::table('master_salesman')->select('*')->where("id", $request->id)->first();

            // $securePass = $spg->password;
            // if($request->password != ""){
            //     $bcrypt = new Bcrypt();
            //     $securePass = $bcrypt->create($request->password);
            // }

            DB::table("im_event")
            ->where("id", $request->id)
            ->update([
                "event_code" => $request->event_code,
                "event_desc" => $request->event_desc,
                "store_id" => $request->store_id,
                "disc_type" => $request->disc_type,
                "disc1" => str_replace(",", "", $request->disc1),
                "disc2" => str_replace(",", "", $request->disc2),
                "disc_opt1" => $request->disc_opt1,
                "disc_opt2" => $request->disc_opt2,
                "margin" => str_replace(",", "", $request->margin),
                "margin_opt" => $request->margin_opt,
                "participation" => str_replace(",", "", $request->participation),
                "special_price" => str_replace(",", "", $request->special_price),
                "date_from" => date('Y-m-d', strtotime($request->date_from)),
                "date_to" => date('Y-m-d', strtotime($request->date_to)),
                "status" => "active",
                "updated_by" => session("user_id"),
                "updated_at" => now(),
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(session("iLogged") == false || session("iLogged") == null){
            return redirect('login');
        }
        
        $permission = (new PermissionuserHandler)->getPermissionFromCurrentUrl($this->properties->activeUrl);

        DB::beginTransaction();
        try{
            if($permission->destroy == false){
                throw new Exception('You dont have permission to write data. Please contact your administrator');
            }

            DB::table("im_event")
            ->where("id", $request->id)
            ->update([
                "deleted_by" => session("user_id"),
                "deleted_at" => now(),
            ]);

            DB::commit();
            return response([
                "message" => "Success! data has been removed.",
            ])->setStatusCode(200);
        }catch(\Exception $e){
            DB::rollback();
            return response([
                "message" => "Failed! ". $e->getMessage(),
                "errors" => $e,
            ])->setStatusCode(500);
        }
    }

    public function storeGroup(Request $request)
    {
        $store = DB::table("im_store_master")->select("*")
            ->whereNull("deleted_at")
            ->where("store_group", $request->group_id)
            ->where("active_flag", "active")
            ->orderBy("im_store_master.created_at", "ASC")
            ->get();

        return collect($store)->map(function($v){
            return $v->id;
        });
    }

    public function active(Request $request)
    {
            
        $currentDate = date('Y-m-d', strtotime('now'));

        $evt = DB::table("im_event")->select("*")
        ->whereNull("deleted_at")
        ->where("date_from", ">=", $currentDate)
        ->orderBy("created_at", "ASC")
        ->update([
            "status" => "active",
        ]);
        // ->get();

        // return $evt;
    }

    public function inActive(Request $request)
    {
            
        $currentDate = date('Y-m-d', strtotime('now'));

        $evt = DB::table("im_event")->select("*")
        ->whereNull("deleted_at")
        ->where("date_to", "<", $currentDate)
        ->orderBy("created_at", "ASC")
        ->update([
            "status" => "in-active",
        ]);
        // ->get();

        // return $evt;
    }

    public function importExcel(Request $request)
    {
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('Downloads', $namaFile);
        
        $input = $request->input_alphanum;
        
        // import data
        $filePath = public_path('/Downloads/' . $namaFile);

        // $result = Excel::import(new ProduksImport, $filePath);
        $array = Excel::toArray(new ProduksImport, $filePath);
        // return $array;
        // print_r ($array[0]);
        foreach ($array[0] as $value) {
            // print_r ($value);
            $createTemp = EventPrd::insertGetId([
                "prd_code" => $value[1],
                "prd_name" => $value[2],
                "category" => $value[3],
                "brand" => $value[4],
                "session_id" => $input,
            ]);            
        };
	    
        DB::table("temporary_import_prd")->whereNull('prd_code')->where('prd_code', '=', 'Produk Kode')->delete();

        // notifikasi dengan session
        // Session::flash('sukses','Data Produk Berhasil Diimport!');
    
        // alihkan halaman kembali
        return redirect('/master/event/create?session='.$input);
    }
}
