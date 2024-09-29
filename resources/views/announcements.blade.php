@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(!auth()->user()->is_admin)
                    <form method="POST" action="{{ route('announcements.store') }}">
                        @csrf
                        <div class="mt-2">
                            <label>Title:</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label>Body:</label>
                            <textarea name="body" class="form-control" required></textarea>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </form>
                    @endif

                    <div class="mt-4">
                        <h3>Announcements</h3>
                        <div id="announcement-container" class="row">
                            @foreach ($announcements as $announcement)
                                <div class="col-md-4 mb-4 announcement-card" data-id="{{ $announcement->id }}">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $announcement->title }}</h5>
                                            <p class="card-text">{{ $announcement->body }}</p>
                                            <p class="card-text"><small class="text-muted">Created at: {{ $announcement->created_at }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script")
<script type="module">
    window.Echo.channel("announcements")
        .listen(".create", (e) => {
            console.log("Received announcement data:", e); // Log the received data
            insertAnnouncement(e); // Call the function to insert announcement
        });

    // Function to insert announcement into HTML
    function insertAnnouncement(announcement) {
        const container = document.getElementById('announcement-container');
        if (container) {
            // Create a new announcement card using the data received
            const announcementHtml = `
                <div class="col-md-4 mb-4 announcement-card" data-id="${announcement.id}">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">${announcement.title}</h5>
                            <p class="card-text">${announcement.body}</p>
                            <p class="card-text"><small class="text-muted">Created at: ${announcement.created_at}</small></p>
                        </div>
                    </div>
                </div>
            `;

            // Append the new announcement to the container
            container.insertAdjacentHTML('afterbegin', announcementHtml);
        } else {
            console.error("Announcement container not found!");
        }
    }
</script>
@endsection
