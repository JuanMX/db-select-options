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
        Schema::create('student_types_select_options', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->timestamps();
            $table->softDeletes('deleted_at');
            $table->comment('Table for HTML select options purposes. This table name needs to end with: '. env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH'));
        });

        DB::table('student_types_select_options')->insert(['name' => 'Full-Time', 'created_at' => now()]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_types_select_options');
    }
};
