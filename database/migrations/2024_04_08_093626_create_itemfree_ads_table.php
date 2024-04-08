<?php

use App\Models\User;
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
        Schema::create('itemfree_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->integer("freetimes") ->default('0')->nullable();
            $table->string("titleImageurl")->nullable();
            $table->integer("price_range")->nullable();
            $table->string("usedOrnew")->nullable();
            $table->string("productName")->nullable();
            $table->string("categories")->nullable();
            $table->string("description")->nullable();
            $table->string("negotiation")->nullable();
            $table->string("state")->nullable();
            $table->string("local_gov")->nullable();
            $table->string("headlines")->nullable();
            $table->string('itemadsid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itemfree_ads');
    }
};
