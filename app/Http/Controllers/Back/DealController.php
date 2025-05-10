<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Purify;
use Str;

class DealController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::orderByDesc('created_at')->get();
        $title = 'All Listings';
        $type = 'all';

        return view('admin.deals.index', compact('listings', 'title', 'type'));
    }

    public function pending(Request $request)
    {
        $listings = Listing::where('status', '!=', 1)->orderByDesc('created_at')->get();
        $title = 'Pending Listings';
        $type = 'pending';

        return view('admin.deals.index', compact('listings', 'title', 'type'));
    }

    public function sold(Request $request)
    {
        $listings = Listing::where('sold', 1)->orderByDesc('id')->get();
        $title = 'Sold Listings';
        $type = 'sold';

        return view('admin.deals.index', compact('listings', 'title', 'type'));
    }

    public function details($id)
    {
        $listing = Listing::findOrFail($id);
        $title = "View {$listing->name}";
        $trx = $listing->transaction;

        return view('admin.deals.details', compact('title', 'listing', 'trx'));
    }

    public function edit($id)
    {
        $listing = Listing::findOrFail($id);
        $title = "Edit {$listing->name}";

        return view('admin.deals.edit', compact('title', 'listing'));
    }

    public function approve($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->status = 1;
        $listing->save();

        return back()->withSuccess('Listing Published successfully');
    }

    public function update($id, Request $request)
    {
        // validate request
        $req = $this->validate($request, [
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'followers' => 'required|integer|min:0',
            'followings' => 'required|integer|min:0',
            'age' => 'required|string',
            'about' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'mobile' => 'required|string|min:8',
            'other_info' => 'nullable|string',
            'preview' => 'nullable|image|max:4048',
            'status' => 'numeric|required',
        ]);
        $input = Purify::clean($req);
        $listing = Listing::findOrfail($id);
        // upload image
        if ($request->hasFile('preview')) {
            $image = $request->file('preview');
            $imageName = 'listings-'.Str::random(15).'.'.$image->getClientOriginalExtension();
            // delete old image?
            if ($listing->preview != null) {
                try {
                    unlink(public_path('uploads/'.$listing->preview));
                } catch (\Throwable $th) {
                    // throw $th;
                }
            }
            $image->move(public_path('uploads/listings'), $imageName);
            $input['preview'] = 'listings/'.$imageName;
        }
        $input['amount'] = $request->price;
        $data = $listing->update($input);

        return back()->withSuccess('Listings updated successfully');
    }
}
