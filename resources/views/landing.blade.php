<x-marketing-layout>

<section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-slate-50">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-5xl md:text-7xl font-bold text-slate-900 tracking-tight mb-6">
            Share your world,<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">unfiltered.</span>
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-10">
            A modern space to connect with friends, share moments, and discover communities that matter to you. Simple, clean, and yours.
        </p>
        <div class="flex justify-center gap-4">
            <a href="/register" class="px-8 py-4 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition shadow-xl shadow-blue-900/20">Get Started</a>
            <a href="#about" class="px-8 py-4 rounded-2xl bg-white text-slate-700 font-semibold border border-slate-200 hover:bg-slate-50 transition">Learn More</a>
        </div>
        
        <div class="mt-16 mx-auto max-w-5xl rounded-3xl bg-white p-4 shadow-soft border border-slate-100">
            <div class="bg-slate-50 rounded-2xl h-64 md:h-96 w-full flex items-center justify-center text-slate-300">
                <span class="text-lg font-medium">Dashboard Preview</span>
            </div>
        </div>
    </div>
</section>

<section id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-100 to-purple-100 rounded-3xl transform -rotate-2"></div>
                <div class="relative bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                    <div class="h-64 bg-slate-100 rounded-xl w-full"></div>
                </div>
            </div>
            <div>
                <h2 class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-2">About Us</h2>
                <h3 class="text-3xl md:text-4xl font-bold text-slate-900 mb-6">Designed for real connections.</h3>
                <p class="text-slate-600 leading-relaxed mb-6">
                    We believe social networks should be about people, not algorithms. Our platform gives you full control over your feed, ensuring you see what matters most—updates from close friends, family, and the creators you love.
                </p>
                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-slate-700">
                        <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center">✓</div>
                        No intrusive tracking
                    </li>
                    <li class="flex items-center gap-3 text-slate-700">
                        <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center">✓</div>
                        Customizable feeds
                    </li>
                    <li class="flex items-center gap-3 text-slate-700">
                        <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center">✓</div>
                        Clean, distraction-free UI
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="testimonials" class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900">Loved by thousands</h2>
            <p class="text-slate-500 mt-4">See what our community has to say</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-blue-100"></div> <div>
                        <h4 class="font-bold text-slate-900">Sarah Jenks</h4>
                        <p class="text-xs text-slate-500">Digital Artist</p>
                    </div>
                </div>
                <p class="text-slate-600">"Finally, a social platform that feels calm. The design is beautiful and I actually see my friends' posts!"</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-purple-100"></div> <div>
                        <h4 class="font-bold text-slate-900">Mike Ross</h4>
                        <p class="text-xs text-slate-500">Developer</p>
                    </div>
                </div>
                <p class="text-slate-600">"The clean interface is a breath of fresh air. No clutter, just content. Highly recommend it."</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-green-100"></div> <div>
                        <h4 class="font-bold text-slate-900">Elena G.</h4>
                        <p class="text-xs text-slate-500">Photographer</p>
                    </div>
                </div>
                <p class="text-slate-600">"Sharing my portfolio here has been amazing. The layout really makes images pop without distractions."</p>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="py-24 bg-white">
    <div class="max-w-3xl mx-auto px-6">
        <div class="bg-slate-900 rounded-3xl p-8 md:p-12 text-center md:text-left relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600 rounded-full opacity-20 blur-3xl"></div>

            <div class="grid md:grid-cols-2 gap-12 items-center relative z-10">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-4">Get in touch</h2>
                    <p class="text-slate-400 mb-8">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
                    
                    <div class="space-y-4 text-slate-300">
                        <p class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-sm">✉️</span>
                            hello@socialverse.com
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-sm">📍</span>
                            San Francisco, CA
                        </p>
                    </div>
                </div>

                <form class="space-y-4">
                    <input type="text" placeholder="Your Name" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                    <input type="email" placeholder="Your Email" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500">
                    <textarea rows="3" placeholder="Message" class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-blue-500"></textarea>
                    <button class="w-full py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-500 transition">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

</x-marketing-layout>