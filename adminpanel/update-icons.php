<?php
$dir = new RecursiveDirectoryIterator("c:/xampp/htdocs/chennais/adminpanel/resources/views");
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, "/\.blade\.php$/", RegexIterator::MATCH);
$count = 0;
foreach($files as $file) {
    if (!$file->isFile()) continue;
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $orig = $content;

    $content = preg_replace("/<i class=\"bi bi-eye-fill( me-1)?\"><\/i>\s*<\/a>/i", "<i class=\"bi bi-eye-fill me-1\"></i> View </a>", $content);
    $content = preg_replace("/<i class=\"bi bi-eye-fill( me-1)?\"><\/i>\s*(<\/button>)/i", "<i class=\"bi bi-eye-fill me-1\"></i> View $2", $content);

    $content = preg_replace("/<i class=\"bi bi-pencil( me-1)?\"><\/i>\s*<\/a>/i", "<i class=\"bi bi-pencil me-1\"></i> Edit </a>", $content);
    $content = preg_replace("/<i class=\"bi bi-pencil( me-1)?\"><\/i>\s*(<\/button>)/i", "<i class=\"bi bi-pencil me-1\"></i> Edit $2", $content);

    $content = preg_replace("/<i class=\"bi bi-pencil-square( me-1)?\"><\/i>\s*<\/a>/i", "<i class=\"bi bi-pencil-square me-1\"></i> Edit </a>", $content);
    $content = preg_replace("/<i class=\"bi bi-pencil-square( me-1)?\"><\/i>\s*(<\/button>)/i", "<i class=\"bi bi-pencil-square me-1\"></i> Edit $2", $content);

    $content = preg_replace("/<i class=\"bi bi-trash( me-1)?\"><\/i>\s*<\/button>/i", "<i class=\"bi bi-trash me-1\"></i> Delete </button>", $content);
    $content = preg_replace("/<i class=\"bi bi-trash( me-1)?\"><\/i>\s*<\/a>/i", "<i class=\"bi bi-trash me-1\"></i> Delete </a>", $content);

    $content = preg_replace("/<i class=\"material-icons md-edit( me-1)?\"><\/i>\s*<\/a>/i", "<i class=\"material-icons md-edit me-1\"></i> Edit </a>", $content);
    $content = preg_replace("/<i class=\"material-icons md-delete_forever( me-1)?\"><\/i>\s*<\/a>/i", "<i class=\"material-icons md-delete_forever me-1\"></i> Delete </a>", $content);

    if ($orig !== $content) {
        file_put_contents($path, $content);
        $count++;
    }
}
echo "Updated $count files.\n";
?>
