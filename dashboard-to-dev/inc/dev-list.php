<div class="wrap">
    <h2>Dev list</h2>

    <table class="dev-list-table" class="wp-list-table widefat striped">
        <thead>
            <tr>
                <!-- Table header columns -->
                <th>ID</th>
                <th>Task</th>
                <th>Page</th>
                <th>Priority Level</th>
                <th>Due Date</th>
                <th>Date Submitted</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Data</td>
                <td>Data</td>
                <td>Data</td>
                <td>Data</td>
                <td>Data</td>
                <td>Data</td>
            </tr>
        </tbody>
    </table>
</div>

<form method="post" id="post-form">
    <label for="task">Task:</label><br>
    <input type="text" id="task" name="task"><br>

    <label for="page">Page:</label><br>
    <input type="text" id="page" name="page"><br>

    <label for="priority">Priority Level:</label><br>
    <select id="priority" name="priority">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select><br>

    <label for="due_date">Due Date:</label><br>
    <input type="date" id="due_date" name="due_date"><br>

    <input type="submit" value="Submit">
</form>