<template>
<<<<<<< Updated upstream
        <div style="background-image: url('/clear.jpg'); background-repeat: no-repeat; background-size: cover;">
=======
        <div style="background-image: url('/clear.jpg'); background-repeat: no-repeat;">
>>>>>>> Stashed changes
        <div class="min-h-screen relative w-full">
            <!-- NavBar -->
            <NavBar />

            <div class="flex">
                <!-- Page Content -->
                <main class="w-full max-w-screen-2xl mx-auto overflow-x-hidden">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
<script setup>
import NavBar from "@/Components/Layouts/NavBar.vue";
</script>
