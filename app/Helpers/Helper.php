<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;



if (!function_exists('pluckDBSelectOptions')) {
    function pluckDBSelectOptions(string $table_select_options)
    {
        $result = array('placeholder'=>'Error', 'data'=>[]);
        
        try {
            if(str_ends_with($table_select_options, env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH')) && Schema::hasTable($table_select_options)){
                $result['data'] = DB::table($table_select_options)->pluck('name','id')->toArray();
                $result['placeholder'] = 'Please select...';
            }
            else{
                Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . __LINE__ . '): ' . 'The table in database does not exists or name not ends with: ' . env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH') );
            }
        } catch(\Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Line: ' . $e->getLine() . '): ' . $e->getMessage());
            return $result;
        }
        
        return $result;
    }
}
if(!function_exists('projectRoot')){
    function projectRoot(){
        return \Request::root();
    }
}