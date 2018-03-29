<?php
namespace app\index\controller;
use think\Controller;
use think\Config;
use think\Session;
use think\Db;
class Index extends Controller{
    public function index(){
        config('CUR_Page', 'index');
        config('CUR_Head_title', 'Kingdom');
       return $this->fetch();
    }
	public function works(){
       config('CUR_Page', 'works');
       config('CUR_Head_title', 'Kingdom');
       $data=Db::table("works")->where("1=1 and is_test=0 and is_deleted=0")->order("create_time DESC")->select();
       $PageCount=ceil(Db::table("works")->count()/24);
       $this->assign('data',$data);
       $this->assign('PageCount',$PageCount);
       return $this->fetch();
    }
	public function area(){
        config('CUR_Page', 'area');
        config('CUR_Head_title', '地区');
       $data=Db::table("school")->where("1=1 and status=1")->order("create_time ASC")->select();
       $PageCount=ceil(Db::table("school")->count()/24);
       $this->assign('data',$data);
       $this->assign('PageCount',$PageCount);
       return $this->fetch();
    }

    public function get_other_works(){
        $p=(input("param.p")-1)*24;
        if(input("param.p")<input("param.pc")){
            $data=Db::table("works")->where("1=1 and is_test=0 and is_deleted=0")->order("create_time DESC")->limit($p.",24")->select();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            echo "Null";
        }  
    }
    public function worksinfo(){
        config('CUR_Page', 'works');
        
        $data=Db::table("works")->where("works_id",input("param.id"))->select();
        $Student=Db::table("student")->where("user_id",$data[0]["user_id"])->select();
        $this->assign('Student',$Student);
        $School=Db::table("school")->where("school_id",$Student[0]["school_id"])->select();
        config('CUR_Head_title', $data[0]['works_name']);
        $this->assign('School',$School);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function areainfo(){
        config('CUR_Page', 'area');
        
        $data=Db::table("school")->where("school_id",input("param.id"))->select();
        
        $worksdata=Db::table("works,school,student")->
        field("works.*")->
        where("works.user_id = student.user_id AND student.school_id = school.school_id AND school.school_id=".input("param.id"))
        ->order("works_type ASC,create_time ASC")->select();
        config('CUR_Head_title', $data[0]['real_name']);
        $this->assign('data',$data);
        $this->assign('id',input("param.id"));
        $this->assign('worksdata',$worksdata);
        $this->assign('PageCount',ceil(count($worksdata)/20));
        $this->assign('workCount',Db::table("works,school,student")->field("works.*")->
        where("works.user_id = student.user_id AND student.school_id = school.school_id AND school.school_id=".input("param.id"))->
        count());
        $this->assign('studentCount', Db::table("student")->where("school_id",input("param.id"))->count());
        return $this->fetch();
    }

    public function get_works_inArea(){
        $p=(input("param.p")-1)*20;
        if(input("param.p")<input("param.pc")){
            $data=Db::table("works,school,student")->
            field("works.*")->
            where("works.user_id = student.user_id AND student.school_id = school.school_id AND school.school_id=".input("param.school_id"))
            ->order("works_type ASC,create_time DESC")->limit($p.",20")->select();
            echo json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            echo "Null";
        }
    }
}
