<!DOCTYPE html>
<html>

<head>
    <title>AI Resume Builder</title>
</head>

<body>
    <h1>AI Resume Builder</h1>
    <form method="post" action="generate_resume.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="job_title">Job Title:</label>
        <select id="job_title" name="job_title" required>
            <option value="">Select job title</option>
            <option value="Software Engineer">Software Engineer</option>
            <option value="Web Developer">Web Developer</option>
            <option value="Data Analyst">Data Analyst</option>
            <!-- Add more job title options as needed -->
        </select><br>

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required><br>

        <label for="start_date">Start Date:</label>
        <input type="month" id="start_date" name="start_date" required><br>

        <label for="end_date">End Date:</label>
        <input type="month" id="end_date" name="end_date" required><br>

        <label for="years_worked">Years Worked:</label>
        <select id="years_worked" name="years_worked" required>
            <option value="">Select years worked</option>
            <option value="Less than 1 year">Less than 1 year</option>
            <option value="1 year">1 year</option>
            <option value="2 years">2 years</option>
            <option value="3 years">3 years</option>
            <option value="4 years">4 years</option>
            <option value="5 years or more">5 years or more</option>
        </select><br>

        <label for="removed_from_job">Removed from Job:</label>
        <div>
            <input type="radio" id="removed_from_job_yes" name="removed_from_job" value="yes" required>
            <label for="removed_from_job_yes">Yes</label>
            <input type="radio" id="removed_from_job_no" name="removed_from_job" value="no" required>
            <label for="removed_from_job_no">No</label>
        </div>

        <label for="skills">Skills Used:</label>
        <select id="skills" name="skills" required><br>
            <option value="">Which skills do u have</option>
            <option value="Python">Python</option>
            <option value="Java">Java</option>
            <option value="C++">C++</option>
        </select>
        <br>

        <input type="submit" value="Generate Resume">
    </form>
</body>

</html>