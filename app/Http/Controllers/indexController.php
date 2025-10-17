<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Order_product;
use App\Models\Order_product_attribute;
use App\Models\Order_product_quantity;
use App\Models\Product;
use App\Models\Product_category;
use App\Models\Product_category_product;
use App\Models\Product_with_attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class indexController extends Controller
{
    public function index()
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $featured_products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->where('is_featured', '1')->latest()->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->where('is_featured', '0')->inRandomOrder()->latest()->get();
        $carts = session()->get('cart'); // Default to an empty array if no cart exists
        // dd($products);
        return view('frontend.index', compact('categories', 'brands', 'products', 'carts', 'featured_products'));
    }

    public function categoryDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart');

        $category_product = Product_category::with('translations', 'hasChild', 'totalProducts')
            ->where('status', 'active')  // Filter by active status
            ->where('id', $id)           // Filter by the specific id
            ->first();

        $category_name = Product_category::findOrFail($id);
        // dd($category_product);
        return view('frontend.category_detail', compact('categories', 'brands', 'products', 'category_name', 'category_product', 'carts'));
    }

    public function brandDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart');

        $brand_product = Product::with('translations', 'brands', 'categories')
            ->where('status', 'active')->where('brand_id', $id)   // Filter by active status
            ->get();

        $brand_name = Brand::findOrFail($id);
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')
            ->where('status', 'active')->latest()->get();

        // dd($brand_product);
        return view('frontend.brand_detail', compact('categories', 'brands', 'products', 'brand_name', 'brand_product', 'carts'));
    }

    public function productDetails($id)
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $featured_products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->where('is_featured', '1')->latest()->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart');

        $selected_product = Product::with('multi_images', 'attribute_set',)->findOrFail($id);

        $attributes = Product_with_attribute::where('product_id', $id)->first();

        $category_product = Product_category_product::with('products', 'category_detail')
            ->where('product_id', $id)           // Filter by the specific id
            ->first();

        $trending_products = Product::with('translations')
            ->where('status', 'active')
            ->where('id', '!=', $id) // Exclude the current product
            ->latest()
            ->get();

        $related_products = Product_category::with('totalProducts')
            ->where('status', 'active')
            ->where('id',  $category_product->category_id) // Exclude the current product
            ->first();

        // dd($category_product);

        return view('frontend.product_detail', compact('categories', 'brands', 'products', 'selected_product', 'category_product', 'trending_products', 'related_products', 'attributes', 'carts', 'featured_products'));
    }

    public function confirmOrder(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'area' => 'required',
            'payment_option' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $carts = session()->get('cart');

            $data = new Order();
            $data->user_id = Auth::user()->id ?? null;
            $data->name = $request->name ?? '';
            $data->phone = $request->phone ?? '';
            $data->address = $request->address ?? '';
            $data->area_charge = $request->area ?? '';
            $data->payment_option = $request->payment_option ?? '';
            // $data->products_id = $request->bkash;
            // $data->attributes = $request->bkash;
            // $data->order_quantity = $request->bkash;
            $data->bkash = $request->bkash ?? '';
            $data->total_cost = $request->sub_total + (int)$request->area ?? '';
            $data->status = 'Processing';
            $data->save();

            foreach ($carts as $key => $cartItem) {
                $data_1 = new Order_product();
                $data_1->order_id = $data->id ?? '';
                $data_1->product_id = $key ?? '';
                $data_1->save();
            }

            foreach ($carts as $key => $cartItem) {
                $data_1 = new Order_product_attribute();
                $data_1->order_id = $data->id ?? '';
                $data_1->product_id = $key ?? '';
                $data_1->attributes = isset($cartItem['attributes']) ? $cartItem['attributes'] : '';
                $data_1->save();
            }

            foreach ($carts as $key => $cartItem) {
                $data_1 = new Order_product_quantity();
                $data_1->order_id = $data->id ?? '';
                $data_1->product_id = $key ?? '';
                $data_1->quantity = isset($cartItem['quantity']) && is_numeric($cartItem['quantity']) ? $cartItem['quantity'] : 0;;
                $data_1->save();
            }


            DB::commit();
            session()->forget('cart'); // only clear the cart data

            return response()->json(['success' => true, 'message' => 'Order Confirm Successfully']);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json(['error' => true, 'message' => 'Failed to Order']);
        }
    }

    public function productSearch(Request $request)
    {
        $request->validate([
            'search' => 'required',
        ]);

        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        // $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->latest()->get();
        $carts = session()->get('cart'); // Default to an empty array if no cart exists

        $query = $request->input('search');
        // dd($query);

        // Check if query exists, else return with no results
        if (!$query) {
            return view('frontend.product_search', compact('categories', 'brands', 'carts'))->with('error', 'No search query provided.');
        }

        // Fetch products based on the search query
        $products = Product::with(['translations', 'inventory_stocks', 'brands', 'categories'])
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->latest()
            ->get();

        // Return the view with the search results
        return view('frontend.product_search', compact('categories', 'brands', 'products', 'carts', 'query'));
    }
    public function mobileProductSearch()
    {
        $categories = Product_category::with('translations', 'hasChild')->where('level', '1')->where('status', 'active')->get();
        $brands = Brand::with('translations')->where('status', 'active')->get();
        $products = Product::with('translations', 'inventory_stocks', 'brands', 'categories')->where('status', 'active')->inRandomOrder()->latest()->get();
        $carts = session()->get('cart'); // Default to an empty array if no cart exists
        // dd($products);
        return view('frontend.mobile_search', compact('categories', 'brands', 'products', 'carts'));
    }
}
