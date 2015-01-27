@extends('layouts.interface')

@section('title')
    Новый вопрос
@stop

@section('content')
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <form id="question-form">
                    <div class="form-group">
                        <label for="title">Название вопроса</label>
                        <input type="text" class="form-control" id="title" placeholder="Введите сюда название вопроса">
                    </div>
                    <div class="form-group">
                        <label for="type">Тип ответов</label>
                        <select class="form-control" id="type">
                        	<option disabled>Выберите тип</option>
                            <option value="input">Текст</option>
                            <option value="radio">Один из нескольких</option>
                            <option value="checkbox">Несколько правильных</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="answer-count">Количество вариантов ответов</label>
                        <input type="text" class="form-control" id="answer-count" placeholder="Количество ответов" disabled value="1">
                    </div>
                    <button type="button" id="next-step" class="btn btn-success btn-sm" disabled>Далее</button>
                </form>
                <div class="form-horizontal" style="display:none;">
                	<p id="question"></p>
            		<div class="form-group r-num">
            			<label class="col-sm-7 control-label">
            				Номер правильного ответа:
            			</label>
            			<div class="col-sm-3">
            				<input type="text" class="form-control r-index" disabled value="1">
            			</div>
            		</div>
            		<button id="save" class="btn btn-success btn-sm" disabled>Сохранить</button>
      	        </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script type="text/javascript" src="../../js/n_question.js"></script>
@stop