$("#ajax-test-button").click(
  function(){
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      type:'get',
      url: '/ajax_test',
      dataType: 'json',
    })
      .done((res) => {
        html = res;
        $('#ajax-test-button').append(html);
      })
      .fail((error) => {
        console.log(error.statuText);
      });
  }
)