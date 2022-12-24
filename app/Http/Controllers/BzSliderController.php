<?php

namespace App\Http\Controllers;
use App\Models\BzSlider;

use Storage;
use Illuminate\Http\Request;

class BzSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bzslider = BzSlider::all();
        return view('backend.bzslider.index',compact('bzslider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
                return view('backend.bzslider.create');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $bzslider = new BzSlider();
        $bzslider->link = $request->input('link');
        if($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename= time().'.'.$extension;
            $file->move(public_path().'//uploads/bzslider/',$filename);
            $bzslider->image = $filename;
        }
        $bzslider->save();
                flash(translate('Slider Added successfully'))->success();
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bzslider = BzSlider::findOrFail($id);
        return view('backend.bzslider.edit',compact('bzslider'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //

        $bzslider = BzSlider::find($request->id);
        $bzslider->link = $request->input('link');
        if($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename= time().'.'.$extension;
            $file->move(public_path().'//uploads/bzslider/',$filename);
            $bzslider->image = $filename;
        }
        $bzslider->update();
        flash(translate('Slider updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
                //
        $upload = BzSlider::findOrFail($id);

        if (auth()->user()->user_type == 'seller' && $upload->user_id != auth()->user()->id) {
            flash(translate("You don't have permission for deleting this!"))->error();
            return back();
        }
        try {
            if (env('FILESYSTEM_DRIVER') == 's3') {
                Storage::disk('s3')->delete($upload->image);
                if (file_exists(public_path() . '/uploads/bzslider/' . $upload->image)) {
                    unlink(public_path() . '/uploads/bzslider/' . $upload->image);
                }
            } else {
                unlink(public_path() . '/uploads/bzslider/' . $upload->image);
            }
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        } catch (\Exception $e) {
            $upload->delete();
            flash(translate('File deleted successfully'))->success();
        }
        return back();
    }
}
