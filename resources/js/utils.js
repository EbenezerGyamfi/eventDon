$(function(){
    $(document).on('change', '.custom-file-input', function(){
        let files = this.files;
        let container = $(document).find('.file-uploader[data-target="#'+ $(this).attr('id') +'"]');

        let message = files.length > 1 ? files.length + ' files selected' : files[0].name;

        container.html(message)
    })

    $('.file-uploader').on('click', function(){
        let fileInput = $($(this).data('target'));
        if ($(this).hasClass('disabled')) return false;
        fileInput.trigger('click');
    })
})
