<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class ArticleclassController extends BaseController
{
    public function datalist(){
        $json = "";
        $articleclass = M('article_classlist');
        $row = $articleclass->field('ID,TITLE,PARENTID')->select();
        $json = $json ."[";
        $json = $json ."{\"id\":\"-1\",\"name\":\"根目录\",\"pId\":\"0\",\"isParent\":\"true\",\"open\":\"true\"}";
        for($i= 0;$i < count($row);$i++)
        {
            $json = $json .",{\"id\":\"".$row[$i]["id"]."\",\"name\":\"".$row[$i]["title"]."\",\"pId\":\"".$row[$i]["parentid"]."\",\"isParent\":\"false\",\"open\":\"true\"}";
        }
        $json = $json ."]";
        echo $json;
    }

	public function ArticleClassList()
	{
		$this->display('articleclasslist');
	}

    public function delarticleclass()
    {
        $classid = I('get.classid','-1');
        $articleclass = M('article_classlist');
        $msg = '';
        if (IS_AJAX) {
            # code...
            $articleclass=M('article_classlist');
            if ($articleclass->where("ID='".$classid."'")->delete()) {
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

	public function getarticleclassinfo()
	{
		# code...
		$classid=I('get.classid','');
		$articleclass=M('article_classlist');
		$row=$articleclass->where("id='".$classid."'")->find();
        $data = array();
        $data["classid"] = $classid;
        $data["title"] = '';
		if ($row) {
            $data["title"] = $row[title];
		}
        echo json_encode($data);
	}

	public function editarticleclass()
	{
		$classid = I('get.classid');
		$title = I('get.title');
		$articleclass=M('article_classlist');
		$flag=$articleclass->where("ID='".$classid."'")->setField(array("TITLE"=>$title,"UPTIME"=>date('Y-m-d H:i:s')));
		$msg = '';
        if ($flag) {
			$msg = '保存成功';
		}
		else
		{
			$msg = '保存失败';
		}
        $this->ajaxReturn($msg);
	}


	public function addarticleclass()
	{
		$classid = GetID();
		$title = I('get.title');
		$pid = I('get.pid');
		$articleclass=M('article_classlist');
		$data["ID"]=$classid;
		$data["TITLE"]=$title;
		$data["UPTIME"]=date('Y-m-d H:i:s');
		$data["PARENTID"]=$pid;
		$flag=$articleclass->data($data)->add();
        $msg = '';
        if ($flag) {
            $msg = '保存成功';
        }
        else
        {
            $msg = '保存失败';
        }
        $this->ajaxReturn($msg);	}
}
 ?>