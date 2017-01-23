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

	public function edit()
	{
		# code...
		$pid=I('get.pid','-1');
		$classid=I('get.id','');
		$articleclass=M('article_classlist');
		$row=$articleclass->where("id='".$classid."'")->find();
		if ($row) {
			$this->assign('classid',$row[id]);
			$this->assign('title',$row[title]);
		}
		if ($pid=="-1") {
			$this->assign('ptitle','根目录');
		}
		else
		{
			$row=$articleclass->where("id='".$pid."'")->find();
			if ($row) {
				$this->assign('ptitle',$row["title"]);
			}
		}
		$this->assign('pid',$pid);
		$this->assign('actionurl',U('articleclass/doedit'));
		$this->assign('classidreadonly','readonly=true');
		$this->display('articleclassedit');
	}

	public function doedit()
	{
		$classid=I('post.classid');
		$title=I('post.title');
		$pid=I('post.pid');
		$articleclass=M('article_classlist');
		$flag=$articleclass->where("ID='".$classid."'")->setField(array("TITLE"=>$title,"UPTIME"=>date('Y-m-d H:i:s')));
		if ($flag) {
			echo '保存成功';
			//$this->success("保存成功",U('articleclass/edit',array("id"=>$classid,"pid"=>$pid)),3);
		}
		else
		{
			echo '保存失败';
			//$this->error("保存失败",U('articleclass/edit',array("id"=>$classid,"pid"=>$pid)),3);
		}
	}

	public function add()
	{
		$pid=I('get.pid','-1');
		$articleclass=M('article_classlist');
		if ($pid=="-1") {
			$this->assign('ptitle','根目录');
		}
		else
		{
			$row=$articleclass->where("id='".$pid."'")->find();
			if ($row) {
				$this->assign('ptitle',$row["title"]);
			}
		}
		$this->assign('classid',GetID());
		$this->assign('pid',$pid);
		$this->assign('actionurl',U('articleclass/doadd'));
		$this->assign('pagetitle','添加栏目信息');
		$this->display('articleclassedit');
	}

	public function doadd()
	{
		$classid=I('post.classid');
		$title=I('post.title');
		$pid=I('post.pid');
		$articleclass=M('article_classlist');
		$data["ID"]=$classid;
		$data["TITLE"]=$title;
		$data["UPTIME"]=date('Y-m-d H:i:s');
		$data["PARENTID"]=$pid;
		$flag=$articleclass->data($data)->add();
		if ($flag) {
			$this->success("保存成功",U('articleclass/add',array("pid"=>$pid)),3);
		}
		else
		{
			$this->error("保存失败",U('articleclass/add',array("pid"=>$pid)),3);
		}
	}

	public function delarticleclass()
	{
		$classid=I('id');
		$data["p"]=I('p');
		$data["pid"]=I('pid');
		$data["tbtitle"]=I('tbTitle');
		if (IS_AJAX) {
			# code...
			$articleclass=M('article_classlist');
			if ($articleclass->where("ID='".$classid."'")->delete()) {
				$data["info"]="删除成功";
			}
			else
			{
				$data["info"]="删除失败";
			}
		}
		else
		{
			$data["info"]="非法操作";
		}
		$data["url"]=U('articleclass/articleclasslist',array('pid'=>$data['pid'],'p'=>$data["p"],'tbtitle'=>$data["tbtitle"]));
		$this->ajaxReturn($data);
	}
}
 ?>