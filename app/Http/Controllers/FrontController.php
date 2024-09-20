<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonaturRequest;
use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $fundraisings = Fundraising::with(['category', 'fundraiser'])->where('is_active', 1)->orderByDesc('id')->get();

        return view('front.views.index', compact('categories', 'fundraisings'));
    }

    public function category(Category $category)
    {
        // $fundraisings = Fundraising::with(['fundraiser'])->where([
        //     ['is_active', 1],
        //     ['category_id', $category->id],
        // ])->orderByDesc('id')->get();
        return view('front.views.category', compact('category'));
    }

    public function details(Fundraising $fundraising)
    {
        // $donaturs = Donatur::with(['fundraising'])->where([
        //     ['is_paid', 1],
        //     ['fundraising_id', $fundraising->id],
        // ])->orderByDesc('id')->get();
        $goalReached = $fundraising->totalReachedAmount() >= $fundraising->target_amount;

        return view('front.views.details', compact('fundraising', 'goalReached'));
    }

    public function support(Fundraising $fundraising)
    {
        return view('front.views.donation', compact('fundraising'));
    }

    public function checkout(Fundraising $fundraising, $totalAmountDonation)
    {
        return view('front.views.checkout', compact('fundraising', 'totalAmountDonation'));
    }

    public function mblud(StoreDonaturRequest $request, Fundraising $fundraising, $totalAmountDonation)
    {
        DB::transaction(function () use ($request, $fundraising, $totalAmountDonation) {
            $validated = $request->validated();

            if($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath; // storage/proofs/wemphy.png
            } 

            $validated['fundraising_id'] = $fundraising->id;
            $validated['total_amount'] = $totalAmountDonation;
            $validated['is_paid'] = false;

            $donatur = Donatur::create($validated);
        });

        return to_route('front.details', $fundraising->slug);
    }
}
