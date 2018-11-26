<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Repositories\admin\IndexRepository;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * @return $value
     */
    public function index()
    {
        $nodes = session('admin.powers');
        $frame = session('admin.frame');
        if (empty($nodes)) {
            return redirect('login');
        }
        $powers = json_decode($nodes, true);
        $frame = json_decode($frame, true);
        ksort($powers);
        return view('admin.index', compact(['powers', 'count','frame']));
    }

    public function index_v1()
    {
        $rep = new IndexRepository();
        $res  = $rep->getData();
        $count = json_decode($res,true)['count'];
        $data = json_encode(json_decode($res,true)['data']);
        return view('admin.index_v1',['count'=>$count,'data'=>$data]);
    }

}