<?php
if (file_exists(PUBLICROOT.DS.'templates'.DS.'back_home.html')) {
    echo getOutput(PUBLICROOT.DS.'templates'.DS.'back_home.html');
}
?>
<div class="content">
<?php
    if (!empty($data['result'])) {
        echo $data['result'];
    } else {
        include_once PUBLICROOT.DS.'templates'.DS.'contact_form.php';
    }
?>
</div>