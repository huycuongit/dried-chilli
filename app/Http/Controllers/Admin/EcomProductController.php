<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;

class EcomProductController extends Controller
{
    public function index()
    {
        return view('admin.ecom_products.index');
    }
    
    public function datatables(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['inventory', 'images']);
            if ($request->has('keyword') && $request->keyword != '') {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            }
            return DataTables::of($query)
                ->addColumn('image', function($row) {
                    $imgUrl = $row->image_url;
                    $badge = $row->images->count() > 1 ? '<span class="badge bg-label-primary ms-1">+' . ($row->images->count() - 1) . '</span>' : '';
                    return '<div class="d-flex align-items-center">
                                <img src="' . $imgUrl . '" alt="' . e($row->name) . '" class="rounded me-2" style="width: 44px; height: 44px; object-fit: cover; border: 1px solid var(--chili-border);">' . $badge . '
                            </div>';
                })
                ->addColumn('action', function($row) {
                    return '<div class="d-flex align-items-center">
                                <a href="'.route('admin.ecom_products.edit', $row->id).'" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill btn-edit" title="Edit"><i class="ti ti-edit ti-md"></i></a>
                                <form action="'.route('admin.ecom_products.destroy', $row->id).'" method="POST" class="d-inline-block" data-confirm="Are you sure you want to delete this product?">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill" title="Delete"><i class="ti ti-trash ti-md text-danger"></i></button>
                                </form>
                            </div>';
                })
                ->addColumn('quantity', function($row) {
                    return $row->inventory ? $row->inventory->quantity : 0;
                })
                ->editColumn('price', function($row) { return '$' . number_format($row->price, 2); })
                ->editColumn('sale_price', function($row) { return $row->sale_price ? '$' . number_format($row->sale_price, 2) : '-'; })
                ->editColumn('is_best_seller', function($row) { return $row->is_best_seller ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>'; })
                ->editColumn('is_sale', function($row) { return $row->is_sale ? '<span class="badge bg-primary">Yes</span>' : '<span class="badge bg-secondary">No</span>'; })
                ->editColumn('is_limited_sale', function($row) { return $row->is_limited_sale ? '<span class="badge bg-warning">Yes</span>' : '<span class="badge bg-secondary">No</span>'; })
                ->rawColumns(['image', 'action', 'is_best_seller', 'is_sale', 'is_limited_sale'])
                ->make(true);
        }
    }

    public function create()
    {
        $data = new Product();
        return view('admin.ecom_products.form', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . time(),
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sale_type' => $request->sale_type ?? 'none',
            'sale_start_date' => $request->sale_start_date,
            'sale_end_date' => $request->sale_end_date,
            'description' => $request->description,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active' => $request->has('is_active'),
            'is_sale' => $request->has('is_sale'),
            'is_limited_sale' => $request->has('is_limited_sale'),
        ]);

