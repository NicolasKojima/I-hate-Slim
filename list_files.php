<?php

function listFiles($dir, $indent = 0)
{
    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo str_repeat('|   ', $indent) . '|— ' . $file . PHP_EOL;

            if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                listFiles($dir . DIRECTORY_SEPARATOR . $file, $indent + 1);
            }
        }
    }
}

// Replace 'path_to_your_project' with the directory path you want to traverse
$path = 'C:\xampp\htdocs\ProjectManagementSite';


listFiles($path);


noteElement.innerHTML = `
                    <div class="note-header">
                        <div class="note-title">${note.title}</div>
                        <div class="note-date">${note.due_date || 'N/A'}</div>
                    </div>
                    <div class="note-content">${note.content}</div>
                `;