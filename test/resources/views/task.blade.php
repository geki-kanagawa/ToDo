<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="ToDo" content="ToDoリスト">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ToDo</title>
        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
        </script>
        <link href="{{ asset('/css/main.css') }}" rel='stylesheet' />
        <script src="{{ asset('/js/main.js') }}" ></script>
        
        <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


        <!-- css -->
        <style>
            #container{
                margin: 2rem;
            }
            #wrap{
                width: 70%;
                height: 70%;
                margin: auto;
            }
            /*
            .fc-scrollgrid-sync-table tr td:hover{
                background-color: #ccc !important;
            }
            */
            .private{
                margin: 0 0.5rem 0 0;
                background-color: #2196f3;
                border-radius: 0.4rem;
                color: #ffffff;
            }
            .work{
                margin: 0 0.5rem 0 0;
                background-color: #00796b;
                border-radius: 0.4rem;
                color: #ffffff;
            }
            .event{
                margin: 0 0 0.2rem 0.5rem;
            }

            /*新規モーダル modal-container*/
            .modal-container{
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                text-align: center;
                background: rgba(0,0,0,50%);
                padding: 40px 20px;
                overflow: auto;
                opacity: 0;
                visibility: hidden;
                transition: .3s;
                box-sizing: border-box;
            }
            /*モーダル本体の擬似要素の指定*/
            .modal-container:before{
                content: "";
                display: inline-block;
                vertical-align: middle;
                height: 100%;
            }
            /*モーダル本体に「active」クラス付与した時のスタイル*/
            .modal-container.active{
                z-index: 2;
                opacity: 1;
                visibility: visible;
            }
            /*編集モーダル modal-container2*/
            .modal-container2{
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                text-align: center;
                background: rgba(0,0,0,50%);
                padding: 40px 20px;
                overflow: auto;
                opacity: 0;
                visibility: hidden;
                transition: .3s;
                box-sizing: border-box;
            }
            /*モーダル本体の擬似要素の指定*/
            .modal-container2:before{
                content: "";
                display: inline-block;
                vertical-align: middle;
                height: 100%;
            }
            /*モーダル本体に「active」クラス付与した時のスタイル*/
            .modal-container2.active{
                z-index: 2;
                opacity: 1;
                visibility: visible;
            }
            /*モーダル枠の指定*/
            .modal-body{
                position: relative;
                display: inline-block;
                vertical-align: middle;
                max-width: 500px;
                width: 90%;
            }
            /*モーダルを閉じるボタンの指定*/
            .modal-close{
                position: absolute;
                display: flex;
                align-items: center;
                justify-content: center;
                top: -40px;
                right: -40px;
                width: 40px;
                height: 40px;
                font-size: 40px;
                color: #fff;
                cursor: pointer;
            }
            .modal-close2{
                position: absolute;
                display: flex;
                align-items: center;
                justify-content: center;
                top: -40px;
                right: -40px;
                width: 40px;
                height: 40px;
                font-size: 40px;
                color: #fff;
                cursor: pointer;
            }
            /*モーダル内のコンテンツの指定*/
            .modal-content{
                background: #fff;
                text-align: left;
                padding: 30px;
            }
        </style>
        <!-- /css -->
    </head>

    <!-- body -->
    <body>
        <div id="container">
            <div id="wrap">
                <div id="calendar"></div>
            </div>
        </div>

        <div id="form-wrap" class="modal-container">
            <div class="modal-body">
                <div class="modal-content">
                    <form action="/instask" method="post" class="event-form" id="new-form">
                        <div class="title">
                            <label for="title">タイトル</label>
                            <input id="title" type="text" name="title" required>
                        </div>
                        <div class="date">
                            <label for="date">日付</label>
                            <input id="date" type="date" name="date" required>
                        </div>
                        <div class="memo">
                            <label for="memo">備考</label>
                            <input type="text" name="memo" id="memo">
                        </div>
                        <div class="category">
                            <label for="category">カテゴリ</label>
                            <select name="category" id="category">
                                <option value="private">private</option>
                                <option value="work">work</option>
                            </select>
                        </div>
                    </form>
                    <div class="submit">
                        <button class="submit-button">追加</button>
                    </div>
                </div>
                <div class="modal-close">×</div>
            </div>
        </div>

        <div id="form-wrap2" class="modal-container2">
            <div class="modal-body">
                <div class="modal-content">
                    <form action="/instask" method="post" class="event-form" id="edit-form">
                        <div class="title">
                            <label for="title2">タイトル</label>
                            <input id="title2" type="text" name="title" required>
                        </div>
                        <div class="date">
                            <label for="date2">日付</label>
                            <input id="date2" type="date" name="date" required>
                        </div>
                        <div class="memo">
                            <label for="memo2">備考</label>
                            <input type="text" name="memo" id="memo2">
                        </div>
                        <div class="category">
                            <label for="category2">カテゴリ</label>
                            <select name="category" id="category2">
                                <option value="private">private</option>
                                <option value="work">work</option>
                            </select>
                        </div>
                        <input type="hidden" name="id" id="edit_id" required>
                    </form>
                    <div class="edit">
                        <button class="edit-button">編集</button>
                    </div>
                    <div class="delete">
                        <button class="delete-button">削除</button>
                    </div>
                </div>
                <div class="modal-close2">×</div>
            </div>
        </div>
    </body>
    <!-- /body -->

    <!-- js -->
    <script>
        createCalender();
        function createCalender(){
            document.addEventListener('DOMContentLoaded', function() {
                //初期化
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    //日本語化
                    locale: 'ja',
                    //ヘッダーのタイトルとボタン
                    headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                    },
                    //日付毎の初期化処理
                    dayCellContent: function(e){
                    //「日」を非表示にする
                    e.dayNumberText = e.dayNumberText.replace('日','');
                    },
                });
                calendar.render();
            });
        };

        $(function() {
            getTaskData();

            var date = ''; //日付
            var event_box = ''; //データを入れるセレクタ
            var datas = {};

            //前月、次月のボタンを押した時のデータ読み込み
            $('.fc-toolbar-chunk button').on('click', function(){
                getTaskData();
            });

            //カレンダー内クリックした時に新規追加フォームを出す
            $(document).on('click', '.fc-daygrid-day', function(){
                date = $(this).attr('data-date');
                event_box = $(this).find('.fc-daygrid-day-events');

                //フォーム初期化
                $('#title').val('');
                $('#memo').val('');
                $('#category').val('private');

                $('#date').attr('value', date);
                $('.modal-container').addClass('active');
                return false;
            });

            //×押したらモーダル閉じる
            $('.modal-close').on('click',function(){	
		        $('.modal-container').removeClass('active');
	        });

            //モーダルの外側をクリックしたらモーダルを閉じる
            $(document).on('click',function(e) {
                if(!$(e.target).closest('.modal-body').length) {
                    $('.modal-container').removeClass('active');
                }
            });

            //submit押した時
            $('.submit-button').on('click', function(e){
                e.preventDefault();
                insData();
            });

            //カレンダー内のeventを押した時
            $(document).on('click', '.event', function(){
                var edit_id = $(this).attr('data-id');
                $('#edit_id').val(edit_id);
                datas = {
                    id : $(this).attr('data-id'),
                    title : $(this).text(),
                    date: $(this).attr('data-date'),
                    category : $(this).attr('data-category'),
                    memo : $(this).attr('data-memo')
                };

                $('#title2').val(datas['title']);
                $('#date2').val(datas['date']);
                $('#memo2').val(datas['memo']);
                $('#category2').val(datas['category']);

                $('.modal-container2').addClass('active');
                return false;
            });

            //×押したらモーダル閉じる
                $('.modal-close2').on('click',function(){	
		        $('.modal-container2').removeClass('active');
	        });

            //モーダルの外側をクリックしたらモーダルを閉じる
                $(document).on('click',function(e) {
                if(!$(e.target).closest('.modal-body').length) {
                    $('.modal-container2').removeClass('active');
                }
            });

            //編集ボタン押した時
            $('.edit-button').on('click', function(e){
                e.preventDefault();
                editData();
            });

            //編集ボタン押した時
            $('.delete-button').on('click', function(e){
                e.preventDefault();
                deleteData();
            });

            //データ取得してカレンダーに表示
            function getTaskData(){
                $('.fc-scrollgrid-sync-table tr td .fc-daygrid-day-events').empty();
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: '/gettask',
                    data: {},
                    dataType: 'json'
                }).done(function(data){
                    $('.fc-scrollgrid-sync-table tr td').each(function(){
                        var data_date = $(this).attr('data-date');
                        event_box = $(this).find('.fc-daygrid-day-events');
                        $.each(data, function(i,v){
                            var date = v.datetime.slice(0, 10);
                            if( data_date == date ){
                                $(event_box).append(
                                    '<div class="event_wrap ' + v.category + '"><div data-id="' + v.id + 
                                    '" class="event" data-memo="' 
                                    + v.memo + '" data-category="'
                                     + v.category + '" data-date="' + date + '">' + v.title + '</div></div>'
                                );
                            }
                        })
                    });
                }).fail(function(data){
                    console.log(data);        
                });
            };

            //新規データ挿入
            function insData(){
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: '/instask',
                    data: $('#new-form').serialize(),
                    dataType: 'json'
                }).done(function(data){
                    //console.log(data);
                    var data_date = data.date.slice(0, 10);
                    if( data_date == date ){
                        $(event_box).append(
                            '<div class="event_wrap ' + data.category + '"><div data-id="' + data.id + 
                            '" class="event" data-memo="' 
                            + data.memo + '" data-category="'
                             + data.category + '" data-date="' + data_date + '">' + data.title + '</div></div>'
                        );
                    }
                    $('.modal-container').removeClass('active');
                    toastr.success('追加しました');
                }).fail(function(data){
                    console.log(data);        
                });
            };

            //データ編集
            function editData(){
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: '/edittask',
                    data: $('#edit-form').serialize(),
                    dataType: 'json'
                }).done(function(data){
                    console.log(data);
                    /*
                    var data_date = data.date.slice(0, 10);
                    var event = $('div[data-id="' + data.id + '"]');
                    $(event).attr('data-memo', data.memo);
                    $(event).attr('data-category', data.category);
                    $(event).attr('data-date', data_date);
                    $(event).text(data.title);
                    */
                   getTaskData();

                    $('.modal-container2').removeClass('active');
                    toastr.success('編集しました');
                }).fail(function(data){
                    console.log(data);        
                });
            };

            //新規データ挿入
            function deleteData(){
                $.ajax({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    url: '/deletetask',
                    data: $('#edit-form').serialize(),
                    dataType: 'json'
                }).done(function(data){

                   getTaskData();

                    $('.modal-container2').removeClass('active');
                    toastr.success('削除しました');
                }).fail(function(data){
                    console.log(data);        
                });
            };
        });
    </script>
    <!-- /js -->
</html>