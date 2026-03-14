<div x-data="{ open: false }" x-show="open" x-cloak x-init="$nextTick(() => { open = true; })"
    @open-modal.window="if ($event.detail.id === 'onboarding-wizard') { open = true; }"
    @close-modal.window="if ($event.detail.id === 'onboarding-wizard') { open = false; }"
    @keydown.window.escape="open = false" class="fixed inset-0 z-50 h-dvh w-screen text-gray-600 text-sm font-sans">

    <!-- Backdrop -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500/40 transition-opacity"
        @click="open = false"></div>

    <div class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 flex h-full min-h-full items-stretch justify-end p-4">
            <div x-show="open" x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" @click.stop
                role="dialog" id="radix-_r_81_" aria-labelledby="radix-_r_82_"
                class="pointer-events-auto relative flex max-h-[calc(100dvh-2rem)] w-full min-w-0 flex-col items-stretch overflow-hidden rounded-2xl bg-white shadow-lg focus:outline-none sm:max-w-xl border border-gray-300"
                tabindex="-1">
                <div data-has-scrolled="false"
                    class="custom-scrollbar relative h-full overflow-x-clip overflow-y-auto transition-all duration-300 pb-24"
                    data-slot="content">
                    <div
                        class="sticky top-0 z-50 border-b border-gray-100 bg-white p-8 transition-colors duration-200 [[data-has-scrolled=true]_&]:border-gray-100!">
                        <div class="absolute top-6 right-6 flex items-center gap-4">
                            <button type="button" @click="open = false"
                                class="shrink-0 cursor-default relative isolate inline-flex items-center justify-center border font-medium whitespace-nowrap focus-visible:shadow-sm data-disabled:cursor-default data-disabled:opacity-50 [&_svg]:shrink-0 [&_svg]:text-(--btn-icon) border-transparent text-gray-400 hover:not-data-disabled:text-gray-500 focus-visible:not-data-disabled:text-gray-700 active:not-data-disabled:text-gray-700 hover:bg-gray-100 hover:bg-gray-200 focus:outline-hidden focus-visible:not-data-disabled:shadow-sm active:not-data-disabled:bg-white active:not-data-disabled:shadow-sm disabled:opacity-50 disabled:hover:bg-transparent data-[state=focus]:not-data-disabled:bg-white! data-[state=focus]:not-data-disabled:shadow-sm! data-[state=open]:not-data-disabled:bg-white data-[state=open]:not-data-disabled:shadow-sm size-8 rounded-md p-0 *:size-5 [&_svg]:size-5">
                                <span
                                    class="pointer-events-none absolute inset-0 flex items-center justify-center opacity-0">
                                    <svg class="animate-spin size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                            d="M2.5 10c0 2.071.84 3.946 2.197 5.303A7.5 7.5 0 1010 2.5"></path>
                                    </svg>
                                </span>
                                <span class="inline-flex min-w-0 items-center justify-center gap-x-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8]"
                                        data-slot="icon">
                                        <path d="M4.75 4.75L19.25 19.25M19.25 4.75L4.75 19.25"></path>
                                    </svg>
                                    <span class="sr-only">Close dialog</span>
                                </span>
                                <span
                                    class="absolute top-1/2 left-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden"
                                    aria-hidden="true"></span>
                            </button>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">
                            Onboarding utilisateur
                        </h2>
                    </div>

                    <!-- Content -->
                    <div class="px-8 pb-8">
                        <form data-dashlane-rid="e0ed8b34c19c5253" data-dashlane-classification="other">
                            <fieldset
                                class="min-w-0 *:data-[slot=text]:mt-1 [&>*+[data-slot=control]]:mt-6 space-y-6">
                                <div class="[&_[data-slot=label]+[data-slot=control]]:mt-1.5 [&_[data-slot=label]+[data-slot=description]]:mt-1 [&_[data-slot=description]+[data-slot=control]]:mt-3 [&_[data-slot=control]+[data-slot=description]]:mt-1.5 [&_[data-slot=control]+[data-slot=error]]:mt-1.5 [&_[data-slot=control]+select+[data-slot=error]]:mt-1.5 scroll-my-[140px]"
                                    data-slot="field"><label data-slot="label" for="database_name"
                                        class="text-sm font-medium text-gray-700 data-disabled:opacity-50 select-none">Database
                                        cluster
                                        name</label>
                                    <p data-slot="description"
                                        class="text-[13px] text-gray-500 data-disabled:opacity-50">
                                        The name cannot be changed on existing database clusters.</p><span
                                        data-slot="control"
                                        class="group relative block w-full before:absolute before:inset-px before:bg-white before:shadow-sm before:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] before:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] before:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] before:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] [--border-radius:var(--radius-md)] dark:before:hidden">
                                        <div class="relative flex items-stretch border hover:border-gray-400 border-gray-300 rounded-tl-[var(--border-radius-tl,var(--border-radius))] rounded-tr-[var(--border-radius-tr,var(--border-radius))] rounded-br-[var(--border-radius-br,var(--border-radius))] rounded-bl-[var(--border-radius-bl,var(--border-radius))] focus-within:bg-blue-50 focus-within:border-blue-500! focus-within:ring-[3px] focus-within:ring-blue-100 data-[disabled=true]:border-gray-400 data-[disabled=true]:bg-gray-50 data-[disabled=true]:text-gray-500"
                                            data-disabled="true"><span
                                                class="pointer-events-none absolute inset-y-0 left-3 flex items-center"
                                                data-slot="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24"
                                                    class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8] text-gray-400"
                                                    data-slot="icon">
                                                    <path
                                                        d="M20.625 13.66C20.625 14.37 19.002 14.944 17 14.944C14.998 14.944 13.375 14.369 13.375 13.66M20.625 13.66C20.625 12.95 19.002 12.375 17 12.375C14.998 12.375 13.375 12.95 13.375 13.66M20.625 13.66V20.34C20.625 21.05 19.002 21.625 17 21.625C14.998 21.625 13.375 21.05 13.375 20.34V13.66M20.625 17C20.625 17.69 19.002 18.25 17 18.25C14.998 18.25 13.375 17.69 13.375 17M9.75 20.25H6.95C5.82989 20.25 5.26984 20.25 4.84202 20.032C4.46569 19.8403 4.15973 19.5343 3.96799 19.158C3.75 18.7302 3.75 18.1701 3.75 17.05V6.95C3.75 5.82989 3.75 5.26984 3.96799 4.84202C4.15973 4.46569 4.46569 4.15973 4.84202 3.96799C5.26984 3.75 5.82989 3.75 6.95 3.75H17.05C18.1701 3.75 18.7302 3.75 19.158 3.96799C19.5343 4.15973 19.8403 4.46569 20.032 4.84202C20.25 5.26984 20.25 5.82989 20.25 6.95V9.75H3.75M9.75 20.25V3.75M9.75 20.25H10.4963">
                                                    </path>
                                                </svg></span><input data-disabled="true" id="database_name"
                                                autocomplete="off" disabled=""
                                                class="relative block w-full appearance-none border-none! bg-transparent! px-[calc(--spacing(3)-1px)] ring-0! outline-hidden rounded-tl-[calc(var(--border-radius-tl,var(--border-radius)))] rounded-tr-[calc(var(--border-radius-tr,var(--border-radius)))] rounded-br-[calc(var(--border-radius-br,var(--border-radius)))] rounded-bl-[calc(var(--border-radius-bl,var(--border-radius)))] pl-10 h-[38px] text-sm/6 text-gray-900 placeholder:text-gray-500 data-[disabled=true]:text-gray-500 focus:border-none focus:ring-0 focus:outline-hidden"
                                                value="bellyum" data-dashlane-rid="9923e8937ce409b9"
                                                data-dashlane-classification="name" data-kwcachedvalue="bellyum"
                                                data-kwimpalastatus="asleep" data-kwimpalaid="1773462454632-6"></div>
                                    </span>
                                </div>
                                <div disabled=""
                                    class="[&_[data-slot=label]+[data-slot=control]]:mt-1.5 [&_[data-slot=label]+[data-slot=description]]:mt-1 [&_[data-slot=description]+[data-slot=control]]:mt-3 [&_[data-slot=control]+[data-slot=description]]:mt-1.5 [&_[data-slot=control]+[data-slot=error]]:mt-1.5 [&_[data-slot=control]+select+[data-slot=error]]:mt-1.5 scroll-my-[140px]"
                                    data-slot="field"><label data-slot="label" for="server_region"
                                        class="text-sm font-medium text-gray-700 data-disabled:opacity-50 select-none">Server
                                        region</label>
                                    <p data-slot="description"
                                        class="text-[13px] text-gray-500 data-disabled:opacity-50 text-pretty">Your
                                        database
                                        cluster's region may affect performance and regulatory compliance. <a
                                            href="/docs/applications#regions" rel="noreferrer" target="_blank"
                                            class="rounded-sm font-medium text-blue-600 hover:text-blue-700 focus:outline-hidden focus-visible:shadow-sm active:text-blue-800">Learn
                                            more</a></p><button type="button" role="combobox"
                                        aria-controls="radix-_r_85_" aria-expanded="false" aria-autocomplete="none"
                                        dir="ltr" data-state="closed" disabled="" data-disabled="true"
                                        id="server_region" data-slot="control"
                                        class="group relative flex w-full items-center gap-2 before:absolute before:inset-px before:bg-white before:shadow-sm before:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] before:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] before:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] before:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] after:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] after:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] after:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] after:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] [--border-radius:var(--radius-md)] dark:before:hidden focus:outline-hidden after:pointer-events-none after:absolute after:inset-0 data-disabled:before:shadow-none focus-visible:after:ring-[3px] focus-visible:after:ring-blue-100 data-[state=open]:after:ring-[3px] data-[state=open]:after:ring-blue-100"
                                        data-invalid="false" data-dashlane-label="true"
                                        data-dashlane-rid="fe12e8ae5f8e67e7" data-dashlane-classification="other">
                                        <div
                                            class="h-10 relative flex w-full min-w-0 appearance-none items-center gap-2 pr-[calc(--spacing(8)-1px)] pl-[calc(--spacing(3)-1px)] text-left text-gray-900 forced-colors:text-[CanvasText] border group-hover:border-gray-400 group-focus:border-blue-500 group-data-[state=open]:border-blue-500 border-gray-300 rounded-tl-[var(--border-radius-tl,var(--border-radius))] rounded-tr-[var(--border-radius-tr,var(--border-radius))] rounded-br-[var(--border-radius-br,var(--border-radius))] rounded-bl-[var(--border-radius-bl,var(--border-radius))] bg-transparent group-focus:bg-blue-50 group-data-[state=open]:bg-blue-50 *:data-[slot=icon]:size-5 *:data-[slot=icon]:shrink-0 *:data-[slot=icon]:text-gray-400 forced-colors:*:data-[slot=icon]:text-[CanvasText] forced-colors:group-data-highlighted/option:*:data-[slot=icon]:text-[Canvas] group-data-[disabled=true]:border-gray-400 group-data-[disabled=true]:bg-gray-50 group-data-[disabled=true]:text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8] text-gray-400!"
                                                data-slot="icon">
                                                <path
                                                    d="M14.75 10C14.75 11.5188 13.5188 12.75 12 12.75C10.4812 12.75 9.25 11.5188 9.25 10C9.25 8.48122 10.4812 7.25 12 7.25C13.5188 7.25 14.75 8.48122 14.75 10ZM19.25 10C19.25 16.0755 12 21.3929 12 21.3929C12 21.3929 4.75 16.0755 4.75 10C4.75 6 7.99594 2.75 12 2.75C16 2.75 19.25 6 19.25 10Z">
                                                </path>
                                            </svg>
                                            <div class="-my-px flex-1 truncate py-px"><span
                                                    style="pointer-events: none;">
                                                    <div class="flex items-center justify-between gap-4 pr-2">EU Central
                                                        (Frankfurt)</div>
                                                </span></div>
                                        </div><span
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8] text-gray-400"
                                                data-slot="icon">
                                                <path d="M8 10L12 14L16 10"></path>
                                            </svg></span>
                                    </button><select aria-hidden="true" tabindex="-1" name="" disabled=""
                                        style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; overflow-wrap: normal;">
                                        <option value="us-east-2">US East (Ohio)</option>
                                        <option value="us-east-1">US East (Virginia)</option>
                                        <option value="eu-central-1" selected="">EU Central (Frankfurt)</option>
                                        <option value="eu-west-1">EU West (Ireland)</option>
                                        <option value="eu-west-2">EU West (London)</option>
                                        <option value="ap-southeast-1">Asia Pacific (Singapore)</option>
                                        <option value="ap-southeast-2">Asia Pacific (Sydney)</option>
                                        <option value="ca-central-1">Canada (Central)</option>
                                        <option value="me-central-1">Middle East (UAE)</option>
                                    </select>
                                </div>
                                <div class="[&_[data-slot=label]+[data-slot=control]]:mt-1.5 [&_[data-slot=label]+[data-slot=description]]:mt-1 [&_[data-slot=description]+[data-slot=control]]:mt-3 [&_[data-slot=control]+[data-slot=description]]:mt-1.5 [&_[data-slot=control]+[data-slot=error]]:mt-1.5 [&_[data-slot=control]+select+[data-slot=error]]:mt-1.5 scroll-my-[140px]"
                                    data-slot="field"><label data-slot="label" for="server_size"
                                        class="text-sm font-medium text-gray-700 data-disabled:opacity-50 select-none">Server
                                        size</label>
                                    <p data-slot="description"
                                        class="text-[13px] text-gray-500 data-disabled:opacity-50 text-pretty">The
                                        amount of
                                        compute available to your database cluster. <a
                                            href="/docs/compute#compute-classes" rel="noreferrer" target="_blank"
                                            class="rounded-sm font-medium text-blue-600 hover:text-blue-700 focus:outline-hidden focus-visible:shadow-sm active:text-blue-800">Learn
                                            more</a></p><button type="button" role="combobox"
                                        aria-controls="radix-_r_86_" aria-expanded="false" aria-autocomplete="none"
                                        dir="ltr" data-state="closed" data-disabled="false" id="server_size"
                                        data-slot="control"
                                        class="group relative flex w-full items-center gap-2 before:absolute before:inset-px before:bg-white before:shadow-sm before:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] before:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] before:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] before:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] after:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] after:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] after:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] after:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] [--border-radius:var(--radius-md)] dark:before:hidden focus:outline-hidden after:pointer-events-none after:absolute after:inset-0 data-disabled:before:shadow-none focus-visible:after:ring-[3px] focus-visible:after:ring-blue-100 data-[state=open]:after:ring-[3px] data-[state=open]:after:ring-blue-100"
                                        data-invalid="false" data-dashlane-label="true"
                                        data-dashlane-rid="2d35e790cb026f04" data-dashlane-classification="other">
                                        <div
                                            class="h-10 relative flex w-full min-w-0 appearance-none items-center gap-2 pr-[calc(--spacing(8)-1px)] pl-[calc(--spacing(3)-1px)] text-left text-gray-900 forced-colors:text-[CanvasText] border group-hover:border-gray-400 group-focus:border-blue-500 group-data-[state=open]:border-blue-500 border-gray-300 rounded-tl-[var(--border-radius-tl,var(--border-radius))] rounded-tr-[var(--border-radius-tr,var(--border-radius))] rounded-br-[var(--border-radius-br,var(--border-radius))] rounded-bl-[var(--border-radius-bl,var(--border-radius))] bg-transparent group-focus:bg-blue-50 group-data-[state=open]:bg-blue-50 *:data-[slot=icon]:size-5 *:data-[slot=icon]:shrink-0 *:data-[slot=icon]:text-gray-400 forced-colors:*:data-[slot=icon]:text-[CanvasText] forced-colors:group-data-highlighted/option:*:data-[slot=icon]:text-[Canvas] group-data-[disabled=true]:border-gray-400 group-data-[disabled=true]:bg-gray-50 group-data-[disabled=true]:text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8] text-gray-400!"
                                                data-slot="icon">
                                                <path
                                                    d="M21.25 12V6.75C21.25 5.64543 20.3546 4.75 19.25 4.75H4.75C3.64543 4.75 2.75 5.64543 2.75 6.75V12M21.25 12H2.75M21.25 12V17.25C21.25 18.3546 20.3546 19.25 19.25 19.25H4.75C3.64543 19.25 2.75 18.3546 2.75 17.25V12M6.5 9.125C6.91421 9.125 7.25 8.78921 7.25 8.375C7.25 7.96079 6.91421 7.625 6.5 7.625C6.08579 7.625 5.75 7.96079 5.75 8.375C5.75 8.78921 6.08579 9.125 6.5 9.125ZM6.5 16.375C6.91421 16.375 7.25 16.0392 7.25 15.625C7.25 15.2108 6.91421 14.875 6.5 14.875C6.08579 14.875 5.75 15.2108 5.75 15.625C5.75 16.0392 6.08579 16.375 6.5 16.375Z">
                                                </path>
                                            </svg>
                                            <div class="-my-px flex-1 truncate py-px"><span
                                                    style="pointer-events: none;"><span
                                                        class="inline-block min-w-[184px]">Flex (1 vCPU · 512 MiB
                                                        RAM)</span><span
                                                        class="ml-2 text-[13px] text-gray-500">$6.40/mo</span></span>
                                            </div>
                                        </div><span
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8] text-gray-400"
                                                data-slot="icon">
                                                <path d="M8 10L12 14L16 10"></path>
                                            </svg></span>
                                    </button><select aria-hidden="true" tabindex="-1" name=""
                                        style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; overflow-wrap: normal;">
                                        <option value="db-flex.m-1vcpu-512mb" selected="">Flex (1 vCPU · 512 MiB
                                            RAM)$6.40/mo</option>
                                        <option value="db-flex.m-1vcpu-1gb" disabled="">Flex (1 vCPU · 1 GiB
                                            RAM)$12.80/mo</option>
                                        <option value="db-flex.m-1vcpu-2gb" disabled="">Flex (1 vCPU · 2 GiB
                                            RAM)$25.60/mo</option>
                                        <option value="db-flex.m-1vcpu-4gb" disabled="">Flex (1 vCPU · 4 GiB
                                            RAM)$51.20/mo</option>
                                        <option value="db-pro.m-1vcpu-4gb" disabled="">Pro (1 vCPU · 4 GiB RAM)$56.00/mo
                                        </option>
                                        <option value="db-pro.m-2vcpu-8gb" disabled="">Pro (2 vCPU · 8 GiB
                                            RAM)$112.00/mo</option>
                                        <option value="db-pro.m-4vcpu-16gb" disabled="">Pro (4 vCPU · 16 GiB
                                            RAM)$224.00/mo</option>
                                        <option value="db-pro.m-8vcpu-32gb" disabled="">Pro (8 vCPU · 32 GiB
                                            RAM)$448.00/mo</option>
                                    </select>
                                </div>
                                <div class="[&_[data-slot=label]+[data-slot=control]]:mt-1.5 [&_[data-slot=label]+[data-slot=description]]:mt-1 [&_[data-slot=description]+[data-slot=control]]:mt-3 [&_[data-slot=control]+[data-slot=description]]:mt-1.5 [&_[data-slot=control]+[data-slot=error]]:mt-1.5 [&_[data-slot=control]+select+[data-slot=error]]:mt-1.5 scroll-my-[140px]"
                                    data-slot="field">
                                    <div data-slot="control" class="flex items-center gap-4">
                                        <div><label data-slot="label" for="server_size"
                                                class="text-sm font-medium text-gray-700 data-disabled:opacity-50 select-none">Storage</label>
                                            <p data-slot="description"
                                                class="text-[13px] text-gray-500 data-disabled:opacity-50 text-balance">
                                                The
                                                amount of database storage is limited on the free trial. <a
                                                    class="rounded-sm font-medium text-blue-600 hover:text-blue-700 focus:outline-hidden focus-visible:shadow-sm active:text-blue-800"
                                                    href="https://cloud.laravel.com/org/abdoul-rahim/billing/subscribe">Select
                                                    a plan</a></p>
                                        </div><span data-slot="control"
                                            class="group relative block before:absolute before:inset-px before:bg-white before:shadow-sm before:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] before:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] before:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] before:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] [--border-radius:var(--radius-md)] dark:before:hidden no-arrows w-[132px] shrink-0">
                                            <div class="relative flex items-stretch border hover:border-gray-400 border-gray-300 rounded-tl-[var(--border-radius-tl,var(--border-radius))] rounded-tr-[var(--border-radius-tr,var(--border-radius))] rounded-br-[var(--border-radius-br,var(--border-radius))] rounded-bl-[var(--border-radius-bl,var(--border-radius))] focus-within:bg-blue-50 focus-within:border-blue-500! focus-within:ring-[3px] focus-within:ring-blue-100 data-[disabled=true]:border-gray-400 data-[disabled=true]:bg-gray-50 data-[disabled=true]:text-gray-500"
                                                data-disabled="true"><input data-invalid="false" data-disabled="true"
                                                    min="5" max="1000" id="storage" placeholder="10" required=""
                                                    disabled=""
                                                    class="relative block w-full appearance-none border-none! bg-transparent! px-[calc(--spacing(3)-1px)] ring-0! outline-hidden rounded-tl-[calc(var(--border-radius-tl,var(--border-radius)))] rounded-tr-[calc(var(--border-radius-tr,var(--border-radius)))] rounded-br-[calc(var(--border-radius-br,var(--border-radius)))] rounded-bl-[calc(var(--border-radius-bl,var(--border-radius)))] h-[38px] text-sm/6 text-gray-900 placeholder:text-gray-500 data-[disabled=true]:text-gray-500 focus:border-none focus:ring-0 focus:outline-hidden rounded-r-none!"
                                                    type="number" value="5" data-dashlane-rid="cff0839982f27da4"
                                                    data-dashlane-classification="other"><span
                                                    class="pointer-events-none flex shrink-0 items-center rounded-r-lg px-[calc(--spacing(3)-1px)] text-sm/6 whitespace-nowrap h-[38px]">GB</span>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <div class="[&_[data-slot=label]+[data-slot=control]]:mt-1.5 [&_[data-slot=label]+[data-slot=description]]:mt-1 [&_[data-slot=description]+[data-slot=control]]:mt-3 [&_[data-slot=control]+[data-slot=description]]:mt-1.5 [&_[data-slot=control]+[data-slot=error]]:mt-1.5 [&_[data-slot=control]+select+[data-slot=error]]:mt-1.5 scroll-my-[140px]"
                                    data-slot="field">
                                    <div data-slot="control" class="flex items-center justify-between">
                                        <div><label data-slot="label" for="is_public"
                                                class="text-sm font-medium text-gray-700 data-disabled:opacity-50 select-none">Enable
                                                public
                                                endpoint</label>
                                            <p data-slot="description"
                                                class="text-[13px] text-gray-500 data-disabled:opacity-50">Allow public
                                                access to your database cluster. <a
                                                    href="/docs/resources/databases#mysql-public-endpoints"
                                                    rel="noreferrer" target="_blank"
                                                    class="rounded-sm font-medium text-blue-600 hover:text-blue-700 focus:outline-hidden focus-visible:shadow-sm active:text-blue-800">Learn
                                                    more</a></p>
                                        </div><button type="button" role="switch" aria-checked="true"
                                            data-state="checked" value="on" data-slot="control" data-switch="true"
                                            id="is_public"
                                            class="relative isolate inline-flex h-2 w-8 shrink-0 cursor-default items-center rounded-full ease transition duration-0 data-changing:duration-200 bg-gray-50 ring-1 ring-weak data-disabled:opacity-50 data-[state=checked]:bg-blue-600 data-[state=checked]:shadow-switch-primary data-[state=checked]:ring-blue-600 focus:outline-hidden"
                                            data-dashlane-label="true" data-dashlane-rid="fd0c10fa31603642"
                                            data-dashlane-classification="other"><span data-state="checked"
                                                aria-hidden="true"
                                                class="relative inline-flex size-5 items-center justify-center rounded-full -translate-x-px -translate-y-[0.5px] transition duration-200 ease-in-out border border-transparent bg-white shadow-sm data-[state=checked]:translate-x-3.5 data-[state=checked]:in-data-disabled:shadow data-[state=checked]:in-data-disabled:bg-white data-[state=checked]:in-data-disabled:ring-black/5 after:size-2 after:rounded-full after:border after:border-transparent not-in-data-disabled:after:block in-[[data-switch]:focus-visible]:after:shadow-sm not-in-data-disabled:in-[[data-switch]:active]:after:border-blue-500/30! not-in-data-disabled:in-[[data-switch]:hover:not(:focus-visible)]:after:border-blue-300 not-in-data-disabled:in-[[data-switch]:hover:not(:focus-visible)]:after:bg-blue-100"></span></button><input
                                            aria-hidden="true" tabindex="-1" type="checkbox" value="on" checked=""
                                            style="transform: translateX(-100%); position: absolute; pointer-events: none; opacity: 0; margin: 0px; width: 32px; height: 8px;">
                                    </div>
                                </div>
                                <div>
                                    <div class="[&_[data-slot=label]+[data-slot=control]]:mt-1.5 [&_[data-slot=label]+[data-slot=description]]:mt-1 [&_[data-slot=description]+[data-slot=control]]:mt-3 [&_[data-slot=control]+[data-slot=description]]:mt-1.5 [&_[data-slot=control]+[data-slot=error]]:mt-1.5 [&_[data-slot=control]+select+[data-slot=error]]:mt-1.5 scroll-my-[140px]"
                                        data-slot="field"><label data-slot="label" for="maintenance_window"
                                            class="text-sm font-medium text-gray-700 data-disabled:opacity-50 select-none">Maintenance
                                            window</label>
                                        <p data-slot="description"
                                            class="text-[13px] text-gray-500 data-disabled:opacity-50">When maintenance
                                            may
                                            occur on your database cluster. <a
                                                href="/docs/resources/databases/laravel-mysql#maintenance-window"
                                                target="_blank" rel="noreferrer"
                                                class="rounded-sm font-medium text-blue-600 hover:text-blue-700 focus:outline-hidden focus-visible:shadow-sm active:text-blue-800">Learn
                                                more</a></p><button type="button" role="combobox"
                                            aria-controls="radix-_r_87_" aria-expanded="false" aria-autocomplete="none"
                                            dir="ltr" data-state="closed" data-disabled="false" id="maintenance_window"
                                            data-slot="control"
                                            class="group relative flex w-full items-center gap-2 before:absolute before:inset-px before:bg-white before:shadow-sm before:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] before:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] before:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] before:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] after:rounded-tl-[calc(var(--border-radius-tl,var(--border-radius))-1px)] after:rounded-tr-[calc(var(--border-radius-tr,var(--border-radius))-1px)] after:rounded-br-[calc(var(--border-radius-br,var(--border-radius))-1px)] after:rounded-bl-[calc(var(--border-radius-bl,var(--border-radius))-1px)] [--border-radius:var(--radius-md)] dark:before:hidden focus:outline-hidden after:pointer-events-none after:absolute after:inset-0 data-disabled:before:shadow-none focus-visible:after:ring-[3px] focus-visible:after:ring-blue-100 data-[state=open]:after:ring-[3px] data-[state=open]:after:ring-blue-100"
                                            data-invalid="false" data-dashlane-label="true"
                                            data-dashlane-rid="ac7fe083c9a8b77e" data-dashlane-classification="other">
                                            <div
                                                class="h-10 relative flex w-full min-w-0 appearance-none items-center gap-2 pr-[calc(--spacing(8)-1px)] pl-[calc(--spacing(3)-1px)] text-left text-gray-900 forced-colors:text-[CanvasText] border group-hover:border-gray-400 group-focus:border-blue-500 group-data-[state=open]:border-blue-500 border-gray-300 rounded-tl-[var(--border-radius-tl,var(--border-radius))] rounded-tr-[var(--border-radius-tr,var(--border-radius))] rounded-br-[var(--border-radius-br,var(--border-radius))] rounded-bl-[var(--border-radius-bl,var(--border-radius))] bg-transparent group-focus:bg-blue-50 group-data-[state=open]:bg-blue-50 *:data-[slot=icon]:size-5 *:data-[slot=icon]:shrink-0 *:data-[slot=icon]:text-gray-400 forced-colors:*:data-[slot=icon]:text-[CanvasText] forced-colors:group-data-highlighted/option:*:data-[slot=icon]:text-[Canvas] group-data-[disabled=true]:border-gray-400 group-data-[disabled=true]:bg-gray-50 group-data-[disabled=true]:text-gray-500">
                                                <div class="-my-px flex-1 truncate py-px"><span
                                                        style="pointer-events: none;">Default window</span></div>
                                            </div><span
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"><svg
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    class="shrink-0 fill-none stroke-current [stroke-linecap:round] [stroke-linejoin:round] size-5 stroke-[1.8] text-gray-400"
                                                    data-slot="icon">
                                                    <path d="M8 10L12 14L16 10"></path>
                                                </svg></span>
                                        </button><select aria-hidden="true" tabindex="-1" name=""
                                            style="position: absolute; border: 0px; width: 1px; height: 1px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; overflow-wrap: normal;">
                                            <option value="anytime" selected="">Default window</option>
                                            <option value="timeframe">Set time</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <div
                                class="flex items-start gap-2.5 rounded-md border p-2.5 text-sm/5 border-blue-200 bg-blue-50 text-blue-700 mt-6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                                    class="size-5 shrink-0">
                                    <path stroke="#00B1C4" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-opacity=".15"
                                        d="M10 1.167a8.834 8.834 0 1 1 0 17.667 8.834 8.834 0 0 1 0-17.667Z"></path>
                                    <path fill="#fff" fill-rule="evenodd"
                                        d="M1.667 10a8.333 8.333 0 1 1 16.666 0 8.333 8.333 0 0 1-16.666 0Z"
                                        clip-rule="evenodd"></path>
                                    <path fill="#05A2C2" fill-rule="evenodd"
                                        d="M1.667 10a8.333 8.333 0 1 1 16.666 0 8.333 8.333 0 0 1-16.666 0ZM10 4.664c.345 0 .625.28.625.625v.72c.714.138 1.343.512 1.736 1.055a.625.625 0 0 1-1.013.733c-.236-.326-.726-.598-1.348-.598h-.238c-.843 0-1.278.525-1.278.898v.065c0 .286.208.642.704.84l2.088.835c.848.34 1.49 1.084 1.49 2 0 1.184-1.01 1.998-2.141 2.177v.697a.625.625 0 1 1-1.25 0v-.72c-.714-.138-1.343-.512-1.736-1.055a.625.625 0 0 1 1.013-.733c.235.326.725.598 1.348.598h.156c.888 0 1.36-.554 1.36-.963 0-.286-.208-.642-.704-.84l-2.088-.835c-.849-.34-1.49-1.084-1.49-2.001v-.065c0-1.175 1.021-1.97 2.14-2.122V5.29c0-.345.28-.625.626-.625Z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>This database cluster will cost <span class="font-medium">$7.00 per month.</span>
                                    <a href="/docs/pricing#laravel-mysql" target="_blank"
                                        class="cursor-pointer relative inline-flex items-center justify-center rounded-sm font-medium whitespace-nowrap underline underline-offset-[40%] focus:outline-hidden focus-visible:decoration-transparent focus-visible:shadow-sm text-blue-700 decoration-(--background-color-info-weak) not-data-disabled:hover:decoration-(--text-color-info)">Learn
                                        more<span
                                            class="absolute top-1/2 left-1/2 size-[max(100%,2.75rem)] -translate-x-1/2 -translate-y-1/2 pointer-fine:hidden"
                                            aria-hidden="true"></span></a>
                                </div>
                            </div>
                        </form>
                        <div
                            class="fixed right-0 bottom-10 z-50 flex w-full flex-1 flex-col items-center justify-center sm:max-w-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>