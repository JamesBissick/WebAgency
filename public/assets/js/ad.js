$('#add-image').click(function () {
    // Recover future field that'll create
    const index = +$('#widgets-counter').val();
    // Recover and replace prototype entries
    const tmpl = $('#annoucement_images').data('prototype').replace(/__name__/g, index);
    // Inject this code inside the div
    $('#annoucement_images').append(tmpl);
    $('#widgets-counter').val(index + 1);
    handleDeleteButtons();

});
function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
}
function updateCounter() {
    const count = +$('#annoucement_images div.form-group').length;
    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();