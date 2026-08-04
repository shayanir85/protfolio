<?php

namespace App\Http\Controllers;

use App\Models\GithubRepo;
use Illuminate\Http\Request;

class GithubReposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $repos = GithubRepo::where('show', true)->paginate(50);
        return response()->json($repos);
    }

    public function count_proj()
    {
        $proj_count = GithubRepo::count();
        return response()->json($proj_count);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GithubRepo $githubRepos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GithubRepo $githubRepos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GithubRepo $githubRepos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GithubRepo $githubRepos)
    {
        //
    }
}
