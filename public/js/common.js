(function ($) {
    var methods = {
        storage: function () {
            var m, n, a = arguments, l = a.length;
            m = typeof a[0] === 'undefined' ? false : a[0], n = typeof a[1] === 'undefined' ? false : a[1];
            switch (l) {
                case 1:
                    return m === false ? undefined : localStorage.getItem(m);
                    break;
                case 2:
                    return m === false && n === false ? undefined : localStorage.setItem(m, n);
                    break;
                default:
                    return undefined;
                    break;
            }
        },
        removeStorage: function () {
            var a = arguments, m;
            m = typeof a[0] === 'undefined' ? false : a[0];
            if (m === false || localStorage.getItem(m) === null) return false;
            localStorage.removeItem(m);
            return true;
        }
    };

    $.fn.extend(methods);
})(jQuery)

function no_sub() {
    $('form').submit(function () {
        return false;
    })
}

function is_modal() {
    var m = $('.modal');m.hasClass('is-active') ? m.removeClass('is-active') : m.addClass('is-active');
}

function is_input() {
    var m = $(this), parent = m.parent(), p = parent.next();
    if (m.val() == '') {
        m.addClass('is-danger');
        if (m.hasClass('required'))
            p.addClass('is-danger').text(p.data('content'));
        return;
    }

    m.removeClass('is-danger').addClass('is-success');
    if (m.hasClass('required'))
        p.removeClass('is-danger').text('');
}

function is_click_btn(a, b, c) {
    var e = $(this), remove = 'is-primary', add = 'is-danger', text = b, ca = 'fa-question-circle',
        cr = 'fa-check-circle', v = 0;
    if (e.hasClass('is-danger'))
        add = 'is-primary', remove = 'is-danger', text = c, ca = 'fa-check-circle', cr = 'fa-question-circle', v = 1;
    e.removeClass(remove).addClass(add);
    e.find('.text').text(text);
    e.find('i').removeClass(cr).addClass(ca);
    $('input[name=' + a + ']').val(v);
}

function is_remove_btn(callback) {
    $('.exit').click(callback);
}
