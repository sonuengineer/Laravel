<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('priority',['LOW','MEDIUM','HIGH']);
            $table->enum('status',['TODO','WIP','DONE','OVERDUE',"IN_PROGRESS"]);
            $table->date('due_date');
            $table->foreignId('assigned_to')->constrained('users');
            $table->foreignId('project_id')->constrained('projects');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tasks');
    }
};
