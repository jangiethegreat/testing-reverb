@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Task List</h2>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create Task</a>

            @if ($tasks->isEmpty())
                <p>No tasks available.</p>
            @else
                <div class="row" id="task-container">
                    @foreach ($tasks as $task)
                        <div class="col-md-4 mb-4 task-card" data-id="{{ $task->id }}">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ $task->description }}</p>
                                    <p class="card-text">
                                        <strong>Status: </strong>{{ $task->status }}
                                    </p>
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section("script")
<script type="module">
    // Function to insert a new task card into the view
    function insertTask(task) {
        const container = document.getElementById('task-container');
        if (container) {
            const taskHtml = `
                <div class="col-md-4 mb-4 task-card" data-id="${task.id}">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${task.title}</h5>
                            <p class="card-text">${task.description}</p>
                            <p class="card-text"><strong>Status: </strong>${task.status}</p>
                            <a href="/tasks/${task.id}/edit" class="btn btn-warning">Edit</a>
                        </div>
                    </div>
                </div>
            `;

            // Insert the new task card at the top of the task container
            container.insertAdjacentHTML('afterbegin', taskHtml);
        } else {
            console.error("Task container not found!");
        }
    }

    // Listen for the 'task_create' event via Laravel Echo
    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.channel("tasks")
            .listen(".task_create", (e) => {
                console.log("New task received:", e); // Log the received task data
                insertTask(e); // Call the function to insert the task
            });
    });


     // Function to remove the task card if it meets the condition
     function removeTask(taskId) {
        const taskCard = document.querySelector(`.task-card[data-id="${taskId}"]`);
        if (taskCard) {
            taskCard.remove();  // Remove the task card from the DOM
        }
    }

    // Listen for task_updated event
    document.addEventListener('DOMContentLoaded', function () {
        window.Echo.channel("tasks")
            .listen(".task_updated", (e) => {
                console.log("Task updated:", e);

                // If the task is marked as completed, remove it from the view
                if (e.status === 'completed') {
                    removeTask(e.id);
                } else {
                    // Optionally, update the task card with the new details
                    const taskCard = document.querySelector(`.task-card[data-id="${e.id}"]`);
                    if (taskCard) {
                        taskCard.querySelector('.card-title').textContent = e.title;
                        taskCard.querySelector('.card-text').textContent = e.description;
                        taskCard.querySelector('.card-text small').textContent = `Status: ${e.status}`;
                    }
                }
            });
    });
</script>
@endsection


