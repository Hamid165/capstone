<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Show the application product catalog.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Optional: Simple Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Show 12 products per page
        $products = $query->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    /**
     * Show the product detail page.
     *
     * @param  Product  $product
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Product $product)
    {
        // Get related products (random for now, or same category if we had categories)
        $relatedProducts = Product::where('id', '!=', $product->id)->inRandomOrder()->take(4)->get();
        
        $reviews = $product->reviews()->with('user')->latest()->get();
        $averageRating = $reviews->avg('rating');
        $totalReviews = $reviews->count();

        return view('products.show', compact('product', 'relatedProducts', 'reviews', 'averageRating', 'totalReviews'));
    }

    /**
     * Show all reviews for a product.
     *
     * @param  Product  $product
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function reviews(\Illuminate\Http\Request $request, Product $product)
    {
        // Simulate Dummy Reviews
        $dummyReviews = collect([]);
        for ($i = 1; $i <= 25; $i++) {
            $dummyReviews->push([
                'user' => 'User ' . $i,
                'initial' => 'U' . $i,
                'rating' => rand(4, 5),
                'date' => now()->subDays(rand(1, 30))->format('d M Y'),
                'content' => 'Sayurnya segar sekali, pengiriman cepat mantap! Review ke-' . $i,
                'image' => $i % 3 == 0 ? 'https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&q=80&w=150' : null
            ]);
        }

        // Manual Pagination
        $perPage = 10;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $currentItems = $dummyReviews->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $reviews = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, count($dummyReviews), $perPage, $currentPage, [
            'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
        ]);

        return view('products.reviews', compact('product', 'reviews'));
    }
}
