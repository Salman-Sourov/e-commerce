<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Product_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_translation;
use App\Models\Product_category_product;
use App\Models\Multi_image;
use App\Models\Product_with_multi_image;
use App\Models\Videos;
use App\Models\Product_with_videos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('status', 'active')->get();
        return view("backend.product.all_product", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::where("status", 'active')->orderBy("name", "asc")->get();
        $categories = Product_category::where('status', 'active')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        return view('backend.product.add_product', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd('hello');
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_name_bangla' => 'required|string|max:255',
            'brand_id' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'quantity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'sale_price' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'length' => 'nullable|numeric',
            'wide' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'short_content' => 'required|string',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp,gif',
        ]);

        DB::beginTransaction();
        try {

            if ($request->file('thumbnail')) {
                $image = $request->file('thumbnail');
                $imageName = date("Y-m-d") . '_' . rand() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $directory = 'upload/product/';
                $image->move($directory, $imageName);
            }

            // $sku = $request->sku ?? $this->generateSku($request->product_name, $request->category_id);

            $product = Product::create([
                'name' => $request->product_name,
                'description' => $request->description,
                'content' => $request->short_content,
                'status' => 'active',
                'thumbnail' => $request->file('thumbnail') ? $directory . $imageName : null,
                // 'sku' => $sku,
                'quantity' => $request->quantity ?? 0,
                'is_featured' => 0,
                'brand_id' => $request->brand_id,
                'is_variation' => $request->has('is_variation') ? 0 : 1,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'length' => $request->length,
                'wide' => $request->wide,
                'height' => $request->height,
                'weight' => $request->weight,
                'created_by_id' => Auth::User()->id,
            ]);

            product_translation::create([
                'name' => $request->product_name_bangla,
                'lang_code' => 'bn',
                'products_id' => $product->id,
            ]);
            // dd($request->all());

            // Handle sub_category_id
            if ($request->filled('sub_category_id')) {
                Product_category_product::create([
                    'category_id' => $request->sub_category_id,
                    'product_id' => $product->id,
                ]);
            } else {
                Product_category_product::create([
                    'category_id' => $request->category_id,
                    'product_id' => $product->id,
                ]);
            }

            if ($request->file('multi_img')) {
                $images = $request->file('multi_img');
                foreach ($images as $image) {
                    $data = new Multi_image();
                    $product_image = new Product_with_multi_image();
                    $photoName = date("Y-m-d") . '.' . rand() . '.' . time() . '.' . $image->getClientOriginalExtension();
                    $directory = 'upload/product/';
                    $image->move($directory, $photoName);
                    $data->image = $directory . $photoName;
                    $data->product_id = $product->id;
                    $data->save();
                    $multiImageId = $data->id;
                    $product_image->product_id = $product->id;
                    $product_image->multiImage_id = $multiImageId;
                    $product_image->save();
                }
            }


            if ($request->has('video_type') && $request->has('video_link')) {
                $videoTypes = $request->input('video_type');
                $videoLinks = $request->input('video_link');
                $count = count($videoTypes);
                for ($i = 0; $i < $count; $i++) {
                    $data = new Videos();
                    $product_video = new Product_with_videos();
                    $data->video_type = $videoTypes[$i];
                    $data->video_link = $videoLinks[$i];
                    $data->product_id = $product->id;
                    $data->save();
                    $product_video->product_id    = $product->id;
                    $product_video->video_id = $data->id;
                    $product_video->save();
                }
            } else if ($request->has('video_type') && $request->has('video_link')) {
                $notification = [
                    'message' => 'Video Type or Link Missing',
                    'alert-type' => 'error',
                ];

                return redirect()->back()->with($notification);
            }

            DB::commit();

            $notification = array(
                'message' => 'Product Successfully Added',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        } catch (\Exception $e) {

            DB::rollback();

            $notification = array(
                'message' => 'Failed to store product',
                'alert-type' => 'error',
            );
            return back()->with($notification);
        }
    }

    /**
     * Display the specified resource. 
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('translations', 'categories', 'multi_images', 'videos')->find($id);
        // dd(vars: $product);
        $product->start_date = \Carbon\Carbon::parse($product->start_date)->format('Y-m-d');
        $product->end_date = \Carbon\Carbon::parse($product->end_date)->format('Y-m-d');

        $brands = Brand::where('status', 'active')->get();

        $categories = Product_category::where('status', 'active')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        // dd($product->brands);
        return view('backend.product.edit_product', compact('product', 'brands', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        // Validate the incoming request
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'nullable|integer',
            // 'price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'length' => 'nullable|numeric',
            'wide' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'short_content' => 'required|string',
            'description' => 'nullable|string',

        ]);

        DB::beginTransaction();
        try {

            // Handle thumbnail upload
            if ($request->file('thumbnail')) {
                // Delete old thumbnail if it exists
                if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                    unlink(public_path($product->thumbnail));
                }
                $image = $request->file('thumbnail');
                $imageName = date("Y-m-d") . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $directory = 'upload/product/';
                $image->move(public_path($directory), $imageName);
                $product->thumbnail = $directory . $imageName;
            }

            // Update product details
            $product->name = $request->product_name;
            $product->description = $request->description;
            $product->content = $request->short_content;
            $product->quantity = $request->quantity ?? 0;
            $product->price = $request->price;
            $product->sale_price = $request->sale_price;
            // $product->status = $request->has('status') ? 'active' : 'inactive';
            // $product->is_featured = $request->has('is_featured') ? 1 : 0;
            $product->is_variation = $request->has('is_variation') ? 1 : 0;
            $product->brand_id = $request->brand_id ?? null;
            $product->start_date = $request->start_date;
            $product->end_date = $request->end_date;
            $product->length = $request->length;
            $product->wide = $request->wide;
            $product->height = $request->height;
            $product->weight = $request->weight;
            $product->created_by_id = Auth::id();

            // Save updated product
            $product->save();

            //dd('hello');

            $translation = product_translation::where('products_id', $product->id)->first();

            $translation->name = $request->product_name_bangla;
            $translation->lang_code = 'bn';
            $translation->products_id = $product->id;
            $translation->save();

            // dd($request->all());

            // Handle sub_category_id
            if ($request->filled('sub_category_id')) {
                $category = Product_category_product::where('product_id', $product->id)->first();
                $category->category_id = $request->sub_category_id;
                $category->product_id = $product->id;
                $category->save();
            } else {
                $category = Product_category_product::where('product_id', $product->id)->first();
                $category->category_id = $request->category_id;
                $category->product_id = $product->id;
                $category->save();
            }


            $videoTypes = $request->input('video_type');
            $videoLinks = $request->input('video_link');

            if ($videoTypes &&  $videoLinks) {
                //dd($videoTypes);
                $data = Videos::where('product_id', $product->id)->first();
                $product_video =  Product_with_videos::where('product_id', $product->id)->first();

                if ($data && $product_video) {
                    $data->video_type = $videoTypes;
                    $data->video_link = $videoLinks;
                    $data->product_id = $product->id;
                    $data->save();
                    $product_video->product_id    = $product->id;
                    $product_video->video_id = $data->id;
                    $product_video->save();
                } else {

                    $videoTypes = $request->input('video_type');
                    $videoLinks = $request->input('video_link');

                    $data = new Videos();
                    $product_video = new Product_with_videos();
                    $data->video_type = $videoTypes;
                    $data->video_link = $videoLinks;
                    $data->product_id = $product->id;
                    $data->save();
                    $product_video->product_id    = $product->id;
                    $product_video->video_id = $data->id;
                    $product_video->save();
                }
            } else if ($videoTypes ||  $videoLinks) {
                $notification = [
                    'message' => 'Video Type or Link Missing',
                    'alert-type' => 'error',
                ];

                return redirect()->back()->with($notification);
            }

            DB::commit();

            // Notification message
            $notification = [
                'message' => 'Product Successfully Updated',
                'alert-type' => 'success',
            ];

            return redirect()->back()->with($notification);
        } catch (\Exception $e) {

            DB::rollback();

            $notification = array(
                'message' => 'Failed to update product. Error: ',
                'alert-type' => 'error',
            );

            return back()->with($notification);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        $product = Product::findOrFail($id);
        $product->status = 'inactive'; // Mark as inactive or deleted
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product Successfully Inactive'
        ]);
    }

    public function uploadMultiImg(Request $request)
    {
        $request->validate([
            'multi_img' => 'required|image|mimes:jpeg,png,jpg,webp,gif|',
        ]);

        if ($request->file('multi_img')) {
            $image = $request->file('multi_img');
            $data = new Multi_image();
            $product_image = new Product_with_multi_image();
            $photoName = date("Y-m-d") . '.' . rand() . '.' . time() . '.' . $image->getClientOriginalExtension();
            $directory = 'upload/product/';
            $image->move($directory, $photoName);
            $data->image = $directory . $photoName;
            $data->product_id = $request->upload_product_id;
            $data->save();
            $multiImageId = $data->id;
            $product_image->product_id = $request->upload_product_id;
            $product_image->multiImage_id = $multiImageId;
            $product_image->save();

            $notification = array(
                'message' => 'Product Successfully Added',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }

        $notification = array(
            'message' => 'Failed to store product. Please try again.',
            'alert-type' => 'error',
        );

        return back()->with($notification);
    }

    public function deleteMultiImg($id)
    {

        // dd(vars: $id);

        $multiImage = Multi_image::findOrFail($id);
        unlink($multiImage->image);

        $multiImage->delete();

        // $product = Product_with_multi_image::where('multiImage_id','$id')->first();

        // $product->delete();

        $notification = array(
            'message' => 'Product MultiImage Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function inactive_product()
    {
        $inactive_product = Product::where('status', 'inactive')->get();
        return view('backend.product.all_inactive_product', compact('inactive_product'));
    }

    public function productChangeStatus(Request $request)
    {

        $inactiveProduct = Product::findOrFail($request->product_id);

        if ($inactiveProduct->status == 'inactive') {

            $inactiveProduct->status = 'active';
            $inactiveProduct->save();
        }

        return response()->json(['success' => 'Status changed successfully']);
    }

    public function productDelete(Request $request, $id)
    {
        //dd('hello');
        $product = Product::findOrFail($id);
        //dd($product);

        if($product) {
 
            if (!empty($product->thumbnail) && file_exists(public_path($product->thumbnail))) {
                unlink(public_path($product->thumbnail));
            }

            $multiImages = Multi_image::where('product_id', $id)->get();

            if ($multiImages->count() > 0) {
                foreach ($multiImages as $multiImage) {
                    if (!empty($multiImage->image) && file_exists(public_path($multiImage->image))) {
                        unlink(public_path($multiImage->image));
                    }
                    $multiImage->delete();
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ]);
        }

        
    }
}
