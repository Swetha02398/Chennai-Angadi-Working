<?php
$files = [
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/shipping/rules-table.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/shipping/zone-table.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/shipping/state-table.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/notification/notification-list.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/contact/contact-enquire.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/admin/roles/role-list.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/admin/users/user-list.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/admin/users/list.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/admin/roles/list.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/contact/contact-enquiries.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/notification/table.blade.php',
  'c:/xampp/htdocs/chennais/adminpanel/resources/views/offer/offer-table.blade.php'
];

foreach (glob('c:/xampp/htdocs/chennais/adminpanel/resources/views/*/*.blade.php') as $f) { $files[] = $f; }
foreach (glob('c:/xampp/htdocs/chennais/adminpanel/resources/views/*/*/*.blade.php') as $f) { $files[] = $f; }

foreach (array_unique($files) as $f) {
  if (!file_exists($f)) continue;

  $content = file_get_contents($f);

  $content = preg_replace(
    '/<a((?:.|\n)*?)class="btn((?:.|\n)*?)btn-warning((?!btn-action-col)(?:.|\n)*?)"((?:.|\n)*?)>\s*<i\s+class="bi bi-pencil(?:-square)?(\s+me-1)?"><\/i>\s*<\/a>/i',
    '<a$1class="btn$2btn-warning btn-action-col d-inline-flex align-items-center justify-content-center$3"$4><i class="bi bi-pencil-square me-1"></i> Edit</a>',
    $content
  );
  if(preg_match('/class="btn[^"]*btn-warning[^"]*"[^>]*>\s*<i[^>]*bi-pencil[^>]*><\/i>\s*Edit\s*<\/a>/i', $content)){
      $content = preg_replace(
        '/<a((?:.|\n)*?)class="btn((?:.|\n)*?)btn-warning((?!btn-action-col)(?:.|\n)*?)"((?:.|\n)*?)>\s*<i\s+class="bi bi-pencil(?:-square)?(\s+me-1)?"><\/i>\s*Edit(\s*)<\/a>/i',
        '<a$1class="btn$2btn-warning btn-action-col d-inline-flex align-items-center justify-content-center$3"$4><i class="bi bi-pencil-square me-1"></i> Edit</a>',
        $content
      );
  }

  $content = preg_replace(
    '/<button((?:.|\n)*?)class="btn((?:.|\n)*?)btn-danger((?!btn-action-col)(?:.|\n)*?)"((?:.|\n)*?)>\s*<i\s+class="bi bi-trash(\s+me-1)?"><\/i>\s*<\/button>/i',
    '<button$1class="btn$2btn-danger btn-action-col d-inline-flex align-items-center justify-content-center$3"$4><i class="bi bi-trash me-1"></i> Delete</button>',
    $content
  );
  
  if(preg_match('/class="btn[^"]*btn-danger[^"]*"[^>]*>\s*<i[^>]*bi-trash[^>]*><\/i>\s*Delete\s*<\/button>/i', $content)){
      $content = preg_replace(
        '/<button((?:.|\n)*?)class="btn((?:.|\n)*?)btn-danger((?!btn-action-col)(?:.|\n)*?)"((?:.|\n)*?)>\s*<i\s+class="bi bi-trash(\s+me-1)?"><\/i>\s*Delete\s*<\/button>/i',
        '<button$1class="btn$2btn-danger btn-action-col d-inline-flex align-items-center justify-content-center$3"$4><i class="bi bi-trash me-1"></i> Delete</button>',
        $content
      );
  }
  
  $content = preg_replace(
    '/<a((?:.|\n)*?)class="btn((?:.|\n)*?)btn-info((?!btn-action-col)(?:.|\n)*?)"((?:.|\n)*?)>\s*<i\s+class="bi bi-eye(\s+me-1)?"><\/i>\s*<\/a>/i',
    '<a$1class="btn$2btn-info btn-action-col d-inline-flex align-items-center justify-content-center$3"$4><i class="bi bi-eye me-1"></i> View</a>',
    $content
  );
  if(preg_match('/class="btn[^"]*btn-info[^"]*"[^>]*>\s*<i[^>]*bi-eye[^>]*><\/i>\s*View\s*<\/a>/i', $content)){
      $content = preg_replace(
        '/<a((?:.|\n)*?)class="btn((?:.|\n)*?)btn-info((?!btn-action-col)(?:.|\n)*?)"((?:.|\n)*?)>\s*<i\s+class="bi bi-eye(\s+me-1)?"><\/i>\s*View\s*<\/a>/i',
        '<a$1class="btn$2btn-info btn-action-col d-inline-flex align-items-center justify-content-center$3"$4><i class="bi bi-eye me-1"></i> View</a>',
        $content
      );
  }

  file_put_contents($f, $content);
}
?>
