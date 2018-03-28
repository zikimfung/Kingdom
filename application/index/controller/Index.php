<?php
namespace app\index\controller;
use think\Controller;
use think\Config;
use think\Session;
use think\Db;
class Index extends Controller{
    public function index(){
       return $this->fetch();
    }
	public function works(){
       $data=Db::table("works")->where("1=1 and is_test=0 and is_deleted=0")->order("create_time DESC")->select();
       $PageCount=ceil(Db::table("works")->count()/24);
       $this->assign('data',$data);
       $this->assign('PageCount',$PageCount);
       return $this->fetch();
    }
	public function area(){
       $data=Db::table("school")->where("1=1 and is_deleted=0")->order("create_time ASC")->select();
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
        $data=Db::table("works")->where("works_id",input("param.id"))->select();
        $Student=Db::table("student")->where("user_id",$data[0]["user_id"])->select();
        $this->assign('Student',$Student);
        $School=Db::table("school")->where("school_id",$Student[0]["school_id"])->select();
        $this->assign('School',$School);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function areainfo(){
        //echo input("param.year");
        $data=Db::table("school")->where("school_id",input("param.id"))->select();
        $data1=Db::table("works,school,student")->
        field("works.*")->
        where("works.user_id = student.user_id AND student.school_id = school.school_id AND school.school_id=".input("param.id"))->
        select();
        $data2=Db::table("works,school,student")->
        field("works.*")->
        where("works.user_id = student.user_id AND student.school_id = school.school_id AND school.school_id=".input("param.id"))->
        count();
        $this->assign('data',$data);
        $this->assign('workCount',$data2);
        $this->assign('studentCount', Db::table("student")->where("school_id",input("param.id"))->count());
        return $this->fetch();
    }
}
