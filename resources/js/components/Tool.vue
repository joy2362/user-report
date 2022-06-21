<template>
    <div>
        <heading class="mb-6">User Report</heading>

        <div  class="container mx-auto">
            <div class="grid lg:grid-cols-5 md:grid-cols-2 sm:grid-cols-1 gap-4">

                <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 p-4" @click="viewProfileReport">
                    <div class="flex flex-col items-center pb-10">
                        <svg class="mb-3 w-24 h-24 rounded-full shadow-lg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M12 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H8a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h8a5 5 0 0 1 5 5v2z"/></svg>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Profile</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Pending Report: {{count.profile}}</span>
                    </div>
                </div>

                <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 p-4" @click="viewMessageReport">
                    <div class="flex flex-col items-center pb-10">
                        <svg class="mb-3 w-24 h-24 rounded-full shadow-lg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path  class="heroicon-ui" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"/></svg>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Message</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Pending Report: {{count.message}}</span>
                    </div>
                </div>

                <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 p-4" @click="viewJobReport">
                    <div class="flex flex-col items-center pb-10">
                        <svg class="mb-3 w-24 h-24 rounded-full shadow-lg"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M2.59 13.41A1.98 1.98 0 0 1 2 12V7a5 5 0 0 1 5-5h4.99c.53 0 1.04.2 1.42.59l8 8a2 2 0 0 1 0 2.82l-8 8a2 2 0 0 1-2.82 0l-8-8zM20 12l-8-8H7a3 3 0 0 0-3 3v5l8 8 8-8zM7 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Job</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Pending Report: {{count.job}}</span>
                    </div>
                </div>

                <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 p-4" @click="viewPackageReport">
                    <div class="flex flex-col items-center pb-10">
                        <svg class="mb-3 w-24 h-24 rounded-full shadow-lg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M19.48 13.03A4 4 0 0 1 16 19h-4a4 4 0 1 1 0-8h1a1 1 0 0 0 0-2h-1a6 6 0 1 0 0 12h4a6 6 0 0 0 5.21-8.98L21.2 12a1 1 0 1 0-1.72 1.03zM4.52 10.97A4 4 0 0 1 8 5h4a4 4 0 1 1 0 8h-1a1 1 0 0 0 0 2h1a6 6 0 1 0 0-12H8a6 6 0 0 0-5.21 8.98l.01.02a1 1 0 1 0 1.72-1.03z"/></svg>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Package</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Pending Report: {{count.package}}</span>
                    </div>
                </div>

                <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 p-4" @click="viewBidReport">
                    <div class="flex flex-col items-center pb-10">
                        <svg class="mb-3 w-24 h-24 rounded-full shadow-lg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M17 22a2 2 0 0 1-2-2v-1a1 1 0 0 0-1-1 1 1 0 0 0-1 1v1a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-3H5a3 3 0 1 1 0-6h1V8c0-1.11.9-2 2-2h3V5a3 3 0 1 1 6 0v1h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1a1 1 0 0 0-1 1 1 1 0 0 0 1 1h1a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3zm3-2v-3h-1a3 3 0 1 1 0-6h1V8h-3a2 2 0 0 1-2-2V5a1 1 0 0 0-1-1 1 1 0 0 0-1 1v1a2 2 0 0 1-2 2H8v3a2 2 0 0 1-2 2H5a1 1 0 0 0-1 1 1 1 0 0 0 1 1h1a2 2 0 0 1 2 2v3h3v-1a3 3 0 1 1 6 0v1h3z"/></svg>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">Bid</h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400">Pending Report: {{count.bid}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    metaInfo() {
        return {
          title: 'User Report',
        }
    },
    data(){
        return{
            count:null,
        }
    },
    mounted() {
        this.fetchData();
    },
    methods:{
        async fetchData(){
            const  {data}  = await Nova.request().get(
                "/nova-vendor/user-report"
            );
            this.count = data;
        },
        viewProfileReport(){
            this.$router.push('/user-report/profile');
        },
        viewPackageReport(){
            this.$router.push('/user-report/package');
        },
        viewBidReport(){
            this.$router.push('/user-report/bid');
        },
        viewJobReport(){
            this.$router.push('/user-report/job');

        },
        viewMessageReport(){
            this.$router.push('/user-report/message');
        }
    },
}
</script>

<style>
/* Scoped Styles */
</style>
