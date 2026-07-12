<!DOCTYPE html>
<html>
<body>
    <h1>Task Reminder</h1>
    <p>Hello!</p>
    <p>This is a friendly reminder that your task: <strong>{{ $todo->description }}</strong> is starting soon!</p>
    <p>Scheduled for: {{ $todo->scheduled_at->format('M d, Y H:i') }}</p>
</body>
</html>