<?php

use App\Models\Pesticide;
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
        Schema::create('pest_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->text('description', 200)->nullable();
            // $table->foreignIdFor(Pesticide::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pest_types');
    }
};
