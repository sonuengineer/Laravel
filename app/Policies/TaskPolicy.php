public function update(User $user, Task $task){
    if($user->role==='admin') return true;
    return $user->id === $task->user_id;
}
