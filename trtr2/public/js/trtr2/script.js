class Vizz {

    randomInteger(min, max) {
        let rand = min + Math.random() * (max + 1 - min);
        return Math.floor(rand);
    }

    constructor(element_id, color, bg_color) {
        this.id = element_id;
        if (color === undefined)
            color = "#03afcc";
        this.color = color;

        if (bg_color === undefined)
            bg_color = "black";
        this.bg_color = bg_color;

        this.moment = 0;

        this.refresh = 0;

        this.ready();
    }

    ready() {
        var canv = document.createElement('canvas');
        canv.id = 'vizz' + this.id;
        canv.style.width = "100%";
        canv.style.height = "100vh";
        document.body.appendChild(canv);

        document.getElementById(this.id).appendChild(canv);
        this.canvas = document.getElementById("vizz" + this.id);
        this.canvas.width = this.canvas.offsetWidth;
        this.canvas.height = this.canvas.offsetHeight;
        this.ctx = this.canvas.getContext("2d");
        this.w = this.canvas.width;
        this.h = this.canvas.height;
    }

    /**
     * Режим 1.
     * Чередование чисел в последовательности. Четные числа рисуют N элементов в линии. Нечетные делают N пропусков в каретке, где N — это число.
     *
     * @param {object} d - набор цифр для отрисовки.
     * @param {number} w_elem - ширина элемента.
     * @param {number} h_elem - высота элемента.
     * @param {string} mode - режим отрисовки. Если true, то в отрисовке значения не будут вылезать за область видимости канваса.
     * @param {string} type - тип фигуры. По умолчанию: четырехугольник w_elem*h_elem. sqr — прямоугольник. cir — окружность радиуса w_elem и отступом от предыдущего ряда в h_elem. tri — треугольник с шириной w_elem и отступом от предыдущего ряда h_elem. ser — как треугольники, но маленькие линии
     * @param {number} margin - отступы между элементами.
     */

    mode_1(d, w_elem, h_elem, mode, type, margin) {
        if (w_elem === undefined)
            w_elem = 5;
        if (h_elem === undefined)
            h_elem = 5;
        if (margin === undefined)
            margin = 0;
        this.ctx.clearRect(0, 0, this.w, this.h);
        var i = 0, chet = true;
        var car_w = 2;
        var car_h = 2;
        h_elem = Math.ceil(h_elem, 1);
        w_elem = Math.ceil(w_elem, 1);
        var lim = d.length;
        this.ctx.fillStyle = this.color;
        while ((car_h < this.h)) {
            if (car_w > this.w) {
                car_h += h_elem;
                car_w = 0;
            } else {
                for (var k = 0; k < d[i]; k++) {
                    if (chet) {
                        this.ctx.fillRect(car_w, car_h, w_elem, h_elem);
                        car_w += w_elem;
                    } else {
                        car_w += w_elem;
                    }
                    if (car_w > this.w && mode) {
                        car_h += h_elem + margin;
                        car_w = 0;
                    }
                }
                if (chet)
                    chet = false;
                else
                    chet = true;
            }
            i++;
            if (i > lim) {
                i = 0;
            }
        }
    }

    randomInteger(min, max) {
        let rand = min + Math.random() * (max + 1 - min);
        return Math.floor(rand);
    }
    line_cloud(ver, p_w, p_h) {
        if (ver === 1) {
            return 0;
        }

        var size;
        if (this.randomInteger(0, 1) === 1) {
            size = 20;
        } else {
            size = 30;
        }

        if (this.randomInteger(0, ver) <= 1) {
            this.ctx.fillRect(p_w - 10, p_h, size, 10);
            this.line_cloud(ver - 1, p_w - 10, p_h);
        }
        if (this.randomInteger(0, ver) <= 1) {
            this.ctx.fillRect(p_w + 10, p_h, size, 10);
            this.line_cloud(ver - 1, p_w + 10, p_h);
        }
        if (this.randomInteger(0, ver) <= 1) {
            this.ctx.fillRect(p_w + 10, p_h + 10, size, 10);
            this.line_cloud(ver - 1, p_w + 10, p_h + 10);
        }

        if (this.randomInteger(0, ver) <= 1) {
            this.ctx.fillRect(p_w - 10, p_h + 10, size, 10);
            this.line_cloud(ver - 1, p_w - 10, p_h + 10);
        }
        if (this.randomInteger(0, ver) <= 1) {
            this.ctx.fillRect(p_w, p_h - 10, size, 10);
            this.line_cloud(ver - 1, p_w, p_h - 10);
        }
        if (this.randomInteger(0, ver) <= 1) {
            this.ctx.fillRect(p_w, p_h + 10, size, 10);
            this.line_cloud(ver - 1, p_w, p_h + 10);
        }

    }
    mode_m() {
        this.ctx.fillStyle = this.color;

        var cloud = this.randomInteger(20, 35);
        var h, w, lines, ver;
        var car_h = this.h / 2;
        for (var i = 0; i < cloud; i++) {
            h = this.randomInteger(1, this.h);
            h -= h % 10;
            w = this.randomInteger(1, this.w);
            w -= w % 10;
            this.ctx.fillRect(w, h, 30, 10);
            lines = this.randomInteger(5, 20);
            this.line_cloud(10, w, h);
        }

        lines = [];
        for (var r = 0; r < 20; r++) {
            lines[r] = this.randomInteger(0, this.w)
        }
        var size = this.w / lines;
        var l = 0;
        while (car_h < this.h) {
            l += 10;
            car_h += 10;

            for (var k = 0; k < 3; k++) {
                this.ctx.fillRect(lines[k] - this.randomInteger(l, l + 10), car_h - 10, l + this.randomInteger(l, l + 10), 10);
            }
        }
        car_h = this.h / 10;
        l = 0;
        while (car_h < this.h) {
            l += 10;
            car_h += 10;

            this.ctx.fillRect(lines[1] - this.randomInteger(l, l + 10), car_h - 10, l + this.randomInteger(l, l + 10), 10);

        }
        car_h = this.h / 2 + this.randomInteger(this.h / 4, this.h / 2);
        l = 0;
        while (car_h < this.h) {
            l += 10;
            car_h += 10;

            for (var k = 0; k < 20; k++) {
                this.ctx.fillRect(lines[k] - this.randomInteger(l, l + 10), car_h - 10, l + this.randomInteger(l, l + 10), 10);
            }
        }
    }

    add_line(l) {
        this.ctx.fillRect(0, l, 5000, 12);
    }

    castle() {
        this.paint_static();
        for (var i = 1; i < 15; i++) {
            if (i <= 3) {
                this.paint_img(i);
            } else {
                for (var k = 0; k < i; k++) {
                    this.paint_img(i);
                }
            }
        }
        this.paint_img('dop');
        
    }
    
    paint_static() {
//19 декабря репетиция ебаного театра 3-5
        var canvas = document.getElementById("vizzcastle");
        var context = canvas.getContext("2d");
        var img = new Image();
        var h, w;
        img.onload = function () {
            function randomInteger(min, max) {
                let rand = min + Math.random() * (max + 1 - min);
                return Math.floor(rand);
            }

            h = 0 - randomInteger(1, canvas.height / 5);
            
            w = randomInteger(canvas.width / 2, canvas.width - img.width - 100);
            context.drawImage(img, w, h);
        };
        var date = new Date();
        if (date.getHours() > 22 || date.getHours() < 7) {
            img.src = '/assets/trtr/trtr2/castle/luna.png';
        }else{
            img.src = '/assets/trtr/trtr2/castle/sun.png';
        }

    }

    paint_img(img_name) {

        var canvas = document.getElementById("vizzcastle");
        var context = canvas.getContext("2d");
        var img = new Image();
        var h, w;
        img.onload = function () {
            function randomInteger(min, max) {
                let rand = min + Math.random() * (max + 1 - min);
                return Math.floor(rand);
            }

            if (img.height < canvas.height) {
                h = canvas.height - img.height;
            } else {
                h = 0;
            }
            w = randomInteger(img.width, canvas.width - img.width - 100);
            context.drawImage(img, w, h);
        };
        img.src = '/assets/trtr/trtr2/castle/' + img_name + ".png";

    }

    /**
     * Помехи.
     *
     * @param {number} mode - режим. -1 для негативных помех. Остальное для обычных.
     * @param {number} w - ширина помех.
     * @param {number} h - высота помех.
     * @param {number} margin - отступы.
     */
    glitch(mode, w, h, margin) {
        if (w === undefined)
            w = this.randomInteger(1, 5);
        if (h === undefined)
            h = this.randomInteger(1, 5);
        if (margin === undefined)
            margin = this.randomInteger(1, 5);
        var car_h = 0;
        var car_w = 0;

        if (mode === -1)
            this.ctx.fillStyle = this.bg_color;
        else
            this.ctx.fillStyle = this.color;

        while ((car_h < this.h)) {
            if (car_w > this.w) {
                car_h += h + margin;
                car_w = 0;
            } else {
                for (var k = 0; k < this.w; k++) {
                    if (this.randomInteger(1, 4) === 4)
                        this.ctx.fillRect(car_w, car_h, w, h);
                    car_w += w + margin;
                }
            }
        }
    }
}

