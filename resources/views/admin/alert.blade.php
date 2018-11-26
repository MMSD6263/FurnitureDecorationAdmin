@extends('admin.master')
@section('css')
@endsection
@section('content')

@endsection
@section('js')
    <script>
        switch (1) {
            case 1:
                layer.confirm('对不起您的账号在另外一个地方登录，请您重新的登录', {
                    btn: ['重新登录'] //按钮
                }, function () {
                    window.location.href = "{{url('admin/login')}}"
                }, function () {

                });
                break;
            default:
                break;
        }
    </script>
@endsection