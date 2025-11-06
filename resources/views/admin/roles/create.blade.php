@extends('layouts.admin')
@section('page_title', 'Add Role')

@section('content')
<h4>Add New Role</h4>

<form action="{{ route('admin.roles.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="role_name" class="form-label">Role Name</label>
        <input type="text" name="role_name" id="role_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection
