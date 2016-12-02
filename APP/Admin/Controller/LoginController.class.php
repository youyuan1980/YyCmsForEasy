<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller
{
	public function login()
	{
		$this->display('login');
	}

	public function logout()
	{
		session('username',null);
		session('userid',null);
		$this->success('登出成功',U('login/login'),3);
	}

	public function dologin()
	{
        $json = '';
		if (IS_POST) {
            $userid = I('post.txt_userid');
            $userpwd = I('post.txt_pwd');
            $user= D('users');
            //判断用户名和密码是否正确 ,返回1为登陆成功 ，2为密码错误，3为用户名错误
            $flag=$user->login($userid,$userpwd);
            switch ($flag) {
                case '1':
                	session("userid",$userid);
                	$dt=$user->where("userid='".$userid."'")->find();
                	session("username",$dt["username"]);
                    $json = "{'msg':'登陆成功','url':'".U('index/index')."'}";
                	break;
                case '2':
                    $this->error('密码错误',U('login/login'),3);
                    $json = "{'msg':'密码错误','url':'".U('login/login')."'}";
                    break;
                case '3':
                    $this->error('用户名错误',U('login/login'),3);
                    $json = "{'msg':'用户名错误','url':'".U('login/login')."'}";
                    break;
                default:
                    break;
            }
        }
        else
        {
            $json = "{'msg':'非法操作','url':'".U('login/login')."'}";
        }
        echo $json;
	}
}
?>