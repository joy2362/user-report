<template>
    <div class="flex float-right m-4">
        <div class="flex items-center mr-4">
            <select v-model="selectAction" class="py-2 px-3  bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select Action</option>
                <option value="investigate">Mark as Investigate</option>
                <option value="solved">Mark as Solved</option>
                <option value="email">Send Email</option>
            </select>
            <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2" v-if="selectAction" @click="actionEvent">
                Action
            </button>

            <button type="button" disabled class="cursor-not-allowed bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2" v-if="!selectAction" >
                Action
            </button>

        </div>

        <div class="flex items-center mr-4" v-if="requestType === 'multi'">
            <button class="btn font-medium text-blue-600 dark:text-blue-500 hover:underline" title="Delete All" @click="selectedDeleteConfirm = true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>

        <!--multiple item delete pop up -->
        <div v-if="selectedDeleteConfirm" class="center overflow-y-auto overflow-x-hidden fixed  z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" @click="selectedDeleteConfirm = false">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete selected item?</h3>
                        <button @click="confirmMultiDelete" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Yes, I'm sure
                        </button>
                        <button @click="selectedDeleteConfirm = false" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!--status change warning pop up -->
        <div v-if="showStatusChangeConfirm" class="center overflow-y-auto overflow-x-hidden fixed  z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" @click="selectedDeleteConfirm = false">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to change status?</h3>
                        <button @click="confirmStatusChange" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Yes, I'm sure
                        </button>
                        <button @click="showStatusChangeConfirm = false" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!--email subject and body pop up -->
        <div v-if="showEmailForm" class="center overflow-y-auto overflow-x-hidden fixed  z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button @click="showEmailForm = false" type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="authentication-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div class="py-6 px-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Send Email</h3>
                        <div class="my-3">
                            <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Subject</label>
                            <input type="text" id="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="subject" v-model="subject">
                        </div>
                        <div class="my-3">
                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your message</label>
                            <textarea id="message" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave your message..." v-model="body"></textarea>
                        </div>
                        <div class="my-3">
                            <label for="receiver" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Select receiver</label>
                            <select id="receiver" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="receiver">
                                <option value="author">Author</option>
                                <option value="against">Against</option>
                            </select>
                        </div>
                        <div class="p-6 text-center">
                           <button  class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2" v-if="subject && body && receiver" @click="sendEmailAction">
                                send email
                            </button>
                            <button  type="button" disabled class="cursor-not-allowed text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2" v-if="!subject && !body && !receiver" >
                                send email
                            </button>
                            <button @click="showEmailForm = false" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "action",
    props:['selectedResources','requestType'],
    data(){
        return {
            selectAction : '',
            selectedDeleteConfirm : false,
            showStatusChangeConfirm : false,
            showEmailForm:false,
            subject:"",
            body:"",
            receiver:"author",
        }
    },
    methods:{
        //send email for both type of user
        async sendEmailAction(){
            let url = "/nova-vendor/user-report/email/send";
            await Nova.request().post(url, {
                'resource'  : this.selectedResources,
                'subject' : this.subject,
                'body' : this.body,
                'receiver' : this.receiver,
                'requestType' : this.requestType,
            });
            this.$toasted.show('Email send successfully!', { type: 'success', position: "top-right",duration : 3000
            });

            this.showEmailForm = false;

            if (this.requestType === "multi"){
                this.$emit('afterEmailSend');
            }
        },

        //change report status
        async confirmStatusChange(){
            let url = "/nova-vendor/user-report/status/change";
            await Nova.request().post(url, {
                'resource'  : this.selectedResources,
                'status' : this.selectAction,
                'requestType' : this.requestType,
            });
            this.$toasted.show('Reports status change successfully!', { type: 'success', position: "top-right",duration : 3000
            });

            this.$emit('afterAction');

        },

        //handle action click
        actionEvent(){
            if(this.selectAction === "investigate" || this.selectAction === "solved"){
                this.showStatusChangeConfirm = true;
            }
            if(this.selectAction === "email"){
                this.showEmailForm = true;
            }
        },

        //delete multi report after user confirm
        async confirmMultiDelete(){
            let url = "/nova-vendor/user-report/delete/multiple";

            await Nova.request().post(url, {
                'resource'  : this.selectedResources
            });
            this.selectedDeleteConfirm = false;
            this.$toasted.show('Reports delete successfully!', { type: 'success', position: "top-right",duration : 3000
            });
            this.$emit('afterAction');
        },
    },
}
</script>

<style scoped>
.center {
    top: calc(50% - 30%);
    left: calc(50% - 20%);
}
</style>
