Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description')->nullable();
    $table->date('due_date');
    $table->enum('status',['IN_PROGRESS','DONE','OVERDUE'])->default('IN_PROGRESS');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('project_id')->constrained()->onDelete('cascade');
    $table->timestamps();
});