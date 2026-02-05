<div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 mb-8 max-w-2xl mx-auto transition-shadow hover:shadow-md">
    <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="flex gap-4">
            <div class="shrink-0">
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->full_name }}" class="w-12 h-12 rounded-full object-cover border border-slate-100">
            </div>
            
            <div class="flex-1">
                <textarea 
                    name="content" 
                    rows="3" 
                    placeholder="What's on your mind, {{ Auth::user()->first_name }}?" 
                    class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 text-slate-800 placeholder:text-slate-400 resize-none transition-all duration-200"
                ></textarea>
                
                @error('content')
                    <p class="text-rose-500 text-sm mt-1 mb-2">{{ $message }}</p>
                @enderror

                <!-- Image Preview Container -->
                <div id="image-preview-container" class="hidden mt-4 flex flex-wrap gap-2">
                     <!-- Images will be injected here -->
                </div>

                <div class="flex items-center justify-between pt-4 mt-2 border-t border-slate-50">
                    <div class="flex items-center gap-2">
                        <label class="flex items-center gap-2 px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition cursor-pointer group">
                            <div class="p-1.5 rounded-full bg-slate-100 group-hover:bg-indigo-50 text-slate-500 group-hover:text-indigo-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                            </div>
                            <span class="font-bold text-sm">Photos</span>
                            <input type="file" id="image-input" name="images[]" class="hidden" accept="image/*" multiple onchange="previewPostImages(event)">
                        </label>
                    </div>

                    <button type="submit" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition shadow-lg shadow-slate-900/10 hover:shadow-indigo-500/20 transform hover:-translate-y-0.5 active:translate-y-0">
                        Post
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewPostImages(event) {
        const files = event.target.files;
        const container = document.getElementById('image-preview-container');
        
        // Clear previous previews
        container.innerHTML = '';
        
        if (files && files.length > 0) {
            container.classList.remove('hidden');
            
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative w-24 h-24 rounded-xl overflow-hidden border border-slate-100 shrink-0';
                    
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
        }
    }
</script>
