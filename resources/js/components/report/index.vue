<template>
    <loading-view :loading="loading">
        <HeadSection :type="type" @goBack="goBack"></HeadSection>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" v-if="data && data.length > 0">
            <div class="m-4 font-bold flow-root">
                <button v-if="hasPreviousPage" class="float-left py-2 px-4 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75" @click="previousPage">Previous</button>
                <button type="button" disabled v-if="!hasPreviousPage" class="cursor-not-allowed float-left py-2 px-4 rounded-lg shadow-md" >Previous</button>
                <button class="float-right py-2 px-4 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75" v-if="hasNextPage" @click="nextPage">Next</button>
                <button type="button" disabled class="cursor-not-allowed float-right py-2 px-4 rounded-lg shadow-md" v-if="!hasNextPage">Next</button>
            </div>
            <Action requestType="multi" @afterEmailSend="afterEmailSend" @afterAction="afterAction" :selectedResources="selectedResources" v-show="selectedResources && selectedResources.length > 0"></Action>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 ">
                <thead class="text-xs text-gray-700 uppercase border-b bg-gray-800">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <input  type="checkbox" class="w-5 h-5 float-left" @input="toggleSelectAll" :checked="selectAllChecked">
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Author name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Against name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Reason
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        View
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Delete
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" v-for="row in data" :key="data.id">
                    <th scope="col" class="px-6 py-3" >
                        <input  type="checkbox" class="w-5 h-5" @input="updateSelectionStatus(row)" :checked="selectedResources && selectedResources.includes(row)">
                    </th>
                    <td class="px-6 py-4 ">
                        {{row.authorable.firstName.charAt(0).toUpperCase() + row.authorable.firstName.slice(1)}}  {{row.authorable.lastName}}
                    </td>
                    <td class="px-6 py-4">
                        {{row.againestable.firstName.charAt(0).toUpperCase() + row.againestable.firstName.slice(1)}} {{row.againestable.lastName}}
                    </td>
                    <td class="px-6 py-4">
                        {{row.reason.charAt(0).toUpperCase() + row.reason.slice(1)}}
                    </td>
                    <td class="px-6 py-4">
                        {{row.status.charAt(0).toUpperCase() + row.status.slice(1)}}
                    </td>
                    <td class="px-6 py-4">
                        <button @click="viewDetails(row.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </td>

                    <td class="px-6 py-4">
                        <button class="font-medium text-blue-600 dark:text-blue-500 hover:underline" @click="remove(row.id)" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-danger" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <span class="text-center" v-else> No Report Found</span>


        <!--single item delete pop up -->
        <div v-if="deleteConfirm" class="center overflow-y-auto overflow-x-hidden fixed  z-50 md:inset-0 h-modal md:h-full">
            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" @click="deleteConfirm = false">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this item?</h3>
                        <button @click="confirmDelete" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Yes, I'm sure
                        </button>
                        <button @click="deleteConfirm = false" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </loading-view>
</template>

<script>
import Action from "../action/index.vue";
import HeadSection from "../asset/header.vue";
export default {
    metaInfo() {
        return {
            title: 'User Report',
        }
    },
    name: "ReportIndex",
    data(){
        return{
            type:this.$route.params.type ? this.$route.params.type : "profile",
            data:null,
            deleteConfirm:false,
            id:null,
            selectedResources: [],
            selectAllChecked:false,
            currentPage:1,
            perPage:2,
            hasNextPage:false,
            hasPreviousPage:false,
            selectedDeleteConfirm:false,
            action:'',
            loading:false,
        }
    },
    components:{
        Action,HeadSection
    },
    mounted() {
        this.fetchData()
    },
    watch: {
        selectedResources:{
            handler:function() {
                this.selectAllChecked = this.selectedResources.length === this.data.length;
            },
            deep: true
        },
    },
    methods:{

        //clear select after send email
        afterEmailSend(){
            this.clearResourceSelections();
        },


        //fetch data after action
        async afterAction(){
            this.clearResourceSelections();
            await this.fetchData();
        },

        //fetch previous page data
        previousPage(){
            this.clearResourceSelections();
            this.currentPage -= 1;
            this.fetchData();
        },

        //fetch next page data
        nextPage(){
            this.clearResourceSelections();
            this.currentPage += 1;
            this.fetchData();
        },

        //fetch report data
        async fetchData() {
            this.loading=true;
            let url = "/nova-vendor/user-report/report?perPage="+ this.perPage + "&page="+this.currentPage + "&type="+this.type;
            const {data} = await Nova.request().get(url);
            this.data = data.data;
            this.hasNextPage = !!data.next_page_url;
            this.hasPreviousPage = !!data.prev_page_url;
            this.loading=false;
        },

        //show delete warning
        remove(id){
            this.id = id;
            this.deleteConfirm = true;
        },

        //view single report
        viewDetails(id){
            this.$router.push('/user-report/' + this.type + '/' + id +'/view');
        },

        //delete single report after user confirm
        async confirmDelete(){
            let url = "/nova-vendor/user-report/report/" + this.id + "/delete"
            await Nova.request().get(url);
            await this.fetchData()
            this.deleteConfirm = false;
            this.$toasted.show('Report delete successfully!', { type: 'success', position: "top-right",duration : 3000
            })
        },

        /**
         * Toggle the selection of all resources
         */
        toggleSelectAll(event) {
            if (this.selectAllChecked) return this.clearResourceSelections()
            this.selectAllResources();
        },

        //mark all resource as selected
        selectAllResources() {
            this.selectedResources = this.data.slice(0);
            this.selectAllChecked = true;
        },

        /**
         * Clear the selected resouces and the "select all" states.
         */
        clearResourceSelections() {
            this.selectedResources = [];
            this.selectAllChecked = false;
        },
        /*
        * Update the resource selection status
        */
        updateSelectionStatus(resource) {
            const index = this.selectedResources.indexOf(resource);
            if (index > -1) {
                this.selectedResources.splice(index, 1);
            }else{
                this.selectedResources.push(resource);
            }
        },

        //go back to index page
        goBack(){
            this.$router.push('/user-report');
        }
    },
}
</script>

<style scoped>
.center {
    top: calc(50% - 20%);
    left: calc(50% - 20%);
}
</style>
