<?php

use App\Models\Pesticide;
use App\Models\PestType;
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
        Schema::create('pesticide_pest_type', function (Blueprint $table) {
            $table->foreignIdFor(Pesticide::class);
            $table->foreignIdFor(PestType::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesticide_pest_type');
    }
};
