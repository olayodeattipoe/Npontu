@extends('layouts.app')

@section('content')
<div class="activities-container">
    <div class="activities-header">
        <h1>Activities</h1>
        <div class="actions">
            <a href="{{ route('activities.daily-report') }}" class="btn-secondary">
                <i class="fas fa-calendar-day"></i> Daily Report
            </a>
            <a href="{{ route('activities.custom-report') }}" class="btn-secondary">
                <i class="fas fa-chart-line"></i> Custom Report
            </a>
        </div>
    </div>
    
    <div class="activities-list">
        @forelse($activities as $activity)
        <div class="activity-card">
            <div class="activity-status {{ $activity->status }}"></div>
            <div class="activity-content">
                <h3>{{ $activity->title }}</h3>
                <p>{{ $activity->description }}</p>
                <div class="activity-meta">
                    <span class="priority {{ $activity->priority }}">{{ ucfirst($activity->priority) }} Priority</span>
                    <span class="due-time">Due: {{ $activity->due_date->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="no-activities">
            <p>No activities found.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .activities-container {
        padding: 24px;
    }

    .activities-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .activities-header h1 {
        color: #ffffff;
        margin: 0;
    }

    .actions {
        display: flex;
        gap: 12px;
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
        background: #383838;
    }

    .activities-list {
        display: grid;
        gap: 16px;
    }

    .activity-card {
        background: #181818;
        border-radius: 8px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s;
    }

    .activity-card:hover {
        transform: translateX(4px);
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
        font-size: 16px;
    }

    .activity-content p {
        color: #b3b3b3;
        margin: 0;
        font-size: 14px;
    }

    .activity-meta {
        display: flex;
        gap: 16px;
        margin-top: 8px;
    }

    .priority {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 4px;
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

    .no-activities {
        text-align: center;
        padding: 24px;
        background: #181818;
        border-radius: 8px;
        color: #b3b3b3;
    }

    @media (max-width: 768px) {
        .activities-header {
            flex-direction: column;
            gap: 16px;
            align-items: flex-start;
        }

        .actions {
            width: 100%;
            flex-direction: column;
        }

        .btn-secondary {
            width: 100%;
            justify-content: center;
        }

        .activity-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .activity-status {
            margin-bottom: 8px;
        }
    }
</style>
@endsection 