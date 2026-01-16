<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_movies', function (Blueprint $table) {
            $table->id();


            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');


            $table->string('movie_id', 20);
            $table->string('primary_img', 511)->default('')->nullable();
            $table->string('primary_title', 255)->nullable();
            $table->string('original_title', 255)->nullable();
            $table->year('start_year')->nullable();

            $table->enum('status', ['to_watch', 'watched', 'in_progress'])
                ->default('to_watch');


            $table->tinyInteger('user_rating')
                ->unsigned()
                ->nullable()
                ->check('user_rating >= 0 AND user_rating <= 10');


            $table->text('comment')->nullable();
            $table->boolean('is_favourite')->nullable();

            $table->timestamp('updated_at');
            $table->timestamp('created_at')->useCurrent();



            $table->unique(['user_id', 'movie_id']);


            $table->index('status');
            $table->index('user_rating');

            $table->index('created_at');


            $table->index('primary_title');
            $table->index('start_year');
            $table->index('is_favourite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_movies');
    }
};
