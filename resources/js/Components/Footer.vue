<script setup>
    import { usePage } from '@inertiajs/vue3';
    import FooterLink from '@/Components/FooterLink.vue';

    const footerPages = usePage().props.footerPages;

    console.log(usePage().props.testProp); // should show the message
    console.log(usePage().props.footerPages); // should show the message
    console.log("Yo!"); // should show the message

    const specialPages = {
    'privacy-policy': 'pages.privacy-policy',
    'privacy-policy-twitch': 'pages.privacy-policy-twitch',
    }

    function pageRoute(slug)
    {
    if (specialPages[slug]) {
        return route(specialPages[slug]);
    }
    return route('pages.show', { slug });
    }

    function isActiveRoute(slug)
    {
    const routeName = specialPages[slug] || 'pages.show';
    
    if (routeName === 'pages.show') {
        return route().current(routeName, { slug });
    } else {
        return route().current(routeName);
    }
    }
</script>

<template>
    <footer class="border-t border-grayop-700">
        <div class="max-w-8xl mt-5 pb-5 flex flex-col items-center mx-auto">
            <!-- media bottom -->
            <div class="flex space-x-4 flex-grow sm:flex-grow-0 mx-auto">
                <div class="group p-1 hover:p-0 transition-all duration-[0.2s] ease-out">
                    <a target="_blank" href="https://discord.defrag.racing" class="rounded-full transition-all duration-[0.2s] ease-out flex p-2 group-hover:p-3  bg-indigo-600 scale-100 hover:bg-indigo-700 text-white cursor-pointer">
                        <svg class="w-6 h-6" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.59 5.88997C17.36 5.31997 16.05 4.89997 14.67 4.65997C14.5 4.95997 14.3 5.36997 14.17 5.69997C12.71 5.47997 11.26 5.47997 9.83001 5.69997C9.69001 5.36997 9.49001 4.95997 9.32001 4.65997C7.94001 4.89997 6.63001 5.31997 5.40001 5.88997C2.92001 9.62997 2.25001 13.28 2.58001 16.87C4.23001 18.1 5.82001 18.84 7.39001 19.33C7.78001 18.8 8.12001 18.23 8.42001 17.64C7.85001 17.43 7.31001 17.16 6.80001 16.85C6.94001 16.75 7.07001 16.64 7.20001 16.54C10.33 18 13.72 18 16.81 16.54C16.94 16.65 17.07 16.75 17.21 16.85C16.7 17.16 16.15 17.42 15.59 17.64C15.89 18.23 16.23 18.8 16.62 19.33C18.19 18.84 19.79 18.1 21.43 16.87C21.82 12.7 20.76 9.08997 18.61 5.88997H18.59ZM8.84001 14.67C7.90001 14.67 7.13001 13.8 7.13001 12.73C7.13001 11.66 7.88001 10.79 8.84001 10.79C9.80001 10.79 10.56 11.66 10.55 12.73C10.55 13.79 9.80001 14.67 8.84001 14.67ZM15.15 14.67C14.21 14.67 13.44 13.8 13.44 12.73C13.44 11.66 14.19 10.79 15.15 10.79C16.11 10.79 16.87 11.66 16.86 12.73C16.86 13.79 16.11 14.67 15.15 14.67Z" fill="#ffffff"/>
                        </svg>
                    </a>
                </div>
                <div class="group p-1 hover:p-0 transition-all duration-[0.2s] ease-out">
                    <a target="_blank" href="https://youtube.com/defraglegends" class="rounded-full transition-all duration-[0.2s] ease-out flex p-2 group-hover:p-3 bg-red-600 hover:bg-red-700 text-white">
                        <svg class="w-6 h-6" width="800px" height="800px" viewBox="0 -3 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ffffff">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="group p-1 hover:p-0 transition-all duration-[0.2s] ease-out">
                    <a target="_blank" href="https://twitch.tv/defraglive" class="rounded-full transition-all duration-[0.2s] ease-out flex p-2 group-hover:p-3 bg-purple-600 hover:bg-purple-700 text-white cursor-pointer">
                        <svg class="w-6 h-6" width="800px" height="800px" viewBox="-0.5 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Dribbble-Light-Preview" transform="translate(-141.000000, -7399.000000)" fill="#ffffff">
                                    <g id="icons" transform="translate(56.000000, 160.000000)">
                                        <path d="M97,7249 L99,7249 L99,7244 L97,7244 L97,7249 Z M92,7249 L94,7249 L94,7244 L92,7244 L92,7249 Z M102,7250.307 L102,7241 L88,7241 L88,7253 L92,7253 L92,7255.953 L94.56,7253 L99.34,7253 L102,7250.307 Z M98.907,7256 L94.993,7256 L92.387,7259 L90,7259 L90,7256 L85,7256 L85,7242.48 L86.3,7239 L104,7239 L104,7251.173 L98.907,7256 Z" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
            </div>
            <div v-if="footerPages" class="flex space-x-4 flex-grow sm:flex-grow-0 mx-auto mt-3">
                <!-- Footer Navigation Menu-->
                <div class="max-w-8xl mx-auto mt-2">
                    <!-- Navigation Links -->
                    <div class="space-x-8 md:-my-px md:flex pb-1">
                        <FooterLink v-for="page in footerPages" :key="page.slug" :href="pageRoute(page.slug)" :active="isActiveRoute(page.slug)" :text="page.title" />
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>
