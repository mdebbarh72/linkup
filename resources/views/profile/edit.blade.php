<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-slate-900 mb-6 tracking-tight">Profile Settings</h1>

        <div class="space-y-6">
            <!-- Public Profile Section -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <div class="p-1.5 bg-blue-50 rounded-lg text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    Public Profile
                </h2>

                <form method="post" action="{{ route('profile.customize') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    <div class="flex flex-col sm:flex-row items-start gap-6">
                        <!-- Avatar Upload -->
                        <div class="shrink-0 group relative mx-auto sm:mx-0">
                             <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-slate-50 shadow-sm">
                             <label for="lien_photo" class="absolute bottom-0 right-0 bg-slate-900 text-white p-2 rounded-full cursor-pointer hover:bg-slate-800 transition shadow-lg ring-2 ring-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                             </label>
                             <input type="file" id="lien_photo" name="lien_photo" class="hidden" onchange="previewAvatar(event)">
                        </div>

                        <div class="flex-1 w-full space-y-4">
                            <div>
                                <label for="pseudo" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-slate-400 font-medium">@</span>
                                    <input type="text" name="pseudo" id="pseudo" value="{{ old('pseudo', $user->profile->pseudo ?? '') }}" class="w-full pl-8 pr-4 py-2 rounded-lg border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm font-medium" placeholder="username">
                                </div>
                                @error('pseudo') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-semibold text-slate-700 mb-1.5">Bio</label>
                                <textarea name="bio" id="bio" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition text-sm" placeholder="Tell us about yourself...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                                @error('bio') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button type="submit" class="px-5 py-2 rounded-lg bg-slate-900 text-white font-semibold text-sm hover:bg-slate-800 transition shadow-sm">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Private Info & Password -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <div class="p-1.5 bg-slate-100 rounded-lg text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    Security
                </h2>
                
                <div class="space-y-8">
                     @include('profile.partials.update-profile-information-form')
                     <div class="border-t border-slate-100 pt-8">
                        @include('profile.partials.update-password-form')
                     </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-rose-100">
                <h2 class="text-lg font-bold text-rose-600 mb-4">Danger Zone</h2>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
