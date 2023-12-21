@foreach (auth()->user()->folders as $folder)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="card border p-0 shadow-none">
                            <div class="d-flex align-items-center px-4 pt-4">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="example-checkbox2"
                                        value="option2">
                                    <span class="custom-control-label"></span>
                                </label>
                                <div class="float-right ml-auto">
                                    <a href="#" class="option-dots" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">

                                        <a class="dropdown-item folder-edit"
                                            data-path="{{ route('showfolder', $folder->id) }}" href="#"><i
                                                class="fe fe-edit mr-2"></i> View Or Edit</a>
                                        <a class="dropdown-item" href="#"><i class="fe fe-share mr-2"></i> Share</a>
                                        <a class="dropdown-item" href="#"><i class="fe fe-download mr-2"></i>
                                            Download</a>
                                        <a class="dropdown-item folder-delete" data-id="{{ $folder->id }}"
                                            href="#"><i class="fe fe-trash mr-2"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 text-center">
                                <div class="file-manger-icon">
                                    <img src="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/assets/images/files/folder.png"
                                        alt="img" class="br-7">
                                </div>
                                <h6 class="mb-1 font-weight-semibold mt-4"><a
                                        href="{{ route('viewfolder', $folder->id) }}">{{ $folder->name }}</a></h6>
                            </div>
                        </div>
                    </div>
                @endforeach
                @foreach (auth()->user()->files->where('folder_id', 0) as $file)
                    <div class="col-xl-3 col-md-4 col-sm-6">
                        <div class="card border p-0 shadow-none">
                            <div class="d-flex align-items-center px-4 pt-4">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="example-checkbox2"
                                        value="option2">
                                    <span class="custom-control-label"></span>
                                </label>
                                <div class="float-right ml-auto">
                                    <a href="#" class="option-dots" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item file-edit" data-path="{{ route('showfile', $file->id) }}"
                                            href="#"><i class="fe fe-edit mr-2"></i>View Or Edit</a>
                                        {{-- <a class="dropdown-item" href="#"><i class="fe fe-share mr-2"></i> Share</a> --}}
                                        <a class="dropdown-item" href="{{ route('sharefile', $file->id) }}">
                                            <i class="fe fe-share mr-2"></i> Share
                                        </a>

                                        <a class="dropdown-item" href="{{ route('downloadfile', $file->id) }}">
                                            <i class="fe fe-download mr-2"></i> Download
                                        </a>

                                        <a class="dropdown-item file-delete" data-id="{{ $file->id }}"
                                            href="#"><i class="fe fe-trash mr-2"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0 text-center">
                                <div class="file-manger-icon">
                                    <img src="{{ asset($file->path) }}" alt="img" class="br-7">
                                </div>
                                <h6 class="mb-1 font-weight-semibold mt-4">{{ $file->name }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach