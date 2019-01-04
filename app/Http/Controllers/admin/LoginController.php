<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Frame;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Node;
use App\Models\Admin;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
     * 登录界面
     */
    public function index()
    {
//        dd(2222222222);


        return view('admin.login');
    }

    /*
     * 提交验证
     */
    public function login(Request $request)
    {
        $result = $request->all();
        if ($result) {
            $str   = $this->verifyPasswd($result['passwd']);
            $admin = new Admin();
            $admin = $admin->where('username', $result['username']);
            $admin = $admin->where('password', $str);
            $res   = $admin->first();
            $frame = $this->getFrame($res->individuation_id);

            if (!empty($res)) {
                $key['admin']              = $res;
                $key['admin']['logintime'] = time();
                $Role                      = new Role();
                $power                     = $Role->where('id', $res['rid'])->first(['powers'])->toarray();
                $key['admin']['powers']    = $power['powers'];
                $Node                      = new Node();
                $Node                      = $Node->where('pid', '>', '0');
                $list                      = $Node->first(['name'])->toarray();

                $data                  = [
                    'last_time' => time(),
                    'last_ip'   => $_SERVER['REMOTE_ADDR'],
                ];
                $admin->where(array('id' => $res['id']))->update($data);

                $key['admin']['nodes'] = $list;
                $key['admin']['frame'] = $frame;

                $request->session()->put('admin', $key['admin']);
                $adminFlag = $request->session()->get('admin');
                $this->sso($res);

                if (!empty($adminFlag['id'])) {

                    return redirect('admin/index');
                } else {
                    return redirect('admin/login');
                }
            } else {
                return view('admin.login');
            }

        } else {
            return view('admin.login');
        }
    }

    public function verifyPasswd($data)
    {
        $verify = 'to';
        $passwd = substr(md5(md5($data) . $verify), -20);
        return $passwd;
    }

    /*
     * 退出
     */
    public function logout(Request $request)
    {
        $admin = $request->session()->get('admin');
        if (isset($admin['id'])) {
            $request->session()->put('admin', '');
            return redirect('admin/login');
        } else {
            return redirect('admin/login');
        }
    }

    /**
     * 静默登录
     */
    public function silentLogin()
    {
        $power = session('admin.powers');
        if (empty($power)) {
            return redirect('admin/login');
        } else {
            return redirect('admin/index');
        }
    }

    public function sso($res)
    {
        //储存点单登录的值到redis中，时间设置36 小时
        $key        = "data|user|login" . $res['id'];
        $session_id = Session::getId();
        if (!empty($session_id)) {
            Redis::set($key, $session_id);
            Redis::expire($key, 36 * 3600);
        } else {
            return redirect('admin/login');
        }
    }

    /**
     * 获取 框架样式
     */
    public function getFrame($id)
    {
        $frame   = new Frame();
        $content = $frame->where(['id' => $id])->first(['css_setting','id']);
        //内容不能为空
        if(empty($content)){
            $content = $frame->first(['css_setting','id']);
        }

        $content['css_setting'] = empty($content->css_setting)?:json_decode($content->css_setting,true);
        return $content;
    }

    /**
     * 重新登录
     */
    public function i()
    {
        return view('admin.alert');
    }
}
