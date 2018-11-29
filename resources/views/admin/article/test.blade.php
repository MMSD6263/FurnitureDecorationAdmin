@extends('admin.master')
@section('css')
@endsection
@section('content')
@endsection
@section('js')
    <script type="text/javascript" src="http(s)://<CDN Host>/goeasy.js"></script>
    <script type="text/javascript">
        var goEasy = new GoEasy({
            appkey: 'BC-0167df8fde354ce7b4834abf7da12236',
        });

        goEasy.publish({
            channel:'demo_channel',
            message:'Hello world!'
        });

        goEasy.subscribe({
            channel:'demo_channel',
            onMessage: function(message){
                alert('收到：'+message.content);
            }
        });

        //        function sendMsg()
        //        {
        //            goEasy.publish({
        //                channel:'demo_channel',
        //                message:'Hello world!'
        //            });
        //        }
    </script>
@endsection