        if ($request->has('quantity')) {
            \App\Models\Inventory::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity ?? 0,
            ]);
        }

        // Upload and assign multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $path = $file->store('products', 'public');
                $imagePath = 'storage/' . $path;
                $isPrimary = ($index === 0);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => $isPrimary,
                    'sort_order' => $index,
                ]);

                if ($isPrimary || empty($product->image)) {
                    $product->update(['image' => $imagePath]);
                }
            }
        }

        return redirect()->route('admin.ecom_products.index')->with('success', 'Product created successfully with gallery images.');
    }

    public function edit($id)
    {
        $data = Product::with('images')->findOrFail($id);
        return view('admin.ecom_products.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer',
            'primary_image_id' => 'nullable|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . $id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sale_type' => $request->sale_type ?? 'none',
            'sale_start_date' => $request->sale_start_date,
            'sale_end_date' => $request->sale_end_date,
            'description' => $request->description,
            'is_best_seller' => $request->has('is_best_seller'),
            'is_active' => $request->has('is_active'),
            'is_sale' => $request->has('is_sale'),
            'is_limited_sale' => $request->has('is_limited_sale'),
        ]);

        if ($request->has('quantity')) {
            $inventory = \App\Models\Inventory::firstOrNew(['product_id' => $product->id, 'variant_id' => null]);
            $inventory->quantity = $request->quantity;
            $inventory->save();
        }

        // Delete requested images
        if ($request->has('delete_images')) {
            $deleteIds = (array) $request->input('delete_images');
            $imagesToDelete = ProductImage::where('product_id', $product->id)->whereIn('id', $deleteIds)->get();
            foreach ($imagesToDelete as $delImg) {
                if ($delImg->image_path && str_starts_with($delImg->image_path, 'storage/')) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $delImg->image_path));
                }
                $delImg->delete();
            }
        }

        // Add newly uploaded images
        if ($request->hasFile('images')) {
            if ($product->image && !$product->images()->where('image_path', $product->image)->exists()) {
                $product->images()->create([
                    'image_path' => $product->image,
                    'is_primary' => !$product->images()->where('is_primary', true)->exists(),
                    'sort_order' => 0,
                ]);
            }
            $lastSort = (int) ProductImage::where('product_id', $product->id)->max('sort_order');
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $imagePath = 'storage/' . $path;

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => false,
                    'sort_order' => $lastSort + $i + 1,
                ]);

                if (empty($product->image)) {
                    $product->update(['image' => $imagePath]);
                }
            }
        }

        // Update primary image if specified
        if ($request->has('primary_image_id') && $request->filled('primary_image_id')) {
            $primaryId = $request->input('primary_image_id');
            $chosen = ProductImage::where('product_id', $product->id)->where('id', $primaryId)->first();
            if ($chosen) {
                ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
                $chosen->update(['is_primary' => true]);
                $product->update(['image' => $chosen->image_path]);
            }
        }

        // Ensure product cover image is synced with images relation
        if ($product->images()->exists()) {
            $currentPrimary = $product->images()->where('is_primary', true)->first();
            if (!$currentPrimary) {
                $firstImg = $product->images()->orderBy('sort_order')->first();
                if ($firstImg) {
                    $firstImg->update(['is_primary' => true]);
                    $product->update(['image' => $firstImg->image_path]);
                }
            } else {
                $product->update(['image' => $currentPrimary->image_path]);
            }
        }

        return redirect()->route('admin.ecom_products.index')->with('success', 'Product updated successfully with gallery images.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Remove uploaded images from disk
        foreach ($product->images as $img) {
            if ($img->image_path && str_starts_with($img->image_path, 'storage/')) {
                Storage::disk('public')->delete(str_replace('storage/', '', $img->image_path));
            }
        }

        $product->delete();
        return redirect()->route('admin.ecom_products.index')->with('success', 'Product deleted successfully.');
    }

    public function deleteImage($productId, $imageId)
    {
        $image = ProductImage::where('product_id', $productId)->where('id', $imageId)->firstOrFail();
        if ($image->image_path && str_starts_with($image->image_path, 'storage/')) {
            Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));
        }
        $wasPrimary = $image->is_primary;
        $image->delete();

        $product = Product::findOrFail($productId);
        if ($wasPrimary && $product->images()->exists()) {
            $newPrimary = $product->images()->first();
            $newPrimary->update(['is_primary' => true]);
            $product->update(['image' => $newPrimary->image_path]);
        } elseif (!$product->images()->exists()) {
            $product->update(['image' => null]);
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Image removed successfully.',
                'primary_image_id' => $product->images()->where('is_primary', true)->value('id'),
            ]);
        }

        return back()->with('success', 'Image removed successfully.');
    }

    public function setPrimaryImage($productId, $imageId)
    {
        $image = ProductImage::where('product_id', $productId)->where('id', $imageId)->firstOrFail();
        ProductImage::where('product_id', $productId)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        $product = Product::findOrFail($productId);
        $product->update(['image' => $image->image_path]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Primary image set successfully.']);
        }

        return back()->with('success', 'Primary image set successfully.');
    }
}
