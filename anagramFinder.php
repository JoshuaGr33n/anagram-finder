<?php
session_start(); // Start the session

function findAnagramGroups($filePath) {
    $words = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $anagramGroups = [];

    // Group words by sorted characters
    foreach ($words as $word) {
        $sorted = str_split($word);
        sort($sorted);
        $key = implode('', array: $sorted);
        
        if (!isset($anagramGroups[$key])) {
            $anagramGroups[$key] = [];
        }
        $anagramGroups[$key][] = $word;
    }

    return $anagramGroups;
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check for upload errors
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            $filePath = $file['tmp_name'];
            $anagramGroups = findAnagramGroups($filePath);

            // Store the result in the session
            $_SESSION['anagramGroups'] = $anagramGroups;

            // Redirect back to the index page
            header("Location: index.php");
            exit;

        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo "File is too large. Please upload a smaller file.";
            break;
        case UPLOAD_ERR_PARTIAL:
            echo "File upload was incomplete. Please try again.";
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "No file was uploaded. Please select a file to upload.";
            break;
        default:
            echo "Unknown error occurred. Please try again.";
            break;
    }
} else {
    echo "No file uploaded.";
}
?>
