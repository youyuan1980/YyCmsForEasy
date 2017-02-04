<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
class ArticleController extends BaseController
{
    public function articlelistdata()
	{
		$p=I('post.page');
		if ($p=="") {
			$p=1;
		}
		$pagesize = I('post.rows');
		$article=M('article');
		$title=I('post.title');
        $classid=I('post.classid');
		$count=$article->where("ISDELETE='0' and title like '%".$title."%' and classid='".$classid."'")
					->count();
		$list=$article->where("ISDELETE='0' and title like '%".$title."%' and classid='".$classid."'")
			->order('uptime desc')
			->page($p.','.$pagesize)
			->select();
		$data["total"]=$count;
		$data["rows"]=$list;
		echo json_encode($data);
	}

	public function delarticle()
	{
		# code...
		$p=I('p');
		$id=I('id');
		$tbtitle=I('tbtitle','');
		$article=M('article');
		$flag=$article->where("ID='".$id."'")
					  ->setField("ISDELETE",'1');
		if ($flag) {
			# code...
			$data["info"]="删除成功";
		}
		else
		{
			$data["info"]="删除失败";
		}
		$data["url"]=U('article/articlelist',array('p'=>$p,'tbtitle'=>$tbtitle));
		$this->ajaxReturn($data);
	}

	public function edit()
	{
		$id=I('get.id');
		$class=I('get.class');
		$article=M('article');
		$this->assign('pagetitle','编辑信息');
		$this->assign('actionurl',U('article/doedit'));
		$this->assign('id',$id);
		$this->assign('classid',$class);
		$data=$article->where("ID='".$id."'")->find();
		if ($data) {
			$this->assign('title',$data["title"]);
			$this->assign('keyword',$data["keyword"]);
			$this->assign('linkurl',$data["linkurl"]);
			$this->assign('source',$data["source"]);
			$this->assign('author',$data["author"]);
			$this->assign('titleimage',$data["titleimage"]);
			$this->assign('isimgnews',$data["isimgnews"]=="1"?"checked=checked":"");
			$this->assign('istop',$data["istop"]=="1"?"checked=checked":"");
			$this->assign('ishot',$data["ishot"]=="1"?"checked=checked":"");
			$this->assign('content',html_entity_decode($data["content"]));
			$articleclass=M('article_classlist');
			$dt=$articleclass->where("ID='".$data["classid"]."'")->find();
			if ($dt) {
				$this->assign('classtitle',$dt["title"]);
			}
		}
		$this->display('articleedit');
	}

	public function doedit()
	{
		$data["TITLE"]=I('post.title');
		$data["KEYWORD"]=I('post.keyword');
		$data["LINKURL"]=I('post.linkurl');
		$data["SOURCE"]=I('post.source');
		$data["AUTHOR"]=I('post.author');
		$data["TITLEIMAGE"]=I('post.titleimage');
		$data["ISIMGNEWS"]=I('post.isimgnews')=='on'?"1":"0";
		$data["ISTOP"]=I('post.istop')=='on'?"1":"0";
		$data["ISHOT"]=I('post.ishot')=='on'?"1":"0";
		$data["CONTENT"]=I('post.editor');
		$data["UPTIME"]=date('Y-m-d H:i:s');
		$data["EDITUSERNAME"]=session("userid");
		$article=M('article');
		$flag=$article->where("ID='".I('post.id')."'")->data($data)->save();
		if ($flag!==false) {
			$this->success('保存成功',U('article/edit',array("class"=>I('post.classid'),"id"=>I('post.id'))));
		}
		else{
			$this->error('保存失败',U('article/edit',array("class"=>I('post.classid'),"id"=>I('post.id'))));
		}
	}

	public function add()
	{
		$class=I('get.class');
		$article=M('article');
		$this->assign('pagetitle','添加信息');
		$this->assign('actionurl',U('article/doadd'));
		$this->assign('classid',$class);
		$articleclass=M('article_classlist');
		$dt=$articleclass->where("ID='".$class."'")->find();
		if ($dt) {
			$this->assign('classtitle',$dt["title"]);
		}
		$this->display('articleedit');
	}

	public function doadd()
	{
		$data["ID"]=GetID();
		$data["TITLE"]=I('post.title');
		$data["CLASSID"]=I('post.classid');
		$data["KEYWORD"]=I('post.keyword');
		$data["LINKURL"]=I('post.linkurl');
		$data["SOURCE"]=I('post.source');
		$data["AUTHOR"]=I('post.author');
		$data["TITLEIMAGE"]=I('post.titleimage');
		$data["ISIMGNEWS"]=I('post.isimgnews')=='on'?"1":"0";
		$data["ISTOP"]=I('post.istop')=='on'?"1":"0";
		$data["ISHOT"]=I('post.ishot')=='on'?"1":"0";
		$data["CONTENT"]=I('post.editor');
		$data["ADDTIME"]=date('Y-m-d H:i:s');
		$data["UPTIME"]=date('Y-m-d H:i:s');
		$data["EDITUSERNAME"]=session("userid");
		$article=M('article');
		$flag=$article->data($data)->add();
		if ($flag!==false) {
			$this->success('保存成功',U('article/add',array("class"=>I('post.classid'))));
		}
		else{
			$this->error('保存失败',U('article/add',array("class"=>I('post.classid'))));
		}
	}
}
 ?>