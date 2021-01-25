<?php
function pusher()
{
    require  APPPATH . '/views/vendor/autoload.php';
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '69a99071d426944894ee',
        'ec3017f3d1a002be9a09',
        '971391',
        $options
    );

    $data['message'] = 'success';
    $pusher->trigger('my-channel', 'my-event', $data);
}
