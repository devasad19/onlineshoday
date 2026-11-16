<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisementCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdvertisementCategoryController extends Controller
{
 public function index()
    {
        $categories = AdvertisementCategory::orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('backend.advertisement_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backend.advertisement_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:advertisement_categories,name',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = $this->makeUniqueSlug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        AdvertisementCategory::create($validated);

        return redirect()
            ->route('admin.advertisement-categories.index')
            ->with('success', 'ক্যাটাগরি সফলভাবে তৈরি হয়েছে।');
    }

    public function edit(AdvertisementCategory $advertisement_category)
    {
        return view('backend.advertisement_categories.edit', [
            'category' => $advertisement_category,
        ]);
    }

    public function update(Request $request, AdvertisementCategory $advertisement_category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('advertisement_categories', 'name')
                    ->ignore($advertisement_category->id),
            ],
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $oldName = $advertisement_category->name;
        $newName = $validated['name'];

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active');

        // নাম পরিবর্তন হলে slug-ও আপডেট
        if ($oldName !== $newName) {
            $validated['slug'] = $this->makeUniqueSlug(
                $newName,
                $advertisement_category->id
            );
        }

        DB::transaction(function () use (
            $advertisement_category,
            $validated,
            $oldName,
            $newName
        ) {
            $advertisement_category->update($validated);

            // পুরোনো বিজ্ঞাপনের category নামও পরিবর্তন
            if ($oldName !== $newName) {
                Advertisement::where('category', $oldName)
                    ->update(['category' => $newName]);
            }
        });

        return redirect()
            ->route('admin.advertisement-categories.index')
            ->with('success', 'ক্যাটাগরি আপডেট হয়েছে।');
    }

    public function toggleStatus(AdvertisementCategory $advertisement_category)
    {
        $advertisement_category->update([
            'is_active' => !$advertisement_category->is_active,
        ]);

        return back()->with(
            'success',
            $advertisement_category->is_active
                ? 'ক্যাটাগরি Active করা হয়েছে।'
                : 'ক্যাটাগরি Inactive করা হয়েছে।'
        );
    }

    public function destroy(AdvertisementCategory $advertisement_category)
    {
        $adsCount = Advertisement::where(
            'category',
            $advertisement_category->name
        )->count();

        if ($adsCount > 0) {
            return back()->with(
                'error',
                "এই ক্যাটাগরিতে {$adsCount}টি বিজ্ঞাপন রয়েছে। আগে বিজ্ঞাপনগুলো অন্য ক্যাটাগরিতে সরান।"
            );
        }

        $advertisement_category->delete();

        return redirect()
            ->route('admin.advertisement-categories.index')
            ->with('success', 'ক্যাটাগরি Delete করা হয়েছে।');
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);

        // বাংলা নামের ক্ষেত্রে Str::slug খালি দিতে পারে
        if (!$baseSlug) {
            $baseSlug = 'category';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            AdvertisementCategory::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }
}
