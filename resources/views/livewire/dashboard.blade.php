<div class="container-fluid py-4">
    @if (session()->has('message'))
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            </div>
        </div>
    @endif
    <div class="row my-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Galleries</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                                <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created On</th>
                                <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                            @endphp
                                @forelse($galleries->get() as $index=> $gallery)
                                    <tr>
                                        <td class="align-middle text-left text-sm"><div class="d-flex px-2 py-1"> <a href="" wire:click.prevent="loadMedia({{$gallery->id}})">{{$gallery->name}}</a></div></td>
                                        <td class="align-middle text-left text-sm">{{$gallery->title}}</td>
                                        <td class="align-middle text-left text-sm">{{$gallery->created_at->format('j F, Y')}}</td>
                                        <td class="align-middle text-left text-sm">
                                            <button type="button" wire:click.prevent="edit({{ $gallery->id }})" class="btn btn-info">Edit</button>
                                            <button type="button" wire:click="deleteId({{ $gallery->id }})" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">Delete</button>
                                            <button type="button" wire:click="uploader({{ $gallery->id }})" class="btn btn-secondary" data-toggle="modal" data-target="#uploaderModal">Add Images</button>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="uploaderModal" tabindex="-1" role="dialog" aria-labelledby="uploaderModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Files</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form wire:submit.prevent="save">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if ($images)
                                        Photo Preview:
                                        <div class="row">
                                            @foreach ($images as $image)
                                                @if($image instanceof Livewire\TemporaryUploadedFile)
                                                        <img src="{{ $image->temporaryUrl() }}">
                                                @else
                                                <div class="col-3 card me-1 mb-1">
                                                    <img src="{{ asset('/uploads/'.$image) }}">
                                                </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Image Upload</label>
                                        <input type="file" class="form-control" wire:model="images" multiple>
                                        <div wire:loading wire:target="images">Uploading...</div>
                                        @error('images.*') <span class="error">{{ $message }}</span> @enderror
                                    </div>
                                    <div wire:loading wire:target="upload">process...</div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                        <button type="button" wire:click.prevent="upload()" class="btn btn-info close-modal" data-dismiss="modal">Upload</button>
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Confirm</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                        <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Gallery Info</h6>
                </div>
                <div class="card-body p-3">
                    <form wire:submit.prevent="save" action="#" method="POST" role="form text-left">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gallery-name" class="form-control-label">{{ __('Name') }}</label>
                                    <div class="@error('galleries.name')border border-danger rounded-3 @enderror">
                                        <input wire:model="galleries.name" class="form-control" type="text" placeholder="Name"
                                               id="gallery-name">
                                    </div>
                                    @error('galleries.name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gallery-title" class="form-control-label">{{ __('Title') }}</label>
                                    <div class="@error('galleries.title')border border-danger rounded-3 @enderror">
                                        <input wire:model="galleries.title" class="form-control" type="text"
                                               placeholder="Gallery Title" id="gallery-title">
                                    </div>
                                    @error('galleries.email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="col-md-3">
                                <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
                            </div>
                            <div class="col-md-1">&nbsp;
                            </div>
                            <div class="col-md-3">
                                <button type="submit" wire:click.prevent="newFields()" class="btn btn-secondary btn-md mt-4 mb-4">{{ 'Clear' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-12">
                                <p class="mb-1 pt-2 text-bold">Uploaded Images</p>
                                @forelse($images as $img)
                                    <img src="{{ asset('/uploads/'.$img) }}" class="img-thumbnail" style="width: 10%" />
                                @empty
                                    No Images for this gallery
                                @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

