<script setup>
    import { Link } from '@inertiajs/vue3';
    import { computed } from 'vue';

    const props = defineProps({
        rating: Object
    });

    const bestrecordCountry = computed(() => {
        let country = props.rating.user?.country ?? props.rating.country;

        return (country == 'XX') ? '_404' : country;
    });

</script>

<template>
    <div>
        <div class="flex justify-between rounded-md p-2 items-center">

            <!--- rating data left -->
            <div class="mr-4 flex items-center">
                <!--- rank -->
                <div class="font-bold text-white text-lg w-11">{{ rating.category_rank }}</div>

                <!--- profile photo -->
                <img class="h-10 w-10 rounded-full object-cover" :src="rating.user?.profile_photo_path ? '/storage/' + rating.user?.profile_photo_path : '/images/null.jpg'" :alt="rating.user?.name ?? rating.name">

                <!--- profile data-->
                <div class="ml-4">
                    <Link class="flex rounded-md" :href="route(rating.user ? 'profile.index' : 'profile.mdd', rating.user ? rating.user.id : rating.mdd_id)">
                    <div class="flex justify-between items-center">
                        <div>
                            <img :src="`/images/flags/${bestratingCountry}.png`" class="w-5 inline mr-2" onerror="this.src='/images/flags/_404.png'" :title="bestratingCountry">
                            <Link class="font-bold text-white" :href="route(rating.user ? 'profile.index' : 'profile.mdd', rating.user ? rating.user.id : rating.mdd_id)" v-html="q3tohtml(rating.user?.name ?? rating.name)"></Link>
                        </div>
                    </div>
                    </Link>

                    <div class="text-gray-400 text-xs mt-2" :title="rating.last_activity"> {{ timeSince(rating.last_activity) }} ago</div>
                </div>

            </div>

            <!--- rating data right -->
            <div class="flex items-center">
                <!--- rating -->
                <div class="text-right ml-5">
                    <div class="text-lg font-bold text-gray-300 text-right" style="width: 100px;">{{ rating.player_rating.toFixed(3) }}</div>
                </div>

                <!--- category -->
                <div class="ml-5">
                    <div class="text-white rounded-full text-xs px-2 py-0.5 uppercase font-bold" :class="{'bg-green-700': rating.physics.includes('cpm'), 'bg-blue-600': !rating.physics.includes('cpm')}">
                        <div>{{ rating.physics }}</div>
                    </div>
                    <div class="rounded-full text-xs px-2 py-0.5 uppercase font-bold bg-gray-300 text-black mt-1">
                        <div>{{ rating.mode }}</div>
                    </div>
                </div>
            </div>

        </div>

        <!--- bar at the bottom -->
        <hr class="my-2 text-gray-700 border-gray-700 bg-gray-700">
    </div>
</template>
