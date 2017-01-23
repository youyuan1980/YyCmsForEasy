<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class UserController extends BaseController
{
    public function UserList()
	{
		$this->display('userlist');
	}

	public function userlistdata()
	{
		$p=I('post.page');
		if ($p=="") {
			$p=1;
		}
		$pagesize = I('post.rows');
		$user=M('users');
		$tbuser=I('post.userlist_userid');
		$count=$user->where("username like '%".$tbuser."%' or userid like '%".$tbuser."%'")
					->count();
		$list=$user->where("username like '%".$tbuser."%' or userid like '%".$tbuser."%'")
			->order('uptime desc')
			->page($p.','.$pagesize)
			->select();
		$data["total"]=$count;
		$data["rows"]=$list;
		echo json_encode($data);
	}

	public function deleteuser()
	{
		$userid=I('userid');
        $msg = "";
		if (IS_AJAX) {
			# code...
			$user=M('users');
			if ($user->where("userid='".$userid."'")->delete()) {
				$msg = "删除成功";
			}
			else
			{
				$msg = "删除失败";
			}
		}
		else
		{
			$msg = "非法操作";
		}
		$this->ajaxReturn($msg);
	}

	public function restuserpwd()
	{
		$userid=I('userid');
        $msg = '';
		if (IS_AJAX) {
			$user=M('users');
			$pwd=md5('123');
			if ($user->where("userid='".$userid."'")->setField('USERPASSWORD',$pwd)!==false) {
				$msg = "密码重置成功，新密码为123";
			}
			else
			{
				$msg = "密码重置失败";
			}
		}
		else
		{
			$msg = "非法操作";
		}
		$this->ajaxReturn($msg);
	}

	public function main()
    {        
        $this->display('main');
    }
    
    public function getuserinfo()
    {
        $data = array();
        $data["userid"]=session("userid");
        $data["username"]=session("username");        
        $userinrole=D('Userinrole');
        $data["userrolesname"]=$userinrole->ShowUserRoles($data["userid"]);
        echo json_encode($data);
    }

	public function updpwd()
    {
        $this->display('updpwd');
    }

    public function doupdpwd()
    {
        if (IS_POST) {
            $oldpwd = I('post.oldpwd');
            $userpwd = I('post.userpwd');
            $user= D('users');
            $userid=session("userid");
            //1为修改成功 ，2为密码错误，3为用户名错误
            $flag=$user->updpwd($userid,$oldpwd,$userpwd);
            switch ($flag) {
                case '1':
                case '0':
                    $this->success('修改成功',U('user/updpwd'),3);
                    break;
                case '2':
                    $this->error('密码错误',U('user/updpwd'),3);
                    break;
                case '3':
                    $this->error('用户名错误',U('user/updpwd'),3);
                    break;
                default:
                    break;
            }
        }
        else
        {
            $this->error('非法操作',U('user/updpwd'),5);
        }
    }

    public function edit()
    {
    	# code...
        $data = array();
    	$userid=I('get.userid');
    	$this->userid=$userid;
    	$user=M('users');
    	$row=$user->field('userid,username')
    			  ->where("userid='".$userid."'")
    			  ->find();
    	if ($row) {
            $data["username"] = $row["username"];
            $data["userid"] = $row["userid"];
    	}
    	$roles=M('roles');
    	$rolerows=$roles->field("roleid,rolename,'' as ischecked")
    					->order('ordernum')
    					->select();
    	$userrole=M('userinrole');
    	$userrolerows=$userrole->field('roleid')
    						   ->where("userid='".$userid."'")
    						   ->select();
    	for ($i=0; $i <count($rolerows) ; $i++) {
    		for ($j=0; $j <count($userrolerows) ; $j++) {
    			if ($rolerows[$i]["roleid"]==$userrolerows[$j]["roleid"]) {
    				$rolerows[$i]["ischecked"]="checked='checked'";
    				break;
    			}
    		}
    	}
        $data["roles"] = $rolerows;
        echo json_encode($data);
    }

    public function edituser()
    {
        $msg = '';
        if (IS_AJAX) {
            $userid=I('post.userid');
            $username=I('post.username');
            $chkroles=I('post.roles');
            $user=M('users');
            if ($user->where("userid='".$userid."'")->setField("USERNAME",$username)!==false) {
                $userinrole=M('userinrole');
                $userinrole->where("USERID='".$userid."'")->delete();
                $roles = explode(',',$chkroles);
                foreach ($roles as $row) {
                    $userrole["USERID"]=$userid;
                    $userrole["ROLEID"]=$row;
                    $userinrole->data($userrole)->add();
                }
                $msg = '保存成功';
            }
            else
            {
                $msg = '修改失败';
            }
        }
        else
        {
            $msg = '非法操作';
        }
        $this->ajaxReturn($msg);
    }

    public function add()
    {
        $roles=M('roles');
        $rolerows=$roles->field("roleid,rolename")
                        ->order('ordernum')
                        ->select();
        echo json_encode($rolerows);
    }

    public function adduser()
    {
        $msg = '';
        if (IS_AJAX) {
            $userid=I('post.userid');
            $username=I('post.username');
            $chkroles=I('post.roles');
            $user=M('users');
            $data["USERID"]=$userid;
            $data["USERNAME"]=$username;
            $data["USERPASSWORD"]=md5('123');
            $count=$user->where("USERID='".$userid."'")->count();
            if ($count==0) {
                if ($user->data($data)->add()!==false) {
                    $userinrole=M('userinrole');
                    $userinrole->where("USERID='".$userid."'")->delete();
                    $roles = explode(',',$chkroles);
                    foreach ($roles as $row) {
                        $userrole["USERID"]=$userid;
                        $userrole["ROLEID"]=$row;
                        $userinrole->data($userrole)->add();
                    }
                    $msg = '保存成功';
                }
                else
                {
                    $msg = '修改失败';
                }
            }
            else
            {
                $msg = '用户名已存在';
            }
        }
        else
        {
            $msg = '非法操作';
        }
        $this->ajaxReturn($msg);
    }
}
?>