function randomInteger(min, max) {
    let rand = min + Math.random() * (max + 1 - min);
    return Math.floor(rand);
}
var test = new Vizz("demo", "#83ecf0");
var test2 = new Vizz("demo2", "#83ecf0");

var monster = new Vizz("monster", "#83ecf0");
monster.mode_m();

var cast = new Vizz("castle", "#83ecf0");
cast.castle();

var d = [];
var l = 0;
var chet = true;
$.doTimeout('someid', 50, function (  ) {
    for (var i = 0; i < 100; i++) {
        d[i] = randomInteger(0, 3);
    }
    l += 10;
    test2.mode_1(d, 10, 10, true, 'sqr', 10);
    if (chet) {
        test.mode_1(d, 10, 10, true, 'sqr', 0);

        chet = false;
    } else {
        chet = true;
    }


    test.add_line(l);
    if (l > 1000) {
        l = 0;
    }
    return true;
}, true);



window.onload = function () {
    var date = new Date();
    if (date.getHours() > 22 || date.getHours() < 7) {
        $('#day').attr('src', '/assets/trtr/trtr2/dop/night.gif');
        $('body').css('filter', 'grayscale(1)');
    }


    var x = 0;
    var bg = $('.intro');
    var bg2 = $('.no_pad');
    var bg3 = $('.chronic');
    var tab = $('.person_count');
    
    var tab_dead = $('.dead_list');
    
    var dead_nums = $('.dead_list td');
    var tmp_dead = 0;
    for (var s = 1; s <= dead_nums.length - 1; s++) {
	    tmp_dead = parseInt(dead_nums[s].innerHTML);
	    
	    if( (tmp_dead > 80 || tmp_dead < 10) && !isNaN(tmp_dead)){
		    dead_nums[s].style.color = 'white'; 
	    }
    }

    var rand1 = $('.rand1');
    var rand2 = $('.rand2');
    var rand3 = $('.rand3');
    var rand4 = $('.rand4');
    var rand5 = $('.rand5');

    var m_id = $('#meta').text().split(' ');

    var w = $('#monster').outerWidth(true);
    var h = $('#monster').outerHeight(true);

    var temp;
    var temp2;

    for (var s = 1; s <= m_id.length - 1; s++) {
        $('#monsters' + parseInt(m_id[s - 1])).css({
            'left': randomInteger(50, w * 0.9),
            'top': randomInteger(50, h * 0.9)
        });
    }

    var timer = setInterval(function () {

        for (var s = 1; s <= m_id.length - 1; s++) {
            temp = parseInt($('#monsters' + parseInt(m_id[s - 1])).css('left').replace('px', ''));
            temp2 = parseInt($('#monsters' + parseInt(m_id[s - 1])).css('top').replace('px', ''));
            if (randomInteger(0, 1) === 1) {
                temp += randomInteger(10, 20);
            } else {
                temp -= randomInteger(10, 20);
            }
            if (randomInteger(0, 1) === 1) {
                temp2 += randomInteger(10, 20);
            } else {
                temp2 -= randomInteger(10, 20);
            }
            if (temp > w * 0.9) {
                temp = 0;
            }
            if (temp < 0) {
                temp = 0;
            }
            if (temp2 > h * 0.9) {
                temp2 = 0;
            }
            if (temp2 < 0) {
                temp2 = 0;
            }
            $('#monsters' + parseInt(m_id[s - 1])).css({
                'left': temp,
                'top': temp2
            });
            $('#monsters_span' + parseInt(m_id[s - 1])).css({
                'left': temp,
                'top': temp2
            });
        }

        bg.css('background-position-x', x);
        bg2.css('background-position-y', x);
        tab.css({
            'background-position-y': x,
            'background-position-x': x
        });
        tab_dead.css({
            'background-position-y': x,
            'background-position-x': x * (-1)
        });
        bg3.css({
            'background-position-y': x * (-1),
            'background-position-x': x * (-1)
        });


        if (x > 100) {
            x = -10;
        }
        x += 10;
    }, 1000);

    var timer2 = setInterval(function () {

        for (var i = 1; i <= 5; i++) {
            $('.rand' + i).css('transform', 'translate(' + randomInteger(1, 2) + 'px, ' + randomInteger(1, 2) + 'px)');
        }

        if (x > 200) {
            x = -10;
        }
        x += 10;
    }, 500);



};