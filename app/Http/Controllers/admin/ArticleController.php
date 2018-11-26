<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\admin\ArticleRepository;

/**
 * Class ArticleController
 * @package App\Http\Controllers\admin
 * 文章控制器
 */
class ArticleController extends Controller
{
    private $_article;

    public function __construct()
    {
        $this->_article = new ArticleRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 文章列表页面
     */
    public function index()
    {
        $sourceList = $this->_article->getSourceList();
        $typeList = $this->_article->getTypeList();
        return view('admin.article.index',['sourceList'=>$sourceList,'typeList'=>$typeList]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 文章审核列表页面
     */
    public function auditing()
    {
        $sourceList = $this->_article->getSourceList();
        $typeList = $this->_article->getTypeList();
        return view('admin.article.auditing',['sourceList'=>$sourceList,'typeList'=>$typeList]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 抓取文章
     */
    public function fetch()
    {
        $sourceList = $this->_article->getSourceList();
        $typeList = $this->_article->getTypeList();
        return view('admin.article.catch',['sourceList'=>$sourceList,'typeList'=>$typeList]);
    }

    /**
     * 获取数据列表
     * @param Request $request
     * @return array
     */
    public function ajaxData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_article->ajaxData($data);
        return $result;
    }

    /**
     * 获取数据列表
     * @param Request $request
     * @return array
     */
    public function auditingData(Request $request)
    {
        $data   = $request->except(['_token']);
        $result = $this->_article->auditingData($data);
        return $result;
    }


    /**
     * @param Request $request
     * @return string
     * 下载数据
     */
    public function downLoadData(Request $request)
    {
        $data   = $request->except(['_token']);
        $res    = $this->_article->downLoadData($data);
        return $res;

    }

    /**
     * @param Request $request
     * @return string审核下架文章
     */
    public function changeStatus(Request $request)
    {
        $data   = $request->except(['_token']);
        $res    = $this->_article->changeStatus($data);
        return $res;
    }


    /**
     * @param Request $request
     * @return string删除未审核的文章
     */
    public function deleteData(Request $request)
    {
        $data   = $request->except(['_token']);
        $res  =$this->_article->deleteData($data);
        return $res;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View文章编辑
     */
    public function editData(Request $request)
    {
//        $data = $request->except(['_token']);
        $article = $this->_article->getArticle($request);
        $sourceList = $this->_article->getSourceList();
        $typeList = $this->_article->getTypeList();
        $small_pic = $article['small_pic'];
        return view('admin.article.edit',['articleInfo'=>$article,'sourceList'=>$sourceList,'typeList'=>$typeList,'small_pic'=>$small_pic]);
    }

    /**
     * @param Request $request
     * @return array
     * 上传图片
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('file');
        if($file->isValid()){
            //获取原文件名
            $originalName = $file->getClientOriginalName();
            //扩展名
            $ext = $file->getClientOriginalExtension();
            //文件类型
            $type = $file->getClientMimeType();
            //临时绝对路径
            $realPath = $file->getRealPath();

            $public_path = base_path().'/public';
            $dir_path = '/src/upload/'.date('Ymd',time()).'/';
            $dir = $public_path.$dir_path;
            mkdirs($dir);
            $newName = time().rand(1000,9999).'.'.$ext;
            $bool = file_put_contents($dir.$newName,file_get_contents($realPath));
            if ($bool) {
                $result    = array('success' =>true ,'message'=>$dir_path.$newName);
            } else {
                $result = array('success' =>false ,'message'=>'文件上传失败！');
            }
            return $result;

        }
    }


    /**
     * @param Request $request
     * @return string
     * 保存文章
     */
    public function saveArticle(Request $request)
    {
        $data = $request->except(['_token']);
        $res = $this->_article->saveArticle($data);
        return $res;
    }


    /**
     * 预热数据，文章存入redis
     */
    public function saveRedis(Request $request)
    {
        $data = $request->except(['_token']);
        $res  = $this->_article->saveRedis($data);
        return $res;
    }


    public function rsync()
    {
        return view('admin.article.rsync');
    }


}
