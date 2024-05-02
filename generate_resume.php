<?php
// Load your project's composer autoloader (If you aren't already doing so).
require_once __DIR__ . '/vendor/autoload.php';

use Alle_AI\Anthropic\AnthropicAPI;
use Dompdf\Dompdf;

$api_key = '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';
$anthropic_version = "2023-06-01";
$anthropic_api = new AnthropicAPI($api_key, $anthropic_version);

// Form handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['resume_content'])) {
        $resumeContent = htmlspecialchars_decode($_POST['resume_content'], ENT_QUOTES | ENT_HTML5);
        $resumeHTML = generateResumeHTML($resumeContent);

        $pdf = new Dompdf();
        $pdf->loadHtml($resumeHTML);
        $pdf->render();
        $pdf->stream("resume.pdf", array("Attachment" => true));
    } else {
        $jobTitle = htmlspecialchars($_POST['job_title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $companyName = htmlspecialchars($_POST['company_name'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $startDate = htmlspecialchars($_POST['start_date'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $endDate = htmlspecialchars($_POST['end_date'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $yearsWorked = htmlspecialchars($_POST['years_worked'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $removedFromJob = isset($_POST['removed_from_job']) && $_POST['removed_from_job'] === 'yes';
        $skills = htmlspecialchars($_POST['skills'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Process user input with Claude API
        $prompt = "\n\nHuman: Generate a well-structured and visually appealing resume section for the following work experience. Use appropriate HTML tags and CSS styles to ensure a clear separation of different sections (job title, company, employment period, skills, etc.) with proper formatting, font styles, sizes, and colors. Do include any personal information like name or email, or any explanatory text.\n\nJob Title: $jobTitle\nCompany Name: $companyName\nEmployment Period: $startDate - $endDate\nYears Worked: $yearsWorked\nRemoved from Job: " . ($removedFromJob ? 'Yes' : 'No') . "\nSkills Used: $skills\n\nAssistant:";
        $data = array(
            'prompt' => $prompt,
            'model' => 'claude-2.1',
            'max_tokens_to_sample' => 300,
            'stop_sequences' => array("\n\nHuman:")
        );
        $response = $anthropic_api->generateText($data);
        $result = $response['completion'];

        // Display resume HTML
        displayResumeHTML($result);

        // Add a form to download the PDF
        echo '<form action="generate_resume.php" method="post">';
        echo '<input type="hidden" name="resume_content" value="' . htmlspecialchars($result) . '">';
        echo '<input type="submit" value="Download PDF">';
        echo '</form>';
    }
}

function generateResumeHTML($processedData)
{
    // Define resume HTML structure with placeholders
    $resumeHTML = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Resume</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="resume">
        $processedData
    </div>
</body>
</html>
HTML;
    return $resumeHTML;
}

function displayResumeHTML($processedData)
{
    // Define resume HTML structure with placeholders
    $resumeHTML = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Resume Preview</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="resume">
        $processedData
    </div>
</body>
</html>
HTML;
    echo $resumeHTML;
}
