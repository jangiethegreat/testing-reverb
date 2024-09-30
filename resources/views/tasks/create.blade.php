@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Create Task</h2>

            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>

                <div class="form-group mt-3">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>

                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success mt-3">Create Task</button>
            </form>
        </div>
    </div>
</div>
@endsection
