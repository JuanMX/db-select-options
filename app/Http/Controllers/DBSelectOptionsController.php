<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
Use Exception;
use App\Http\Requests\DBSelectOptionsRequest;

class DBSelectOptionsController extends Controller
{
    /**
     * Display the main view.
     */
    public function index(Request $request, string $DBSelectOptions)
    {
        if(str_ends_with($DBSelectOptions, env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH')) && Schema::hasTable($DBSelectOptions)){
            return view('db-select-options', [
                'DBSelectOptions' => $DBSelectOptions
            ]);
        }
        else{
            abort(500);
        }
    }

    /**
     * Return a listing of the resource.
     */
    public function read(DBSelectOptionsRequest $request){

        $jsonReturn = array('success'=>false,'data'=>[]);
        
        try {
            $jsonReturn['data'] = DB::table($request->DBSelectOptions)
                                        ->select('*')
                                        ->whereNull('deleted_at')
                                        ->get()
                                        ->toArray();

            $jsonReturn['success'] = True;
        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = array("Error reading stored data");
            return response()->json($jsonReturn, 404);
        }

        return response()->json($jsonReturn);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(DBSelectOptionsRequest $request)
    {
        $jsonReturn = array('success'=>false, 'error'=>[], 'data'=>[]);
        
        try {
            $record = DB::table($request->DBSelectOptions)->insert([
                'name' => $request->name,
                'created_at' => now(),
            ]);

            $jsonReturn['success'] = true;
        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = array("Can not create the record");
            return response()->json($jsonReturn, 500);
        }
        
        return response()->json($jsonReturn);
    }

    /**
     * Update the specified non-deleted resource in storage.
     */
    public function update(DBSelectOptionsRequest $request)
    {
        $jsonReturn = array('success'=>false, 'error'=>[], 'data'=>[]);

        try{
            $record = DB::table($request->DBSelectOptions)
                    ->where('id', $request->id)
                    ->whereNull('deleted_at')
                    ->update(['name' => $request->name, 'updated_at' => now()]);

            $jsonReturn['success'] = true;

        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = array("Can not update the record");
            return response()->json($jsonReturn, 500);
        }

        return response()->json($jsonReturn);
    }

    /**
     * Remove (throughth softdelete) the specified resource from storage.
     */
    public function delete(DBSelectOptionsRequest $request)
    {
        
        $jsonReturn = array('success'=>false, 'error'=>[], 'data'=>[]);

        try{
            $record = DB::table($request->DBSelectOptions)->where('id', $request->id)->whereNull('deleted_at')->update(['deleted_at' => now()]);

            $jsonReturn['success'] = true;

        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = array("Can not delete the record");
            return response()->json($jsonReturn, 500);
        }

        return response()->json($jsonReturn);
    }
}
