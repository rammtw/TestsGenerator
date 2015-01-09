@extends('layouts.interface')

@section('title')
    Тестирование
@stop

@section('script')
    <script type="text/javascript">
        var next = function () {
            var answers = "";
            $(".answer").each(function () {
                var ischecked = $(this).is(":checked");
                if (ischecked) {
                    answers += $(this).val() + "|";
                }
            });
            var dataString = 'a=' + answers + '&c={{ Session::get('hash') }}' + '&_token={{ csrf_token() }}';
            $.ajax({
                type: "POST",
                url : "/q/a/set",
                data : dataString,
                success : function(data){
                    // window.location.href="/q/" + data.hash;
                }
            },"json");
        }
    </script>
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-9 col-md-offset-2">
                <p>{{ $question->title }}</p>
                @if($question->type === 'input')
                    <input type="text" class="form-control" class="answer" name="answer">
                @elseif($question->type === 'radio')
                    @foreach($answers as $key => $answer)
                        <div class="radio">
                            <label>
                                <input type="radio" class="answer" name="answer" value="{{ $key }}"> {{ $answer }}
                            <label>
                        </div>
                    @endforeach
                @elseif($question->type === 'checkbox')
                    @foreach($answers as $key => $answer)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="answer" name="v{{ $key }}" value="{{ $key }}"> {{ $answer }}
                            </label>
                        </div>
                    @endforeach
                @endif
                    <button type="button" class="btn btn-success" style="margin-top:25px;" onclick="next();">Далее</button>
            </div>
        </div>
    </div>
@stop