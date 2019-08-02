(function ($) {
    $(document).on('submit','#add-text-form', function(ev) {
        var  $this = $(this)

        ev.preventDefault()
        $.post($this.attr('action'), $this.serialize(), function (data) {
               console.log('success')
               $.pjax.reload({container: '#pjax-message-list'})
        }, 'json').fail(function(error) {
                console.log(error.responseText)
        })
    })

    $(document).on('click', '#del-message', function(ev){
        ev.preventDefault()
        console.log('delete')
        $.post($(this).attr('href'), {id: $(this).data('id')}, function(data){
            console.log('success')
            $.pjax.reload({container: '#pjax-receive-message-list'})
            }, 'json').fail(function(error) {
            console.log(error.responseText)
        })
    })
    $(document).on('click', '#gridviewtrash', function(ev){
        ev.preventDefault()
        console.log('delete')
        $.get($(this).attr('href'), {id: $(this).data('id')}, function(data){
            console.log('success')
            $.pjax.reload({container: '#pjax-message-list'})
        }, 'json').fail(function(error) {
            console.log(error.responseText)
        })
    })

})(jQuery)