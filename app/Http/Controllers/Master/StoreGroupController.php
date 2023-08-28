<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use App\Models\strGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Zend\Crypt\Password\Bcrypt;
use App\Http\Controllers\Handlers\PermissionuserHandler;
use Exception;

class StoreGroupController extends Controller
{
    public function __construct()
    {
        $this->properties = [
            "header" => "Group Store",
            "activeUrl" => "/master/group-store"
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
        $grpStore = DB::table('im_store_group')->select(
            'im_store_group.*',
        )
        // ->leftJoin("im_store_master", "im_store_master.id", "=", "im_store_group.store_id")
        ->whereNull('im_store_group.deleted_at')
        ->orderBy("im_store_group.created_at", "ASC")
        ->get();
        // return $grpStore;

        return view('Master.StoreGroup.storeGroup',
            array(
                "properties" => $this->properties,
                "data" => $grpStore,
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function openForm()
    {
        $store = DB::table("im_store_master")->select("*")
        ->whereNull("deleted_at")
        ->where("active_flag", "active")
        ->orderBy("im_store_master.created_at", "ASC")
        ->get();

        // return $spg;

        return view('Master.StoreGroup.add-storeGroup',
            array(
                "properties" => $this->properties,
                "store" => $store,
                "disabled" => "",
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
        // dd($request->all());
        $request->validate([
            'group_code' => 'required|max:255',
            'group_desc' => 'required|max:255',
        ]);

        $str_group = [
            "store_group_code" => $request->group_code,
            "store_group_desc" => $request->group_desc,
            "status" => "active",
            "created_by" => session("user_id"),
            "created_at" => now(),
        ];
        strGroup::insert($str_group);
        // return $str_group;

        if($str_group){
            return back()->with('success');
        }else{
            return back()->with('failed');
        }
        return json_encode(
        array(
            "statusCode" => 200
        )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        
        // $request->validate([
        //     'group_code' => 'required|max:255',
        //     'group_desc' => 'required|max:255',
        // ]);

        // $str_group = DB::table("im_store_group")->insert([
        //     "store_group_code" => $request->group_code,
        //     "store_group_desc" => $request->group_desc,
        //     "status" => "active",
        //     "created_by" => session("user_id"),
        //     "created_at" => now(),
        // ]);
        // return $str_group;

        // if($str_group){
        //     return back()->with('success');
        // }else{
        //     return back()->with('failed');
        // }

        // DB::beginTransaction();
        // try{
        //     // $bcrypt = new Bcrypt();
        //     // $securePass = $bcrypt->create($request->password);

        //     $str_group = DB::table("im_store_group")->insert([
        //         "store_group_code" => $request->group_code,
        //         "store_group_desc" => $request->group_desc,
        //         "status" => "active",
        //         "created_by" => session("user_id"),
        //         "created_at" => now(),
        //     ]);
        //     return $str_group;

        //     DB::commit();
        //     return response([
        //         "message" => "Success! data has been saved.",
        //     ])->setStatusCode(200);
        // }catch(\Exception $e){
        //     DB::rollback();
        //     return response([
        //         "message" => "Failed! ". $e->getMessage(),
        //         "errors" => $e,
        //     ])->setStatusCode(500);
        // }
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
            $grpStore = DB::table("im_store_group")->select("*")->where("id", $request->query('id'))->first();

            return view('Master.StoreGroup.update-storeGroup',
                array(
                    "properties" => $this->properties,
                    "id" => $request->query('id'),
                    "data" => $grpStore,
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
            'group_code' => 'required|max:255',
        ]);

        $permission = (new PermissionuserHandler)->getPermissionFromCurrentUrl($this->properties->activeUrl);

        DB::beginTransaction();
        try{
            if($permission->update == false){
                throw new Exception('You dont have permission to write data. Please contact your administrator');
            }

            /** data salesman */
            // $grpStore = DB::table('im_store_group')->select('*')->where("id", $request->id)->first();

            DB::table("im_store_group")
            ->where("id", $request->id)
            ->update([
                "store_group_code" => $request->group_code,
                "store_group_desc" => $request->group_desc,
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

            DB::table("im_store_group")
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
}