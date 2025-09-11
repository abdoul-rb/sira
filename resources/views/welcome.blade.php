@extends('layouts.app')

@section('content')
    <div id="root" class="font-raleway">
        <div role="region" aria-label="Notifications (F8)" tabindex="-1" style="pointer-events: none;">
            <ol tabindex="-1"
                class="fixed top-0 z-[100] flex max-h-screen w-full flex-col-reverse p-4 sm:bottom-0 sm:right-0 sm:top-auto sm:flex-col md:max-w-[420px]">
            </ol>
        </div>
        <section aria-label="Notifications alt+T" tabindex="-1" aria-live="polite" aria-atomic="false"></section>
        <main>
            <section class="relative min-h-[90vh] flex items-center justify-center bg-gray-100">
                <div class="container px-4 py-20 text-center">
                    <div class="max-w-4xl mx-auto space-y-8">
                        <h1
                            class="text-6xl font-bold bg-gradient-to-r from-gray-900 to-gray-500 bg-clip-text text-transparent">
                            Simplify Your Business Operations with
                            <span
                                class="font-dancing bg-gradient-to-r from-blue-100 via-blue-300 to-blue-500 bg-clip-text text-transparent">FlowCRM</span>
                        </h1>
                        <p class="text-lg max-w-2xl mx-auto">
                            The complete CRM and ERP solution
                            designed specifically for African small and medium businesses. Manage customers, track sales,
                            handle inventory, and grow your business with ease.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mt-12">
                            <button
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-linear-to-r from-cyan-500 to-blue-500 text-white hover:opacity-90 shadow-md hover:shadow-lg rounded-lg px-8 py-3 text-base group">
                                Try Free for 30 Days
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-arrow-right ml-2 h-5 w-5 transition-transform group-hover:translate-x-1">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </button>
                            <button
                                class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-transparent hover:bg-accent hover:text-accent-foreground h-12 rounded-lg px-8 text-base group"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-play mr-2 h-5 w-5 transition-transform group-hover:scale-110">
                                    <polygon points="6 3 20 12 6 21 6 3"></polygon>
                                </svg>Watch Demo</button>
                        </div>
                        <div class="mt-16 flex justify-center items-center space-x-8 text-sm text-muted-foreground">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                No Credit Card Required
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                30-Day Free Trial
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                Cancel Anytime
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute inset-0 bg-gradient-to-br from-transparent via-transparent to-muted/20 pointer-events-none">
                </div>
            </section>

            <section class="py-24 bg-white">
                <div class="container px-4">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="text-3xl lg:text-5xl font-bold mb-6">
                            Everything You Need to
                            <span
                                class="bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent">Grow
                                Your Business</span>
                        </h2>
                        <p class="text-lg text-gray-500 font-medium">
                            FlowCRM combines powerful CRM and ERP features in one
                            easy-to-use platform, specifically designed for the unique needs of African businesses.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        <div
                            class="rounded-lg bg-white text-gray-500 group transition-all duration-300 border-0 shadow-md hover:shadow-sm">
                            <div class="p-8 text-center">
                                <div class="mb-6 flex justify-center">
                                    <div
                                        class="p-4 bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="heading-sm mb-4">Customer Management</h3>
                                <p class="text-muted-foreground leading-relaxed">
                                    Keep track of all your customers, their
                                    contact details, purchase history, and preferences in one centralized location.
                                </p>
                            </div>
                        </div>
                        <div
                            class="rounded-lg bg-white text-gray-500 group transition-all duration-300 border-0 shadow-md hover:shadow-sm">
                            <div class="p-8 text-center">
                                <div class="mb-6 flex justify-center">
                                    <div
                                        class="p-4 bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                            <polyline points="16 7 22 7 22 13"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="heading-sm mb-4">Sales Tracking</h3>
                                <p class="text-muted-foreground leading-relaxed">
                                    Monitor your sales pipeline, track deals
                                    from lead to close, and never miss a follow-up with automated reminders.
                                </p>
                            </div>
                        </div>
                        <div
                            class="rounded-lg bg-white text-gray-500 group transition-all duration-300 border-0 shadow-md hover:shadow-sm">
                            <div class="p-8 text-center">
                                <div class="mb-6 flex justify-center">
                                    <div
                                        class="p-4 bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                            <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                            <path d="M10 9H8"></path>
                                            <path d="M16 13H8"></path>
                                            <path d="M16 17H8"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="heading-sm mb-4">Inventory Control</h3>
                                <p class="text-muted-foreground leading-relaxed">
                                    Manage your products and services, track
                                    stock levels, set reorder points, and generate purchase orders automatically.
                                </p>
                            </div>
                        </div>
                        <div
                            class="rounded-lg bg-white text-gray-500 group transition-all duration-300 border-0 shadow-md hover:shadow-sm">
                            <div class="p-8 text-center">
                                <div class="mb-6 flex justify-center">
                                    <div
                                        class="p-4 bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                            <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                                            <path d="M18 17V9"></path>
                                            <path d="M13 17V5"></path>
                                            <path d="M8 17v-3"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="heading-sm mb-4">Smart Reporting</h3>
                                <p class="text-muted-foreground leading-relaxed">
                                    Get insights into your business
                                    performance with beautiful, easy-to-understand reports and analytics dashboards.
                                </p>
                            </div>
                        </div>
                        <div
                            class="rounded-lg bg-white text-gray-500 group transition-all duration-300 border-0 shadow-md hover:shadow-sm">
                            <div class="p-8 text-center">
                                <div class="mb-6 flex justify-center">
                                    <div
                                        class="p-4 bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-white">
                                            <path
                                                d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="heading-sm mb-4">Secure &amp; Reliable</h3>
                                <p class="text-muted-foreground leading-relaxed">
                                    Your business data is protected with
                                    enterprise-grade security, regular backups, and 99.9% uptime guarantee.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="py-24 bg-gradient-subtle">
                <div class="container px-4">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="heading-lg mb-6">See FlowCRM in <span
                                class="bg-gradient-primary bg-clip-text text-transparent">Action</span></h2>
                        <p class="body-lg text-muted-foreground">Our intuitive dashboard gives you a complete overview of
                            your business operations. Manage customers, track sales, and monitor performance all in one
                            place.</p>
                    </div>
                    <div class="max-w-6xl mx-auto">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-primary rounded-3xl blur-3xl opacity-20 scale-105">
                            </div>
                            <div class="relative bg-card rounded-3xl shadow-2xl overflow-hidden border border-border/50">
                                <div class="p-6 bg-gradient-to-r from-muted/50 to-transparent">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="text-sm text-muted-foreground font-mono">
                                        flowcrm.com/dashboard</div>
                                </div><img src="/assets/crm-dashboard-mockup-CZUoH7Jj.jpg"
                                    alt="FlowCRM Dashboard Interface - Modern CRM showing customer management, sales tracking, and business analytics"
                                    class="w-full h-auto">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="py-24 bg-background">
                <div class="container px-4">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="heading-lg mb-6">Simple <span
                                class="bg-gradient-primary bg-clip-text text-transparent">Transparent Pricing</span></h2>
                        <p class="body-lg text-muted-foreground">Choose the plan that's right for your business. Start
                            with our free plan and upgrade as you grow. No hidden fees, cancel anytime.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                        <div
                            class="rounded-lg border bg-card text-card-foreground shadow-sm relative hover:shadow-lg transition-all duration-300 border-border hover:border-primary/50">
                            <div class="flex flex-col space-y-1.5 p-6 text-center pb-8 pt-8">
                                <h3 class="heading-sm mb-2">Free</h3>
                                <div class="mb-4"><span class="text-4xl font-bold">$0</span><span
                                        class="text-muted-foreground">/month</span></div>
                                <p class="text-muted-foreground">Perfect for small businesses just getting started</p>
                            </div>
                            <div class="p-6 pt-0">
                                <ul class="space-y-3 mb-8">
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Up to 100 customers</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Basic sales tracking</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Email support</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">1 user account</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Basic reporting</span></li>
                                </ul><button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-transparent hover:bg-accent hover:text-accent-foreground h-12 rounded-lg px-8 text-base w-full">Start
                                    Free</button>
                            </div>
                        </div>
                        <div
                            class="rounded-lg border bg-card text-card-foreground shadow-sm relative hover:shadow-lg transition-all duration-300 border-primary shadow-glow scale-105">
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                                <div
                                    class="bg-gradient-primary text-primary-foreground px-4 py-1 rounded-full text-sm font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star w-4 h-4 mr-1">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg>Most Popular
                                </div>
                            </div>
                            <div class="flex flex-col space-y-1.5 p-6 text-center pb-8 pt-8">
                                <h3 class="heading-sm mb-2">Pro</h3>
                                <div class="mb-4"><span class="text-4xl font-bold">$29</span><span
                                        class="text-muted-foreground">/month</span></div>
                                <p class="text-muted-foreground">Most popular for growing businesses</p>
                            </div>
                            <div class="p-6 pt-0">
                                <ul class="space-y-3 mb-8">
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Unlimited customers</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Advanced sales pipeline</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Inventory management</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Up to 5 users</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Advanced reporting</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Priority support</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Mobile app access</span></li>
                                </ul><button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-gradient-primary text-primary-foreground hover:opacity-90 shadow-md hover:shadow-lg h-12 rounded-lg px-8 text-base w-full">Start
                                    Pro Trial</button>
                            </div>
                        </div>
                        <div
                            class="rounded-lg border bg-card text-card-foreground shadow-sm relative hover:shadow-lg transition-all duration-300 border-border hover:border-primary/50">
                            <div class="flex flex-col space-y-1.5 p-6 text-center pb-8 pt-8">
                                <h3 class="heading-sm mb-2">Enterprise</h3>
                                <div class="mb-4"><span class="text-4xl font-bold">$99</span><span
                                        class="text-muted-foreground">/month</span></div>
                                <p class="text-muted-foreground">For large businesses with advanced needs</p>
                            </div>
                            <div class="p-6 pt-0">
                                <ul class="space-y-3 mb-8">
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Everything in Pro</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Unlimited users</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Custom integrations</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Dedicated support</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Advanced analytics</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">Custom training</span></li>
                                    <li class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-check h-5 w-5 text-green-500 mr-3 flex-shrink-0">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg><span class="text-sm">API access</span></li>
                                </ul><button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-transparent hover:bg-accent hover:text-accent-foreground h-12 rounded-lg px-8 text-base w-full">Contact
                                    Sales</button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-12">
                        <p class="text-muted-foreground mb-4">All plans include a 30-day free trial. No credit card
                            required.</p>
                        <p class="text-sm text-muted-foreground">Need a custom solution? <a href="#contact"
                                class="text-primary hover:underline">Contact our sales team</a></p>
                    </div>
                </div>
            </section>
            <section class="py-24 bg-gradient-subtle">
                <div class="container px-4">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="heading-lg mb-6">Trusted by <span
                                class="bg-gradient-primary bg-clip-text text-transparent">Growing Businesses</span></h2>
                        <p class="body-lg text-muted-foreground">See what business owners across Africa are saying about
                            FlowCRM</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                        <div
                            class="rounded-lg bg-card text-card-foreground hover:shadow-lg transition-all duration-300 border-0 shadow-md">
                            <div class="p-8">
                                <div class="flex items-center mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg></div>
                                <blockquote class="text-card-foreground mb-6 leading-relaxed">"FlowCRM transformed how we
                                    manage
                                    our customer relationships. Sales have increased by 40% since we started using it. The
                                    interface is so intuitive, my team was up and running in just one day."</blockquote>
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-primary-foreground font-semibold mr-4">
                                        AK</div>
                                    <div>
                                        <div class="font-semibold text-card-foreground">Amina Kone
                                        </div>
                                        <div class="text-sm text-muted-foreground">CEO, Kone
                                            Textiles</div>
                                        <div class="text-xs text-muted-foreground">Lagos, Nigeria
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="rounded-lg bg-card text-card-foreground hover:shadow-lg transition-all duration-300 border-0 shadow-md">
                            <div class="p-8">
                                <div class="flex items-center mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg></div>
                                <blockquote class="text-card-foreground mb-6 leading-relaxed">"The inventory management
                                    feature is
                                    a game-changer. We never run out of stock anymore, and the automated reorder points have
                                    saved us countless hours. Best investment we've made for our business."</blockquote>
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-primary-foreground font-semibold mr-4">
                                        DM</div>
                                    <div>
                                        <div class="font-semibold text-card-foreground">David Mensah
                                        </div>
                                        <div class="text-sm text-muted-foreground">Operations
                                            Manager, GH Electronics</div>
                                        <div class="text-xs text-muted-foreground">Accra, Ghana
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="rounded-lg bg-card text-card-foreground hover:shadow-lg transition-all duration-300 border-0 shadow-md">
                            <div class="p-8">
                                <div class="flex items-center mb-4"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-star h-5 w-5 text-yellow-400 fill-current">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg></div>
                                <blockquote class="text-card-foreground mb-6 leading-relaxed">"As a small business owner, I
                                    needed
                                    something simple yet powerful. FlowCRM gives me everything I need to manage customers,
                                    track sales, and understand my business performance. Highly recommended!"</blockquote>
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 bg-gradient-primary rounded-full flex items-center justify-center text-primary-foreground font-semibold mr-4">
                                        FR</div>
                                    <div>
                                        <div class="font-semibold text-card-foreground">Fatima
                                            Al-Rashid</div>
                                        <div class="text-sm text-muted-foreground">Founder, Desert
                                            Rose Trading</div>
                                        <div class="text-xs text-muted-foreground">Cairo, Egypt
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-12">
                        <p class="text-muted-foreground">Join over <span class="font-semibold text-primary">2,500+
                                businesses</span> already using FlowCRM</p>
                    </div>
                </div>
            </section>
            <footer class="bg-card border-t border-border">
                <div class="container px-4">
                    <div class="py-16 text-center border-b border-border">
                        <div class="max-w-3xl mx-auto">
                            <h2 class="heading-md mb-6">Ready to Transform Your <span
                                    class="bg-gradient-primary bg-clip-text text-transparent">Business?</span></h2>
                            <p class="body-md text-muted-foreground mb-8">Join thousands of African businesses already
                                growing with FlowCRM. Start your free trial today and see the difference.</p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center"><button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-gradient-primary text-primary-foreground hover:opacity-90 shadow-md hover:shadow-lg h-12 rounded-lg px-8 text-base">Start
                                    Free Trial</button><button
                                    class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-transparent hover:bg-accent hover:text-accent-foreground h-12 rounded-lg px-8 text-base">Schedule
                                    Demo</button></div>
                        </div>
                    </div>
                    <div class="py-16">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-8">
                            <div class="lg:col-span-2">
                                <div class="mb-6">
                                    <h3 class="text-2xl font-bold bg-gradient-primary bg-clip-text text-transparent">
                                        FlowCRM</h3>
                                    <p class="text-muted-foreground mt-2">Simplifying business operations for African
                                        enterprises</p>
                                </div>
                                <div class="space-y-3 text-sm text-muted-foreground">
                                    <div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-map-pin h-4 w-4 mr-2">
                                            <path
                                                d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0">
                                            </path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>Lagos, Nigeria</div>
                                    <div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-phone h-4 w-4 mr-2">
                                            <path
                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                            </path>
                                        </svg>+234 (0) 123 456 7890</div>
                                    <div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-mail h-4 w-4 mr-2">
                                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                        </svg>hello@flowcrm.com</div>
                                </div>
                                <div class="flex space-x-4 mt-6"><button
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-9 rounded-md p-2"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-facebook h-5 w-5">
                                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                            </path>
                                        </svg></button><button
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-9 rounded-md p-2"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-twitter h-5 w-5">
                                            <path
                                                d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z">
                                            </path>
                                        </svg></button><button
                                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-smooth focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-9 rounded-md p-2"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-linkedin h-5 w-5">
                                            <path
                                                d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                            </path>
                                            <rect width="4" height="12" x="2" y="9"></rect>
                                            <circle cx="4" cy="4" r="2"></circle>
                                        </svg></button></div>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-4">Product</h4>
                                <ul class="space-y-2">
                                    <li><a href="#features"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Features</a>
                                    </li>
                                    <li><a href="#pricing"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Pricing</a>
                                    </li>
                                    <li><a href="#demo"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Demo</a>
                                    </li>
                                    <li><a href="#api"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">API</a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-4">Company</h4>
                                <ul class="space-y-2">
                                    <li><a href="#about"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">About
                                            Us</a></li>
                                    <li><a href="#careers"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Careers</a>
                                    </li>
                                    <li><a href="#blog"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Blog</a>
                                    </li>
                                    <li><a href="#contact"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Contact</a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-4">Support</h4>
                                <ul class="space-y-2">
                                    <li><a href="#help"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Help
                                            Center</a></li>
                                    <li><a href="#docs"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Documentation</a>
                                    </li>
                                    <li><a href="#training"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Training</a>
                                    </li>
                                    <li><a href="#status"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Status</a>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="font-semibold mb-4">Legal</h4>
                                <ul class="space-y-2">
                                    <li><a href="#privacy"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Privacy
                                            Policy</a></li>
                                    <li><a href="#terms"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Terms
                                            of Service</a></li>
                                    <li><a href="#cookies"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">Cookie
                                            Policy</a></li>
                                    <li><a href="#gdpr"
                                            class="text-muted-foreground hover:text-primary transition-colors text-sm">GDPR</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="py-6 border-t border-border flex flex-col md:flex-row justify-between items-center">
                        <p class="text-sm text-muted-foreground">© 2024 FlowCRM. All rights reserved.</p>
                        <p class="text-sm text-muted-foreground mt-2 md:mt-0">Made with ❤️ for African businesses</p>
                    </div>
                </div>
            </footer>
        </main>
    </div>
@endsection
