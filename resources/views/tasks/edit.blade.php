@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Edit Task</h2>

            <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
                </div>

                <div class="form-group mt-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ $task->description }}</textarea>
                </div>

                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-3">Update Task</button>
            </form>
        </div>
    </div>
</div>
@endsection
