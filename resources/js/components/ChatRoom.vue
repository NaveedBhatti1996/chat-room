<template>
    <div class="offset-4 col-4 col-sm-8 offset-sm-2">
        <li class="list-group-item bg-primary text-white fs-4 py-2 rounded text-center" aria-current="true">
            Chat Room
            <span class="badge rounded-pill bg-warning text-dark">{{this.totalUsers}}</span>
        </li>
        <ul class="list-group" ref="chatWindow">
            <Message
                v-for="(value,index) in chat.messages"
                :key="index"
                :user="chat.user[index]"
                :time="chat.time[index]"

            >{{value}}</Message>
        </ul>
        <div v-if="this.typing" class="badge badge-pill bg-primary">
            typing......
        </div>
        <input
            class="form-control"
            @keypress.enter="send"
            v-model="message"
            placeholder="Type your message here...."
        >

    </div>
</template>

<script>
    import Message from "./Message.vue";
    // import  Toaster from 'v-toaster';
    // import  Vue from  '@vitejs/plugin-vue';
    // import 'v-toaster/dist/v-toaster.css'
    // Vue.use(Toaster,{
    //     timeout:5000,
    // });


    export default {
        components:{
            Message
        },
        data(){
            return {
                message:'',
                typing:false,
                totalUsers:0,
                chat:{
                    messages:[],
                    user:[],
                    time:[]
                }
            }
        },
        watch:{
          message(){
              Echo.private(`chat`)
                  .whisper('typing', {
                      name: this.message
                  });
          }
        },
        methods:{
            send(){
                if(this.message.length!==0){
                    this.chat.messages.push(this.message)
                    this.chat.user.push('you')
                    this.chat.time.push(this.getTime());
                    this.scrollChatToBottom()
                    axios.post('/send',{
                        message:this.message
                    }).then(response=> {
                        console.log(response)
                        this.message=''

                    }).catch(error =>  {
                        console.log(error)
                    })
                }
            },
            scrollChatToBottom() {
                this.$nextTick(() => {
                    const chatWindow = this.$refs.chatWindow;
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                });
            },
            getTime(){
                let time =new Date();
                return time.getHours()+':'+time.getMinutes();
            },
        },mounted() {
            Echo.private('chat')
                .listen('ChatEvent', (e) => {
                    this.chat.messages.push(e.message);
                    this.chat.user.push(e.user);
                    this.chat.time.push(this.getTime());
                    this.scrollChatToBottom()
                }).listenForWhisper('typing', (e) => {
                    if(e.name!=''){
                        this.typing=true;
                    }else{
                        this.typing=false;
                    }
                })
            Echo.join(`chat`)
                .here((users) => {
                    this.totalUsers=users.length
                })
                .joining(({user}) => {
                    this.totalUsers++;
                    this.$toast.success(`${user} joined the chat room`);
                })
                .leaving(({user}) => {
                    this.totalUsers--
                    this.$toast.warning(`${user} left the chat room`);
                })
                .error((error) => {
                    console.error(error);
                });
        }
    }
</script>
<style>
    .list-group{
        overflow-y: scroll;
        height: 400px;
    }
</style>
