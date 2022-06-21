<template>
    <tr class="bg-white dark:bg-gray-800  hover:bg-gray-50 dark:hover:bg-gray-600" >
        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">
            {{ name }}
        </td>
        <td class="px-6 py-4" v-if="description">
            {{description}}
        </td>
        <td class="px-6 py-4" v-if="attachments ">
            <div class="grid grid-cols-4 " v-if="attachments.length >0">
                <div class="mx-3" v-for="row in attachments" :key="row.id">
                    <a :href="row.url" target="_blank"> <img  :src="row.url" :alt="row.name" class="object-cover h-24 w-32"></a>
                </div>
            </div>
        <div  v-else>
            ----
        </div>
        </td>
    </tr>
</template>

<script>
export default {
    name: "detailsTable",
    props:['name','description','attachments']
}
</script>

<style scoped>

</style>
