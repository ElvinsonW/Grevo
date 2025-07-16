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
        Schema::create('trees', function (Blueprint $table) {
            $table->id('treeid');
            $table->string('treename');
            $table->string('treecategory');
            $table->text('treedesc');
            $table->integer('treelife');
            $table->decimal('treeprice', 10, 5);
            $table->string('treephoto');
            $table->unsignedBigInteger('organization_id');
            $table->foreign('organization_id')
                ->references('organization_id')
                ->on('organizations')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trees');
    }
};
