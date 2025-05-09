<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campuses_select_options', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->timestamps();
            $table->comment('Table for HTML select options purposes. This table name needs to end with: '. env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH'));
        });

        DB::table('campuses_select_options')->insert(['name' => 'North', 'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses_select_options');
    }
};
