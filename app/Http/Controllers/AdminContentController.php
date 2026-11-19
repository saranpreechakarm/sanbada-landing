<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminContentController extends Controller
{
    public function dashboard(\App\Services\LeadAnalytics $analytics)
    {
        return view('admin.dashboard', [
            'total' => Project::count(), 'published' => Project::where('is_published', true)->count(),
            'condos' => Project::where('category', 'condo')->count(), 'villas' => Project::where('category', 'villa')->count(),
            'videoCount' => Video::count(), 'recent' => Project::latest('updated_at')->limit(5)->get(),
            'leadSummary' => $analytics->overview(),
        ]);
    }

    public function projects(Request $request)
    {
        $filters = $request->validate(['q' => 'nullable|string|max:100',
            'category' => ['nullable', Rule::in(['condo', 'villa'])],
            'status' => ['nullable', Rule::in(['published', 'draft', 'new', 'featured', 'trash'])]]);
        $query = Project::query();
        if ($q = $filters['q'] ?? null) {
            $query->where('title', 'like', '%'.$q.'%');
        }
        if ($category = $filters['category'] ?? null) {
            $query->where('category', $category);
        }
        if ($status = $filters['status'] ?? null) {
            match ($status) {
                'new' => $query->where('is_new', true),
                'featured' => $query->where('is_featured', true),
                'trash' => $query->onlyTrashed(),
                default => $query->where('is_published', $status === 'published'),
            };
        }
        return view('admin.projects.index', ['projects' => $query->orderByDesc('is_featured')->orderBy('sort_order')->orderBy('id')->paginate(15)->withQueryString()]);
    }

    public function createProject()
    {
        return view('admin.projects.form', ['project' => new Project(['category' => 'condo', 'sort_order' => 0, 'images' => []])]);
    }

    public function editProject(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function storeProject(Request $request)
    {
        return $this->saveProject($request, new Project);
    }

    public function updateProject(Request $request, Project $project)
    {
        return $this->saveProject($request, $project);
    }

    private function saveProject(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255', 'category' => ['required', Rule::in(['condo', 'villa'])],
            'location' => 'nullable|string|max:255', 'sort_order' => 'required|integer|min:0|max:100000',
            'badge' => 'required|array:en,ru', 'badge.en' => 'nullable|string|max:120', 'badge.ru' => 'nullable|string|max:120',
            'price' => 'required|array:en,ru', 'price.en' => 'nullable|string|max:255', 'price.ru' => 'nullable|string|max:255',
            'description' => 'required|array:en,ru', 'description.en' => 'required|string|max:20000', 'description.ru' => 'required|string|max:20000',
            'seo_title' => 'sometimes|array:en,ru', 'seo_title.en' => 'nullable|string|max:120', 'seo_title.ru' => 'nullable|string|max:120',
            'seo_description' => 'sometimes|array:en,ru', 'seo_description.en' => 'nullable|string|max:165', 'seo_description.ru' => 'nullable|string|max:165',
            'is_published' => 'required|boolean', 'is_new' => 'required|boolean', 'is_featured' => 'required|boolean',
            'new_year' => 'nullable|integer|between:2000,2100',
            'new_images' => 'nullable|array|max:30', 'new_images.*' => 'required|file|image|mimes:jpg,jpeg,png,webp|max:8192|dimensions:max_width=12000,max_height=12000',
            'remove_images' => 'nullable|array', 'remove_images.*' => ['integer', Rule::in(array_keys($project->images ?? []))],
            'image_order' => 'nullable|array', 'image_order.*' => 'required|integer|min:0|max:100000',
            'gallery_order' => 'nullable|array|max:60',
            'gallery_order.*' => ['required', 'string', 'distinct:strict', 'regex:/^(old|new):[0-9]+$/'],
            'brochure' => 'nullable|file|mimes:pdf|max:20480', 'remove_brochure' => 'nullable|boolean',
        ], [
            'description.en.required' => 'กรุณาใส่รายละเอียดภาษาอังกฤษ', 'description.ru.required' => 'กรุณาใส่รายละเอียดภาษารัสเซีย',
            'new_images.*.max' => 'รูปภาพต้องมีขนาดไม่เกิน 8 MB ต่อรูป', 'brochure.max' => 'PDF ต้องมีขนาดไม่เกิน 20 MB',
        ]);
        $retained = collect($project->images ?? [])->reject(fn ($path, $index) => in_array($index, array_map('intval', $data['remove_images'] ?? []), true))
            ->sortBy(fn ($path, $index) => $data['image_order'][$index] ?? $index);
        $uploads = $request->file('new_images', []);
        if ($retained->count() + count($uploads) > 30) {
            throw ValidationException::withMessages(['new_images' => 'หนึ่งโปรเจกต์มีรูปได้สูงสุด 30 รูป']);
        }
        if ($request->boolean('is_published') && $retained->isEmpty() && !$request->hasFile('new_images')) {
            throw ValidationException::withMessages(['new_images' => 'เพิ่มรูปอย่างน้อย 1 รูปก่อนเผยแพร่']);
        }
        $paths = [];
        foreach ($retained as $index => $path) {
            $paths['old:'.$index] = $path;
        }
        $expected = array_merge(array_keys($paths), array_map(fn ($index) => 'new:'.$index, array_keys($uploads)));
        $order = $data['gallery_order'] ?? $expected;
        if (count($order) !== count($expected) || array_diff($expected, $order) || array_diff($order, $expected)) {
            throw ValidationException::withMessages(['gallery_order' => 'ลำดับรูปไม่ครบหรือไม่ตรงกับไฟล์ที่เลือก กรุณาตรวจรูปและลองบันทึกใหม่']);
        }
        $stored = [];
        try {
            foreach ($uploads as $index => $image) {
                $path = $image->store('images', 'content_images');
                $stored[] = ['content_images', $path];
                $paths['new:'.$index] = 'uploads/content/'.$path;
            }
            $existing = array_map(fn ($token) => $paths[$token], $order);
            $pdf = $request->boolean('remove_brochure') ? null : $project->pdf_path;
            if ($request->hasFile('brochure')) {
                $path = $request->file('brochure')->store('brochures', 'content_documents');
                $stored[] = ['content_documents', $path];
                $pdf = 'content/'.$path;
            }
            DB::transaction(function () use ($project, $data, $existing, $pdf) {
                $project->fill(collect($data)->only(['title', 'category', 'location', 'sort_order', 'badge', 'price', 'description', 'is_published', 'is_new', 'is_featured', 'seo_title', 'seo_description', 'new_year'])->all());
                $project->images = $existing;
                $project->pdf_path = $pdf;
                $project->save();
            });
        } catch (\Throwable $exception) {
            foreach ($stored as [$disk, $path]) {
                Storage::disk($disk)->delete($path);
            }
            throw $exception;
        }
        return redirect()->route('admin.projects.edit', $project)->with('saved', 'บันทึกโปรเจกต์แล้ว'.($project->is_published ? ' — แสดงบนหน้าเว็บแล้ว' : ' — บันทึกเป็นฉบับร่าง'));
    }

    public function destroyProject(Project $project)
    {
        // Retain files for recovery and avoid removing legacy assets shared elsewhere.
        $project->delete();
        return redirect()->route('admin.projects.index')->with('saved', 'ย้ายโปรเจกต์ไปถังขยะแล้ว สามารถกู้คืนได้จากตัวกรองถังขยะ');
    }

    public function restoreProject(Project $project)
    {
        $project->is_published = false;
        $project->restore();
        return redirect()->route('admin.projects.edit', $project)->with('saved', 'กู้คืนโปรเจกต์เป็นฉบับร่างแล้ว กรุณาตรวจข้อมูลก่อนเผยแพร่');
    }

    public function videos()
    {
        return view('admin.videos.index', ['videos' => Video::with('project')->orderBy('sort_order')->orderBy('id')->paginate(15)]);
    }

    public function createVideo()
    {
        return view('admin.videos.form', ['video' => new Video(['sort_order' => 0, 'aspect_ratio' => '16:9']), 'projects' => Project::orderBy('title')->get()]);
    }

    public function editVideo(Video $video)
    {
        return view('admin.videos.form', ['video' => $video, 'projects' => Project::orderBy('title')->get()]);
    }

    public function storeVideo(Request $request)
    {
        return $this->saveVideo($request, new Video);
    }

    public function updateVideo(Request $request, Video $video)
    {
        return $this->saveVideo($request, $video);
    }

    private function saveVideo(Request $request, Video $video)
    {
        $data = $request->validate([
            'title' => 'required|array:en,ru', 'title.en' => 'required|string|max:255', 'title.ru' => 'required|string|max:255',
            'description' => 'required|array:en,ru', 'description.en' => 'nullable|string|max:3000', 'description.ru' => 'nullable|string|max:3000',
            'url' => ['bail', 'required', 'string', 'max:500', function ($attribute, $value, $fail) {
                if (!Video::embedUrl($value)) {
                    $fail('กรุณาใส่ลิงก์ HTTPS ของวิดีโอ YouTube หรือ Vimeo ที่ถูกต้อง');
                }
            }],
            'project_id' => 'nullable|integer|exists:projects,id', 'sort_order' => 'required|integer|min:0|max:100000',
            'aspect_ratio' => ['required', Rule::in(array_keys(Video::ASPECT_RATIOS))],
            'is_published' => 'required|boolean',
            'cover' => 'nullable|file|image|mimes:jpg,jpeg,png,webp|max:8192|dimensions:max_width=12000,max_height=12000',
            'remove_cover' => 'nullable|boolean',
        ]);
        $stored = null;
        try {
            $cover = $request->boolean('remove_cover') ? null : $video->cover_path;
            if ($request->hasFile('cover')) {
                $stored = $request->file('cover')->store('video-covers', 'content_images');
                $cover = 'uploads/content/'.$stored;
            }
            $video->fill(collect($data)->only(['title','description','url','project_id','sort_order','aspect_ratio','is_published'])->all());
            $video->cover_path = $cover;
            $video->save();
        } catch (\Throwable $exception) {
            if ($stored) Storage::disk('content_images')->delete($stored);
            throw $exception;
        }
        return redirect()->route('admin.videos.edit', $video)->with('saved', 'บันทึกวิดีโอแล้ว');
    }

    public function destroyVideo(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('saved', 'ลบวิดีโอแล้ว');
    }
}
