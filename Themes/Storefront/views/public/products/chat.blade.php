@extends('public.layout')

@section('content')

        <section class="product-details-wrap">
            <div class="container">
                <div class="messaging">
                    <div class="inbox_msg">
                        <div class="inbox_people">
                        <div class="inbox_chat">
                        @if(!$found)
                          <div class="chat_list active_chat">
                            <div class="chat_people">
                                <div class="chat_img"> <a href="{{ route('products.chat',$product->id)}}"><img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"></a> </div>
                                
                                <div class="chat_ib">
                                <h5>   <a href="{{ route('products.chat',$product->id)}}">{{$product->name}} </a></h5>
                               </div>
                            </div>
                            </div>
                          @endif
                        @foreach($all_products as $product)
                            <div class="chat_list active_chat">
                            <div class="chat_people">
                                <div class="chat_img"> <a href="{{ route('products.chat',$product->id)}}"><img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </a></div>
                                
                                <div class="chat_ib">
                                <h5>   <a href="{{ route('products.chat',$product->id)}}">{{$product->name}} </a></h5>
                            </div>
                            </div>
                            </div>
                            @endforeach
                     
                            </div>
                        </div>
                        @if($own_product)
                            <div class="row text-center">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-8"style="background:#CDD6E5;">
                                    <input type="text" class="form-control"  id="accepted_value"  name="accepted_value"  placeholder="Acceped value">
                                    <input type="hidden" name="product_id" id="product_id" value="{{$product_id}}" />
                                    <button class="btn btn-info" onclick="acceptClicked()" id="accept_offer">Accept</button>
                                </div>

                            </div>
                            @endif
                        <div class="mesgs">
                            <div class="msg_history">
                            @if(count($product_chats))
                                <input type="hidden" name="sender_id" id="sender_id" value="{{$product_chats[0]->sender_id}}" />
                            @endif
                           @foreach($product_chats as $chat)
                            @if($own_product)
                             @if($chat->type==1)
                                <div class="incoming_msg">
                                    <div class="incoming_msg_img">
                                    <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                                    </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                        <p>{{$chat->message}}</p>
                                        <span class="time_date"> {{$chat->created_at}}</span>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="outgoing_msg">
                                    <div class="sent_msg">
                                     <p>{{$chat->message}}</p>
                                     <span class="time_date"> {{$chat->created_at}}</span>
                                    </div>
                                </div>
                                @endif
                                @else
                                @if($chat->type==0)
                                <div class="incoming_msg">
                                    <div class="incoming_msg_img">
                                    <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> 
                                    </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                        <p>{{$chat->message}}</p>
                                        <span class="time_date"> {{$chat->created_at}}</span>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="outgoing_msg">
                                    <div class="sent_msg">
                                     <p>{{$chat->message}}</p>
                                     <span class="time_date"> {{$chat->created_at}}</span>
                                    </div>
                                </div>
                                @endif
                                @endif
                        @endforeach
                                <span id="incoming_msg"></span>
                                <span id="outgoing_msg"></span>
                        </div>
                        <div class="type_msg">
                        @csrf
                            <div class="input_msg_write">
                                <input type="hidden" name="product_id" id="product_id" value="{{$product_id}}" />
                         
                                <input type="text" name="message" class="write_msg" id="message" placeholder="Type a message" />
                                <button class="msg_send_btn send_message"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
     const db = firebase.firestore();
     function acceptClicked(){
            var date={{date('Y-m-d')}};
            var value = $("#accepted_value").val();
            if(value!=''){
            var row='<div class="outgoing_msg" > <div class="sent_msg">'+
                        '<p style="background-color:green">Accept with '+value+'</p>'+
                        '<span class="time_date"> '+date+'</span>'+
                    '</div>';
            $("#incoming_msg").append(row)
            $(".msg_history").stop().animate({ scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                    url: '{{url("accept_price")}}',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, product_id:$("#product_id").val(),sender_id:$("#sender_id").val(),new_price:value},
                    success: function (data) { 
                    //  console.log('success')
                      $("#accepted_value").val('')
                    },error:function(data){
                    //   console.log('error')
                    //   console.log(data)
                     
                         }
                }); 
            }
        }


        $(document).ready(function(){

            $(".msg_history").stop().animate({ scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(".send_message").click(function(){
                $(".msg_history").stop().animate({ scrollTop: $(".msg_history")[0].scrollHeight}, 1000);

                var message= $("#message").val();
                $("#message").val('');
                       var result='<div class="outgoing_msg">'+
                                        '<div class="sent_msg">'+
                                            '<p>'+message+'</p>'+
                                            '<span class="time_date"> {{date("Y-m-d H:i:s")}}</span>'+
                                        '</div>'+
                                  '</div>';
              $("#outgoing_msg").append(result)
            //   console.log('')

                $.ajax({
                    url: '{{url("createchat")}}',
                    type: 'GET',
                    data: {_token: CSRF_TOKEN, message:message,product_id:$("#product_id").val(),sender_id:$("#sender_id").val()},
                    success: function (data) { 
                      
                    },error:function(data){
                     
                         }
                }); 
            });
       });    
    </script>
<script>


         var docRef = db.collection("chatroom").doc("82-27");

docRef.get().then(function(doc) {
    if (doc.exists) {
        console.log("Document data:", doc.data());
    } else {
        // doc.data() will be undefined in this case
        console.log("No such document!");
    }
}).catch(function(error) {
    console.log("Error getting document:", error);
});

         var chatroom  = db.collection("chatroom").doc('SF');

         chatroom.get().then(function(doc) {
    if (doc.exists) {
        console.log("Document data:", doc.data());
    } else {
        // doc.data() will be undefined in this case
        console.log("No such document!");
    }
}).catch(function(error) {
    console.log("Error getting document:", error);
});




//     const messaging = firebase.messaging();
//     messaging.getToken({vapidKey: "BBjlcihhSxiStGK8cewYRTyKYBms1lsXlP-GpvoPhyuzrZp5Gkr5bgevcIWSGpwH9-GHO_e1mfIU6uC82oh648U"});
//     function sendTokenToServer(token){
//         const user_id = '{{Auth::user()->id}}'
//     axios.post('/api/save-token',{
//         token,user_id
//     }).then(res=>{
//     })
//     }
//     function retrieveToken(){
//         messaging.getToken().then((currentToken) => {
//             if (currentToken) {
                
//                 sendTokenToServer(currentToken);
//             } else {
//                 alert('you should allow notification')
//             }
//         }).catch((err) => {
//             alert('you should allow notification')
//             //console.log('An error occurred while retrieving token. ', err);
//         });
//     }
//     retrieveToken()
//     messaging.onTokenRefresh(()=>{
//         retrieveToken()
//     })
//     messaging.onMessage((payload)=>{
//         const user_id = '{{Auth::user()->id}}'
//         var receive ='<div class="incoming_msg">'+
//                     '<div class="incoming_msg_img">'+
//                     '<img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">'+ 
//                     '</div><div class="received_msg">'+
//                     '<div class="received_withd_msg">'+
//                         '<p>'+payload.data.message+'</p>'+
//                         '<span class="time_date"> '+payload.data.created_at+'</span>'+
//                     '</div></div></div>';

//        var send='<div class="outgoing_msg">'+
//                     '<div class="sent_msg">'+
//                         '<p>'+payload.data.message+'</p>'+
//                         '<span class="time_date"> '+payload.data.created_at+'</span>'+
//                     '</div>'+
//                 '</div>';
// //console.log('new message')
//         if(payload.data.owned === true){
            
//             if(user_id === $("#sender_id").val()){
                
              
//                 if(payload.data.type == 0)
//                 {
//                     $("#incoming_msg").append(receive)
                
//                 }else{
//                     $("#incoming_msg").append(send)            
//                 }
//             }else{
            
//                 if(payload.data.type == 0)
//                 {
                   
//                     $("#incoming_msg").append(send)
//                 }else{                
                
//                     $("#incoming_msg").append(receive)
//                 }
//             }
//         }else{
//             if(user_id === $("#sender_id").val()){
                
              
//                 if(payload.data.type == 0)
//                 {
//                     $("#incoming_msg").append(receive)
                
//                 }else{
//                     $("#incoming_msg").append(send)            
//                 }
//             }else{
            
//                 if(payload.data.type == 0)
//                 {
                   
//                     $("#incoming_msg").append(send)
//                 }else{                
                
//                     $("#incoming_msg").append(receive)
//                 }
//             }
//         }
//         $(".msg_history").stop().animate({ scrollTop: $(".msg_history")[0].scrollHeight}, 1000);
//     })
</script>
    <script src="{{ v(Theme::url('public/js/flatpickr.js')) }}"></script>
@endpush
