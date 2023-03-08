window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

window.Echo.channel('ChatChannel')
.listen('SendChatEvent',function(data){

  if((data['chat_contants']['user_id'] != login_user_id) && (data['chat_contants']['room_id'] == current_room_id)){
    let receive_textarea_value_array = data['chat_contants']['text'].split(/\r?\n/g);
    let receive_chat_contants = '<div class="message_box w-100"> \
                                  <div class="d-flex flex-row ms-3 mt-3 text-secondary align-items-center pb-1"> \
                                    <img src="' + data['chat_contants']['user_icon'] + '" class="border rounded-circle img-responsive me-2" width="30px">\
                                    <div class="pe-2">'+ data['chat_contants']['user_name'] +'</div>\
                                    <div class="pe-2">' + data['chat_contants']['send_at'] + '</div>\
                                    <div class="pe-2"></div>\
                                  </div>\
                                  <div class="bg-white ms-3 px-3 py-2 alert alert-secondary message-box">';
    $.each(receive_textarea_value_array, function(index, value){
      receive_chat_contants += value+'</br>';
    })
    receive_chat_contants += '</div> </div>';
  
    $('#chat_area_contants').append(receive_chat_contants)
    let chat_area_contants = $('#chat_area_contants');
    chat_area_contants[0].scrollTo(0, chat_area_contants[0].scrollHeight);
  }
});