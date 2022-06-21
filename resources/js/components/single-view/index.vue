<template>
    <loading-view :loading="loading">
        <HeadSection :type="type" @goBack="goBack"></HeadSection>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" v-if="data">
            <Action @afterAction="fetchData" requestType="single" :selectedResources="data" ></Action>

            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" >
                <DetailsTable name="Author Name:" :description="getAuthorName"> </DetailsTable>
                <DetailsTable name="Against Name:" :description="getAgainstName"> </DetailsTable>
                <DetailsTable name="Report Type:" :description="getTypeName"> </DetailsTable>
                <DetailsTable name="Report Reason:" :description="getReasonName"> </DetailsTable>
                <DetailsTable name="Comment:" :description="getCommentName"> </DetailsTable>
                <DetailsTable name="Status:" :description="getStatusName"> </DetailsTable>
                <DetailsTable name="Attachments:" :attachments="data.attachments"> </DetailsTable>
            </table>
        </div>
    </loading-view>
</template>

<script>
import Action from "../action/index.vue";
import HeadSection from "../asset/header.vue";
import DetailsTable from "../asset/detailsTable.vue";
export default {
    metaInfo() {
        return {
            title: 'User Report',
        }
    },
    name: "viewProfileReport",
    data(){
        return{
            type:this.$route.params.type,
            id:this.$route.params.id,
            loading:false,
            data:null,
        }
    },
    computed:{
        getAuthorName(){
           return this.data.authorable.firstName.charAt(0).toUpperCase()+ this.data.authorable.firstName.slice(1) + " " + this.data.authorable.lastName;
        },
        getAgainstName(){
            return this.data.againestable.firstName.charAt(0).toUpperCase()+ this.data.againestable.firstName.slice(1) + " " + this.data.againestable.lastName;
        },
        getTypeName(){
            return this.data.type.charAt(0).toUpperCase()+ this.data.type.slice(1);
        },
        getReasonName(){
            return this.data.reason.charAt(0).toUpperCase()+ this.data.reason.slice(1);
        },
        getCommentName(){
            return this.data.comments ? this.data.comments.charAt(0).toUpperCase()+ this.data.comments.slice(1) : "----";
        },
        getStatusName(){
            return this.data.status.charAt(0).toUpperCase()+ this.data.status.slice(1);
        }
    },
    mounted() {
        this.fetchData();
    },
    components:{
        Action,HeadSection,DetailsTable
    },
    methods:{
        //go back to index page
        goBack(){
            this.$router.push('/user-report/'+this.type);
        },
        //fetch report data
        async fetchData() {
            this.loading=true;
            let url = "/nova-vendor/user-report/report/"+this.id+"/view";
            const {data} = await Nova.request().get(url);
            this.data = data;
            this.loading=false;
        },
    }
}
</script>

<style scoped>

</style>
