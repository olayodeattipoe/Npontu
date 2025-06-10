@extends('layouts.app')

@section('content')
<div class="create-activity-container">
    <div class="create-activity-header">
        <h1>Create New Activity</h1>
        <a href="{{ route('activities.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Activities
        </a>
    </div>

    <form action="{{ route('activities.store') }}" method="POST" class="activity-form">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required placeholder="Enter activity title">
                @error('title')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3" required placeholder="Enter activity description"></textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="priority">Priority</label>
                <select id="priority" name="priority" class="form-control" required>
                    <option value="">Select Priority</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
                @error('priority')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="due_date">Due Date</label>
                <input type="datetime-local" id="due_date" name="due_date" class="form-control" required>
                @error('due_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="sms_count">SMS Count</label>
                <input type="number" id="sms_count" name="sms_count" class="form-control" min="0" placeholder="Enter SMS count">
                @error('sms_count')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="log_sms_count">Log SMS Count</label>
                <input type="number" id="log_sms_count" name="log_sms_count" class="form-control" min="0" placeholder="Enter log SMS count">
                @error('log_sms_count')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="daily_count">Daily Count</label>
                <input type="number" id="daily_count" name="daily_count" class="form-control" min="0" placeholder="Enter daily count">
                @error('daily_count')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="log_count">Log Count</label>
                <input type="number" id="log_count" name="log_count" class="form-control" min="0" placeholder="Enter log count">
                @error('log_count')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Create Activity
            </button>
        </div>
    </form>
</div>

<style>
    .create-activity-container {
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .create-activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .create-activity-header h1 {
        color: #ffffff;
        margin: 0;
    }

    .btn-secondary {
        padding: 12px 24px;
        border-radius: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        background: #282828;
        color: #ffffff;
        text-decoration: none;
    }

    .btn-secondary:hover {
        transform: scale(1.02);
    }

    .activity-form {
        background: #181818;
        border-radius: 8px;
        padding: 24px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        color: #ffffff;
        font-weight: 500;
    }

    .form-control {
        background: #282828;
        border: 1px solid #404040;
        border-radius: 4px;
        padding: 12px;
        color: #ffffff;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #1db954;
        box-shadow: 0 0 0 2px rgba(29, 185, 84, 0.2);
    }

    .form-control::placeholder {
        color: #666666;
    }

    .error-message {
        color: #ff4444;
        font-size: 12px;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
    }

    .btn-primary {
        padding: 12px 24px;
        border-radius: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        background: #1db954;
        color: #000000;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        transform: scale(1.02);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection 