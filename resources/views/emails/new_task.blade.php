<!DOCTYPE html>
<html>
<head>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            color: white !important;
            background-color: #2563eb;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-family: sans-serif;
            font-size: 14px;
        }
        .button:hover { background-color: #1d4ed8; }
    </style>
</head>
<body style="font-family: sans-serif; color: #333; line-height: 1.6;">
    <h2>Hello, {{ $todo->user->name }}!</h2>
    <p>You have been assigned a new task:</p>
    <blockquote style="background: #f3f4f6; padding: 15px; border-left: 5px solid #2563eb; font-style: italic;">
        "{{ $todo->description }}"
    </blockquote>
    <p><strong>Scheduled Time:</strong> {{ \Carbon\Carbon::parse($todo->scheduled_at)->format('M d, Y @ H:i') }}</p>
    
    <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 30px 0;">
    
    <h3>⏰ When would you like an email reminder for this task?</h3>
    <p>Click your preferred preference below to set it instantly:</p>

    <a href="{{ route('todos.set-reminder', ['todo' => $todo->id, 'minutes' => 30]) }}" class="button">30 Mins Before</a>
    <a href="{{ route('todos.set-reminder', ['todo' => $todo->id, 'minutes' => 15]) }}" class="button">15 Mins Before</a>
    <a href="{{ route('todos.set-reminder', ['todo' => $todo->id, 'minutes' => 10]) }}" class="button">10 Mins Before</a>
    <a href="{{ route('todos.set-reminder', ['todo' => $todo->id, 'minutes' => 5]) }}" class="button">5 Mins Before</a>

    <p style="font-size: 12px; color: #9ca3af; margin-top: 30px;">If you do not click an option, you will not receive a follow-up reminder.</p>
</body>
</html>