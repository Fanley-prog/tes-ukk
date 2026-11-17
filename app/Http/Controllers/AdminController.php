<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\websites;
use App\Models\templates;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    public function index()
    {
        $websites = websites::with('template')->get();

        return view('welcome', compact('websites'));
    }
    public function add()
    {
        $templates = templates::all();

        return view('add', compact('templates'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_website' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:websites,slug'],
            'id_template' => ['required', 'exists:templates,id_template'],
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10000'],
            'gallery_photos' => ['required', 'array', 'size:5'],
            'gallery_photos.0' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20000'],
            'gallery_photos.1' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20000'],
            'gallery_photos.2' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20000'],
            'gallery_photos.3' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20000'],
            'gallery_photos.4' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,mp4,webm', 'max:100000'],
            'gallery_prices' => ['nullable', 'array', 'max:5'],
            'gallery_prices.*' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['required', 'string'],
            'instagram' => ['nullable', 'string'],
        ]);

        $logoPath = $request->file('logo')->store('websites/logos', 'public');

        $galleryPhotoPaths = collect($request->file('gallery_photos'))
            ->map(fn ($file) => $file->store('websites/gallery', 'public'))
            ->values()
            ->all();

        $galleryPrices = collect(range(0, 4))
            ->map(fn ($index) => $validated['gallery_prices'][$index] ?? null)
            ->all();

        $website = websites::create([
            'name_website' => $validated['name_website'],
            'bio' => $validated['bio'] ?? null,
            'slug' => $validated['slug'],
            'id_template' => $validated['id_template'],
            'whatsapp' => $validated['whatsapp'],
            'instagram' => $validated['instagram'] ?? null,
            'logo_path' => $logoPath,
            'gallery_photos' => $galleryPhotoPaths,
            'gallery_prices' => $galleryPrices,
        ]);

        $this->recordActivity($request, 'website.created', "Website {$website->name_website} dibuat");

        return redirect('/');
    }

    public function delete(Request $request, $id): RedirectResponse
    {
        $website = websites::findOrFail($id);
        $websiteName = $website->name_website;

        $filePaths = array_filter([
            $website->logo_path,
            ...($website->gallery_photos ?? []),
        ]);

        Storage::disk('public')->delete($filePaths);

        $website->delete();

        $this->recordActivity($request, 'website.deleted', "Website {$websiteName} dihapus");

        return redirect('/');
    }

        public function edit($id)
    {
        $website = websites::findOrFail($id);
        $templates = templates::all();

        return view('edit', compact('website', 'templates'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $website = websites::findOrFail($id);

        $validated = $request->validate([
            'name_website' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('websites', 'slug')->ignore($website->id_website, 'id_website'),
            ],
            'id_template' => ['required', 'exists:templates,id_template'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_photos' => ['sometimes', 'array', 'max:5'],
            'gallery_photos.0' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_photos.1' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_photos.2' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_photos.3' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_photos.4' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,webm', 'max:51200'],
            'gallery_prices' => ['nullable', 'array', 'max:5'],
            'gallery_prices.*' => ['nullable', 'string', 'max:100'],
            'whatsapp' => ['required', 'string'],
            'instagram' => ['nullable', 'string'],
        ]);

        $logoPath = $website->logo_path;

        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }

            $logoPath = $request->file('logo')->store('websites/logos', 'public');
        }

        $galleryPhotoPaths = $website->gallery_photos ?? [];

        foreach (range(0, 4) as $index) {
            if ($request->hasFile("gallery_photos.$index")) {
                if (! empty($galleryPhotoPaths[$index])) {
                    Storage::disk('public')->delete($galleryPhotoPaths[$index]);
                }

                $galleryPhotoPaths[$index] = $request->file("gallery_photos.$index")
                    ->store('websites/gallery', 'public');
            }
        }

        ksort($galleryPhotoPaths);

        $galleryPrices = collect(range(0, 4))
            ->map(fn ($index) => $validated['gallery_prices'][$index] ?? null)
            ->all();

        $website->update([
            'name_website' => $validated['name_website'],
            'bio' => $validated['bio'] ?? null,
            'slug' => $validated['slug'],
            'id_template' => $validated['id_template'],
            'whatsapp' => $validated['whatsapp'],
            'instagram' => $validated['instagram'] ?? null,
            'logo_path' => $logoPath,
            'gallery_photos' => array_values($galleryPhotoPaths),
            'gallery_prices' => $galleryPrices,
        ]);

        $this->recordActivity($request, 'website.updated', "Website {$website->name_website} diubah");

        return redirect('/');
    }

    public function login()
    {
        return view('login.login');
    }

    public function process(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $this->recordActivity($request, 'auth.login', 'Admin berhasil login');

            return redirect('/');
        }

        return back()
            ->withErrors(['name' => 'Nama atau password salah'])
            ->onlyInput('name');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->recordActivity($request, 'auth.logout', 'Admin berhasil logout');

        return redirect()->route('login');
    }

        public function editSettings()
    {
        return view('settings');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'name' => $validated['name'],
            'password' => $validated['password'],
        ]);

                $request->user()->update([
            'name' => $validated['name'],
            'password' => $validated['password'],
        ]);

        $this->recordActivity($request, 'profile.updated', 'Admin memperbarui username dan password');

        return redirect()
            ->route('settings.edit')
            ->with('status', 'Username dan password berhasil diperbarui');
    }   

    private function recordActivity(Request $request, string $action, string $description): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => $request->ip(),
        ]);
    }
}