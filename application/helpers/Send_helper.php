<?php
function send_emailbro($subject, $pesan, $email)
{
    $ci = get_instance();
    $config = [
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_user' => 'deriatmaja12@gmail.com',
        'smtp_pass' => 'DeriAtmaja@12',
        'smtp_crypto' => 'tls',
        'smtp_port' => '587',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
    ];
    $ci->load->library('email', $config);
    $ci->email->initialize($config);
    $ci->email->subject($subject);
    $ci->email->message($pesan);
    // $ci->email->attach(base_url('assets/upload/default.jpg'));
    $ci->email->from('deriatmaja12@gmail.com', 'SISTEM MONITORING MIB');
    $ci->email->to($email);
    $ci->email->send();
}
