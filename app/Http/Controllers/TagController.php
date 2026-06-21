<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('projects')->latest()->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        Tag::create($data);
        return redirect()->route('admin.tags.index')->with('success', 'Tag berhasil ditambahkan.');
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $data = $request->validated();
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $tag->update($data);
        return redirect()->route('admin.tags.index')->with('success', 'Tag diperbarui.');
    }

    public function destroy(Tag $tag)
    {
        if ($tag->projects()->count() > 0) {
            return back()->with('error', 'Tag tidak bisa dihapus karena masih digunakan oleh proyek.');
        }
        $tag->delete();
        return back()->with('success', 'Tag dihapus.');
    }
}
