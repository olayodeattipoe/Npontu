@extends('layouts.app')

@section('content')
<div class="team-container">
    <h1>Team Members</h1>
    
    <div class="team-grid">
        @foreach($users as $user)
        <div class="team-card">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-info">
                <h3>{{ $user->name }}</h3>
                <p class="user-email">{{ $user->email }}</p>
                <span class="user-role">{{ ucfirst($user->role) }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .team-container {
        padding: 24px;
    }

    .team-container h1 {
        color: #ffffff;
        margin-bottom: 24px;
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
    }

    .team-card {
        background: #181818;
        border-radius: 8px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s;
    }

    .team-card:hover {
        transform: translateY(-2px);
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        background: #282828;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #1db954;
    }

    .user-info {
        flex: 1;
    }

    .user-info h3 {
        color: #ffffff;
        margin: 0 0 4px;
    }

    .user-email {
        color: #b3b3b3;
        margin: 0 0 8px;
        font-size: 14px;
    }

    .user-role {
        display: inline-block;
        padding: 4px 12px;
        background: #282828;
        color: #1db954;
        border-radius: 12px;
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .team-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection 