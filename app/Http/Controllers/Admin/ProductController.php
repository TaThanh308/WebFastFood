<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; // <-- Đảm bảo import đúng
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhereHas('category', function($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $products = $query->get();
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
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'price'        => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'description'  => 'required|string',
            'image'        => 'nullable|image|max:2048',
            'size'         => 'nullable|array',              // Cho phép mảng size
            'size.*'       => 'string|in:S,M,L,XL',            // Mỗi giá trị phải thuộc các tùy chọn cho phép
        ]);

        // Nếu người dùng tích chọn size, chuyển mảng thành chuỗi (ví dụ "M,L")
        $sizes = $request->has('size') ? implode(',', $request->size) : null;

        $imagePath = $request->file('image') ? $request->file('image')->store('products', 'public') : null;

        Product::create([
            'name'         => $request->name,
            'category_id'  => $request->category_id,
            'price'        => $request->price,
            'size'         => $sizes, // Lưu chuỗi kích thước hoặc null nếu không chọn
            'stock'        => $request->stock,
            'description'  => $request->description,
            'image'        => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được thêm!');
    }

    

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:50',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->except('image'));

        return redirect()->route('products.index')->with('success', 'Sản phẩm đã được cập nhật!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Sản phẩm đã bị xóa!');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

}

