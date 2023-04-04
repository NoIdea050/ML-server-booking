@extends('user.layouts.app')
@section('header-links')
<style>
.img-wrapper {
    border: 1px solid;
    padding: 0;
    border-radius: 6px;
    overflow: hidden;
    height: 225px;
}

.img-wrapper input {
    background: ;
    width: 100%;
    padding: 2px;
    border-bottom: 1px solid;
}

.img-wrapper .preview {
    width: 100% !important;
    height: 100% !important;
}

.border-image {
    border: 1px solid #e7515a !important;
}
</style>
@endsection

@section('contents')

<div class="container mt-5">
    <div class="row">

        <div class="col-md-8 col-lg-8 m-auto">
            <h3 class="text-center font-weight-normal text-dark">Update Profile information</h3>
            <div class="right-section">

                <form action="{{route('user.profile-update')}}" method="post" class=" " enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row border bg-light">
                        <div class="col-md-4 col-lg-4 image-upload-section ">
                            <div class="image-upload-one">
                                <div class="center">
                                    <div class="form-input w-100 ">
                                        <label for="fullName">Image<span class="text-danger">*</span></label>
                                        <div class="col-sm-12 text-left img-wrapper ">
                                            <div class="">
                                                <input type="hidden" name="old_avatar"
                                                    value="{{ $data->user_more_info ? $data->user_more_info->avatar : '' }}" />
                                                <input type="file" accept="image/*" name="avatar" id="imgInp1"
                                                    class="slider-update-input" value="{{ old('avatar') }}"
                                                    onchange="loadFile(event)" style="width : 100%;color:black">
                                            </div>
                                            <img class="preview" id="preview1"
                                                src="{{ !empty($data->user_more_info) ? asset('storage/'.$data->user_more_info->avatar) : asset('all/website/assets/images/profile_demo.png') }}"
                                                alt="your image" style="" />
                                        </div>
                                        <script>
                                        imgInp1.onchange = evt => {
                                            const [file] = imgInp1.files
                                            if (file) {
                                                preview1.src = URL.createObjectURL(file)
                                            }
                                        }
                                        </script>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-sm-12 col-md-8 col-lg-8">

                            <div class="mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">Name<span
                                                class="text-danger">*</span></span>
                                    </div>
                                    <input type="text" class="form-control" name="name" placeholder="Enter name"
                                        aria-label="Username" value="{{ Auth::user()->name }}">
                                </div>
                                @error('name')
                                <small class="text-danger mb-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">Email<span
                                                class="text-danger">*</span></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email"
                                        aria-label="Useremail" value="{{ Auth::user()->email }}">
                                </div>
                                @error('email')
                                <small class="text-danger mb-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon5">Phone<span
                                                class="text-danger">*</span></span>
                                    </div>
                                    <input type="text" name="phone"
                                        value="{{ $data->user_more_info ? $data->user_more_info->phone : '' }}"
                                        class="form-control" aria-label="Contact Number"
                                        aria-describedby="basic-addon1">
                                </div>
                                @error('phone')
                                <small class="text-danger mb-2" role="alert">
                                    <strong>{{ $message }}</strong>
                                </small>
                                @enderror
                            </div>


                            <div class="p-3 row mb-3 ml-1 d-flex flex-row justify-content-between"
                                style="float: right;">
                                <button type="submit" name="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row border bg-light mt-3">
                <div class="col-12">
                    <form action="{{route('user.change-password')}}" method="post" class="">
                        @csrf
                        @method('PUT')
                        <h3 class="text-left text-dark">Update Password</h3>

                        <div class="mt-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">Old Password<span
                                            class="text-danger">*</span></span>
                                </div>

                                <input type="password" name="old_password" value=""
                                    class="form-control {{ ($errors->first('old_password') ? 'border border-danger' : '') }}"
                                    aria-label="Contact Number" aria-describedby="basic-addon1">
                            </div>
                            @error('old_password')
                            <small class="text-danger mb-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>


                        <div class="mt-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">New Password<span
                                            class="text-danger">*</span></span>
                                </div>

                                <input type="password" name="password" value=""
                                    class="form-control {{ ($errors->first('password') ? 'border border-danger' : '') }}"
                                    aria-label="Contact Number" aria-describedby="basic-addon1">
                            </div>
                            @error('password')
                            <small class="text-danger mb-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon5">Confirn Password<span
                                            class="text-danger">*</span></span>
                                </div>

                                <input type="password" name="password_confirmation" value=""
                                    class="form-control {{ ($errors->first('password_confirmation') ? 'border border-danger' : '') }}"
                                    aria-label="Contact Number" aria-describedby="basic-addon1">
                            </div>
                            @error('password_confirmation')
                            <small class="text-danger mb-2" role="alert">
                                <strong>{{ $message }}</strong>
                            </small>
                            @enderror
                        </div>

                        <div class=" p-3 row mt-4 mb-3 ml-1 d-flex flex-row justify-content-between">
                            <button type="submit" name="submit" class="btn btn-success">Update password</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-8">
            <br>
        </div>

    </div>
</div>
@endsection


@section('footer-links')

@endsection