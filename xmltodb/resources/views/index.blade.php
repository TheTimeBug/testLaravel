@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Logo & Icons Management</h1>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIconModal">
                <i class="fas fa-plus"></i> Add New Icon
            </button>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Filter by Type</label>
                        <select class="form-select" id="iconTypeFilter">
                            <option value="">All Types</option>
                            <option value="1">Logos</option>
                            <option value="2">Icons</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search by title or tag...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Icons Grid -->
    <div class="row" id="iconsGrid">
        @foreach($logoIcons as $icon)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div class="card-img-top text-center pt-3">
                    @if($icon->icon_location)
                        <img src="{{ asset($icon->icon_location) }}" alt="{{ $icon->icon_title }}" class="icon-image">
                    @else
                        <div class="no-image">No Image</div>
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $icon->icon_title }}</h5>
                    <p class="card-text">
                        <span class="badge {{ $icon->icon_type == 1 ? 'bg-primary' : 'bg-secondary' }}">
                            {{ $icon->icon_type == 1 ? 'Logo' : 'Icon' }}
                        </span>
                        <span class="badge bg-info">{{ $icon->icon_tag }}</span>
                    </p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-sm btn-primary edit-btn" data-id="{{ $icon->id }}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $icon->id }}">Delete</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addIconModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Icon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="iconForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="iconId" name="id">
                        
                        <div class="mb-3">
                            <label for="iconTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="iconTitle" name="icon_title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="iconType" class="form-label">Type</label>
                            <select class="form-select" id="iconType" name="icon_type" required>
                                <option value="1">Logo</option>
                                <option value="2">Icon</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="iconTag" class="form-label">Tag</label>
                            <input type="text" class="form-control" id="iconTag" name="icon_tag" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="iconFile" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="iconFile" name="icon_file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Filter by icon type
        $('#iconTypeFilter').change(function() {
            filterIcons();
        });
        
        // Search functionality
        $('#searchInput').keyup(function() {
            filterIcons();
        });
        
        function filterIcons() {
            const typeFilter = $('#iconTypeFilter').val();
            const searchQuery = $('#searchInput').val().toLowerCase();
            
            $('#iconsGrid .col-md-3').each(function() {
                let card = $(this);
                let title = card.find('.card-title').text().toLowerCase();
                let tag = card.find('.bg-info').text().toLowerCase();
                let type = card.find('.badge:first').hasClass('bg-primary') ? '1' : '2';
                
                let typeMatch = typeFilter === '' || type === typeFilter;
                let textMatch = title.includes(searchQuery) || tag.includes(searchQuery);
                
                if (typeMatch && textMatch) {
                    card.show();
                } else {
                    card.hide();
                }
            });
        }
        
        // Open modal for new icon
        $('[data-bs-target="#addIconModal"]').click(function() {
            $('#modalTitle').text('Add New Icon');
            $('#iconForm').attr('action', '{{ route("logo.store") }}');
            $('#iconForm').attr('method', 'POST');
            $('#iconId').val('');
            $('#iconForm')[0].reset();
        });
        
        // Edit icon
        $(document).on('click', '.edit-btn', function() {
            const iconId = $(this).data('id');
            
            $.ajax({
                url: `/logo/get/${iconId}`,
                type: 'GET',
                success: function(response) {
                    $('#modalTitle').text('Edit Icon');
                    $('#iconForm').attr('action', `/logo/update/${iconId}`);
                    $('#iconForm').attr('method', 'POST');
                    $('#iconId').val(iconId);
                    
                    $('#iconTitle').val(response.icon_title);
                    $('#iconType').val(response.icon_type);
                    $('#iconTag').val(response.icon_tag);
                    
                    $('#addIconModal').modal('show');
                }
            });
        });
        
        // Delete icon
        $(document).on('click', '.delete-btn', function() {
            if (confirm('Are you sure you want to delete this icon?')) {
                const iconId = $(this).data('id');
                
                $.ajax({
                    url: `/logo/delete/${iconId}`,
                    type: 'DELETE',
                    success: function() {
                        location.reload();
                    }
                });
            }
        });
        
        // Form submission
        $('#iconForm').submit(function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = new FormData(this);
            
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    $('#addIconModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    // Display validation errors
                    for (let field in errors) {
                        $(`#${field}`).addClass('is-invalid');
                        $(`#${field}`).after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                    }
                }
            });
        });
    });
</script>
@endsection