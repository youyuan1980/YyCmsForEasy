<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class ArticleclassController extends BaseController
{
	public function ArticleClassList()
	{
		$pid=I('get.pid','-1');
		$articleclassherf="";
		$articleclass=M('article_classlist');
		if ($pid=="-1") {
			# code...
			$articleclassherf="上级目录：根目录";
		}
		else
		{
			$row=$articleclass->field('PARENTID,TITLE')->where("ID='".$pid."'")->find();
			if ($row) {
				$url=U('articleclass/articleclasslist',array('pid'=>$row["parentid"]));
				$articleclassherf="返回上级目录："."<a onclick=\"Open('栏目列表','".$url."');\" href=\"#\">".$row["title"]."</a>&nbsp;&nbsp;";
			}
		}
		$articleclassdataurl = U('articleclass/ArticleClassListForSearch',array('pid'=>$pid));
		$this->assign('articleclassherf',$articleclassherf);
		$this->assign('articleclassdataurl',$articleclassdataurl);
		$this->display('articleclasslist');
	}

	public function ArticleClassListForSearch()
	{
		$p=I('post.page');
		if ($p=="") {
			$p=1;
		}
		$pid=I('get.pid','-1');
		$pagesize = I('post.rows');
		$articleclass=M('article_classlist');
		$title=I('post.title');
		$count=$articleclass->where("title like '%".$title."%' and parentid =".$pid)
					->count();
		$list=$articleclass->where("title like '%".$title."%' and parentid = ".$pid )
			->order('uptime desc')
			->page($p.','.$pagesize)
			->select();
		$data["total"]=$count;
		$data["rows"]=$list;
		echo json_encode($data);
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
		echo $pid;
		$flag=$articleclass->where("ID='".$classid."'")->setField(array("TITLE"=>$title,"UPTIME"=>date('Y-m-d H:i:s')));
		if ($flag) {
			//echo '保存成功';
			//$this->success("保存成功",U('articleclass/edit',array("id"=>$classid,"pid"=>$pid)),3);
		}
		else
		{
			//echo '保存失败';
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