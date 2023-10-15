<template>
    <Head>
        <title>Users</title>
        <meta type="description" content="Users Information" head-key="description">
    </Head>

    <div class="flex justify-between mb-5">
        <div class="flex items-center">
            <h1 class="text-3xl">Users</h1>
            <Link v-if="can.create_users" href="/users/create" class="text-blue-500 text-sm ml-2">New User</Link>
        </div>

        <input v-model="search" type="text" placeholder="Search..." class="border px-2 rounded-lg">
    </div>

    <!-- table -->
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="p-1.5 w-full inline-block align-middle">
                <div class="overflow-hidden border rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" aria-describedby="users-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-bold text-right text-gray-500 uppercase">
                                    Edit
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="user in users.data" :key="user.id">
                                <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                    {{ user.id }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                                    {{ user.name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                                    {{ user.email }}
                                </td>
                                <td v-if="user.can.edit" class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <Link :href="`/users/${user.id}/edit`" class="text-blue-500 hover:text-blue-700">
                                    Edit
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end table -->

    <!-- paginator -->
    <Pagination :links="users.links" class="mt-6" />
    <!-- end paginator -->
</template>

<script setup>
import Pagination from '../../Shared/Pagination.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from "lodash/debounce";

let props = defineProps({ users: Object, filters: Object, can: Object });

let search = ref(props.filters.search);

watch(search, debounce(function (value) {
    router.get('/users', { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));
</script>
