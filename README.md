### MY PROJECT
- This is my test project
- Task management: Create , assign , and track tasks for specific users.
- Live Status Tracking: Real time visibility into whether reminder emails are such as pending and sent.
- Unsent Tasks filter: Quick view dropdown tracking pending follow up alerts.
- Link Reminders: Instant transactional emails generated upon task creation.

### SYSTEM WORKFLOW 
- A task is added with discription, assigned user, and a target sceduled timestamp.
- Immediate Notification the application immediately dispatches a new task assigned email containing 4 customs action links.
- Preference Capturing:Clicking a link routes back to the application (`TodoController@setReminder`), silently tracking the integer payload in the database (`reminder_minutes`) and    displaying a sleek feedback screen.
- Automated Checking The background scheduler queries pending tasks, dynamically computes the exact target window (`scheduled_at - reminder_minutes`), and fires off the final alert when the system clock matches or exceeds the target.


- Username: `admin@company.com`
- Password: `:password123`

