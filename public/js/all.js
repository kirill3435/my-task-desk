$(document).ready(function () {
    $('.sort').click(function () {
        console.log(location.href);
        sortType = $(this).attr('data-sort-type');
        setAttr('SORT', sortType);
    });

    $('.pagination-btn').click(function () {
        pageNumber = $(this).attr('data-pg-id');
        console.log(pageNumber);
        setAttr('PAGE', pageNumber);
    });

    $('.logout').click(function () {
        $.ajax({
            type: 'post',
            url: '/logout',
            success: function () {
                location.reload();
            }
        });

    });

    function getAttr(name, val) {
        let d = location.href.split("#")[0].split("?");
        let params = d[1];
    }

    function setAttr(name, val) {
        let res = '';
        let urlParts = location.href.split("#")[0].split("?");
        let base = urlParts[0];
        let query = urlParts[1];
        //if (text.indexOf("def") !== -1)
        if (query) {
            console.log(query);
            let params = query.split("&");
            console.log('params', params);
            for (let i = 0; i < params.length; i++) {
                let keyval = params[i].split("=");
                console.log('keyval', keyval);
                if (keyval[0] != name) {
                    res += params[i] + '&';
                }
            }
        }
        res += name + '=' + val;
        console.log(base + '?' + res);
        window.location.href = base + '?' + res;
        return false;
    }

    /*removeAttr() {
        let res = '';
        let d = location.href.split("#")[0].split("?");
        let base = d[0];
        let query = d[1];
        if (query) {
        }
    }*/
});