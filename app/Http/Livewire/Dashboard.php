<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use App\Models\Gallery;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;
    public Gallery $galleries;
    protected $rules = [
        'galleries.name' => 'required|unique:galleries|max:255',
        'galleries.title' => 'required|max:255',
    ];
    public $images= [];
    public $deleteId = 0;
    public $uploader_id = 0;
    public function mount()
    {
        $this->galleries = new Gallery();
    }
    public function upload()
    {
        $this->validate([
            'images.*' => 'image|max:1024', // 1MB Max
        ]);
        $gallery = Gallery::find($this->uploader_id);
        foreach ($this->images as $key => $image) {
            Storage::disk('uploads')->put($gallery->name.'/'.$image->hashName(), $image->get());
        }
        $this->images = [];

        session()->flash('success', 'Images has been successfully Uploaded.');
    }

    public function loadMedia(Gallery $gall)
    {
        $this->images = [];
        $this->galleries= $gall;
        $this->images = Storage::disk('uploads')->files($gall->name);
    }
    public function render()
    {

        $all_galleries = Gallery::get();
        return view('livewire.dashboard', [
            'galleries' => $all_galleries,
        ]);
    }

    public function edit(Gallery $gal)
    {
        $this->galleries = $gal;
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function deleteId($id)
    {
        $this->deleteId = $id;
    }

    public function uploader($id)
    {
        $this->uploader_id = $id;
        $this->galleries = Gallery::find($this->uploader_id);
//        $this->images = Storage::disk('uploads')->files($this->galleries->name);
    }
    public function uploadNow(){

    }
    public function newFields()
    {
        $this->deleteId = $this->uploader_id = 0;
        $this->galleries = new Gallery();
    }
    public function delete()
    {
        Gallery::find($this->deleteId)->delete();
    }
    public function save()
    {
        $this->validate();
        $this->galleries->save();
        $this->galleries = new Gallery();
        session()->flash('message', 'Gallery successfully saved.');
    }
}
