<?php
function check_notif()
{
    $ci = get_instance();
    $user = $ci->session->userdata('id');
    // $ci->db->where('usr'=>$user);
    // return $ci->db->get('notif n')->result_array();

    return $ci->db->select('n.*,u.nama')->from('notif n')
        ->join('user u', 'u.id = n.usr', 'left')
        ->where(['n.usr' => $user, 'baca' => 0])->get()->result_array();
}

function send_notif($usr, $pesan)
{
    $ci = get_instance();
    $in = [
        'pesan' => $pesan,
        'baca' => 0,
        'usr' => $usr
    ];
    $ci->db->insert('notif', $in);
}
function check_prosentase()
{

    // $ci = get_instance();
    // $project = $ci->db->get('project')->result_array();
    // $data = [];
    // $i = 0;
    // $j = 0;
    // foreach ($project as $pj) {
    //     $id = $pj['id'];
    //     // $id = 2;
    //     $data[$i]['idp'] = $pj['id'];
    //     $data[$i]['namap'] = $pj['nama'];
    //     $task = $ci->db->query("SELECT COUNT(prjid) as total From task where prjid='$id'")->result_array();
    //     foreach ($task as $t) {
    //         $data[$i]['total'] = $t['total'];
    //     }
    //     $pgs = $ci->db->query("SELECT COUNT(prj) as do FROM progress where prj='$id'")->result_array();
    //     foreach ($pgs as $p) {
    //         $data[$i]['do'] = $p['do'];
    //     }
    //     $i++;
    // }

}
