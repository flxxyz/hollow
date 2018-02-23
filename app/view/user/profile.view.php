<?php
view('layout/header', [
    'title'       => $title,
    'keyword'     => 'login',
    'description' => 'login',
]);
?>
<?php _e(session()->all()) ?>
