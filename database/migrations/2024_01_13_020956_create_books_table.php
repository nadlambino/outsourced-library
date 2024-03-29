<?php

use App\Models\Author;
use App\Models\Library;
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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Library::class)
                ->references('id')
                ->on('libraries')
                ->restrictOnDelete();
            $table->foreignIdFor(Author::class)
                ->references('id')
                ->on('authors')
                ->restrictOnDelete();
            $table->string('title');
            $table->boolean('is_borrowed')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
