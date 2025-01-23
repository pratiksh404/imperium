<template>
    <div class="hidden md:block">
        <!-- Button to trigger the command palette -->
        <Button @click="openDialog = true" icon="pi pi-compass" iconPos="left" label="⌘ + K" size="small" />
        <!-- Command Palette Dialog -->
        <Dialog v-model:visible="openDialog" header="Command Palette" :modal="true" :closable="true" position="top"
            @hide="clearSearch" :pt="{
                root: {
                    class: 'w-3/4 md:w-1/3',
                }
            }">
            <div id="quick-search" aria-hidden="false" tabindex="-1"
                class="modal group bg-gradient-to-b from-theme-1/50 via-theme-2/50 to-black/50 transition-[visibility,opacity] w-screen h-screen fixed left-0 top-0 overflow-y-hidden z-[60] [&amp;:not(.show)]:duration-[0s,0.2s] [&amp;:not(.show)]:delay-[0.2s,0s] [&amp;:not(.show)]:invisible [&amp;:not(.show)]:opacity-0 [&amp;.show]:visible [&amp;.show]:opacity-100 [&amp;.show]:duration-[0s,0.1s] overflow-y-auto show"
                style="margin-top: 0px; margin-left: 0px; padding-left: 0px; z-index: 10000;">
                <div
                    class="relative mx-auto my-2 w-[95%] scale-95 transition-transform group-[.show]:scale-100 sm:mt-40 sm:w-[600px] lg:w-[700px]">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex w-12 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="search"
                                class="lucide lucide-search stroke-[1] w-5 h-5 -mr-1.5 text-slate-500">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                        <input type="text" placeholder="Quick search..."
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full border-slate-200 placeholder:text-slate-400/90 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80 [&amp;[type='file']]:border file:mr-4 file:py-2 file:px-4 file:rounded-l-md file:border-0 file:border-r-[1px] file:border-slate-100/10 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-500/70 hover:file:bg-200 group-[.form-inline]:flex-1 group-[.input-group]:rounded-none group-[.input-group]:[&amp;:not(:first-child)]:border-l-transparent group-[.input-group]:first:rounded-l group-[.input-group]:last:rounded-r group-[.input-group]:z-10 rounded-lg border-0 py-3.5 pl-12 pr-14 text-base shadow-lg focus:ring-0">
                        <div class="absolute inset-y-0 right-0 flex w-14 items-center">
                            <div
                                class="mr-auto rounded-[0.4rem] border bg-slate-100 px-2 py-1 text-xs text-slate-500/80">
                                ESC
                            </div>
                        </div>
                    </div>
                    <div
                        class="global-search group relative z-10 mt-1 max-h-[468px] overflow-y-auto rounded-lg bg-white pb-1 shadow-lg sm:max-h-[615px] global-search--show-result">
                        <div
                            class="flex flex-col items-center justify-center pb-28 pt-20 group-[.global-search--show-result]:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" data-lucide="search-x"
                                class="lucide lucide-search-x h-20 w-20 fill-theme-1/5 stroke-[0.5] text-theme-1/20">
                                <path d="m13.5 8.5-5 5"></path>
                                <path d="m8.5 8.5 5 5"></path>
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                            <div class="mt-5 text-xl font-medium">
                                No result found
                            </div>
                            <div class="mt-3 w-2/3 text-center leading-relaxed text-slate-500">
                                No results found for
                                <span class="global-search__keyword font-medium italic">""</span>
                                . Please try a different search term or check your
                                spelling.
                            </div>
                        </div>
                        <div class="hidden group-[.global-search--show-result]:block">
                            <div class="px-5 py-4">
                                <div class="flex items-center">
                                    <div class="text-xs uppercase text-slate-500">
                                        Start your search here...
                                    </div>
                                </div>
                                <div class="mt-3.5 flex flex-wrap gap-2">
                                    <a class="flex items-center gap-x-1.5 rounded-full border border-slate-300/70 px-3 py-0.5 hover:bg-slate-50"
                                        href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" data-lucide="users2"
                                            class="lucide lucide-users2 h-4 w-4 stroke-[1.3]">
                                            <path d="M14 19a6 6 0 0 0-12 0"></path>
                                            <circle cx="8" cy="9" r="4"></circle>
                                            <path d="M22 19a6 6 0 0 0-6-6 4 4 0 1 0 0-8"></path>
                                        </svg>
                                        Users
                                    </a>
                                    <a class="flex items-center gap-x-1.5 rounded-full border border-slate-300/70 px-3 py-0.5 hover:bg-slate-50"
                                        href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" data-lucide="building2"
                                            class="lucide lucide-building2 h-4 w-4 stroke-[1.3]">
                                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                            <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                            <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                            <path d="M10 6h4"></path>
                                            <path d="M10 10h4"></path>
                                            <path d="M10 14h4"></path>
                                            <path d="M10 18h4"></path>
                                        </svg>
                                        Departments
                                    </a>
                                    <a class="flex items-center gap-x-1.5 rounded-full border border-slate-300/70 px-3 py-0.5 hover:bg-slate-50"
                                        href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" data-lucide="kanban-square"
                                            class="lucide lucide-kanban-square h-4 w-4 stroke-[1.3]">
                                            <rect width="18" height="18" x="3" y="3" rx="2"></rect>
                                            <path d="M8 7v7"></path>
                                            <path d="M12 7v4"></path>
                                            <path d="M16 7v9"></path>
                                        </svg>
                                        Products
                                    </a>
                                    <a class="flex items-center gap-x-1.5 rounded-full border border-slate-300/70 px-3 py-0.5 hover:bg-slate-50"
                                        href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" data-lucide="mail-check"
                                            class="lucide lucide-mail-check h-4 w-4 stroke-[1.3]">
                                            <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h8"></path>
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                            <path d="m16 19 2 2 4-4"></path>
                                        </svg>
                                        Mails
                                    </a>
                                    <div data-tw-placement="bottom-end" class="dropdown relative"><a
                                            data-tw-toggle="dropdown" aria-expanded="false" href="javascript:;"
                                            class="cursor-pointer flex items-center gap-x-1.5 rounded-full border border-slate-300/70 px-3 py-0.5 hover:bg-slate-50">More
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                data-lucide="chevron-down"
                                                class="lucide lucide-chevron-down -ml-0.5 h-4 w-4 stroke-[1.3]">
                                                <path d="m6 9 6 6 6-6"></path>
                                            </svg>
                                        </a>
                                        <div data-transition="" data-selector=".show"
                                            data-enter="transition-all ease-linear duration-150"
                                            data-enter-from="absolute !mt-5 invisible opacity-0 translate-y-1"
                                            data-enter-to="!mt-1 visible opacity-100 translate-y-0"
                                            data-leave="transition-all ease-linear duration-150"
                                            data-leave-from="!mt-1 visible opacity-100 translate-y-0"
                                            data-leave-to="absolute !mt-5 invisible opacity-0 translate-y-1"
                                            class="dropdown-menu absolute z-[9999] hidden invisible opacity-0 translate-y-1"
                                            data-state="leave" style="display: none;">
                                            <div
                                                class="dropdown-content rounded-md border-transparent bg-white p-2 shadow-[0px_3px_10px_#00000017] dark:border-transparent dark:bg-darkmode-600 w-40">
                                                <a
                                                    class="cursor-pointer flex items-center p-2 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dark:bg-darkmode-600 dark:hover:bg-darkmode-400 dropdown-item"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="map"
                                                        class="lucide lucide-map stroke-[1] mr-2 h-4 w-4">
                                                        <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21">
                                                        </polygon>
                                                        <line x1="9" x2="9" y1="3" y2="18"></line>
                                                        <line x1="15" x2="15" y1="6" y2="21"></line>
                                                    </svg>
                                                    Locations</a>
                                                <a
                                                    class="cursor-pointer flex items-center p-2 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dark:bg-darkmode-600 dark:hover:bg-darkmode-400 dropdown-item"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="file-check"
                                                        class="lucide lucide-file-check stroke-[1] mr-2 h-4 w-4">
                                                        <path
                                                            d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z">
                                                        </path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                        <path d="m9 15 2 2 4-4"></path>
                                                    </svg>
                                                    Projects</a>
                                                <a
                                                    class="cursor-pointer flex items-center p-2 transition duration-300 ease-in-out rounded-md hover:bg-slate-200/60 dark:bg-darkmode-600 dark:hover:bg-darkmode-400 dropdown-item"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        data-lucide="printer"
                                                        class="lucide lucide-printer stroke-[1] mr-2 h-4 w-4">
                                                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                        <path
                                                            d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                        </path>
                                                        <rect width="12" height="8" x="6" y="14"></rect>
                                                    </svg>
                                                    Devices</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-dashed px-5 py-4">
                                <div class="flex items-center">
                                    <div class="text-xs uppercase text-slate-500">
                                        Users
                                    </div>
                                    <a class="ml-auto text-xs text-slate-500" href="#">
                                        See All
                                    </a>
                                </div>
                                <div class="mt-3.5 flex flex-col gap-1">
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="image-fit zoom-in box h-6 w-6 overflow-hidden rounded-full border-2 border-slate-200/70">
                                            <img src="dist/images/users/user6-50x50.jpg"
                                                alt="Tailwise - Admin Dashboard Template">
                                        </div>
                                        <div class="truncate font-medium">
                                            Jennifer Lawrence
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Miami, USA
                                        </div>
                                    </a>
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="image-fit zoom-in box h-6 w-6 overflow-hidden rounded-full border-2 border-slate-200/70">
                                            <img src="dist/images/users/user10-50x50.jpg"
                                                alt="Tailwise - Admin Dashboard Template">
                                        </div>
                                        <div class="truncate font-medium">
                                            Julia Roberts
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Austin, USA
                                        </div>
                                    </a>
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="image-fit zoom-in box h-6 w-6 overflow-hidden rounded-full border-2 border-slate-200/70">
                                            <img src="dist/images/users/user8-50x50.jpg"
                                                alt="Tailwise - Admin Dashboard Template">
                                        </div>
                                        <div class="truncate font-medium">
                                            Cate Blanchett
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Houston, USA
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="border-t border-dashed px-5 py-4">
                                <div class="flex items-center">
                                    <div class="text-xs uppercase text-slate-500">
                                        Departments
                                    </div>
                                    <a class="ml-auto text-xs text-slate-500" href="#">
                                        See All
                                    </a>
                                </div>
                                <div class="mt-3.5 flex flex-col gap-1">
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="zoom-in box flex h-6 w-6 items-center justify-center overflow-hidden rounded-md border border-theme-1/10 bg-theme-1/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" data-lucide="hotel"
                                                class="lucide lucide-hotel h-3.5 w-3.5 stroke-[1.3] text-theme-1">
                                                <path
                                                    d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z">
                                                </path>
                                                <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16"></path>
                                                <path d="M8 7h.01"></path>
                                                <path d="M16 7h.01"></path>
                                                <path d="M12 7h.01"></path>
                                                <path d="M12 11h.01"></path>
                                                <path d="M16 11h.01"></path>
                                                <path d="M8 11h.01"></path>
                                                <path d="M10 22v-6.5m4 0V22"></path>
                                            </svg>
                                        </div>
                                        <div class="truncate font-medium">
                                            Marketing
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Latvia
                                        </div>
                                    </a>
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="zoom-in box flex h-6 w-6 items-center justify-center overflow-hidden rounded-md border border-theme-1/10 bg-theme-1/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" data-lucide="hotel"
                                                class="lucide lucide-hotel h-3.5 w-3.5 stroke-[1.3] text-theme-1">
                                                <path
                                                    d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z">
                                                </path>
                                                <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16"></path>
                                                <path d="M8 7h.01"></path>
                                                <path d="M16 7h.01"></path>
                                                <path d="M12 7h.01"></path>
                                                <path d="M12 11h.01"></path>
                                                <path d="M16 11h.01"></path>
                                                <path d="M8 11h.01"></path>
                                                <path d="M10 22v-6.5m4 0V22"></path>
                                            </svg>
                                        </div>
                                        <div class="truncate font-medium">
                                            Sales
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Tonga
                                        </div>
                                    </a>
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="zoom-in box flex h-6 w-6 items-center justify-center overflow-hidden rounded-md border border-theme-1/10 bg-theme-1/10">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" data-lucide="hotel"
                                                class="lucide lucide-hotel h-3.5 w-3.5 stroke-[1.3] text-theme-1">
                                                <path
                                                    d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z">
                                                </path>
                                                <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16"></path>
                                                <path d="M8 7h.01"></path>
                                                <path d="M16 7h.01"></path>
                                                <path d="M12 7h.01"></path>
                                                <path d="M12 11h.01"></path>
                                                <path d="M16 11h.01"></path>
                                                <path d="M8 11h.01"></path>
                                                <path d="M10 22v-6.5m4 0V22"></path>
                                            </svg>
                                        </div>
                                        <div class="truncate font-medium">
                                            Research and Development
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Saint Barthélemy
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="border-t border-dashed px-5 py-4">
                                <div class="flex items-center">
                                    <div class="text-xs uppercase text-slate-500">
                                        Products
                                    </div>
                                    <a class="ml-auto text-xs text-slate-500" href="#">
                                        See All
                                    </a>
                                </div>
                                <div class="mt-3.5 flex flex-col gap-1">
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="image-fit zoom-in box h-6 w-6 overflow-hidden rounded-full border-2 border-slate-200/70">
                                            <img src="dist/images/products/product3-400x400.jpg"
                                                alt="Tailwise - Admin Dashboard Template">
                                        </div>
                                        <div class="truncate font-medium">
                                            8-Cup Coffee Maker
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Furniture
                                        </div>
                                    </a>
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="image-fit zoom-in box h-6 w-6 overflow-hidden rounded-full border-2 border-slate-200/70">
                                            <img src="dist/images/products/product3-400x400.jpg"
                                                alt="Tailwise - Admin Dashboard Template">
                                        </div>
                                        <div class="truncate font-medium">
                                            Wireless Earbuds with Mic
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Toys &amp; Games
                                        </div>
                                    </a>
                                    <a class="flex items-center gap-2.5 rounded-md border border-transparent p-1 hover:border-slate-100 hover:bg-slate-50/80"
                                        href="#">
                                        <div
                                            class="image-fit zoom-in box h-6 w-6 overflow-hidden rounded-full border-2 border-slate-200/70">
                                            <img src="dist/images/products/product6-400x400.jpg"
                                                alt="Tailwise - Admin Dashboard Template">
                                        </div>
                                        <div class="truncate font-medium">
                                            Smart Home Security Camera
                                        </div>
                                        <div class="hidden text-slate-500 sm:block">
                                            Home &amp; Garden
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Search Input -->
            <div class="flex items-center gap-2 bg-gray-100 p-2 rounded">
                <!-- Navigate icon svg -->
                <i class="pi pi-compass text-gray-500"></i>
                <input type="text" v-model="searchQuery" placeholder="Search for a route..." @input="filterRoutes"
                    class="bg-transparent outline-none w-full text-gray-700 placeholder-gray-400"
                    @keydown.up.prevent="highlightPrevious" @keydown.down.prevent="highlightNext"
                    @keydown.enter.prevent="selectRoute" autofocus />
            </div>

            <!-- Filtered Routes -->
            <ul v-if="filteredRoutes.length" class="mt-4 max-h-48 overflow-y-auto">
                <li v-for="(route, index) in filteredRoutes" :key="index" @mouseover="selectedIndex = index"
                    @click="navigateTo(route.url)"
                    :class="{ 'bg-black text-white': selectedIndex === index, 'hover:bg-black hover:text-white': selectedIndex !== index }"
                    class="py-2 px-4 rounded cursor-pointer transition">
                    {{ route.label }}
                </li>
            </ul>

            <ul v-else-if="recentRoutes.length" class="mt-4 max-h-48 overflow-y-auto">
                <li v-for="(route, index) in recentRoutes" :key="index" @mouseover="selectedIndex = index"
                    @click="navigateTo(route.url)"
                    :class="{ 'bg-black text-white': selectedIndex === index, 'hover:bg-black hover:text-white': selectedIndex !== index }"
                    class="py-2 px-4 rounded cursor-pointer transition">
                    <i class="pi pi-history mr-2"></i> {{ route.label }}
                </li>
            </ul>

            <!-- No Results Found -->
            <div v-else class="mt-4 text-gray-500 text-center">No routes found.</div>
        </Dialog>
    </div>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { useShortcut } from "@/Composables/shortcut";
