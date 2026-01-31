<footer class="bg-white border-t border-slate-100 pt-16 pb-8 mt-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <div class="col-span-1 md:col-span-1">
                <span class="text-xl font-bold text-slate-800">LinkUp</span>
                <p class="mt-4 text-slate-500 text-sm leading-relaxed">
                    Connecting people through stories, moments, and genuine interactions.
                </p>
            </div>
            
            <div>
                <h4 class="font-bold text-slate-800 mb-4">Platform</h4>
                <ul class="space-y-2 text-slate-500 text-sm">
                    <li><a href="#" class="hover:text-blue-600">News Feed</a></li>
                    <li><a href="#" class="hover:text-blue-600">Communities</a></li>
                    <li><a href="#" class="hover:text-blue-600">Trending</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-slate-800 mb-4">Company</h4>
                <ul class="space-y-2 text-slate-500 text-sm">
                    <li><a href="#" class="hover:text-blue-600">About Us</a></li>
                    <li><a href="#" class="hover:text-blue-600">Careers</a></li>
                    <li><a href="#" class="hover:text-blue-600">Privacy Policy</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-slate-800 mb-4">Subscribe</h4>
                <div class="flex gap-2">
                    <input type="email" placeholder="Email address" class="w-full px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>
        
        <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-400">
            <p>&copy; {{ date('Y') }} LinkUp. All rights reserved.</p>
            <div class="flex gap-4 mt-4 md:mt-0">
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
                <a href="#">LinkedIn</a>
            </div>
        </div>
    </div>
</footer>
