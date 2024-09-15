<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Only add the column if it doesn't already exist
        if (!Schema::hasColumn('posts', 'slug')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('slug')->unique()->after('title'); // Add slug column
            });
        }

        // Generate slugs for existing posts if slugs are empty
        $posts = \App\Models\Post::whereNull('slug')->get();
        foreach ($posts as $post) {
            $post->slug = \Illuminate\Support\Str::slug($post->title, '-');
            $post->save();
        }
    }

    public function down()
    {
        if (Schema::hasColumn('posts', 'slug')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};


