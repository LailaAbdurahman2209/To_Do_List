<form action="/todos" method="POST" id="todoForm">
    @csrf
    
    <label>Task Description:</label>
    <input type="text" name="description" required>

    <label>Date:</label>
    <input type="date" id="task_date" required>
    
    <label>Time:</label>
    <input type="time" id="task_time" required>

    <input type="hidden" name="scheduled_at_string" id="final_datetime">

    <button type="submit" onclick="prepareDateTimeString()">Add Task</button>
</form>

<script>
function prepareDateTimeString() {
    // Grab the date and time from the calendar inputs
    let date = document.getElementById('task_date').value;
    let time = document.getElementById('task_time').value;
    
    // Combine them into one string (e.g., "2026-07-10 14:30:00")
    let combinedString = date + ' ' + time + ':00';
    
    // Inject the string into the hidden input so it goes to the backend
    document.getElementById('final_datetime').value = combinedString;
}
</script>