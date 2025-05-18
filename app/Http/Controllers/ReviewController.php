<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * クチコミ登録フォームの表示
     */
    public function create()
    {
        return view('review_touroku');
    }

    /**
     * クチコミ投稿処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|string|max:50',
            'comp_name' => 'required|string|max:255',
            'speciality' => 'nullable|string|max:255',
            'employment_status' => 'required|string|max:50',
            'age_group' => 'required|string|max:50',
            'employment_type' => 'required|string|max:50',
            'growth_potential' => 'required|integer|between:1,5',
            'job_satisfaction' => 'required|integer|between:1,5',
            'organizational_climate' => 'required|integer|between:1,5',
            'social_contribution' => 'required|integer|between:1,5',
            'salary' => 'required|integer|between:1,5',
            'benefits' => 'required|integer|between:1,5',
            'female_advancement' => 'required|integer|between:1,5',
            'reviews' => 'nullable|string|max:500',
        ]);

        Review::create([
            'user_id' => Auth::id(), // これがあること！
            'name' => $request->input('name'),
            'email' => $request->email,
            'gender' => $request->gender,
            'comp_name' => $request->comp_name,
            'speciality' => $request->speciality,
            'employment_status' => $request->employment_status,
            'years_of_service' => $request->years_of_service,
            'age_group' => $request->age_group,
            'employment_type' => $request->employment_type,
            'growth_potential' => $request->growth_potential,
            'job_satisfaction' => $request->job_satisfaction,
            'organizational_climate' => $request->organizational_climate,
            'social_contribution' => $request->social_contribution,
            'salary' => $request->salary,
            'benefits' => $request->benefits,
            'female_advancement' => $request->female_advancement,
            'reviews' => $request->reviews,
        ]);

        return redirect('review_touroku_kakunin')->with('success', '登録が完了しました！');
    }

    /**
     * クチコミ一覧表示
     */
    public function showReview(Request $request)
    {
        $companies = Review::select('comp_name')->distinct()->get();

        $review = collect(); // デフォルトは空のコレクション
        if ($request->has('comp_name')) {
            $review = Review::with('user')
                ->where('comp_name', $request->input('comp_name'))
                ->get();
        }

        return view('review', [
            'companies' => $companies,
            'comp_name' => $request->input('comp_name'),
            'review' => $review,
        ]);
    }
}
