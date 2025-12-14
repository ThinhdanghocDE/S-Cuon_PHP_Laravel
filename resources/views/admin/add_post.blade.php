@extends('admin/adminlayout')

@section('container')

<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Thêm Bài Viết</h4>
            <br>
            @if(Session::has('wrong'))
                <div class="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>Lỗi!</strong> {{Session::get('wrong')}}
                </div>
                <br>
            @endif
            @if(Session::has('success'))
                <div class="success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                    <strong>Thành công!</strong> {{Session::get('success')}}
                </div>
                <br>
            @endif

            <form class="forms-sample" action="{{ route('admin.posts.add.process') }}" method="post" enctype="multipart/form-data" id="postForm">
                @csrf

                <div class="form-group">
                    <label for="postTitle">Tiêu Đề <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="postTitle" placeholder="Nhập tiêu đề bài viết" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="postExcerpt">Tóm Tắt</label>
                    <textarea class="form-control @error('excerpt') is-invalid @enderror" name="excerpt" id="postExcerpt" rows="3" placeholder="Nhập tóm tắt ngắn (tùy chọn)">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Tối đa 500 ký tự</small>
                </div>

                <div class="form-group">
                    <label for="postContent">Nội Dung <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="postContent" rows="15" placeholder="Nhập nội dung bài viết" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Tối thiểu 50 ký tự</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postCategory">Danh Mục <span class="text-danger">*</span></label>
                            <select class="form-control @error('category') is-invalid @enderror" name="category" id="postCategory" required>
                                <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>Tổng hợp</option>
                                <option value="news" {{ old('category') == 'news' ? 'selected' : '' }}>Tin tức</option>
                                <option value="promotion" {{ old('category') == 'promotion' ? 'selected' : '' }}>Khuyến mãi</option>
                                <option value="recipe" {{ old('category') == 'recipe' ? 'selected' : '' }}>Công thức</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postStatus">Trạng Thái <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" name="status" id="postStatus" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Đã đăng</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postImage">Ảnh Đại Diện</label>
                    <div class="custom-file-input-wrapper">
                        <input type="file" name="featured_image" class="custom-file-input" id="postImage" accept="image/jpeg,image/jpg,image/png" onchange="updateFileName(this, 'postImageLabel')">
                        <label for="postImage" class="custom-file-label" id="postImageLabel">
                            <i class="mdi mdi-file-image"></i> Chọn file
                        </label>
                        <span class="file-name-display" id="postImageFileName"></span>
                    </div>
                    <small class="form-text text-muted">Chỉ chấp nhận file JPG, JPEG, PNG. Kích thước tối đa: 5MB</small>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_featured" id="postFeatured" value="1">
                        <label class="form-check-label" for="postFeatured">
                            Đánh dấu bài viết nổi bật
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="postMetaTitle">SEO Title</label>
                    <input type="text" name="meta_title" class="form-control" id="postMetaTitle" placeholder="Tiêu đề SEO (tùy chọn)">
                </div>

                <div class="form-group">
                    <label for="postMetaDescription">SEO Description</label>
                    <textarea class="form-control" name="meta_description" id="postMetaDescription" rows="2" placeholder="Mô tả SEO (tùy chọn)"></textarea>
                </div>
              
                <button type="submit" class="btn btn-primary me-2">Xác nhận</button>
                <a href="{{ route('admin.posts') }}" class="btn btn-dark">Hủy</a>
            </form>
        </div>
    </div>
</div>

<style>
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    border-radius: 5px;
}

.success {
    padding: 20px;
    background-color: #4BB543;
    color: white;
    border-radius: 5px;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}

.custom-file-input-wrapper {
    position: relative;
    display: block;
    width: 100%;
}

.custom-file-input {
    position: absolute !important;
    left: -9999px !important;
    opacity: 0 !important;
    width: 0 !important;
    height: 0 !important;
    visibility: hidden !important;
    overflow: hidden !important;
    z-index: -1 !important;
    pointer-events: none !important;
}

.custom-file-label {
    display: inline-block;
    padding: 10px 20px;
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.custom-file-label:hover {
    background-color: #e0e0e0;
}

.file-name-display {
    margin-left: 10px;
    color: #666;
    font-style: italic;
}
</style>

<script>
function updateFileName(input, labelId) {
    const fileName = input.files[0] ? input.files[0].name : '';
    const displayElement = document.getElementById(input.id + 'FileName');
    if (displayElement) {
        displayElement.textContent = fileName;
    }
}
</script>

@endsection

