export default function printActionFunctions() {
    var count;

    $("body").on('click', ".page-link", function(){
        console.log('kk');
        $('#main_content').empty();
        let current = $(this);
        getSerialsData(current.data('pagin'), current);
    });

    function getSerialsData(pagin, el) {
        let get_serials_data = window.Routing.generate(
            'get_serials_data');
        let clickPaginationNav = false;
        if (pagin !== undefined) {
            get_serials_data += '?page=' + pagin;
            clickPaginationNav = true;
        }

        $.ajax({
            type: "GET",
            url: get_serials_data,
            error: (result) => {
                console.log(result);
            },
            success: (data) => {
                let content = '';

                $.each(data.collection, function (index, value) {
                    content += extracted(value);
                });
                if (parseInt(count) !== parseInt(data.count)) {
                    $('.pagination_container').remove();

                    let pagination = '<nav aria-label="Page navigation" class="example pagination_container">\n' +
                        '  <ul class="pagination">';

                    let number = Math.ceil(parseInt(data.count)/10);
                    var pagingNumbers = Array(number);

                    $.each(pagingNumbers, function (index, value) {
                        index += 1;
                        if (clickPaginationNav && pagin === index) {
                            pagination += '<li class="page-item active"><span class="page-link" data-pagin="' + index + '">' + index + '</span></li>';
                        } else {
                            pagination += '<li class="page-item"><span class="page-link" data-pagin="' + index + '">' + index + '</span></li>';
                        }
                    });
                    pagination += '  </ul>\n' +
                        '</nav>';
                    $(pagination).insertAfter('#main_content');
                    $(pagination).insertBefore('#main_content');
                    count = data.count;
                }

                if (clickPaginationNav && parseInt(pagin)) {
                    $("span").closest('li').removeClass('active');
                    $("span[data-pagin='" + parseInt(pagin) +"']").closest('li').addClass('active');
                }

                $('#main_content').append(content);
            },
            complete: () => {
                if (el !== undefined) {
                    el.focus();
                } else {
                    window.scrollTo(0,document.body.scrollHeight);
                }
                    // $('.justify-content-between').focus();
            }
        });
    }

    getSerialsData();

    function extracted(value) {
        return '<div class="col-md-4">\n' +
            '    <div class="card mb-4 shadow-sm">\n' +
            '        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_16b0547180a%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_16b0547180a%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.234375%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">\n' +
            '        <div class="card-body">\n' +
            '            <p class="card-text">' + value.short_description + '</p>\n' +
            '            <p class="card-text">' + value.name + '</p>\n' +
            '            <div class="d-flex justify-content-between align-items-center">\n' +
            '                <div class="btn-group">\n' +
            '                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>\n' +
            '                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>\n' +
            '                </div>\n' +
            '                <small class="text-muted">9 mins</small>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>';
    }

}
