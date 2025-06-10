@extends('layouts.app')

@section('content')
<div class="dashboard-grid">
    <!-- Quick Stats -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>Completed Tasks</h3>
                <p class="stat-number">{{ $completedCount }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>Pending Tasks</h3>
                <p class="stat-number">{{ $pendingCount }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-info">
                <h3>Today's Tasks</h3>
                <p class="stat-number">{{ $todayCount }}</p>
            </div>
        </div>
    </div>

    <!-- Add Task Button -->
    <div class="action-bar">
        <button class="btn-add-task" onclick="openTaskModal()">
            <i class="fas fa-plus"></i> Add New Task
        </button>
    </div>

    <!-- Today's Activities -->
    <div class="activities-section">
        <h2>Today's Activities</h2>
        <div class="activities-list">
            @php
                $today = \Carbon\Carbon::today();
                $todayActivities = $activities->filter(function ($activity) use ($today) {
                    return \Carbon\Carbon::parse($activity->created_at)->isSameDay($today);
                });
            @endphp
            @forelse($todayActivities as $activity)
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
                <div class="activity-actions">
                    <button class="btn-update" onclick="updateTaskStatus({{ $activity->id }})">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            </div>
            @empty
            <div class="no-activities">
                <p>No activities for today.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Task Modal -->
<div id="taskModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Task</h2>
            <button class="close-modal" onclick="closeTaskModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="taskForm" class="task-form" action="{{ route('activities.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="taskTitle">Task Title</label>
                <input type="text" id="taskTitle" name="title" class="form-control" required placeholder="Enter task title">
                @error('title')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="taskDescription">Description</label>
                <textarea id="taskDescription" name="description" class="form-control" rows="3" placeholder="Enter task description"></textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="taskPriority">Priority</label>
                <select id="taskPriority" name="priority" class="form-control" required>
                    <option value="">Select priority</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
                @error('priority')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="taskStatus">Status</label>
                <select id="taskStatus" name="status" class="form-control" required>
                    <option value="">Select status</option>
                    <option value="pending">Pending</option>
                    <option value="done">Done</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="taskDueDate">Due Date</label>
                <input type="datetime-local" id="taskDueDate" name="due_date" class="form-control" required>
                @error('due_date')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-primary">Create Task</button>
        </form>
    </div>
</div>

<!-- Update Status Modal -->
<div id="updateStatusModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Update Task Status</h2>
            <button class="close-modal" onclick="closeUpdateModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="updateStatusForm" class="task-form">
            @csrf
            <input type="hidden" id="taskId" name="task_id">
            <div class="form-group">
                <label for="updateStatus">Status</label>
                <select id="updateStatus" name="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="done">Done</option>
                </select>
            </div>
            <div class="form-group">
                <label for="updateRemark">Remark</label>
                <textarea id="updateRemark" name="remark" class="form-control" rows="3" required placeholder="Add any remarks about the status update"></textarea>
            </div>
            <button type="submit" class="btn-primary">Update Status</button>
        </form>
    </div>
</div>

<style>
    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        gap: 24px;
        padding: 24px;
    }

    /* Stats Container */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #181818;
        border-radius: 8px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #1db954;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #000000;
    }

    .stat-info h3 {
        color: #b3b3b3;
        font-size: 14px;
        margin: 0;
    }

    .stat-number {
        color: #ffffff;
        font-size: 24px;
        font-weight: 600;
        margin: 4px 0 0;
    }

    /* Action Bar */
    .action-bar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 24px;
    }

    .btn-add-task {
        background: #1db954;
        color: #000000;
        border: none;
        padding: 12px 24px;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-add-task:hover {
        background: #1ed760;
        transform: scale(1.02);
    }

    /* Activities Section */
    .activities-section {
        background: #181818;
        border-radius: 8px;
        padding: 24px;
    }

    .activities-section h2 {
        color: #ffffff;
        margin: 0 0 24px;
        font-size: 20px;
    }

    .activities-list {
        display: grid;
        gap: 16px;
    }

    .activity-card {
        background: #242424;
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

    .activity-status.in-progress {
        background: #1db954;
    }

    .activity-status.completed {
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

    .activity-actions {
        display: flex;
        gap: 8px;
    }

    .btn-update {
        background: none;
        border: none;
        color: #b3b3b3;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .btn-update:hover {
        color: #ffffff;
        background: #383838;
    }

    .btn-danger {
        width: 100%;
        padding: 12px;
        background: #ff4444;
        color: #ffffff;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-danger:hover {
        background: #ff0000;
        transform: scale(1.02);
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #181818;
        border-radius: 8px;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 24px;
        border-bottom: 1px solid #282828;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        color: #ffffff;
        margin: 0;
        font-size: 20px;
    }

    .close-modal {
        background: none;
        border: none;
        color: #b3b3b3;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .close-modal:hover {
        color: #ffffff;
        background: #282828;
    }

    .task-form {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        color: #b3b3b3;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        background: #121212;
        border: 1px solid #282828;
        border-radius: 4px;
        color: #ffffff;
        font-size: 14px;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: #1db954;
        outline: none;
        background: #1a1a1a;
    }

    .btn-primary {
        width: 100%;
        padding: 12px;
        background: #1db954;
        color: #000000;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: #1ed760;
        transform: scale(1.02);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-grid {
            padding: 16px;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .activity-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .activity-status {
            margin-bottom: 8px;
        }

        .activity-actions {
            width: 100%;
            justify-content: flex-end;
            margin-top: 16px;
        }
    }

    .no-activities {
        text-align: center;
        padding: 24px;
        background: #181818;
        border-radius: 8px;
        color: #b3b3b3;
    }

    .error-message {
        color: #ff4444;
        font-size: 12px;
        margin-top: 4px;
    }
</style>

<script>
    function openTaskModal() {
        document.getElementById('taskModal').classList.add('active');
    }

    function closeTaskModal() {
        document.getElementById('taskModal').classList.remove('active');
        document.getElementById('taskForm').reset();
    }

    function openUpdateModal(taskId) {
        document.getElementById('taskId').value = taskId;
        document.getElementById('updateStatusModal').classList.add('active');
    }

    function closeUpdateModal() {
        document.getElementById('updateStatusModal').classList.remove('active');
        document.getElementById('updateStatusForm').reset();
    }

    function updateTaskStatus(taskId) {
        openUpdateModal(taskId);
    }

    // Handle form submissions
    document.getElementById('taskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("activities.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.message) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (error.errors) {
                Object.entries(error.errors).forEach(([field, messages]) => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'error-message';
                        errorDiv.textContent = messages[0];
                        input.parentNode.appendChild(errorDiv);
                    }
                });
            } else {
                alert('An error occurred while creating the task.');
            }
        });
    });

    document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const taskId = document.getElementById('taskId').value;
        const formData = new FormData(this);
        
        fetch(`/activities/${taskId}/status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(data => {
            if (data.message) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the activity status.');
        });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const taskModal = document.getElementById('taskModal');
        const updateModal = document.getElementById('updateStatusModal');
        if (event.target === taskModal) {
            closeTaskModal();
        }
        if (event.target === updateModal) {
            closeUpdateModal();
        }
    }
</script>
@endsection
