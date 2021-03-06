<?php
/**
 * Created by PhpStorm.
 * User: Princelo
 * Date: 8/16/15
 * Time: 05:15
 */
function check_access_right($type = 'user', $session)
{
    switch (strval($type))
    {
        case 'user':
            if ($session->userdata('is_login') != 1 || !$session->userdata('biz_id'))
                redirect('auth/login');
            break;
        case 'admin':
            if ($session->userdata('is_login') != 1 || $session->userdata('is_admin') != 1)
                redirect('auth/login');
            break;
        case 'seller':
            if ($session->userdata('is_login') != 1 || !$session->userdata('seller_id'))
                redirect('auth/seller_login');
            break;
        case 'login':
            if ($session->userdata('is_login') != 1 )
                redirect('auth/login');
            break;
        default:
            redirect('auth/login');
            break;
    }
}