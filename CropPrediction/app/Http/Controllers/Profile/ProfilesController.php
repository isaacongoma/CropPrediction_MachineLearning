<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Profile;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $profiles = Profile::where('Jilla', 'LIKE', "%$keyword%")
                ->orWhere('taluka', 'LIKE', "%$keyword%")
                ->orWhere('phone', 'LIKE', "%$keyword%")
                ->orWhere('address', 'LIKE', "%$keyword%")
                ->orWhere('state', 'LIKE', "%$keyword%")
                ->orWhere('country', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $profiles = Profile::paginate($perPage);
        }

      if(Auth::check() && Auth::user()->hasRole('admin')) {
        return view('frontendprofile.profiles.index', compact('profiles'));
       }
       else{
         $id=Auth::id();
           // print_r($id);die();
             $profile = Profile::where('id', '=', $id)->first();
            if ($profile === null) {
               // user doesn't exist
                 return view('frontendprofile.profiles.create');  //orig
            }else{

                 $profile = Profile::findOrFail($id);

                 return view('frontendprofile.profiles.show', compact('profile'));

            }

       }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
     //  return view('frontendprofile.profiles.create');  //orig
 
            $id=Auth::id();
           // print_r($id);die();
             $profile = Profile::where('id', '=', $id)->first();
            if ($profile === null) {
               // user doesn't exist
                 return view('frontendprofile.profiles.create');  //orig
            }
            else{

                 $profile = Profile::findOrFail($id);

                 return view('frontendprofile.profiles.show', compact('profile'));

            }




    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
         ////////////ORIGINAL//////////////////////

        // $requestData = $request->all();
        
        // Profile::create($requestData);

        // return redirect('frontendprofile/profiles')->with('flash_message', 'Profile added!');
 ////////////ORIGINAL//////////////////////
        $id=Auth::id();
    //    print_r($id);die();
        $requestData = $request->all();
        $requestData['id']= $id;
      //  print_r($requestData);die();
        Profile::create($requestData);

      //  Session::flash('flash_message', 'Profile added!');

        return redirect('frontendprofile/profiles')->with('flash_message', 'Profile added!');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $profile = Profile::findOrFail($id);

        return view('frontendprofile.profiles.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);

        return view('frontendprofile.profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $profile = Profile::findOrFail($id);
        $profile->update($requestData);

        return redirect('frontendprofile/profiles')->with('flash_message', 'Profile updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Profile::destroy($id);

        return redirect('frontendprofile/profiles')->with('flash_message', 'Profile deleted!');
    }
}
