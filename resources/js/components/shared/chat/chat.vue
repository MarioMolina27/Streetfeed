<template>
    <div class="col-12">
        <div class="chat-header">
            <div class="left-header">
                <i class="fa-icon fas fa-user" style="cursor: none;"></i>
            </div>
            <div class="right-header">
                <span class="user-name" for="user-name">{{user.name + " " + user.surnames}}</span>
            </div>
        </div>
        <div class="chat-container">
            <div class="chat-messages" ref="chatMessages">
                <div v-for="(message, index) in messages" :key="index" class="message-manage-ticket-container-chatting" :class="{ 'received-manage-ticket-chatting': !message.isMyMessage, 'sent-manage-ticket-chatting': message.isMyMessage }">
                    <p v-if="messages.length !== 0 && !showChangeDay(message)" class="message-change-day-conversion">{{ dateCorrectFormatTodayYesterday(message.day) }}</p>

                    <!-- MESSAGE -->
                    <div class="message-text-manage-ticket-chatting" :style="{ marginTop: !showChangeDay(message) ? '40px' : '0' }">
                        <div :class="{ 'message-text': message.active == 1, 'message-deleted': message.active == 0 }">
                            <p class="message-text-parraf">{{ message.message }}</p>
                        </div>
                        <div class="delete-message" v-if="message.isMyMessage && message.active == 1" @click="deleteMessage(message.id_message)">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>

                    <p class="message-info-manage-ticket-chatting" v-if="messages.length !== 0 && !showTimeStamp(message)">
                        <strong>{{ message.isMyMessage ? 'Tú' : user.name }}</strong> - {{ dateCorrectFormatTodayYesterday(message.day) + translations.atLabel + message.time }}
                    </p>
                </div>
                <p class="message-start-conversion" v-if="messages.length === 0">{{translations.startConversation}}</p>
            </div>
            <div class="chat-input">
                <textarea ref="messageInput" class="chat-text-input description" rows="1" cols="100" @keydown="onKeyDown"pInputTextarea></textarea>
                <i class="fa-icon fas fa-paper-plane" @click="sendMessage"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    inject: ['dialogRef'],
    props: {
        user: Object,
        loggedUser: Number,
        lang: String
    },
    data() {
        return {
            messages: [],
            translations: {},
        }
    },
    created() {
      import(`../../../../lang/shared/${this.lang}.json`)
            .then(module => {
                this.translations = module.default;
            })
            .catch(error => {
                console.error(`Error al importar el archivo de idioma: ${error}`);
            });
    },
    mounted() {
        this.getMessages();
        
        setInterval(() => {
            this.getMessages();
        }, 5000);
    },
    
    methods: {
        getMessages() {
            axios.get(`/api/message/get-messages/${this.loggedUser}/${this.user.id_user}`)
                .then(response => {
                    if (response.data.length !== this.messages.length) {
                        this.messages = response.data;
                        this.dateSintax();
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        showTimeStamp(message) {
            const index = this.messages.findIndex(msg => msg.id_message === message.id_message);
            const nextMessage = this.messages[index + 1];
            if (nextMessage) {
                const nextTimeParts = nextMessage.time.split(':');
                const messageTimeParts = message.time.split(':');
                return (nextMessage.day === message.day &&
                            nextTimeParts[0] === messageTimeParts[0] &&
                            nextTimeParts[1] === messageTimeParts[1] &&
                            nextMessage.id_user === message.id_user) ||
                        (nextMessage.day === message.day &&
                            nextTimeParts[0] === messageTimeParts[0] &&
                            nextTimeParts[1] === messageTimeParts[1] &&
                            nextMessage.id_user_receiver === message.id_user_receiver);
            }
            return false;
        },
        showChangeDay(message) {
            const index = this.messages.findIndex(msg => msg.id_message === message.id_message);
            const nextMessage = this.messages[index - 1];
            if (nextMessage) {
                return nextMessage.day === message.day;
            }
            return false;
        },
        dateCorrectFormatTodayYesterday(date) {
            const messsageDate = new Date(date);
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);

            if (messsageDate.toDateString() === today.toDateString()) {
                return this.translations.todayLabel;
            } else if (messsageDate.toDateString() === yesterday.toDateString()) {
                return this.translations.yesterdayLabel;
            } else {
                return messsageDate.toLocaleDateString();
            }
        },
        toggleDeleteButton(isVisible) {
            this.isDeleteButtonVisible = isVisible;
        },
        onKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault(); 
                this.sendMessage();
            }
        },
        scrollToBottom() {
            const chatMessages = this.$refs.chatMessages;
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        },
        dateSintax() {
            this.messages = this.messages.map(message => {
                const [datePart, timePart] = message.timestamp.split(' ');
                return {
                    ...message,
                    day: datePart,
                    time: timePart
                };
            });
        },
        sendMessage() {
            const message = this.$refs.messageInput.value.trim();
            if (message) {
                axios.post('/api/message/send-message', {
                    id_user: this.loggedUser,
                    id_user_receiver: this.user.id_user,
                    message: message
                })
                .then(response => {
                    this.$refs.messageInput.value = '';
                    this.getMessages();
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },
        deleteMessage(idMessage) {
            axios.post('/api/message/delete-message', {
                id_message: idMessage
            })
            .then(response => {
                this.messages = this.messages.map(message => {
                    if (message.id_message === idMessage) {
                        return {
                            ...message,
                            active: 0
                        };
                    }
                    return message;
                });
                this.getMessages();
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>
.chat-header {
    display: flex;
    gap: 2%;
    align-items: center;
    border: 1px solid #ddd;
    border-bottom: none;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    height: 50px;
    width: 100%;
}

.left-header {
    display: flex;
    align-items: center;
    margin-left: 2%;
}

.right-header {
    display: flex;
    align-items: center;
    flex: 1;
    width: 80%;
}
.user-name{
  width: 96%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-size: 1em;
}

.chat-container {
    border: 1px solid #ddd;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}
  
.chat-messages {
    padding: 10px;
    height: 500px;
    max-height: 500px;
    overflow: auto;
    overflow-x: hidden;
    position: relative;
    &,* {
      scrollbar-width: thin;
      scrollbar-color: #222222 #fff;
    }
  
    /* Chrome, Edge, and Safari */
    &::-webkit-scrollbar {
      width: 4px;
    }
  
    &::-webkit-scrollbar-track {
      background-color: transparent;
    }
  
    &::-webkit-scrollbar-thumb {
      background-color: #222222;
      border-radius: 15px;
      border: 1px solid transparent;
    }
}
  
.message-manage-ticket-container-chatting {
    max-width: 70%;  
    border-radius: 5px;
    padding: 5px;
    display: flex;
    flex-direction: column;
    margin-bottom: 5px;
}

.message-text-manage-ticket-chatting {
  max-width: 100%;
  position: relative;
  border-radius: 5px;
  .message-text {
    max-width: 100%;
    word-break: break-all;
    overflow-wrap: break-word;
    white-space: pre-line;
    .message-text-parraf {
      padding: 10px;
      margin: 0;
      z-index: 2;
      position: relative;
      border-radius: 5px;
    }
  }
  .message-deleted {
    max-width: 100%;
    word-break: break-all;
    overflow-wrap: break-word;
    white-space: pre-line;
    padding: 10px;
    font-style: italic;
    .message-text-parraf {
      margin: 0;
    }
  }
}

.message-file-manage-ticket-chatting {
  cursor: pointer;
  display: flex;
  align-items: center;
  box-sizing: border-box;
  gap: 20px;
  background-color: #fff;
  padding: 5px 10px;
  border-radius: 5px;
  position: relative;
  z-index: 1;

  .message-icon {
    display: flex;
    align-items: center;
  }
  
  .message-file-name {
    flex: 1;
    font-weight: bold;
    font-style: italic;
    word-break: break-all;
    overflow-wrap: break-word;
  }
}
.message-file-text-manage-ticket-chatting {
  display: flex;
  flex-direction: column;
  box-sizing: border-box;
  
  .message-file-manage-ticket-chatting {
    background-color: #fff;
    padding: 5px 10px;
    border: 5px solid #73FD70;
  }
  .line-separator {
    height: 1px;
    width: 100%;
    background-color: #000;
  }
}

.message-change-day-conversion {
  position: absolute;
  font-style: italic;
  color: #C7C7C7;
  left: 50%;
  transform: translateX(-50%);
}

.message-info-manage-ticket-chatting {
  margin-top: 5px;
  margin-bottom: 0;
  font-size: 0.8em;
  color: #5E5E5E;
}

.message-start-conversion {
  text-align: center;
  font-style: italic;
  color: #C7C7C7;
}

.sent-manage-ticket-chatting {
  margin-left: auto;
  align-items: end;
    .message-text-manage-ticket-chatting {
      width: auto;
      background-color: #cea1db;
      text-align: left;
      position: relative;
      z-index: 2;
      .message-text-parraf {
        background-color: #cea1db;
      }
    }
    .message-info-manage-ticket-chatting {
      text-align: right;
    }
}
  
.received-manage-ticket-chatting {
  margin-right: auto;
  align-items: start;
    .message-text-manage-ticket-chatting {
      width: auto;
      background-color: #C7C7C7;
      text-align: left;
      position: relative;
      z-index: 2;
    }
    .message-file-manage-ticket-chatting {
      border: 5px solid #C7C7C7;

    }
    .message-info-manage-ticket-chatting {
      text-align: left;
    }
}


.delete-message {
  visibility: hidden;
  position: absolute;
  top: 50%;
  left: 0px;
  transform: translateY(-50%);
  cursor: pointer;
  height: 70%;
  align-items: center;
  justify-content: center;
  width: 30px;
  border-radius: 5px 0 0 5px;
  transition: transform 0.8s ease, left 0.8s ease;
}

.message-text-manage-ticket-chatting:hover .delete-message,
.message-text-manage-ticket-chatting .delete-message:hover {
  visibility: visible;
  display: flex;
  z-index: -1;
  left: -30px;
  background-color: #ff5050;
}
  
.chat-input {
  display: flex;
  align-items: center;
  padding: 10px;
  border-top: 1px solid #ddd;
}

.chat-file-input {
  position: relative;
  flex: 1;
}

.file-info {
  position: absolute;
  bottom: 47px;
  width: 100%;
  background-color: #ddd; 
  padding: 10px;
  z-index: 2;
  border: 1px solid #000;
  border-bottom: none-;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}

.file-info p {
  margin: 0;
  display: flex;
  justify-content: space-around;
}

.file-info i {
  margin-left: 10px;
  text-align: right;
}

.description {
    margin-right: 15px;
    flex-grow: 1;
}
  
.fa-icon {
    font-size: 1.5em;
    margin: 0 7.5px;
    cursor: pointer;
}
</style>