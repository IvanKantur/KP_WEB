<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::withTrashed()->with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function indexActive()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function indexArchived()
    {
        $products = Product::onlyTrashed()->with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products',
            'price' => 'required|numeric',
            'stock' => 'integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            $sortOrder = 0;
            foreach ($request->file('images') as $file) {
                $filename = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Товар добавлен');
    }

    public function edit($id)
    {
        $product = Product::withTrashed()->with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'price' => 'required|numeric',
            'stock' => 'integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');

        $product->update($data);

        if ($request->hasFile('images')) {
            $currentCount = $product->images()->count();
            $sortOrder = $currentCount;
            foreach ($request->file('images') as $file) {
                $filename = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()->route('admin.products')->with('success', 'Товар обновлен');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function archive($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Товар перемещен в архив');
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products')->with('success', 'Товар восстановлен');
    }

    public function destroy($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }
        
        $product->forceDelete();

        return redirect()->route('admin.products')->with('success', 'Товар удален навсегда');
    }

    //Сортировка изображений
    public function sortImages(Request $request)
    {
        $items = $request->input('items', []);
        
        foreach ($items as $item) {
            ProductImage::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }
        
        return response()->json(['success' => true]);
    }
}