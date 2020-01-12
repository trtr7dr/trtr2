<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>ТырТыр 2</title>
        <meta name="description" value="ТырТыр 2">
        <meta name="keywords" valeu="ТырТыр 2, королевство ТырТыр 2">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <link rel="shortcut icon" href="{{asset('/assets/trtr/trtr2/favicon.ico')}}" type="image/x-icon">
        <link rel="stylesheet" href="{{asset('css/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('css/trtr2/style.css')}}">
    </head>
    <body class="status{{$data['world']->status - 1}}">

        <div id="demo">
            <div class="h_info">
                <p>Цифровое Королевство <span>{{$data['world']->id}}</span></p>
                <p>Волшебная пыль: {{$data['world']->dust}}</p>
                <p>Жители: {{count($data['person'])}}</p>
                <p>R.I.P.: {{($data['dead'])}}</p>
                <p>Прошло лет: {{$data['world']->steps}}</p>
                <p>Месяц: {{$data['date']}}</p>

            </div>
            <div class="r_info">
                <p><a href="/trtr">Альтернативное ТырТыр 7 дыр</a></p>
            </div>
            <h1>trtr 2</h1>
        </div>

        <div class="col-md-12 intro">
            <div id="castle" width="100vw" height="100vh"></div>
<!--            <img class="trtrgif" src="{{asset('/assets/trtr/trtr2/trtr.gif')}}">-->
        </div>

        <div class="col-md-6 intro r_pad">
            <div class="information ">
                <p class="top_zerro">Идет {{$data['status'][$data['world']->status - 1]}}</p>
            </div>
            <img class="image_in black_bg" src="/assets/trtr/trtr2/stat/{{$data['world']->status}}.gif">
        </div>
        <div class="col-md-6 intro l_pad ">
            <img id="day" class="image_in black_bg" src="{{asset('/assets/trtr/trtr2/dop/sun.gif')}}">
        </div>

        <div class="col-md-12 no_pad">

            <div class="col-md-6 location r_pad">
                <div class="information">
                    <p>Работа</p>
                </div>
                <div class="pers_cont">
                    @foreach($data['person'] as $per)
                    @if($per['location'] === 2)
                    <div id="per{{$per['person_obj']['id']}}" class="person">
                        <a href="#name{{$per['person_obj']['id']}}">
                            <img class="rand{{rand(1,5)}}" src="/assets/trtr/trtr2/pers/{{$per['person_obj']['figure']}}.png">
                            <span class="inf_pers">{{$per['person_obj']['nick_name_obj']['name']}} {{$per['person_obj']['name_obj']['name']}} {{$per['person_obj']['sub_name_obj']['name']}}</span>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>

                <img class="image_location" src="{{asset('/assets/trtr/trtr2/bg/work.gif')}}">
            </div>

            <div class="col-md-6 location l_pad">
                <div class="information">
                    <p>Лес</p>
                </div>

                <div class="pers_cont">
                    @foreach($data['person'] as $per)
                    @if($per['location'] === 4)
                    <div id="per{{$per['person_obj']['id']}}" class="person">
                        <a href="#name{{$per['person_obj']['id']}}">
                            <img class="rand{{rand(1,5)}}" src="/assets/trtr/trtr2/pers/{{$per['person_obj']['figure']}}.png">
                            <span class="inf_pers">{{$per['person_obj']['nick_name_obj']['name']}} {{$per['person_obj']['name_obj']['name']}} {{$per['person_obj']['sub_name_obj']['name']}}</span>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>

                <img class="image_location" src="{{asset('/assets/trtr/trtr2/bg/les.gif')}}">
            </div>
            <div class="col-md-6 location">
                <div class="information">
                    <p>Дом</p>
                </div>

                <div class="pers_cont">
                    @foreach($data['person'] as $per)
                    @if($per['location'] === 3)
                    <div id="per{{$per['person_obj']['id']}}" class="person">
                        <a href="#name{{$per['person_obj']['id']}}">
                            <img class="rand{{rand(1,5)}}" src="/assets/trtr/trtr2/pers/{{$per['person_obj']['figure']}}.png">
                            <span class="inf_pers">{{$per['person_obj']['nick_name_obj']['name']}} {{$per['person_obj']['name_obj']['name']}} {{$per['person_obj']['sub_name_obj']['name']}}</span>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>

                <img class="image_location" src="{{asset('/assets/trtr/trtr2/bg/home.gif')}}">
            </div>
            <div class="col-md-6 location">
                <div class="information">
                    <p>Чад</p>
                </div>
                <div class="pers_cont">
                    @foreach($data['person'] as $per)
                    @if($per['location'] === 1)
                    <div id="per{{$per['person_obj']['id']}}" class="person">
                        <a href="#name{{$per['person_obj']['id']}}">
                            <img class="rand{{rand(1,5)}}" src="/assets/trtr/trtr2/pers/{{$per['person_obj']['figure']}}.png">
                            <span class="inf_pers">{{$per['person_obj']['nick_name_obj']['name']}} {{$per['person_obj']['name_obj']['name']}} {{$per['person_obj']['sub_name_obj']['name']}}</span>
                        </a>
                    </div>
                    @endif
                    @endforeach
                </div>
                <img class="image_location" src="{{asset('/assets/trtr/trtr2/bg/chad.gif')}}">
            </div>

        </div>

        <div class="col-md-12 intro dead">
            <div class="pers_cont">
                @foreach($data['person'] as $per)
                @if($per['person_obj']['death'] === 1)
                <div class="person dead">

                    <img src="/assets/trtr/trtr2/pers/{{$per['person_obj']['figure']}}.png">
                    <span class="inf_pers">{{$per['person_obj']['nick_name_obj']['name']}} {{$per['person_obj']['name_obj']['name']}} {{$per['person_obj']['sub_name_obj']['name']}}</span>

                </div>
                @endif
                @endforeach
            </div>
            <img class="trtrgif" src="{{asset('/assets/trtr/trtr2/bg/dead.gif')}}">
            <div class="information">
                <p>Кладбище</p>
            </div>

        </div>

        <div class="col-md-12" id="monster">
            <div class="information bestiari">
                    <p>Бестиарий</p>
                </div>
            @foreach($data['monster'] as $m)
            <div class="monster_in">
                <img id="monsters{{$m->id}}" src="/assets/trtr/trtr2/monster/{{$m->figure}}.gif" >
                <span id="monsters_span{{$m->id}}">{{$m->text}}</span>
            </div>
            @endforeach
            
        </div>
        <div id="meta">@foreach($data['monster'] as $m){{$m->id}} @endforeach</div>



        <div class="col-md-12 chronic">
            <div class="col-md-12 clear">
                <div class="col-md-6 clear">
                    <h2>Лог</h2>
                </div>
            </div>

            @foreach($data['log'] as $log)
            <div class="col-md-12 chron">
                <p>> {{$log->text}}</p>
            </div>
            @endforeach

            {!! $data['log']->render() !!}
        </div>

        <div class="col-md-12 person_count">
            <table>
                <tr class="legend">
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/alien.svg')}}" alt="Имя" title="Имя"><span class="text_leg">Имя</span></td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/calendar.svg')}}" alt="Возраст" title="Возраст"><span class="text_leg">Возраст</span></td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/cash.svg')}}" alt="Пыль" title="Пыль"><span class="text_leg">Пыль</span></td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/battery.svg')}}" alt="Энергия" title="Энергия"><span class="text_leg">Энергия</span></td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/heart.svg')}}" alt="Жизнь" title="Жизнь"><span class="text_leg">Жизнь</span></td>
                </tr>

                @foreach($data['person'] as $per)
                @if($per['person_obj']['death'] === 0)
                <tr>
                    <td><a name="name{{$per['person_obj']['id']}}"></a>
                        @if($per['person_obj']['sex'] === 1)
                        <img class="icon_gend" src="{{asset('/assets/trtr/trtr2/dop/man.svg')}}">
                        @else
                        <img class="icon_gend" src="{{asset('/assets/trtr/trtr2/dop/woman.svg')}}">
                        @endif
                        {{$per['person_obj']['nick_name_obj']['name']}} {{$per['person_obj']['name_obj']['name']}} {{$per['person_obj']['sub_name_obj']['name']}}</td>
                    <td>{{$per['person_obj']['old']}}.</td>
                    <td>{{$per['person_obj']['cash']}}.</td>
                    <td>{{ (100 - $per['person_obj']['powerless']) }}.</td>
                    <td>{{$per['person_obj']['life']}}.</td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>
        
        
        <div class="col-md-12 dead_list">
            <table class="">
                <tr class="legend">
                    <td class="black_font">Мертвецы</td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/calendar.svg')}}" alt="Возраст" title="Возраст"><span class="text_leg">Возраст</span></td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/cash.svg')}}" alt="Пыль" title="Пыль"><span class="text_leg">Пыль</span></td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/battery.svg')}}" alt="Энергия" title="Энергия"><span class="text_leg">Энергия</span></td>
                    <td><img class="icon_char" src="{{asset('/assets/trtr/trtr2/dop/heart.svg')}}" alt="Жизнь" title="Жизнь"><span class="text_leg">Жизнь</span></td>
                </tr>

                @foreach($data['person'] as $per)
                @if($per['person_obj']['death'] === 1)
                <tr>
                    <td><a name="name{{$per['person_obj']['id']}}"></a>
                        
                        {{$per['person_obj']['nick_name_obj']['name']}} {{$per['person_obj']['name_obj']['name']}} {{$per['person_obj']['sub_name_obj']['name']}}</td>
                    <td>{{$per['person_obj']['old']}}.</td>
                    <td>{{$per['person_obj']['cash']}}.</td>
                    <td>{{ (100 - $per['person_obj']['powerless']) }}.</td>
                    <td>{{$per['person_obj']['life']}}.</td>
                </tr>
                @endif
                @endforeach
            </table>
        </div>

        <div id="demo2">

        </div>
        <p class="final">Цифровое Королевство ТырТыр 2 (альтернативное Королевство для <a href="/trtr">ТырТыр Семь дыр</a>)<span class="y_no">_</p>
        <p class="final">Непредсказуемое начало мира <span class="y_no">_</p>
        <p class="final">Много способов разрушить мир <span class="y_no">_</p>
        <p class="final">Характер влияет на обдуманность действий <span class="y_no">_</p>
        <p class="final">Смерть может наступить от нищеты, старости и усталости, а также от неожиданных происшествий <span class="y_no">_</p>
        <p class="final">Работники платят налоги, когда работают <span class="y_no">_</p>
        <p class="final">С определенным шансом начинается (и с определенным заканчивается) событие катаклизма / мора / войны / праздника / роста и т.д. с различным влиянием на мир и персонажей<span class="y_no">_</p>
        <p class="final">Фамилии даются при рождении ребенка всем троим участникам процесса (если фамилий нет). Иначе, приоритетным является фамилия основного родителя <span class="y_no">_</p>
        <p class="final">Ребенок может получиться только из пар разного пола <span class="y_no">_</p>
        <p class="final">Каждые 100 лет выбирается король. Он может назначить наследника и совершить действия другого рода <span class="y_no">_</p>
        <p class="final">Ритуал сожжения трупов <span class="y_no">_</p>
        <p class="final">Покушения и убийства <span class="y_no">_</p>
        <p class="final"><a href="/sacrificer">Боги</a> могут воскрешать или сводить с ума <span class="y_no">_</p>
        <p class="final">Смена дня и ночи <span class="y_no">_</p>
        <p class="final">Генерация башен замка <span class="y_no">_</p>
        <p class="final">Процедурная генерация ландшафта с монстрами <span class="y_no">_</p>


        <script src="{{asset('/js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('/js/jquery.ba-dotimeout.min.js')}}"></script>
        <script src="{{asset('/js/trtr2/script.js')}}"></script>
    </body>
</html>
