@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload PDF</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.pdf.add') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>

                            <div class="col-md-6">
                                <select id="category" name="category" class="form-control @error('category') is-invalid @enderror">
                                    <option value="">-- Select Category --</option>
                                    <option value="SW">SW</option>
                                    <option value="IS">IS</option>
                                    <option value="IT">IT</option>
                                    <option value="CS">CS</option>
                                </select>

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="year" class="col-md-4 col-form-label text-md-right">Year</label>

                            <div class="col-md-6">
                                <select id="year" name="year" class="form-control @error('year') is-invalid @enderror">
                                    <option value="">-- Select Year --</option>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="3rd">3rd</option>
                                    <option value="4th">4th</option>
                                </select>

                                @error('year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pdf_file" class="col-md-4 col-form-label text-md-right">PDF File</label>

                            <div class="col-md-6">
                                <input id="pdf_file" type="file" class="form-control-file @error('pdf_file') is-invalid @enderror" name="pdf_file" required>

                                @error('pdf_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
