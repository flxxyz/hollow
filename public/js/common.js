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