import { usePage } from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'

const page = usePage();

const menu = page.props.menuItems ?? [];

const openDialog = ref(false);
const searchQuery = ref("");
const filteredRoutes = ref([]);
const selectedIndex = ref(-1);
const recentRoutes = ref(JSON.parse(localStorage.getItem('recentRoutes')) || []);

useShortcut("k", () => {
    openDialog.value = true;
});

// Example route list
const routes = computed(() => {
    return extractLabelsAndUrls(menu);
})

const extractLabelsAndUrls = (items, result = []) => {
    items.forEach(item => {
        if (item.label && item.url) {
            result.push({ label: item.label, url: item.url });
        }
        if (item.group) {
            extractLabelsAndUrls(item.group, result);
        }
        if (item.items) {
            extractLabelsAndUrls(item.items, result);
        }
    });
    return result;
};

// Filter function
const filterRoutes = () => {
    if (searchQuery.value.trim()) {
        filteredRoutes.value = routes.value.filter((route) =>
            route.label.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
        selectedIndex.value = filteredRoutes.value.length ? 0 : -1;
    } else {
        filteredRoutes.value = [];
        selectedIndex.value = -1;
    }
};

// Navigation function
const navigateTo = (path) => {
    openDialog.value = false; // Close the dialog
    router.visit(path);
    saveRecentRoute(path);
};

// Save recent route to local storage
const saveRecentRoute = (path) => {
    const route = routes.value.find(route => route.url === path);
    if (route) {
        recentRoutes.value = [route, ...recentRoutes.value.filter(r => r.url !== path)].slice(0, 8);
        localStorage.setItem('recentRoutes', JSON.stringify(recentRoutes.value));
    }
};


// Clear search when dialog closes
const clearSearch = () => {
    searchQuery.value = "";
    filteredRoutes.value = [];
    selectedIndex.value = -1;
};

// Highlight previous route
const highlightPrevious = () => {
    if (selectedIndex.value > 0) {
        selectedIndex.value--;
    }
};

// Highlight next route
const highlightNext = () => {
    if (selectedIndex.value < filteredRoutes.value.length - 1) {
        selectedIndex.value++;
    }
};

// Select highlighted route
const selectRoute = () => {
    if (selectedIndex.value >= 0 && selectedIndex.value < filteredRoutes.value.length) {
        navigateTo(filteredRoutes.value[selectedIndex.value].url);
    }
};

// Watch for dialog open to focus input
watch(openDialog, (newVal) => {
    if (newVal) {
        setTimeout(() => {
            document.querySelector('input[type="text"]').focus();
        }, 100);
    }
});
</script>

<style scoped>
/* Scoped styles can be minimized as Tailwind provides most of the utility */
</style>