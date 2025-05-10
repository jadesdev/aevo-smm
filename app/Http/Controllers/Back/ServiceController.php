<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Categories
    public function all_categories()
    {
        $title = 'All Categories';
        $categories = [];
        $categories = Category::has('services')->orderBy('name')->paginate(100);

        return view('admin.categories.index', compact('title', 'categories'));
    }

    public function store_category(Request $request)
    {
        $id = $request->id ?? 0;

        $request->validate([
            'name' => 'required|unique:categories,name,'.$id,
        ]);

        if ($id) {
            $category = Category::findOrFail($id);
            $message = 'Category updated successfully';
            $status = $request->status;
            // update category services if
            $services = $category->service;
            foreach ($services as $item) {
                $item->status = $status;
                $item->save();
            }
        } else {
            $category = new Category;
            $message = 'Category added successfully';
            $status = 1;
        }
        $category->name = $request->name;
        $category->status = $status;
        $category->save();

        return back()->withSuccess($message);
    }

    public function delete_category($id)
    {
        $category = Category::findOrFail($id);
        $services = $category->service;
        foreach ($services as $item) {
            $item->forceDelete();
        }
        $category->forceDelete();

        return back()->withSuccess('Categories Deleted Successfully');
    }

    public function category_services($id)
    {
        $category = Category::findOrFail($id);
        $title = 'All Services';
        $categories = Category::whereId($id)->get();
        $services = Service::orderBy('name')->paginate(40);

        return view('admin.service.index', compact('title', 'services', 'categories'));
    }

    public function category_multiple_deactivate(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');

            return response()->json(['error' => 1]);
        } else {
            $ids = explode(',', $request->strIds);
            $category = Category::whereIn('id', $ids);
            $category->update([
                'status' => 2,
            ]);
            // Fetch the updated category with services
            $categories = Category::with('service')->find($ids);
            foreach ($categories as $category) {
                // Update the status of related services;
                foreach ($category->services as $item) {
                    $item->update([
                        'status' => 2,
                    ]);
                }
            }

            session()->flash('success', 'Updated Successfully.');

            return response()->json(['success' => 1]);
        }
    }

    public function category_multiple_activate(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');

            return response()->json(['error' => 1]);
        } else {
            $ids = explode(',', $request->strIds);
            $category = Category::whereIn('id', $ids);
            $category->update([
                'status' => 1,
            ]);
            // Fetch the updated category with services
            $categories = Category::with('service')->find($ids);
            foreach ($categories as $category) {
                // Update the status of related services;
                foreach ($category->services as $item) {
                    $item->update([
                        'status' => 1,
                    ]);
                }
            }

            session()->flash('success', 'Updated Successfully.');

            return response()->json(['success' => 1]);
        }
    }

    public function category_multiple_delete(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');

            return response()->json(['error' => 1]);
        } else {
            $ids = explode(',', $request->strIds);
            // Fetch the updated category with services
            $categories = Category::with('service')->find($ids);
            foreach ($categories as $category) {
                // Update the status of related services;
                foreach ($category->services as $item) {
                    $item->forceDelete();
                }
            }
            $category = Category::whereIn('id', $ids);
            $category->delete();
            session()->flash('success', 'Services Deleted Successfully.');

            return response()->json(['success' => 1]);
        }
    }

    public function all_services()
    {
        $title = 'All Services';
        $categories = Category::orderBy('name')->get();
        $service = Service::orderBy('name')->paginate(40);

        return view('admin.service.index', compact('title', 'service', 'categories'));
    }

    public function add_service()
    {
        $categories = Category::whereStatus(1)->orderBy('name')->get();
        $apiProviders = ApiProvider::orderBy('id', 'DESC')->whereStatus(1)->get();

        return view('admin.service.add', compact('categories', 'apiProviders'));

    }

    public function store_service(Request $request)
    {
        // if service is api, check is service exist by provider id and service id;
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'min' => 'required|integer',
            'price' => 'required|numeric',
            'max' => 'required|integer',
            'status' => 'required|integer',
            'dripfeed' => 'required|integer',
            'manual_api' => 'required|integer',
            'api_provider_id' => 'nullable|integer',
            'api_service_id' => 'nullable|integer',
            'refill' => 'nullable|integer',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        // return $request;

        $service = new Service;
        $service->name = $validatedData['name'];
        $service->category_id = $validatedData['category_id'];
        $service->min = $validatedData['min'];
        $service->price = $validatedData['price'];
        $service->max = $validatedData['max'];
        $service->status = $validatedData['status'];
        $service->dripfeed = $validatedData['dripfeed'];
        $service->manual_api = $validatedData['manual_api'];
        $service->api_provider_id = ($validatedData['api_provider_id'] == 0) ? null : $validatedData['api_provider_id'];
        $service->api_service_id = (empty($validatedData['api_service_id'])) ? 0 : $validatedData['api_service_id'];
        $service->refill = $validatedData['refill'] ?? 2;
        $service->type = $validatedData['type'];
        $service->s_type = $request['s_type'];
        $service->description = $validatedData['description'];
        $service->api_price = ($validatedData['manual_api'] == 1) ? 0 : $request->api_price;

        $provider = ApiProvider::find($request['api_provider_id']);
        // validate plan id if its api
        if ($request->manual_api == 0) {
            $service->api_price = $request->api_price;
            $success = 'Successfully Added Api service';
            // $response = send_post_request($provider['api_url'], ['key' => $provider['api_key'], 'action' => 'services']);
            // foreach ($response as $current):
            //     if ($current->service == $request['api_service_id']):
            //         $service->api_price = $current->rate ;
            //         break;
            //     endif;
            // endforeach;
            // if (!isset($success)):
            //     return back()->with('error', 'Please Check again Api Service ID')->withInput();
            // endif;
        } else {
            $success = 'Service Created Successfully';
        }
        $service->save();

        return redirect()->route('admin.service.index')->withSuccess($success);
    }

    public function edit_service($id)
    {
        $service = Service::findOrFail($id);
        $categories = Category::whereStatus(1)->orderBy('name')->get();
        $apiProviders = ApiProvider::orderBy('id', 'DESC')->whereStatus(1)->get();

        return view('admin.service.edit', compact('service', 'categories', 'apiProviders'));

    }

    public function update_service($id, Request $request)
    {
        // validate request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'min' => 'required|integer',
            'api_price' => 'required|numeric',
            'price' => 'required|numeric',
            'max' => 'required|integer',
            'status' => 'required|integer',
            'dripfeed' => 'required|integer',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|string',
            'manual_api' => 'required|numeric|in:0,1',
            'refill' => 'required|numeric|in:1,2,3',
            'api_provider_id' => 'exclude_if:manual_api,1|exists:api_providers,id',
            'api_service_id' => 'exclude_if:manual_api,1|numeric|not_in:0',

        ]);
        // return $validatedData;
        $service = Service::findOrFail($id);
        $service->name = $validatedData['name'];
        $service->category_id = $validatedData['category_id'];
        $service->min = $validatedData['min'];
        $service->price = $validatedData['price'];
        $service->max = $validatedData['max'];
        $service->status = $validatedData['status'];
        $service->dripfeed = $validatedData['dripfeed'];
        $service->manual_api = $validatedData['manual_api'];
        if ($request['manual_api'] == 1) {
            $service->api_provider_id = 0;
            $service->api_service_id = (empty($validatedData['api_service_id'])) ? 0 : $validatedData['api_service_id'];
        } else {
            $service->api_provider_id = ($validatedData['api_provider_id'] == 0) ? null : $validatedData['api_provider_id'];
            $service->api_service_id = (empty($validatedData['api_service_id'])) ? 0 : $validatedData['api_service_id'];
        }
        $service->refill = $validatedData['refill'];
        $service->type = $validatedData['type'];
        $service->s_type = $request['s_type'];
        $service->description = $validatedData['description'];
        $service->api_price = ($validatedData['manual_api'] == 1) ? 0 : $validatedData['api_price'];
        $provider = ApiProvider::find($request['api_provider_id']);
        // validate plan id if its api
        if ($request->manual_api == 0) {
            $success = 'Successfully Update Api service';
            // $response = send_post_request($provider['api_url'], ['key' => $provider['api_key'], 'action' => 'services']);
            // foreach ($response as $current):
            //     if ($current['service'] == $request['api_service_id']):
            //         $success = "Successfully Update Api service";
            //         $service->api_price = $current['rate'] * get_setting('currency_rate');
            //         $service->type = $current['type'];
            //         $service->description = $current['desc'] ?? $current['description'] ?? $request->description;
            //         break;
            //     endif;
            // endforeach;
            // if (!isset($success)):
            //     return back()->with('error', 'Please Check again Api Service ID')->withInput();
            // endif;
        } else {
            $success = 'Service Updated Successfully';
        }
        $service->save();

        return redirect()->route('admin.service.index')->withSuccess($success);
    }

    public function service_multiple_deactivate(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');

            return response()->json(['error' => 1]);
        } else {
            $ids = explode(',', $request->strIds);
            $service = Service::whereIn('id', $ids);
            $service->update([
                'status' => 2,
            ]);
            session()->flash('success', 'Updated Successfully.');

            return response()->json(['success' => 1]);
        }
    }

    public function service_multiple_activate(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');

            return response()->json(['error' => 1]);
        } else {
            $ids = explode(',', $request->strIds);
            $service = Service::whereIn('id', $ids);
            $service->update([
                'status' => 1,
            ]);
            session()->flash('success', 'Updated Successfully.');

            return response()->json(['success' => 1]);
        }
    }

    public function service_multiple_delete(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');

            return response()->json(['error' => 1]);
        } else {
            $ids = explode(',', $request->strIds);
            $service = Service::whereIn('id', $ids);
            $service->forceDelete();
            session()->flash('success', 'Services Deleted Successfully.');

            return response()->json(['success' => 1]);
        }
    }

    // API Providers
    public function api_providers()
    {
        $providers = ApiProvider::all();

        return view('admin.providers.index', compact('providers'));
    }

    public function store_provider(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'api_url' => 'required|url',
            'api_key' => 'required',

        ]);
        $apiProvider = new ApiProvider;
        $message = 'API provider added successfully';
        $apiProvider->name = $request->name;
        $apiProvider->api_url = $request->api_url;
        $apiProvider->api_key = $request->api_key;
        // Get balance
        $response = send_post_request($request->api_url, ['key' => $request->api_key, 'action' => 'balance']);
        $apiProvider->balance = $response['balance'];

        $apiProvider->save();

        return back()->withSuccess($message);
    }

    // Edit provider
    public function edit_provider($id, Request $request)
    {

        $request->validate([
            'name' => 'required',
            'api_url' => 'required|url',
            'api_key' => 'required',

        ]);
        $apiProvider = ApiProvider::find($id);
        $message = 'API provider updated successfully';
        $apiProvider->status = $request->status;
        $apiProvider->name = $request->name;
        $apiProvider->api_url = $request->api_url;
        $apiProvider->api_key = $request->api_key;
        // Get balance
        $apiProvider->save();

        $services = $apiProvider->services;
        if ($request->status == 2) {
            $message = 'API provider disabled successfully';
            $apiProvider->status = 2;
            // get all services and disbale
            foreach ($services as $item) {
                $item->status = 2;
                $item->save();
                $category = $item->category;
                if ($category) {
                    $category->status = 2;
                    $category->save();
                }
            }
        } else {
            $apiProvider->status = 1;
            foreach ($services as $item) {
                $item->status = 1;
                $item->save();
                $category = $item->category;
                if ($category) {
                    $category->status = 1;
                    $category->save();
                }
            }
            $message = 'API provider Enabled successfully';
        }

        return back()->withSuccess($message);
    }

    public function provider_balance($id)
    {
        $apiProvider = ApiProvider::findOrFail($id);
        $message = 'API provider Balance updated successfully';
        $response = send_post_request($apiProvider->api_url, ['key' => $apiProvider->api_key, 'action' => 'balance']);
        $apiProvider->balance = $response['balance'] ?? $apiProvider->balance;
        $apiProvider->save();

        return back()->withSuccess($message);
    }

    public function provider_status($id)
    {
        $apiProvider = ApiProvider::findOrFail($id);
        $services = $apiProvider->services;
        if ($apiProvider->status == 1) {
            $message = 'API provider disabled successfully';
            $apiProvider->status = 2;
            // get all services and disbale
            foreach ($services as $item) {
                $item->status = 2;
                $item->save();
                $category = $item->category;
                if ($category) {
                    $category->status = 2;
                    $category->save();
                }
            }
        } else {
            $apiProvider->status = 1;
            foreach ($services as $item) {
                $item->status = 1;
                $item->save();
                $category = $item->category;
                if ($category) {
                    $category->status = 1;
                    $category->save();
                }
            }
            $message = 'API provider Enabled successfully';
        }
        $apiProvider->save();

        return back()->withSuccess($message);
    }

    public function delete_provider($id)
    {
        $apiProvider = ApiProvider::find($id);
        $services = $apiProvider->services;
        if ($services) {
            $message = 'API provider deleted successfully';
            // get all services and delete
            foreach ($services as $item) {
                $category = $item->category;
                if ($category) {
                    $category->forceDelete();
                }
                $item->forceDelete();
            }
        }

        $apiProvider->delete();

        return back()->withSuccess($message);
    }

    public function provider_price($id, Request $request)
    {
        // return $request;
        $provider = ApiProvider::findOrFail($id);
        $response = send_post_request($provider->api_url, ['key' => $provider->api_key, 'action' => 'services']);

        $api_services = array_sort_by_new_key($response, 'service');
        $current_services = array_sort_by_new_key(json_decode($provider->services, true), 'api_service_id');

        $disabled_services = array_diff_key($current_services, $api_services);
        $new_services = array_diff_key($api_services, $current_services);
        $exists_services = array_diff_key($api_services, $new_services);

        // dd($disabled_services, $new_services, $exists_services, 'available', $current_services);
        // update status
        if (! empty($disabled_services)) {
            $service = Service::whereIn('id', array_column($disabled_services, 'id'));
            $service->update([
                'status' => 2,
            ]);
        }
        $params = $request->all();
        $params['api_provider_id'] = $provider->id;
        // Sync exististing services
        if (! empty($exists_services) && ! empty($request['sync_request_options'])) {
            $this->sync_exists_services($exists_services, $params);
        }
        if (! empty($new_services) && $request['request_type'] == 1) {
            $this->sync_all_services($new_services, $params);
        }

        return back()->withSuccess('Provider Services Updated successfully');
    }

    public function sync_exists_services($data_services = [], $params = [])
    {
        // return $params;
        if (! empty($data_services)) {
            $sync_request_options = $params['sync_request_options'];
            foreach ($data_services as $key => $item) {
                $data_item = [
                    'type' => service_type_format($item['type']),
                ];
                /* ----------  Sync New Price  ---------- */
                if (isset($sync_request_options['new_price']) && $sync_request_options['new_price']) {
                    $new_currency_rate = $item['rate'] * get_setting('currency_rate');
                    $data_item['price'] = percentageIncrease($params['percentage'], $item['rate']);
                }
                /* ----------  sync Descriptions  ---------- */
                if (isset($sync_request_options['service_desc']) && $sync_request_options['service_desc']) {
                    $data_item['description'] = $item['desc'] ?? $item['description'] ?? '';
                }
                /* ----------  sync Servie Name  ---------- */
                if (isset($sync_request_options['service_name']) && $sync_request_options['service_name']) {
                    $data_item['name'] = $item['name'];
                }
                /* ----------  Sync Original Price  ---------- */
                if (isset($sync_request_options['original_price']) && $sync_request_options['original_price']) {
                    $data_item['api_price'] = (float) $item['rate'];
                }
                /* ---------- Sync  Min Max dripfeed  ---------- */
                if (isset($sync_request_options['min_max_dripfeed']) && $sync_request_options['min_max_dripfeed']) {
                    $data_item['min'] = $item['min'];
                    $data_item['max'] = $item['max'];
                    $data_item['dripfeed'] = (isset($item['dripfeed']) && $item['dripfeed']) ? $item['dripfeed'] : 0;
                }
                /* ---------- Old Service status  ---------- */
                if (isset($sync_request_options['old_service_status']) && $sync_request_options['old_service_status']) {
                    $data_item['status'] = 1;
                }

                $service = Service::where('api_service_id', $item['service'])->where('api_provider_id', $params['api_provider_id'])->first();

                $service->update($data_item);
            }

            return true;
        }

        return false;

    }

    public function sync_all_services($data_services = [], $params = [])
    {
        // return $data_services;
        if (! empty($data_services)) {
            foreach ($data_services as $key => $item) {
                $category = Category::where('name', $item['category'])->first();

                if (! $category) {
                    $category = new Category;
                    $category->name = $item['category'];
                    $category->status = 1;
                    $category->save();
                }

                $service_id = $item['service'];
                $checkService = Service::where('api_service_id', $service_id)->where('api_provider_id', $params['api_provider_id'])->first();

                if ($checkService) {
                    // update prices and other info??
                    continue;
                }
                $service = new Service;
                $service->category_id = $category->id;
                $service->api_provider_id = $params['api_provider_id'];
                $service->name = $item['name'];
                $service->price = percentageIncrease($params['percentage'], $item['rate']);
                $service->min = $item['min'];
                $service->max = $item['max'];
                $service->api_price = $item['rate'];
                $service->api_service_id = $item['service'];
                $service->type = strtolower($item['type']);
                $service->description = $item['desc'] ?? $item['description'] ?? '';
                $service->dripfeed = $item['dripfeed'];
                $service->refill = (isset($item['refill'])) ? (int) $item['refill'] : 0;
                $service->save();

            }

            return true;
        }

        return false;

    }

    public function import_provider_services($id, Request $request)
    {
        $provider = ApiProvider::findOrFail($id);
        // get services from api
        $response = send_post_request($provider->api_url, ['key' => $provider->api_key, 'action' => 'services']);
        // return $response;
        if (! $response) {
            return back()->with('error', 'Please enter your api credentials from API Setting Option');
        }

        // save to database
        foreach ($response as $key => $item) {
            $category = Category::where('name', $item['category'])->first();

            if (! $category) {
                $category = new Category;
                $category->name = $item['category'];
                $category->status = 1;
                $category->save();
            }

            $service_id = $item['service'];
            $checkService = Service::where('api_service_id', $service_id)->where('api_provider_id', $provider->id)->first();

            if ($checkService) {
                // update prices and other info??
                continue;
            }
            $service = new Service;
            $service->category_id = $category->id;
            $service->api_provider_id = $provider->id;
            $service->name = $item['name'];
            $service->price = percentageIncrease($request->percentage, $item['rate']);
            $service->min = $item['min'];
            $service->max = $item['max'];
            $service->api_price = $item['rate'];
            $service->api_service_id = $item['service'];
            $service->type = strtolower($item['type']);
            $service->description = $item['desc'] ?? $item['description'] ?? '';
            $service->dripfeed = $item['dripfeed'];

            $service->save();

            // return $service;
        }

        return redirect()->back()->withSuccess('API Services Imported Successfully');
    }

    public function provider_services($id)
    {
        $provider = ApiProvider::findOrFail($id);
        $title = $provider->name.' Services';
        $categories = Category::whereStatus(1)->orderBy('name')->get();
        // $services = $provider->services()->paginate(500);
        $services = send_post_request($provider['api_url'], ['key' => $provider['api_key'], 'action' => 'services']);
        if ($services) {
            return view('admin.providers.services', compact('title', 'services', 'categories', 'provider'));
        } else {
            return back()->with('error', 'Please enter your api credentials from API Setting Option');
        }
    }

    public function store_provider_service(Request $request)
    {
        // return $request;
        $percentage = $request->percentage;
        $provider = ApiProvider::findOrFail($request->api_provider_id);
        $item = $request->all();
        $checkService = Service::where('api_service_id', $request->api_service_id)->where('api_provider_id', $provider->id)->first();
        $service = null;
        if ($checkService) {
            // update prices and other info??
            $checkService->api_provider_id = $provider->id;
            $checkService->category_id = $request->category;
            $checkService->name = $item['name'];
            $checkService->min = $item['min'];
            $checkService->max = $item['max'];
            $checkService->api_price = $item['api_price'];
            $checkService->api_service_id = $item['api_service_id'];
            $checkService->type = strtolower($item['type']) ?? 'default';
            $checkService->description = $item['desc'] ?? $item['description'] ?? '';
            $checkService->dripfeed = $item['dripfeed'] ?? 0;
            $checkService->price = percentageIncrease($percentage, $item['api_price']);
            $checkService->save();
        } else {
            $service = new Service;
            $service->category_id = $request->category;
            $service->api_provider_id = $provider->id;
            $service->name = $item['name'];
            $service->price = percentageIncrease($request->percentage, $item['api_price']);
            $service->min = $item['min'];
            $service->max = $item['max'];
            $service->api_price = $item['api_price'];
            $service->api_service_id = $item['api_service_id'];
            $service->type = strtolower($item['type']) ?? 'default';
            $service->description = $item['desc'] ?? $item['description'] ?? '';
            $service->dripfeed = $item['dripfeed'] ?? 0;
            $service->save();
        }

        return redirect()->back()->withSuccess('API Services Updated Successfully');
    }

    public function provider_bulkimport(Request $request)
    {
        // return $request->all();
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Id!');

            return response()->json(['error' => 1]);
        }
        if ($request->percentage == null) {
            session()->flash('error', 'Increase percentage can not be null!');

            return response()->json(['error' => 1]);
        }
        $provider = ApiProvider::findOrFail($request->provider_id);
        $response = send_post_request($provider->api_url, ['key' => $provider->api_key, 'action' => 'services']);

        if (! $response) {
            return back()->with('error', 'Please enter your api credentials from API Setting Option');
        }
        // return $response;
        $api_services = array_sort_by_new_key($response, 'service');
        $serviceIds = explode(',', $request->strIds);

        $current_services = array_filter($api_services, function ($element) use ($serviceIds) {
            return in_array($element['service'], $serviceIds);
        });
        $disabled_services = array_diff_key($current_services, $api_services);
        $new_services = array_diff_key($api_services, $current_services);
        $exists_services = array_diff_key($api_services, $new_services);
        // add new services
        foreach ($current_services as $item) {
            $category = Category::where('name', $item['category'])->first();
            if (! $category) {
                $category = new Category;
                $category->name = $item['category'];
                $category->status = 1;
                $category->save();
            }
            $service_id = $item['service'];
            $checkService = Service::where('api_service_id', $service_id)->where('api_provider_id', $provider->id)->first();

            if ($checkService) {
                // update prices and other info??
                $checkService->api_provider_id = $provider->id;
                $checkService->category_id = $category->id;
                $checkService->name = $item['name'];
                $checkService->min = $item['min'];
                $checkService->max = $item['max'];
                $checkService->api_price = $item['rate'];
                $checkService->api_service_id = $item['service'];
                $checkService->type = strtolower($item['type']) ?? 'default';
                $checkService->description = $item['desc'] ?? $item['description'] ?? '';
                $checkService->dripfeed = $item['dripfeed'];
                $checkService->price = percentageIncrease($request->percentage, $item['rate']);
                $checkService->save();

                continue;
            }
            $service = new Service;
            $service->category_id = $category->id;
            $service->api_provider_id = $provider->id;
            $service->name = $item['name'];
            $service->price = percentageIncrease($request->percentage, $item['rate']);
            $service->min = $item['min'];
            $service->max = $item['max'];
            $service->api_price = $item['rate'];
            $service->api_service_id = $item['service'];
            $service->type = strtolower($item['type']) ?? 'default';
            $service->description = $item['desc'] ?? $item['description'] ?? '';
            $service->dripfeed = $item['dripfeed'];
            $service->save();

        }
        session()->flash('success', 'Services Imported Successfully.');

        return response()->json(['success' => 1]);

    }

    public function get_apiServices(Request $request)
    {
        // return $request;
        $option_plan = '';
        $id = $request->service_id ?? old('api_service_id') ?? null;
        $provider = ApiProvider::findOrFail($request->provider);
        $services = send_post_request($provider['api_url'], ['key' => $provider['api_key'], 'action' => 'services']);

        if ($services) {
            foreach ($services as $fetch_data) {
                $desc = $fetch_data['description'] ?? $fetch_data['desc'] ?? '';
                $option_plan .= '<option value="'.$fetch_data['service'].'" data-show="'.'show'.'" data-rate="'.($fetch_data['rate']).'" data-min="'.$fetch_data['min'].'" data-max="'.$fetch_data['max'].'" data-desc="'.$desc.'" '.($id == $fetch_data['service'] ? 'selected' : '').'>'.$fetch_data['name'].'</option>';
            }
        }

        return '<option value="0" data-rate="0" data-min="10" data-price="5000"  selected>-- Select a Service --</option>'.$option_plan;

    }
}
