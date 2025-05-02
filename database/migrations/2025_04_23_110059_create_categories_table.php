<?php

use App\Filament\Resources\DepartmentResource\RelationManagers\CategoriesRelationManager;
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
        //create Category after the creating department and at the time of editing department then will stored these data
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('department_id')
                ->index()->constrained();

            $table->foreignID('parent_id')
                ->nullable()
                ->index()
                ->constrained('categories');
            $table->boolean('active')
                ->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
