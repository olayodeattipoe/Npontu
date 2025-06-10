@extends('layouts.app')

@section('content')
<div class="report-container">
    <div class="report-header">
        <h1>Custom Activity Report</h1>
        <div class="actions">
            <form action="{{ route('activities.custom-report') }}" method="GET" class="date-form">
                <div class="date-inputs">
                    <input type="date" name="start_date" value="{{ request('start_date', now()->subDays(7)->format('Y-m-d')) }}" class="form-control" onchange="this.form.submit()">
                    <span>to</span>
                    <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="form-control" onchange="this.form.submit()">
                </div>
            </form>
            <a href="{{ route('activities.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Activities
            </a>
        </div>
    </div>

    <div class="report-grid">
        <div class="report-card">
            <div class="report-card-header">
                <h3>Activity Summary</h3>
            </div>
            <div class="report-card-content">
                <div class="stat-item">
                    <span class="stat-label">Total Activities</span>
                    <span class="stat-value">{{ $activities->count() }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Completed</span>
                    <span class="stat-value">{{ $activities->where('status', 'done')->count() }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Pending</span>
                    <span class="stat-value">{{ $activities->where('status', 'pending')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="activities-section">
        <h2>Activities from {{ request('start_date') }} to {{ request('end_date') }}</h2>
        <div class="activities-list">
            @foreach($activities as $activity)
            <div class="activity-card">
                <div class="activity-status {{ $activity->status }}"></div>
                <div class="activity-content">
                    <h3>{{ $activity->title }}</h3>
                    <p>{{ $activity->description }}</p>
                    <div class="activity-meta">
                        <span class="priority {{ $activity->priority }}">
                            {{ ucfirst($activity->priority) }} Priority
                        </span>
                        <span class="due-time">
                            Due: {{ $activity->due_date->format('M d, Y H:i') }}
                        </span>
                    </div>
                    <div class="activity-updates">
                        <h4>Updates</h4>
                        @foreach($activity->updates as $update)
                        <div class="update-item">
                            <div class="update-header">
                                <span class="update-status {{ $update->status }}">{{ ucfirst($update->status) }}</span>
                                <span class="update-time">{{ $update->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            <p class="update-remark">{{ $update->remark }}</p>
                            <div class="update-user">
                                By: {{ $update->user->name }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .report-container {
        padding: 24px;
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .report-header h1 {
        color: #ffffff;
        margin: 0;
    }

    .actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .date-form {
        margin: 0;
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .date-inputs {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .date-inputs span {
        color: #b3b3b3;
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

    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .report-card {
        background: #181818;
        border-radius: 8px;
        overflow: hidden;
    }

    .report-card-header {
        padding: 16px;
        background: #282828;
    }

    .report-card-header h3 {
        color: #ffffff;
        margin: 0;
        font-size: 18px;
    }

    .report-card-content {
        padding: 16px;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #282828;
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .stat-label {
        color: #b3b3b3;
    }

    .stat-value {
        color: #ffffff;
        font-weight: 600;
        font-size: 18px;
    }

    .activities-section {
        margin-top: 32px;
    }

    .activities-section h2 {
        color: #ffffff;
        margin: 0 0 24px;
    }

    .activities-list {
        display: grid;
        gap: 24px;
    }

    .activity-card {
        background: #181818;
        border-radius: 8px;
        padding: 24px;
        display: flex;
        gap: 24px;
    }

    .activity-status {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .activity-status.pending {
        background: #ffd700;
    }

    .activity-status.done {
        background: #1ed760;
    }

    .activity-content {
        flex: 1;
    }

    .activity-content h3 {
        color: #ffffff;
        margin: 0 0 8px;
    }

    .activity-content p {
        color: #b3b3b3;
        margin: 0 0 16px;
    }

    .activity-meta {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }

    .priority {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
    }

    .priority.high {
        background: rgba(255, 0, 0, 0.1);
        color: #ff4444;
    }

    .priority.medium {
        background: rgba(255, 193, 7, 0.1);
        color: #ffd700;
    }

    .priority.low {
        background: rgba(29, 185, 84, 0.1);
        color: #1db954;
    }

    .due-time {
        color: #b3b3b3;
        font-size: 12px;
    }

    .activity-updates {
        margin-top: 24px;
    }

    .activity-updates h4 {
        color: #ffffff;
        margin: 0 0 16px;
    }

    .update-item {
        background: #242424;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
    }

    .update-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .update-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
    }

    .update-status.pending {
        background: rgba(255, 215, 0, 0.1);
        color: #ffd700;
    }

    .update-status.done {
        background: rgba(30, 215, 96, 0.1);
        color: #1ed760;
    }

    .update-time {
        color: #b3b3b3;
        font-size: 12px;
    }

    .update-remark {
        color: #ffffff;
        margin: 0 0 8px;
    }

    .update-user {
        color: #b3b3b3;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .report-grid {
            grid-template-columns: 1fr;
        }

        .date-form {
            flex-direction: column;
            align-items: stretch;
        }

        .date-inputs {
            flex-direction: column;
            align-items: stretch;
        }
    }

    /* Date picker styles */
    input[type="date"] {
        background: #282828;
        color: #ffffff;
        border: 1px solid #404040;
        padding: 8px 12px;
        border-radius: 4px;
        font-family: 'Montserrat', sans-serif;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }

    /* Style the date picker popup */
    ::-webkit-datetime-edit {
        color: #ffffff;
    }

    ::-webkit-datetime-edit-fields-wrapper {
        color: #ffffff;
    }

    ::-webkit-datetime-edit-text {
        color: #ffffff;
    }

    ::-webkit-datetime-edit-month-field,
    ::-webkit-datetime-edit-day-field,
    ::-webkit-datetime-edit-year-field {
        color: #ffffff;
    }

    /* Style the calendar popup */
    ::-webkit-calendar-picker {
        background-color: #ffffff;
        color: #000000;
    }

    /* For Firefox */
    input[type="date"]::-moz-calendar-picker-indicator {
        filter: invert(1);
    }

    /* For the calendar popup in Firefox */
    input[type="date"]::-moz-calendar-picker {
        background-color: #ffffff;
        color: #000000;
    }

    /* For Edge */
    input[type="date"]::-ms-clear {
        display: none;
    }

    input[type="date"]::-ms-reveal {
        display: none;
    }

    /* For the calendar popup in Edge */
    input[type="date"]::-ms-calendar-picker {
        background-color: #ffffff;
        color: #000000;
    }
</style>
@endsection 