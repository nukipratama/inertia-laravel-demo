<template>
    <nav>
        <ul class="flex space-x-6">
            <li>
                <NavLink href="/" :active="$page.component.startsWith('Home')">Home</NavLink>
            </li>
            <li>
                <NavLink href="/users" :active="$page.component.startsWith('Users')">Users</NavLink>
            </li>
            <li>
                <NavLink href="/logout" method="POST" as="button">Log Out</NavLink>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import NavLink from './NavLink.vue';
</script>
